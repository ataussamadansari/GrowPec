# Phase 15 Plan: Model & Schema Normalization

**Phase:** 15  
**Milestone:** v1.3 — Architecture Cleanup & Schema Normalization  
**Goal:** Safely drop 4 redundant database tables (`college_comparisons`, `college_course_fees`, `college_course_specializations`, `college_learning_experiences`), delete orphaned models, eliminate duplicate migration `repair_college_alumni_table.php`, streamline public course queries and views, clean seeders, and add regression tests.  
**Status:** Completed  

---

## 1. Context & Architecture

### Existing State:
- During earlier iterative prototyping, four experimental or duplicate database tables were created:
  - `college_comparisons`: An unfeatured table with 0 routes, views, or Filament resources.
  - `college_course_fees`: An unneeded multi-tier fee breakdown table superseded by `college_courses.fee_amount` and `fee_type`.
  - `college_course_specializations`: A duplicate specialization table with separate fees; in the active architecture and Filament v5 panel, `college_courses` already directly links `college_id`, `course_id`, and `specialization_id` with `fee_amount`, `duration`, `eligibility`, and `seats`.
  - `college_learning_experiences`: An orphaned table duplicate of `college_highlights` which is already actively managed and displayed.
- The 4 corresponding Eloquent models remain in `app/Models/`:
  - `CollegeComparison.php`
  - `CollegeCourseFee.php`
  - `CollegeCourseSpecialization.php`
  - `CollegeLearningExperience.php`
- Model relationships in `College.php` (`learningExperiences()`) and `CollegeCourse.php` (`specializationFees()`, `fees()`) still point to these deprecated models.
- In `resources/views/colleges/show.blade.php`, lines 2800–2830 attempt to query `$entry->specializationFees` before falling back to `$entry->fee_amount`.
- In `app/Http/Controllers/CollegeController.php`, line 42 eagerly loads `'collegeCourses.specializationFees.specialization'`, causing unnecessary database queries.
- A redundant repair migration `2026_09_15_202122_repair_college_alumni_table.php` exists, duplicating the `college_alumni` table creation from `2026_09_15_191011_update_college_table.php`.
- Five seeders still reference these dropped tables in truncate lists and dead insert loops.

### Target Architecture:
1. **Normalized Database Schema**:
   - Migration `drop_redundant_college_tables` safely drops the 4 tables with `Schema::dropIfExists()`.
   - Redundant migration `2026_09_15_202122_repair_college_alumni_table.php` is deleted.
2. **Lean Eloquent Models**:
   - Four orphaned models deleted from `app/Models/`.
   - `College.php` retains only active child relationships (`collegeHighlights`, `accreditations`, `admissionSections`, `scholarships`, `placementStats`, `recruiters`, `careerOutcomes`, `collegeFacilities`, `loanOptions`, `collegeFaqs`, `gallery`, `alumni`, `approvedReviews`).
   - `CollegeCourse.php` cleans out `fees()` and `specializationFees()`, keeping direct relations (`college`, `course`, `specialization`).
3. **Optimized Public Course Display**:
   - `CollegeController::show()` removes eager load for `specializationFees`.
   - `resources/views/colleges/show.blade.php` maps directly from `$courseEntries` (`CollegeCourse` records) to produce program rows, eliminating dead checks.
4. **Clean Seeders**:
   - Truncate lists in `StreamCourseSpecializationSeeder.php`, `RegularCollegeSeeder.php`, `OnlineUniversitySeeder.php`, `DistanceOnlineCollegeSeeder.php`, and `CollegeSeeder.php` cleaned.
5. **Comprehensive Verification**:
   - Dedicated `tests/Feature/CollegeDetailPageTest.php` to verify public college detail rendering, program fee display, and schema normalization.
   - `php artisan test --compact` passes 100% green with 0 regressions.
   - `vendor/bin/pint --format agent` passes with 0 style issues.

---

## 2. Tasks & Execution Steps

