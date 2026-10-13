# Phase 12 Plan: College Aggregate Resource & Relation Managers

**Phase:** 12  
**Milestone:** v1.2 — Filament Admin Panel v5 Migration  
**Goal:** Build the primary `CollegeResource` in Filament Admin Panel v5 featuring an organized multi-tab form layout, a rich table view with filters/badges, and 8 child RelationManagers for comprehensive institutional management, verified with automated Pest tests.  
**Status:** Completed (15 tests passed, 75 assertions; full suite 105 passed, 465 assertions)  

---

## 1. Context & Architecture

### Existing State:
- Colleges and their 15+ sub-entities were managed via the legacy monolithic Blade controller `CollegeManagerController.php` (718 lines) under `/admin/colleges`.
- In `routes/web.php`, `Route::resource('colleges', AdminCollege::class);` is currently bound directly under `/admin/colleges`.
- Core database schema:
  - `colleges`: Primary aggregate root containing over 35 attributes (basic info, location, branding, NIRF/NAAC ratings, fees/packages, editorial content, and SEO metadata).
  - Child tables linked via `college_id`:
    - `college_courses` (`CollegeCourse`): Academic offerings, tuition fees, eligibility, and duration.
    - `college_accreditations` (`CollegeAccreditation`): Approvals, authorities, grades, and ranks.
    - `college_facilities` (`CollegeFacility`): Infrastructure and amenities.
    - `college_placement_stats` (`CollegePlacementStat`): Annual placement metrics, packages, and recruiter stats.
    - `college_career_outcomes` (`CollegeCareerOutcome`): Career paths, roles, industries, and average packages.
    - `college_scholarships` (`CollegeScholarship`): Scholarship programs, eligibility, waivers, and amounts.
    - `college_faqs` (`CollegeFaq`): Institutional FAQ questions and answers.
    - `college_gallery` (`CollegeGallery`): Campus photos, event images, and facility galleries.

### Target Architecture (Filament v5):
- Move legacy route `admin/colleges` to `admin/legacy/colleges` to ensure `/admin/colleges` cleanly serves Filament v5's `CollegeResource` while keeping named routes backward-compatible.
- Create `CollegeResource` under `app/Filament/Resources/Colleges/`:
  - Navigation Group: `'College Management'` (`protected static string|UnitEnum|null $navigationGroup = 'College Management';`).
  - Navigation Icon: `Heroicon::OutlinedAcademicCap`.
  - Navigation Sort: 1.
- Form Schema (`CollegeForm.php`):
  - Uses `Tabs::make('CollegeDetails')` to neatly segment complex college data:
    1. **Tab 1: Overview & Location** — Name, slug, short name, college mode (`regular` vs `online`), university name, college type, established year, website, campus size, state, city, address, featured toggle, status toggle.
    2. **Tab 2: Media & Assets** — Logo image, hero banner image, sample degree certificate, brochure PDF.
    3. **Tab 3: Ratings, Accreditations & Placements** — Star rating, NAAC grade, UGC approval toggle, NIRF ranking and year, approval list, entrance exam list, highest package, average package, top recruiters, hostels toggles, facilities overview.
    4. **Tab 4: Editorial & SEO** — College overview text, admission process details, scholarship overview, SEO title, SEO description.
- Table Configuration (`CollegesTable.php`):
  - Thumbnail logo, college name, mode badge (`regular` info / `online` primary), location badges (state/city), rating badge (`★ 4.5/5`), featured indicator, active status toggle/icon, course count badge.
  - Filters: Mode filter (`regular` / `online`), State filter, Active status filter, Featured filter.
  - Actions: EditAction, DeleteAction, BulkDeleteAction.
- RelationManagers (`app/Filament/Resources/Colleges/RelationManagers/`):
  1. `CollegeCoursesRelationManager` (`collegeCourses` relation)
  2. `AccreditationsRelationManager` (`accreditations` relation)
  3. `FacilitiesRelationManager` (`collegeFacilities` relation)
  4. `PlacementStatsRelationManager` (`placementStats` relation)
  5. `CareerOutcomesRelationManager` (`careerOutcomes` relation)
  6. `ScholarshipsRelationManager` (`scholarships` relation)
  7. `FaqsRelationManager` (`collegeFaqs` relation)
  8. `GalleriesRelationManager` (`gallery` relation)

