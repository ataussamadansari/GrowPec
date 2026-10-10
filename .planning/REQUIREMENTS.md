# Requirements: Milestone v1.2 — Filament Admin Panel v5 Migration

**Milestone:** v1.2 — Filament Admin Panel v5 Migration  
**Status:** Approved  
**Version:** 1.2  
**Date:** 2026-10-11  

---

## 1. Functional Requirements

### FR-1: Filament Installation, Authentication & Panel Foundation
- **FR-1.1:** Require `filament/filament:"^5.0"` via Composer and ensure assets are published via `php artisan filament:upgrade`.
- **FR-1.2:** Configure `AdminPanelProvider` (`app/Providers/Filament/AdminPanelProvider.php`):
  - Path: `/admin`
  - Colors: Brand primary palette (GrowPec Navy `#002B67`, Emerald Green `#008A43`, Gold `#D9A400`).
  - Brand name: "GrowPec Administration".
  - Login route & authentication: Native Filament v5 login page (`->login()`).
  - Discover resources, pages, and widgets automatically.
- **FR-1.3:** Update `App\Models\User`:
  - Implement `Filament\Models\Contracts\FilamentUser`.
  - Implement `canAccessPanel(Panel $panel): bool` ensuring only users with `role` in `['super_admin', 'sub_admin']` are granted panel access.
- **FR-1.4:** Session and authentication behavior:
  - Unauthorized users (guests and users with role `student`) are denied entry with 403 or redirected to login.

### FR-2: Academic & Geographic Master Resources
- **FR-2.1:** `StateResource` & `CityResource`:
  - Forms: State name, code/status toggle. City name, state selector (`Select::make('state_id')->relationship('state', 'name')->searchable()->required()`), status toggle.
  - Tables: Searchable names, state filters, status toggles (`ToggleColumn` or boolean icons), and bulk actions.
- **FR-2.2:** `StreamResource`, `CourseResource`, `SpecializationResource`:
  - `StreamResource`: Name, slug (auto-generated), description, status toggle.
  - `CourseResource`: Name, stream relation (`belongsTo`), duration, eligibility, short description, slug, status toggle.
  - `SpecializationResource`: Name, course relation (`belongsTo`), slug, status toggle.
  - Tables: Filter by stream and course, search by keyword, quick inline editing where appropriate.

### FR-3: Marketing, CRM & Review Moderation Resources
- **FR-3.1:** `LeadResource`:
  - Form schema: Student name, email, phone, target college, preferred course, source, counseling status (`new`, `contacted`, `counseling`, `admitted`, `closed`), notes.
  - Table: Status badges, date range filter, search by student name/phone/email, export to CSV action.
  - RelationManager or Activity log: Show counselor notes and status changes.
- **FR-3.2:** `CollegeReviewResource`:
  - Table: Reviewer name, email, IP address, target college, rating (visual star representation or badge), course, review body excerpt, status badge (`pending`, `approved`, `rejected`), created date.
  - Tabs or Filters: Tabbed navigation or filter by `status` (Pending, Approved, Rejected, All).
  - Quick Row Actions:
    - **Approve**: 1-click action setting `status = 'approved'` and `is_verified = true` with success notification.
    - **Reject**: 1-click action setting `status = 'rejected'` with warning notification.
    - **Delete**: Standard delete action with confirmation modal.
- **FR-3.3:** Marketing & Static Resources:
  - `BannerResource`: Hero banner image upload, title, subtitle, CTA text, CTA URL, order index, active toggle.
  - `PartnerResource`: University logo upload, partner name, website URL, order index, status toggle.
  - `LeadershipMessageResource`: Leader name, role (`director`, `ceo`), photo, designation, full message body, status toggle.
  - `CenterLoginResource`: Center title, login portal URL, order index, status toggle.
  - `MasterSettingResource` (or Custom Settings Page): Maintenance mode toggle, contact email, phone, address, social media links.

### FR-4: College Aggregate Root & Relation Managers
- **FR-4.1:** `CollegeResource` Form Schema (Tabbed/Sectioned Layout):
  - **Tab 1: Basic Information**:
    - Name, slug, college mode (`regular`, `online`, `distance`), status toggle, featured toggle.
    - State & City reactive dropdowns (`state_id`, `city_id`).
    - Base rating, established year, campus size, ownership/type (private, government, deemed).
    - Logo, cover banner, and brochure download link or file upload.
  - **Tab 2: Overview & Details**:
    - About college (rich editor), highlights, ranking details (NIRF/NAAC).
    - Minimum & maximum fee range, average package, highest package.
  - **Tab 3: SEO & Meta**:
    - Meta title, meta description, meta keywords.
- **FR-4.2:** Filament RelationManagers:
  - `CoursesRelationManager`: Manage course offerings, tuition fees, eligibility, duration.
  - `AccreditationsRelationManager`: NAAC grade, UGC, AICTE, NIRF rankings.
  - `FacilitiesRelationManager`: Campus facilities (Hostel, WiFi, Sports, Labs, Library).
  - `PlacementStatsRelationManager`: Placement percentage, top recruiters, salary packages.
  - `CareerOutcomesRelationManager`: Career paths, job roles, industries.
  - `FaqsRelationManager`: Question & answer pairs for the college detail page.
  - `GalleriesRelationManager`: Campus photos and video URLs.
  - `ScholarshipsRelationManager`: Scholarship schemes, eligibility, deduction amount.
  - `DocumentsRelationManager`: Mandatory disclosure PDFs and admission forms.
- **FR-4.3:** Table View:
  - Columns: Logo thumbnail, College name, City/State, Mode badge (`regular`/`online`), Status toggle, Rating badge, Courses count, Reviews count.
  - Filters: Mode filter (`regular`, `online`), State filter, Status filter.

### FR-5: Dashboard & Legacy Cutover
- **FR-5.1:** Filament Dashboard Overview:
  - Stats overview widget: Total Colleges (with regular vs online split), Total Leads (with new leads count), Pending College Reviews (with moderation link), Active Partners.
- **FR-5.2:** Legacy Admin Route Cutover:
  - Gracefully redirect or retire legacy custom admin controllers and routes (`routes/web.php` lines under `admin.`).
  - Ensure zero disruption to public website routes or authentication flows.
- **FR-5.3:** Automated Test Coverage:
  - Author comprehensive Pest feature tests covering Filament panel authentication, resources CRUD, review approval/rejection actions, and college relation managers.

---

## 2. Non-Functional Requirements (NFRs)

- **NFR-1: Performance & Bundling**: Filament v3 assets must be published or compiled via Vite without blocking public website styles or causing manifest errors.
- **NFR-2: Role-Based Access Control**: Strict enforcement of `canAccessPanel()` so students or unauthenticated guests can never access `/admin`.
- **NFR-3: Code Formatting**: All created or modified PHP files must pass `vendor/bin/pint --dirty --format agent`.
- **NFR-4: Zero Regression**: The existing 42 passing Pest feature tests for public college show pages, lead submissions, and reviews must remain 100% green.
