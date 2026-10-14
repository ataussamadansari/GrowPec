# Project: GrowPec Education Portal

**Current State:** Active Milestone v1.3 — Architecture Cleanup & Schema Normalization  
**Updated:** 2026-10-14  
**Framework:** Laravel 12 on PHP 8.2+  
**Admin Tool:** Filament Admin Panel v5 (`filament/filament:"^5.0"`)  
**Database:** MySQL (growpec_db)  
**Test Suite Health:** 116 passed tests (510 assertions), 100% green  

---

## 1. Project Overview & Current State
GrowPec is an education portal empowering students across India to discover, compare, and enroll in top regular and distance/online colleges.

As of **Milestone v1.2**, the entire administrative back-office has been modernized with **Filament Admin Panel v5**:
- Unified authentication & role access control on path `/admin` (`super_admin`, `sub_admin`).
- 11 comprehensive Filament Resources across College Management, Academics & Geography, Leads & Reviews, and Marketing & Settings.
- 8 RelationManagers on `CollegeResource` managing child course offerings, accreditations, facilities, placement stats, career outcomes, scholarships, FAQs, and photo galleries.
- Real-time dashboard overview with `StatsOverviewWidget`, `LatestLeadsWidget`, and `PendingReviewsWidget` (featuring 1-click review moderation).
- 116 automated Pest feature tests verifying all public and administrative workflows with 0 regressions.

---

## 2. Active Milestone Goals: v1.3 Architecture Cleanup & Schema Normalization
- **Phase 14: Controllers & Routes Cleanup:**
  - Delete unused prototype `v0_CollegeController.php` and orphaned `StudentProfileController.php`.
  - Remove legacy admin route block (`admin/legacy/*`, `admin/locations/*`, `admin/settings/*`, `admin/reviews/*`) from `routes/web.php`.
  - Safely retire deprecated custom Blade admin controllers (`app/Http/Controllers/Admin/*`) and templates (`resources/views/admin/`).
  - Modernize legacy test suites (`CenterLoginTest`, `ContactSettingsTest`, `CollegeReviewModerationTest`) to ensure continuous 100% test pass rate without relying on deleted routes.
- **Phase 15: Model & Schema Normalization:**
  - Drop redundant tables via migration: `college_comparisons`, `college_course_fees`, `college_course_specializations`, `college_learning_experiences`.
  - Delete orphaned models (`CollegeComparison`, `CollegeCourseFee`, `CollegeCourseSpecialization`, `CollegeLearningExperience`).
  - Consolidate highlights/learning experiences in `College.php` and streamline `CollegeCourse.php` & public views to read directly from `college_courses`.
  - Delete duplicate alumni migration `2026_09_15_202122_repair_college_alumni_table.php` and sanitize seeders.
- **Phase 16: End-to-End Verification, Code Hygiene & Documentation:**
  - Full test suite execution (`php artisan test --compact`) ensuring 0 regressions.
  - Laravel Pint code styling compliance (`vendor/bin/pint --format agent`).
  - Milestone audit report and archival readiness.

---

## 3. Technology Stack & Architecture
- **Backend:** Laravel 12, PHP 8.2+
- **Admin Panel:** Filament v5 (`filament/filament:"^5.0"`)
- **Database:** MySQL with Eloquent (33 domain models)
- **Frontend / Public:** Blade templates, Bootstrap 5.3.3
- **Testing:** Pest 3.8 / PHPUnit 11 with `RefreshDatabase`
- **Code Standards:** Laravel Pint (`vendor/bin/pint --format agent`)

---

## 4. Milestone History
- **v1.0 — Architecture Mapping & Foundational Setup:** Codebase mapping and distance/online catalog foundation.
- **v1.1 — Public Guest College Review System:** Unauthenticated visitor review submission, honeypot & throttling, public showcase, and moderation suite.
- **v1.2 — Filament Admin Panel v5 Migration (Shipped):** Complete replacement of custom Blade admin controllers with Filament v5 Resources, RelationManagers, and Dashboard widgets.

<details>
<summary>Archived Milestone v1.2 Context & Objectives</summary>

### Milestone v1.2 Core Objectives (Completed)
- **Filament Foundation & Auth:** Install Filament v5, configure `AdminPanelProvider` on path `/admin`, and enforce `FilamentUser` access policies based on user roles (`super_admin`, `sub_admin`).
- **Academic & Geographic Masters:** Implement Filament Resources for `State`, `City`, `Stream`, `Course`, and `Specialization` with schema validation, auto-slug, and reactive dropdown lookups.
- **Marketing, CRM & Review Moderation:** Implement `LeadResource` (with activity logs and status badges), `CollegeReviewResource` (with 1-click Approve/Reject table actions and status tabs), `BannerResource`, `PartnerResource`, `LeadershipMessageResource`, `CenterLoginResource`, and `MasterSettingResource`.
- **College Aggregate Root & Relation Managers:** Build `CollegeResource` with multi-tab layout and dedicated RelationManagers for courses & fees, accreditations, facilities, placement stats, FAQs, galleries, scholarships, and documents.
- **Dashboard & Legacy Cutover:** Provide overview stat widgets and safely deprecate/redirect legacy custom admin routes to Filament panel routes.

See complete records in [.planning/milestones/v1.2-ROADMAP.md](.planning/milestones/v1.2-ROADMAP.md) and [.planning/v1.2-MILESTONE-AUDIT.md](.planning/v1.2-MILESTONE-AUDIT.md).
</details>