---

## 2. Tasks & Execution Steps

### Task 12.1: Route Harmonization & Resource Scaffolding
- **Action:**
  - In `routes/web.php`, move `Route::resource('colleges', AdminCollege::class);` into `Route::prefix('legacy')` group.
  - Scaffold `CollegeResource` via `php artisan make:filament-resource College --model=App\\Models\\College --no-interaction`.
  - Scaffold 8 RelationManagers via `php artisan make:filament-relation-manager CollegeResource <relation> <titleAttr> --no-interaction`.
- **Artifacts:**
  - `routes/web.php`
  - `app/Filament/Resources/Colleges/CollegeResource.php`
  - `app/Filament/Resources/Colleges/Pages/ListColleges.php`
  - `app/Filament/Resources/Colleges/Pages/CreateCollege.php`
  - `app/Filament/Resources/Colleges/Pages/EditCollege.php`
  - `app/Filament/Resources/Colleges/RelationManagers/` (8 classes)

### Task 12.2: Implement College Form & Table Schemas
- **Action:**
  - Implement `app/Filament/Resources/Colleges/Schemas/CollegeForm.php` with 4-tab layout, state/city cascading relations, file uploads on `public` disk, and validation constraints.
  - Implement `app/Filament/Resources/Colleges/Tables/CollegesTable.php` with columns, rating badges, mode colors, filters, and actions.
  - Configure `CollegeResource.php` navigation properties (`'College Management'`, icon, sort 1).

### Task 12.3: Implement Child Entity RelationManagers
- **Action:**
  - Configure forms and tables for each RelationManager:
    - `CollegeCoursesRelationManager`: Course selector, specialization, fee amount, fee type, duration, eligibility, seats, status.
    - `AccreditationsRelationManager`: Authority, accreditation, grade, rank, year, certificate image, status.
    - `FacilitiesRelationManager`: Name, icon, description, image, status.
    - `PlacementStatsRelationManager`: Year, metric label, metric value, percentage, course, status.
    - `CareerOutcomesRelationManager`: Career role, industry, average salary, salary range, status.
    - `ScholarshipsRelationManager`: Name, eligibility, criteria, amount, percentage, status.
    - `FaqsRelationManager`: Question, answer, status.
    - `GalleriesRelationManager`: Title, image, category, alt text, status.
  - Register all 8 RelationManagers in `CollegeResource::getRelations()`.

### Task 12.4: Author Automated Pest Feature Tests
- **Action:**
  - Create `tests/Feature/FilamentCollegeResourceTest.php`.
  - Test suites:
    1. Guest & student access control: Verify redirection / 403 Forbidden for `/admin/colleges` and `/admin/colleges/create`.
    2. Super admin access: Verify 200 OK on college index, create, and edit pages.
    3. College CRUD via Livewire: Test creating a college using `CreateCollege::class` and updating via `EditCollege::class`.
    4. RelationManager Livewire tests:
       - Creating child course offering via `CollegeCoursesRelationManager`.
       - Creating accreditation via `AccreditationsRelationManager`.
       - Creating facility via `FacilitiesRelationManager`.
       - Creating placement stat via `PlacementStatsRelationManager`.
       - Creating FAQ via `FaqsRelationManager`.

### Task 12.5: Code Formatting & Regression Verification
- **Action:**
  - Run `vendor/bin/pint --dirty --format agent` (and on `app/Filament/Resources/Colleges/`).
  - Run narrow Pest tests: `vendor/bin/pest tests/Feature/FilamentCollegeResourceTest.php`.
  - Run complete test suite: `php artisan test --compact` (ensuring 100+ tests pass with zero regressions).

---

## 3. Verification & Acceptance Criteria
- [x] `/admin/colleges` is served by Filament v5 without conflict from legacy routes.
- [x] Administrators can create and edit colleges with all tabs and media uploads.
- [x] Administrators can manage courses, accreditations, facilities, placements, careers, scholarships, FAQs, and gallery items directly from the College edit page.
- [x] All 90 existing tests pass + new college feature tests pass (105 total passed).
- [x] Clean code formatting according to Laravel Pint rules.
