# Phase 11 Plan: Marketing, CRM & Review Moderation Resources

**Phase:** 11  
**Milestone:** v1.2 — Filament Admin Panel v5 Migration  
**Goal:** Create native Filament v5 Resources for Leads CRM (`LeadResource`), Review Moderation with 1-click Approve/Reject (`CollegeReviewResource`), and Marketing & Settings (`BannerResource`, `PartnerResource`, `LeadershipMessageResource`, `CenterLoginResource`, `ManageSettings` Page), complete with Pest automated test coverage.  
**Status:** Complete  
**Executed At:** 2026-10-12  
**Verification:** 90 Pest tests passed (390 assertions), Laravel Pint clean.

---

## 1. Context & Architecture

### Existing State:
- Reviews, leads, and marketing/settings were managed via custom Blade controllers:
  - `ReviewManagerController.php` (College Reviews Moderation)
  - `LeadManagerController.php` (Leads CRM with notes and status workflow)
  - `BannerManagerController.php` (Home Banners)
  - `PartnerManagerController.php` (Partner Universities)
  - `LeadershipMessageController.php` (Director & CEO Messages)
  - `CenterLoginManagerController.php` (Center Logins with caching)
  - `MasterSettingController.php` (System settings with caching)

### Target Architecture (Filament v5):
- Resources placed in `app/Filament/Resources/` and pages in `app/Filament/Pages/`:
  - **Group `'Leads & Reviews'`**:
    - `App\Filament\Resources\Leads\LeadResource` (Sort: 1, Icon: `Heroicon::OutlinedUserGroup`)
    - `App\Filament\Resources\CollegeReviews\CollegeReviewResource` (Sort: 2, Icon: `Heroicon::OutlinedStar`)
  - **Group `'Marketing & Settings'`**:
    - `App\Filament\Resources\Banners\BannerResource` (Sort: 1, Icon: `Heroicon::OutlinedPhoto`)
    - `App\Filament\Resources\Partners\PartnerResource` (Sort: 2, Icon: `Heroicon::OutlinedBuildingLibrary`)
    - `App\Filament\Resources\LeadershipMessages\LeadershipMessageResource` (Sort: 3, Icon: `Heroicon::OutlinedUser`)
    - `App\Filament\Resources\CenterLogins\CenterLoginResource` (Sort: 4, Icon: `Heroicon::OutlinedArrowRightOnRectangle`)
    - `App\Filament\Pages\ManageSettings` (Sort: 5, Icon: `Heroicon::OutlinedAdjustmentsHorizontal`)
- Preserves all business rules & workflows:
  - College Review Moderation: Quick 1-click **Approve** (sets `status='approved'`, `is_verified=true`) and **Reject** (sets `status='rejected'`) table actions with notifications; status tabs (`all`, `pending`, `approved`, `rejected`).
  - Lead Management: Status progression (`new`, `contacted`, `counseling`, `admitted`, `closed`), counselor assignment, and follow-up notes.
  - Image Uploads & Cleanup: Public disk storage for banners, logos, and leadership photos with storage cleanup on deletion.
  - Cache Management: Automatic cache invalidation for `CenterLogin` and `SystemSetting`.

---

## 2. Tasks & Execution Steps

### Task 11.1: Scaffold and Implement Review Moderation & Leads CRM Resources
- **Action:**
  - Scaffold `CollegeReviewResource` and `LeadResource` via `php artisan make:filament-resource`.
  - Configure `CollegeReviewResource`:
    - Navigation Group: `'Leads & Reviews'`, Sort: 2, Icon: `Heroicon::OutlinedStar`.
    - Table: Reviewer name, email, college badge, course, star rating/badge, review excerpt, status badge (`pending` warning, `approved` success, `rejected` danger), verified toggle/badge, IP address, created_at.
    - Status tabs in `ListCollegeReviews`: All, Pending, Approved, Rejected.
    - Record Actions:
      - **Approve**: 1-click button (success color, check icon) setting `status = 'approved'` and `is_verified = true`.
      - **Reject**: 1-click button (danger color, x icon) setting `status = 'rejected'`.
      - EditAction and DeleteAction.
  - Configure `LeadResource`:
    - Navigation Group: `'Leads & Reviews'`, Sort: 1, Icon: `Heroicon::OutlinedUserGroup`.
    - Form: Student name, phone, email, city, state, college (Select relation), course (Select relation), specialization (Select relation), status (`new`, `contacted`, `counseling`, `admitted`, `closed`), assigned counselor (Select relation to `User`), next follow-up datetime, notes.
    - Table: Student name, phone, email, college name, course name, status badge, counselor badge, next follow-up, created_at.
    - Filters: Status filter, college filter.

