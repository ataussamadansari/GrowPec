# Project Roadmap: GrowPec Education Portal

**Current Milestone:** v1.2 — Filament Admin Panel v5 Migration  
**Updated:** 2026-10-11  
**Mode:** Agile / Structured  

---

## Milestone v1.2 Phases Overview

```
┌────────────────────────────────────────────────────────┐
│ Phase 9: Filament Installation, Auth & Panel Foundation│
│ (composer require ^5.0, AdminPanelProvider, FilamentUser)│
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 10: Academic & Geographic Master Resources       │
│ (State, City, Stream, Course, Specialization)          │
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 11: Marketing, CRM & Review Moderation Resources │
│ (LeadResource, CollegeReviewResource, Banners, Partners│
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 12: College Aggregate Resource & RelationManagers│
│ (Tabs, Courses, Accreditations, Placement, Media, FAQs)│
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 13: Dashboard Widgets, Legacy Cutover & Tests    │
│ (Overview widgets, route cutover, full Pest validation)│
└────────────────────────────────────────────────────────┘
```

---

## Detailed Phase Breakdown

### Phase 9: Filament Installation, Auth & Panel Foundation
- **Goal:** Install Filament v5 into Laravel 12, configure `AdminPanelProvider` under `/admin`, implement `FilamentUser` access policies, and establish the base admin panel foundation.
- **Tasks:**
  - Install `filament/filament:"^5.0"` via Composer.
  - Scaffold and configure `AdminPanelProvider` (`/admin` path, brand name, primary colors, navigation groups).
  - Implement `FilamentUser` on `App\Models\User` with `canAccessPanel(Panel $panel): bool` checking `role` in `['super_admin', 'sub_admin']`.
  - Feature tests in Pest verifying panel authentication, role access control, and student/guest rejection.
- **Success Criteria:** Admin users can log in to `/admin` and see the Filament dashboard; unauthenticated users and students are denied access.

### Phase 10: Academic & Geographic Master Resources
- **Goal:** Create complete Filament Resources for Geographic and Academic master entities.
- **Tasks:**
  - Create `StateResource` and `CityResource` with search, state relationship binding, and status toggles.
  - Create `StreamResource`, `CourseResource`, and `SpecializationResource` with auto-slug generation, hierarchical relationships, and duration/eligibility inputs.
  - Author Pest tests verifying CRUD actions for academic and geographic resources.
- **Status:** Completed (20 tests passed, 66 assertions)
- **Success Criteria:** Administrators can manage states, cities, streams, courses, and specializations via clean Filament forms and tables.

### Phase 11: Marketing, CRM & Review Moderation Resources
- **Goal:** Migrate lead management, public review moderation, and marketing/settings resources to Filament.
- **Tasks:**
  - Create `LeadResource` with status badges, counselor notes, date filters, and CSV export.
  - Create `CollegeReviewResource` featuring:
    - Rating star display.
    - Status tabs / filters (`pending`, `approved`, `rejected`).
    - Quick 1-click **Approve** and **Reject** row action buttons.
    - Permanent delete action with confirmation modal.
  - Create marketing resources: `BannerResource`, `PartnerResource`, `LeadershipMessageResource`, `CenterLoginResource`, and `ManageSettings` page.
  - Author Pest tests verifying review moderation actions, lead management, marketing CRUD, and settings in Filament.
- **Status:** Completed (23 tests passed, 79 assertions; full suite 90 passed, 390 assertions)
- **Success Criteria:** Administrators can moderate reviews with 1 click directly in the table, manage student leads, and update site banners and settings.

### Phase 12: College Aggregate Resource & Relation Managers
- **Goal:** Build the comprehensive `CollegeResource` with multi-tab layout and child entity RelationManagers.
- **Tasks:**
  - Build `CollegeResource` form with tabs:
    - Overview (Name, Slug, Mode, State/City selectors, Logos, Brochure).
    - Details & Highlights (Fees range, Packages, NAAC/NIRF, Highlights, About).
    - SEO & Meta (Meta title, description, keywords).
  - Build RelationManagers:
    - `CoursesRelationManager` (Course offerings, tuition fees, duration).
    - `AccreditationsRelationManager` & `FacilitiesRelationManager`.
    - `PlacementStatsRelationManager` & `CareerOutcomesRelationManager`.
    - `FaqsRelationManager` & `GalleriesRelationManager`.
    - `ScholarshipsRelationManager` & `DocumentsRelationManager`.
  - Table view with logo thumbnails, mode badges, status toggles, rating, and filtering by mode/state.
  - Author Pest tests verifying College resource and relation managers.
- **Success Criteria:** Full lifecycle management of colleges and their 18 related entities in Filament.

### Phase 13: Dashboard Widgets, Legacy Cutover & Tests
- **Goal:** Add dashboard overview stat widgets, cleanly transition routes from legacy custom controllers, and verify end-to-end reliability.
- **Tasks:**
  - Build dashboard widgets: `StatsOverviewWidget` (Colleges, Leads, Pending Reviews count, Partners) and `LatestReviewsWidget` (or `LatestLeadsWidget`).
  - Safely retire or redirect legacy custom admin controllers (`ReviewManagerController`, `LeadManagerController`, etc.) to Filament panel routes.
  - Run full test suite (`php artisan test --compact`) ensuring all existing and new tests pass.
  - Run Pint formatter (`vendor/bin/pint --dirty --format agent`).
- **Success Criteria:** Zero regression across the entire application, clean Pint formatting, and complete cutover to Filament v3.

---

## Milestone Archive
- **Milestone v1.0 (Archived):** Project initialization, architecture mapping (`.planning/codebase/`), and distance/online university catalog foundation.
- **Milestone v1.1 (Archived):** Public guest college review system (Phases 5-8) with honeypot anti-spam, rate throttling, public show integration, admin moderation, and 100% passing Pest tests.
