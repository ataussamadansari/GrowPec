# Phase 13 Plan: Dashboard Widgets, Legacy Cutover & Tests

**Phase:** 13  
**Milestone:** v1.2 — Filament Admin Panel v5 Migration  
**Goal:** Build native Filament v5 dashboard widgets (StatsOverview, Recent Leads, Pending Review Moderation), transition legacy admin entry points and redirects to Filament, and verify complete test suite integrity with zero regressions.  
**Status:** Planned  

---

## 1. Context & Architecture

### Existing State:
- Legacy custom Blade dashboard (`DashboardController.php` & `resources/views/admin/dashboard.blade.php`):
  - Displayed stats: Total Colleges (regular vs online), Total Leads (with today's count), Total Courses.
  - Displayed Recent Student Enquiries table with contact info and status.
  - Legacy login in `AuthController.php` redirected to `route('admin.dashboard')` (`/admin/dashboard`).
- Filament Panel (`/admin`):
  - `AdminPanelProvider` currently registers default `AccountWidget` and `FilamentInfoWidget`.
  - All 11 resources and 8 relation managers across College Management, Academics & Geography, Leads & Reviews, and Marketing & Settings are fully built and verified in Filament v5.
- Milestone v1.2 Test Suite:
  - 105 tests passing (465 assertions) across all features and legacy routes.

### Target Architecture (Filament v5):
1. **Dashboard Widgets (`app/Filament/Widgets/`)**:
   - `StatsOverviewWidget`:
     - Displays key real-time platform metrics:
       - **Total Colleges**: Total institutions, with regular vs online count subtitle.
       - **Total Leads**: Total student inquiries, with today's count subtitle.
       - **Pending Reviews**: Moderation queue count, highlighted with danger/warning indicator.
       - **Academic Courses**: Total academic courses cataloged.
     - Sort: 1.
   - `LatestLeadsWidget`:
     - Extends `TableWidget`.
     - Displays latest 5 student inquiries with student name, contact/phone, college, course, color-coded status badge, and relative timestamp.
     - View/Edit action linking directly to `LeadResource`.
     - Sort: 2.
   - `PendingReviewsWidget`:
     - Extends `TableWidget`.
     - Displays up to 5 pending reviews awaiting moderation.
     - Shows reviewer name, college, star rating, and review title/excerpt.
     - Provides instant 1-click **Approve** and **Reject** row actions with notifications right from the dashboard.
     - Sort: 3.
2. **Widget Discovery & Provider Setup**:
   - In `AdminPanelProvider.php`, replace `FilamentInfoWidget` with GrowPec widgets while preserving `AccountWidget`.
3. **Legacy Cutover & Redirects**:
   - Update `AuthController.php`: redirect successful logins to `/admin` (Filament panel dashboard).
   - In `routes/web.php`: update `/admin/dashboard` route to redirect to `/admin` while retaining `admin.dashboard` route name for backward-compatibility.
   - Preserve legacy route aliases and named routes for existing test suites (`CenterLoginTest`, `ContactSettingsTest`, `CollegeReviewModerationTest`) ensuring zero regressions.
4. **Automated Verification**:
   - Create comprehensive Pest test suite `tests/Feature/FilamentDashboardWidgetsTest.php` testing access control, widgets rendering, stat accuracy, and 1-click widget actions.
   - Run Laravel Pint formatter.
   - Run entire test suite (`php artisan test --compact`) ensuring 100% green pass rate.

---

## 2. Tasks & Execution Steps

### Task 13.1: Implement Filament Dashboard Widgets
- **Action:**
  - Create `app/Filament/Widgets/StatsOverviewWidget.php`:
    - Extend `Filament\Widgets\StatsOverviewWidget`.
    - Implement `getStats()` returning `Stat` items for Colleges (total + regular/online), Leads (total + today), Pending Reviews (count + moderation notice), and Courses (catalog count).
  - Create `app/Filament/Widgets/LatestLeadsWidget.php`:
    - Extend `Filament\Widgets\TableWidget`.
    - Query `Lead::query()->with(['college', 'course'])->latest()->limit(5)`.
    - Columns: Name, Phone, College, Course, Status (badge), Received (since).
    - Row action: View/Edit in `LeadResource`.
  - Create `app/Filament/Widgets/PendingReviewsWidget.php`:
    - Extend `Filament\Widgets\TableWidget`.
    - Query `CollegeReview::query()->where('status', 'pending')->with(['college'])->latest()->limit(5)`.
    - Columns: Reviewer Name, College, Star Rating badge, Title/Snippet, Submitted (since).
    - Row actions: 1-click **Approve** (`status='approved'`, `is_verified=true`) and **Reject** (`status='rejected'`) with notifications.
  - Update `AdminPanelProvider.php`:
    - Register `AccountWidget`, `StatsOverviewWidget`, `LatestLeadsWidget`, and `PendingReviewsWidget`.
    - Remove placeholder `FilamentInfoWidget`.
- **Artifacts:**
  - `app/Filament/Widgets/StatsOverviewWidget.php`
  - `app/Filament/Widgets/LatestLeadsWidget.php`
  - `app/Filament/Widgets/PendingReviewsWidget.php`
  - `app/Providers/Filament/AdminPanelProvider.php`

### Task 13.2: Legacy Route Cutover & Seamless Redirection
- **Action:**
  - In `app/Http/Controllers/AuthController.php`, update post-login redirection to `url('/admin')` / Filament dashboard.
  - In `routes/web.php`, configure `/admin/dashboard` to redirect to `/admin` with `name('admin.dashboard')`.
  - Verify that legacy URLs seamlessly forward to their Filament counterparts or maintain API endpoints required by existing tests.
- **Artifacts:**
  - `app/Http/Controllers/AuthController.php`
  - `routes/web.php`

### Task 13.3: Author Automated Pest Feature Tests
- **Action:**
  - Create `tests/Feature/FilamentDashboardWidgetsTest.php`.
  - Test suites:
    1. **Authentication & Access Control**:
       - Guests visiting `/admin` are redirected to `/admin/login`.
       - Students visiting `/admin` receive 403 Forbidden.
       - Super Admins and Sub Admins access `/admin` with 200 OK.
    2. **Legacy Dashboard Cutover**:
       - Authenticated admin visiting `/admin/dashboard` is redirected to `/admin`.
    3. **StatsOverviewWidget**:
       - Renders on dashboard Livewire component.
       - Outputs accurate numbers for colleges, leads, pending reviews, and courses.
    4. **LatestLeadsWidget**:
       - Renders recent leads with correct student data and status badges.
    5. **PendingReviewsWidget**:
       - Renders pending reviews queue.
       - 1-click Approve action executes successfully and updates review status in database.
       - 1-click Reject action executes successfully and updates review status in database.
- **Artifacts:**
  - `tests/Feature/FilamentDashboardWidgetsTest.php`

### Task 13.4: Code Formatting & Full Suite Regression Verification
- **Action:**
  - Run `vendor/bin/pint --dirty --format agent`.
  - Run narrow Pest test: `vendor/bin/pest tests/Feature/FilamentDashboardWidgetsTest.php`.
  - Run complete application test suite: `php artisan test --compact` to guarantee zero regressions.
  - Confirm all 110+ tests pass with 480+ assertions.

---

## 3. Verification & Acceptance Criteria
- [ ] Filament dashboard at `/admin` renders `AccountWidget`, `StatsOverviewWidget`, `LatestLeadsWidget`, and `PendingReviewsWidget`.
- [ ] `StatsOverviewWidget` displays accurate metrics for colleges, leads, reviews, and courses.
- [ ] `LatestLeadsWidget` lists recent student inquiries with color-coded status badges.
- [ ] `PendingReviewsWidget` allows direct 1-click approve/reject actions for pending reviews.
- [ ] Legacy `/admin/dashboard` redirects cleanly to `/admin`.
- [ ] Custom login form redirects successfully to `/admin`.
- [ ] All existing 105 tests continue to pass without any regressions.
- [ ] New Pest feature tests in `FilamentDashboardWidgetsTest.php` pass 100%.
- [ ] Code formatting complies with Laravel Pint standards.
