# Phase 14 Plan: Controllers & Routes Cleanup

**Phase:** 14  
**Milestone:** v1.3 — Architecture Cleanup & Schema Normalization  
**Goal:** Remove obsolete controller prototypes (`v0_CollegeController`, `StudentProfileController`), decommission legacy admin route groups (`admin/legacy/*`, `admin/locations/*`, `admin/settings/*`, `admin/reviews/*`) from `routes/web.php`, retire deprecated `app/Http/Controllers/Admin/*` controllers and views, and modernize legacy test suites to ensure 100% green test suite health.  
**Status:** Completed

---

## 1. Context & Architecture

### Existing State:
- During Milestone v1.2, all 11 administrative resources and 8 relation managers were migrated to **Filament Admin Panel v5**.
- Legacy admin routes in `routes/web.php` were temporarily scoped under `admin/legacy/*` and individual route groups (`admin/locations/*`, `admin/settings/*`, `admin/reviews/*`) to ensure safe coexistence during the migration.
- Prototype and dead controllers still exist in the repository:
  - `app/Http/Controllers/v0_CollegeController.php`: An unrouted prototype controller defining a duplicate `CollegeController` class.
  - `app/Http/Controllers/StudentProfileController.php` & `resources/views/student/profile.blade.php`: An unrouted student profile prototype.
  - 13 custom Blade admin controllers in `app/Http/Controllers/Admin/*`: Monolithic controllers (~70KB of obsolete code) that have been 100% superseded by Filament v5 Resources, Pages, and Widgets.
  - Custom Blade admin views in `resources/views/admin/`: ~15 Blade view folders that are no longer rendered anywhere.
- Three older test files still invoke legacy routes:
  - `tests/Feature/CenterLoginTest.php` calls `route('admin.center-logins.*')`.
  - `tests/Feature/ContactSettingsTest.php` calls `route('admin.settings.*')`.
  - `tests/Feature/CollegeReviewModerationTest.php` calls `route('admin.reviews.*')`.
  (Note: Modern Filament equivalents in `tests/Feature/FilamentMarketingReviewCrmTest.php` already test these resources in Filament v5).

### Target Architecture:
1. **Clean Routes (`routes/web.php`)**:
   - Remove unused controller imports from `App\Http\Controllers\Admin\*`.
   - Remove `admin/legacy/*`, `admin/locations/*`, `admin/settings/*`, and `admin/reviews/*`.
   - Retain only the `/admin/dashboard` redirection route (`Route::get('/dashboard', fn () => redirect('/admin'))->name('dashboard')`) protected by `AdminMiddleware`.
2. **Controller & View Decluttering**:
   - Delete `app/Http/Controllers/v0_CollegeController.php`.
   - Delete `app/Http/Controllers/StudentProfileController.php` and `resources/views/student/profile.blade.php`.
   - Delete the 13 legacy controllers in `app/Http/Controllers/Admin/`.
   - Delete obsolete custom Blade admin templates under `resources/views/admin/`.
3. **Test Suite Modernization**:
   - Modernize `tests/Feature/CenterLoginTest.php` to verify `CenterLogin` model logic, active status toggling, cache management, and public frontend display without legacy admin routes.
   - Modernize `tests/Feature/ContactSettingsTest.php` to verify `SystemSetting` key-value persistence, helper methods (`getPhones()`, `getEmails()`, `getAddresses()`), and public contact display.
   - Modernize `tests/Feature/CollegeReviewModerationTest.php` to verify `CollegeReview` approval/rejection state transitions, query scopes (`approved()`, `pending()`, `rejected()`), and authorization rules.
4. **Verification**:
   - `php artisan test --compact` passes 100% green with 0 regressions.
   - `vendor/bin/pint --format agent` passes with 0 style issues.

---

## 2. Tasks & Execution Steps

### Task 14.1: Delete Dead Controller Prototypes & Templates
- **Action:**
  - Delete `app/Http/Controllers/v0_CollegeController.php`.
  - Delete `app/Http/Controllers/StudentProfileController.php`.
  - Delete `resources/views/student/profile.blade.php` and remove empty `resources/views/student` directory.