### Task 15.1: Create Database Migration to Drop Redundant Tables & Remove Duplicate Migration
- **Action:**
  - Create migration `database/migrations/2026_10_15_000001_drop_redundant_college_tables.php`.
  - In `up()`:
    - Drop `college_course_fees`, `college_course_specializations`, `college_learning_experiences`, and `college_comparisons` using `Schema::dropIfExists()`.
  - In `down()`:
    - Re-create tables if rolled back.
  - Delete duplicate migration: `database/migrations/2026_09_15_202122_repair_college_alumni_table.php`.
  - Run `php artisan migrate --force`.
- **Verification:** Run `php artisan migrate:status` and verify dropped tables are no longer in SQLite/MySQL schema.

### Task 15.2: Delete Orphaned Eloquent Models
- **Action:**
  - Delete `app/Models/CollegeComparison.php`.
  - Delete `app/Models/CollegeCourseFee.php`.
  - Delete `app/Models/CollegeCourseSpecialization.php`.
  - Delete `app/Models/CollegeLearningExperience.php`.
- **Verification:** Confirm files are deleted and no unimported references remain in `app/`.

### Task 15.3: Streamline Model Relationships, Controller & Public View
- **Action:**
  - In `app/Models/College.php`: Remove `learningExperiences(): HasMany` method and unused import if any.
  - In `app/Models/CollegeCourse.php`: Remove `specializationFees(): HasMany` and `fees(): HasMany` methods.
  - In `app/Http/Controllers/CollegeController.php`: Remove `'collegeCourses.specializationFees.specialization'` from eager loading array.
  - In `resources/views/colleges/show.blade.php`: Refactor lines 2800–2830 to map `$programRows` directly from `$courseEntries` using each `CollegeCourse`'s properties (`specialization`, `duration`, `eligibility`, `fee_amount`, `fee_type`).
- **Verification:** Verify public college show page renders smoothly without any relationship or template errors.

### Task 15.4: Clean Seeders
- **Action:**
  - Update `database/seeders/StreamCourseSpecializationSeeder.php`: Remove the 4 dropped tables from `$tables` truncate list.
  - Update `database/seeders/RegularCollegeSeeder.php`: Remove dropped tables from `$tables` and clean dead `Schema::hasTable` insert blocks.
  - Update `database/seeders/OnlineUniversitySeeder.php`: Remove dropped tables from `$tables` and clean dead insert blocks.
  - Update `database/seeders/DistanceOnlineCollegeSeeder.php`: Remove dropped tables from `$tables` and clean dead insert blocks.
  - Update `database/seeders/CollegeSeeder.php`: Remove duplicate inserts to `college_course_specializations` and `college_course_fees`.
- **Verification:** Run seeder syntax checks.

### Task 15.5: Add Feature Tests & Test Suite Verification
- **Action:**
  - Create `tests/Feature/CollegeDetailPageTest.php`:
    - Test public college detail page loads successfully with 200 OK.
    - Test college highlights and active child relations are displayed.
    - Test course program rows render correct specialization name, duration, eligibility, and formatted fee.
    - Test college without courses renders gracefully.
    - Test that dropped tables do not exist in the database schema (`Schema::hasTable(...)` is false).
  - Run `vendor/bin/pint --dirty --format agent`.
  - Run full test suite: `php artisan test --compact`.
- **Verification:** 100% green test suite across all feature and unit tests.

---

## 3. Verification & Acceptance Criteria
- [x] Migration `drop_redundant_college_tables` executed; 4 redundant tables dropped.
- [x] Redundant migration `2026_09_15_202122_repair_college_alumni_table.php` deleted.
- [x] 4 orphaned models (`CollegeComparison`, `CollegeCourseFee`, `CollegeCourseSpecialization`, `CollegeLearningExperience`) deleted.
- [x] Obsolete relationships removed from `College.php` and `CollegeCourse.php`.
- [x] `CollegeController::show()` and `resources/views/colleges/show.blade.php` streamlined to query and render course fees directly from `collegeCourses`.
- [x] Seeders cleaned of references to dropped tables.
- [x] `tests/Feature/CollegeDetailPageTest.php` created and passing.
- [x] Full test suite passes 100% green (`php artisan test --compact`, 118 passed, 484 assertions).
- [x] Laravel Pint code formatting passes with 0 issues.

