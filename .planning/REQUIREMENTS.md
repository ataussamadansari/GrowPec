# Milestone v1.3 Requirements: Architecture Cleanup & Schema Normalization

**Milestone:** v1.3 — Architecture Cleanup & Schema Normalization  
**Status:** In Progress  
**Created:** 2026-10-14  

---

## 1. Functional & Structural Requirements

### FR-1: Controllers & Routes Cleanup
- **FR-1.1:** Delete unused prototype controller `app/Http/Controllers/v0_CollegeController.php`.
- **FR-1.2:** Remove orphaned `app/Http/Controllers/StudentProfileController.php` and its associated view `resources/views/student/profile.blade.php`.
- **FR-1.3:** Decommission legacy admin route group (`admin/legacy/*`, `admin/locations/*`, `admin/settings/*`, `admin/reviews/*`) from `routes/web.php`, retaining only clean Filament panel routing under `/admin`.
- **FR-1.4:** Remove/retire obsolete custom Blade admin controllers in `app/Http/Controllers/Admin/*` (`CollegeManagerController.php`, `CourseManagerController.php`, `ReviewManagerController.php`, `LeadManagerController.php`, `BannerManagerController.php`, `PartnerManagerController.php`, `LeadershipMessageController.php`, `CenterLoginManagerController.php`, `MasterSettingController.php`, `LocationController.php`, `SpecializationManagerController.php`, `StreamManagerController.php`, `DashboardController.php`) and old Blade templates under `resources/views/admin/`.
- **FR-1.5:** Modernize legacy test suites (`CenterLoginTest.php`, `ContactSettingsTest.php`, `CollegeReviewModerationTest.php`) so all tests run against current models and Filament panel resources without depending on deleted legacy routes.

### FR-2: Model & Schema Normalization
- **FR-2.1:** Create database migration to drop orphaned and redundant tables:
  - Drop `college_comparisons`.
  - Drop `college_course_fees`.
  - Drop `college_course_specializations`.
  - Drop `college_learning_experiences`.
- **FR-2.2:** Delete orphaned Eloquent model classes:
  - `app/Models/CollegeComparison.php`
  - `app/Models/CollegeCourseFee.php`
  - `app/Models/CollegeCourseSpecialization.php`
  - `app/Models/CollegeLearningExperience.php`
- **FR-2.3:** Update `App\Models\CollegeCourse`:
  - Remove `fees()` and `specializationFees()` relationships since `college_courses` directly stores fee amounts, fee types, specializations, durations, and eligibility.
- **FR-2.4:** Update `App\Models\College`:
  - Consolidate institutional highlights by removing `learningExperiences()` relationship in favor of `collegeHighlights()`.
- **FR-2.5:** Simplify public college show template (`resources/views/colleges/show.blade.php`) to fetch course fee details directly from `collegeCourses` without referencing `specializationFees`.
- **FR-2.6:** Delete redundant duplicate migration `database/migrations/2026_09_15_202122_repair_college_alumni_table.php` (already fully handled in `2026_09_15_191011_update_college_table.php`).
- **FR-2.7:** Clean seeders (`RegularCollegeSeeder.php`, `OnlineUniversitySeeder.php`, `DistanceOnlineCollegeSeeder.php`, `StreamCourseSpecializationSeeder.php`, `CollegeSeeder.php`) to remove references to dropped tables.

---

## 2. Non-Functional & Verification Requirements

### NFR-1: Zero Regressions
- All tests must pass with 100% green status (`php artisan test --compact`).
- Public catalog browsing, college detail page, lead inquiry submission, and review creation must continue functioning without error.

### NFR-2: Code Hygiene & Pint Compliance
- Run Laravel Pint formatter (`vendor/bin/pint --format agent`) across all modified PHP files with 0 style issues.

### NFR-3: Database Integrity
- `php artisan migrate` runs smoothly on fresh and existing databases.