- **Verification:** Confirm files are deleted and no public routes break.

### Task 14.2: Decommission Legacy Admin Routes
- **Action:**
  - In `routes/web.php`:
    - Remove imports of legacy admin controllers (`AdminBanner`, `AdminCenterLogin`, `AdminCollege`, `AdminCourse`, `AdminDashboard`, `AdminLead`, `AdminLeadershipMessage`, `AdminLocation`, `AdminSettings`, `AdminPartner`, `AdminReview`, `AdminSpecialization`, `AdminStream`).
    - Remove `Route::prefix('legacy')->group(...)` block.
    - Remove legacy routes: `/admin/locations/*`, `/admin/settings/*`, `/admin/reviews/*`.
    - Keep only `/admin/dashboard` redirect to `/admin` with `name('admin.dashboard')`.
- **Verification:** Run `php artisan route:list` to verify only clean public and Filament routes exist.

### Task 14.3: Retire Obsolete Legacy Admin Controllers & Views
- **Action:**
  - Delete all 13 legacy admin controllers from `app/Http/Controllers/Admin/`:
    - `BannerManagerController.php`
    - `CenterLoginManagerController.php`
    - `CollegeManagerController.php`
    - `CourseManagerController.php`
    - `DashboardController.php`
    - `LeadManagerController.php`
    - `LeadershipMessageController.php`
    - `LocationController.php`
    - `MasterSettingController.php`
    - `PartnerManagerController.php`
    - `ReviewManagerController.php`
    - `SpecializationManagerController.php`
    - `StreamManagerController.php`
  - Remove obsolete custom Blade admin view directories in `resources/views/admin/`.
- **Verification:** Confirm directory `app/Http/Controllers/Admin` is removed or empty, and no broken imports remain.

### Task 14.4: Modernize Legacy Test Suites
- **Action:**
  - In `tests/Feature/CenterLoginTest.php`:
    - Refactor admin management tests to test `CenterLogin` model CRUD, cache invalidation, and active toggling directly.
    - Retain public frontend tests for header/footer center login rendering and counseling modal.
  - In `tests/Feature/ContactSettingsTest.php`:
    - Refactor admin update tests to test `SystemSetting` key-value updates, array helpers (`getPhones`, `getEmails`, `getAddresses`), and cache invalidation directly.
    - Retain public contact page and header/footer tests.
  - In `tests/Feature/CollegeReviewModerationTest.php`:
    - Refactor tests to verify `CollegeReview` state transitions (`status = 'approved'`, `status = 'rejected'`), query scopes (`approved`, `pending`, `rejected`), helper methods (`isApproved`, `isPending`, `isRejected`), and search/filtering logic.
- **Verification:** Run `vendor/bin/pest tests/Feature/CenterLoginTest.php tests/Feature/ContactSettingsTest.php tests/Feature/CollegeReviewModerationTest.php`.

### Task 14.5: Code Formatting & Full Test Suite Verification
- **Action:**
  - Run `vendor/bin/pint --dirty --format agent`.
  - Run full test suite: `php artisan test --compact`.
  - Confirm 100% passing tests with 0 regressions.

---

## 3. Verification & Acceptance Criteria
- [x] `v0_CollegeController.php` and `StudentProfileController.php` deleted.
- [x] Legacy admin route block (`admin/legacy/*`, `admin/locations/*`, `admin/settings/*`, `admin/reviews/*`) cleanly removed from `routes/web.php`.
- [x] All 13 legacy admin controllers in `app/Http/Controllers/Admin/*` deleted.
- [x] Obsolete custom Blade admin views in `resources/views/admin/` removed.
- [x] `CenterLoginTest.php`, `ContactSettingsTest.php`, and `CollegeReviewModerationTest.php` modernized and passing.
- [x] Full test suite passes 100% green (`php artisan test --compact`, 112 passed, 467 assertions).
- [x] Laravel Pint code style checks pass with 0 errors.

