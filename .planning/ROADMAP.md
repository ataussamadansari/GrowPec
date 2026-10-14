# Project Roadmap: GrowPec Education Portal

**Current Milestone:** v1.3 — Architecture Cleanup & Schema Normalization  
**Updated:** 2026-10-14  
**Mode:** Agile / Structured  

---

## Milestone v1.3 Phases Overview

```
┌────────────────────────────────────────────────────────┐
│ Phase 14: Controllers & Routes Cleanup                 │
│ (v0_CollegeController, StudentProfile, legacy routes)  │
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 15: Model & Schema Normalization                 │
│ (Drop comparisons, course fees/spec, experiences, migr)│
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 16: Verification, Pint Hygiene & Milestone Audit │
│ (100% green tests, Pint compliance, milestone audit)   │
└────────────────────────────────────────────────────────┘
```

---

## Detailed Phase Breakdown

### Phase 14: Controllers & Routes Cleanup
- **Goal:** Remove dead controller prototypes, decommission legacy custom admin routes from `routes/web.php`, and safely retire obsolete `Admin/*` controllers and views now handled by Filament v5.
- **Tasks:**
  - Remove unused prototype `app/Http/Controllers/v0_CollegeController.php`.
  - Remove dead `app/Http/Controllers/StudentProfileController.php` and view `resources/views/student/profile.blade.php`.
  - Remove legacy admin route block (`admin/legacy/*`, `admin/locations/*`, `admin/settings/*`, `admin/reviews/*`) from `routes/web.php`.
  - Deprecate/retire obsolete custom Blade admin controllers (`app/Http/Controllers/Admin/*`) and templates (`resources/views/admin/`).
  - Refactor or modernize legacy test files (`CenterLoginTest.php`, `ContactSettingsTest.php`, `CollegeReviewModerationTest.php`) so assertions run against current models and Filament panel resources.
- **Status:** Completed
- **Success Criteria:** No dead controllers remain; `routes/web.php` contains only active routes; all tests pass without relying on legacy admin routes.

### Phase 15: Model & Schema Normalization
- **Goal:** Drop redundant database tables, delete orphaned models, eliminate duplicate migrations, and consolidate entity relationships.
- **Tasks:**
  - Create database migration to safely drop redundant tables: `college_comparisons`, `college_course_fees`, `college_course_specializations`, and `college_learning_experiences`.
  - Remove orphaned Eloquent models: `CollegeComparison.php`, `CollegeCourseFee.php`, `CollegeCourseSpecialization.php`, and `CollegeLearningExperience.php`.
  - Update `CollegeCourse.php` to remove obsolete `fees()` and `specializationFees()` relations.
  - Update `College.php` to remove `learningExperiences()` in favor of `collegeHighlights()`.
  - Update `resources/views/colleges/show.blade.php` to read course fee data directly from `collegeCourses`.
  - Delete redundant duplicate migration `2026_09_15_202122_repair_college_alumni_table.php`.
  - Update seeders to remove insert/truncate references to dropped tables.
- **Status:** Pending
- **Success Criteria:** Database schema normalized; 4 redundant tables dropped; 4 orphaned models deleted; public college views functioning cleanly.

### Phase 16: Verification, Pint Hygiene & Milestone Audit
- **Goal:** Validate end-to-end portal stability, guarantee 0 regressions, format all files, and generate milestone audit documentation.
- **Tasks:**
  - Run complete test suite (`php artisan test --compact`) ensuring 100% green pass rate.
  - Run Laravel Pint formatter (`vendor/bin/pint --format agent`).
  - Verify migration status (`php artisan migrate:status`).
  - Author `v1.3-MILESTONE-AUDIT.md` verifying all requirements are satisfied.
- **Status:** Pending
- **Success Criteria:** 100% green test suite, clean Pint formatting, zero regressions, and audit report compiled.

---

## Milestone Archive
- **Milestone v1.0 (Archived):** Project initialization, architecture mapping (`.planning/codebase/`), and distance/online university catalog foundation.
- **Milestone v1.1 (Archived):** Public guest college review system (Phases 5-8) with honeypot anti-spam, rate throttling, public show integration, admin moderation, and 100% passing Pest tests.
- **Milestone v1.2 (Archived):** Filament Admin Panel v5 Migration (Phases 9-13) — Complete migration of admin panel to Filament v5 with 11 resources, 8 relation managers, and 3 dashboard widgets (116 tests passing, 510 assertions). See [v1.2 Roadmap Archive](.planning/milestones/v1.2-ROADMAP.md) and [v1.2 Requirements Archive](.planning/milestones/v1.2-REQUIREMENTS.md).