### Task 11.2: Scaffold and Implement Marketing Resources (`BannerResource`, `PartnerResource`, `LeadershipMessageResource`, `CenterLoginResource`)
- **Action:**
  - Scaffold `BannerResource`, `PartnerResource`, `LeadershipMessageResource`, `CenterLoginResource`.
  - Configure `BannerResource`:
    - Navigation Group: `'Marketing & Settings'`, Sort: 1, Icon: `Heroicon::OutlinedPhoto`.
    - Form: Title, image upload (`banners`, public disk), sort_order, status toggle.
    - Table: Image preview thumbnail, title, sort_order, status toggle.
  - Configure `PartnerResource`:
    - Navigation Group: `'Marketing & Settings'`, Sort: 2, Icon: `Heroicon::OutlinedBuildingLibrary`.
    - Form: Partner university name, logo upload (`partners`, public disk), sort_order, status toggle.
    - Table: Logo preview thumbnail, name, sort_order, status toggle.
  - Configure `LeadershipMessageResource`:
    - Navigation Group: `'Marketing & Settings'`, Sort: 3, Icon: `Heroicon::OutlinedUser`.
    - Form: Role (`director`, `ceo`), name, designation, photo upload (`leadership`, public disk), message body (Textarea), status toggle.
    - Table: Photo thumbnail, role badge, name, designation, status toggle.
  - Configure `CenterLoginResource`:
    - Navigation Group: `'Marketing & Settings'`, Sort: 4, Icon: `Heroicon::OutlinedArrowRightOnRectangle`.
    - Form: Title, portal URL, index (order), is_active toggle.
    - Table: Title, URL, index, is_active toggle.

### Task 11.3: Implement `ManageSettings` Custom Filament Page
- **Action:**
  - Create `app/Filament/Pages/ManageSettings.php` extending `Filament\Pages\Page`.
  - Navigation Group: `'Marketing & Settings'`, Sort: 5, Icon: `Heroicon::OutlinedAdjustmentsHorizontal`.
  - Form sections/tabs:
    - General & SEO: Tagline, SEO title, site description, site keywords.
    - Support & Contacts: Support phone, support email, office address, map embed URL.
    - Social Media Links: Facebook, Instagram, LinkedIn, YouTube, Twitter.
  - Saves directly to `SystemSetting` key-values and clears the settings cache.

### Task 11.4: Author Automated Pest Feature Tests
- **Action:**
  - Create `tests/Feature/FilamentMarketingReviewCrmTest.php`.
  - Test suites:
    1. Role Security: Guest and student access blocked on all Phase 11 resources.
    2. Super Admin Access: Can view index and create/edit pages for all Phase 11 resources and settings.
    3. `CollegeReviewResource`:
       - 1-click Approve action sets `status = 'approved'` and `is_verified = true`.
       - 1-click Reject action sets `status = 'rejected'`.
       - Delete action removes the review.
    4. `LeadResource`:
       - List leads, create lead, update status.
    5. `BannerResource` & `PartnerResource`:
       - List and create records with image/logo.
    6. `LeadershipMessageResource`:
       - List and create director/ceo messages.
    7. `CenterLoginResource`:
       - List, create, and active toggle.
    8. `ManageSettings`:
       - Load settings page and update settings values.

### Task 11.5: Code Formatting & Full Regression Verification
- **Action:**
  - Run `vendor/bin/pint --dirty --format agent`.
  - Run `php artisan test --compact` to verify 100% test pass rate with 0 regressions.

---

## 3. Verification & Acceptance Criteria
- [ ] `CollegeReviewResource` renders in Filament with status tabs and 1-click Approve/Reject actions working seamlessly.
- [ ] `LeadResource` allows managing student leads with status progression and counselor assignment.
- [ ] `BannerResource`, `PartnerResource`, `LeadershipMessageResource`, and `CenterLoginResource` provide full CRUD management with file uploads.
- [ ] `ManageSettings` page updates system settings and invalidates cache properly.
- [ ] All resources grouped in `'Leads & Reviews'` and `'Marketing & Settings'` with correct icons and sort order.
- [ ] Automated Pest tests in `FilamentMarketingReviewCrmTest.php` pass 100%.
- [ ] All existing 67 tests continue to pass without regressions.
- [ ] Laravel Pint code style checks pass cleanly.
