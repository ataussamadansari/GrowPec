# Phase 8 Plan: Admin Moderation Suite & Pest Testing

**Phase:** 8  
**Milestone:** v1.1 — Public Guest College Review System (Without Login)  
**Goal:** Build a complete administrative moderation interface to approve, reject, or delete visitor reviews, integrate the admin sidebar link with badge counters, and author comprehensive automated feature tests.  
**Status:** Completed  

---

## 1. Context & Architecture

Existing state:
- Schema and models (Phase 5), public controller and rate limiting (Phase 6), and frontend detail page showcase/form (Phase 7) are completed and verified.
- Reviews submitted by public guests are stored with `status = 'pending'`.
- There is currently no admin controller or view to manage reviews.

Planned state:
- Controller: `App\Http\Controllers\Admin\ReviewManagerController` with `index`, `approve`, `reject`, and `destroy` methods.
- Routes: `admin.reviews.*` registered in `routes/web.php` under the existing authenticated admin group.
- View: `resources/views/admin/reviews/index.blade.php` with status tabs, search/filter controls, review table, and quick moderation actions.
- Layout: Add "College Reviews" navigation item with pending count badge in `resources/views/admin/layout.blade.php`.
- Test Suite: `tests/Feature/CollegeReviewModerationTest.php` verifying authorization, status changes, deletions, and public visibility sync.

---

## 2. Tasks & Execution Steps

### Task 8.1: Create `ReviewManagerController`
- **Artifact:** `app/Http/Controllers/Admin/ReviewManagerController.php`
- **Status:** [x] Completed

### Task 8.2: Register Admin Routes in `routes/web.php`
- **Artifact:** `routes/web.php`
- **Status:** [x] Completed

### Task 8.3: Create Admin Moderation View
- **Artifact:** `resources/views/admin/reviews/index.blade.php`
- **Status:** [x] Completed

### Task 8.4: Update Admin Sidebar in `admin/layout.blade.php`
- **Artifact:** `resources/views/admin/layout.blade.php`
- **Status:** [x] Completed

### Task 8.5: Author Pest Automated Moderation Tests
- **Artifact:** `tests/Feature/CollegeReviewModerationTest.php`
- **Status:** [x] Completed (8/8 tests passed, 58 assertions)

---

## 3. Verification & Acceptance Criteria
- [x] Admin can view reviews index at `/admin/reviews`.
- [x] Status tabs display correct real-time counters.
- [x] Approving a review publishes it to the public page immediately.
- [x] Rejecting a review removes it from the public page immediately.
- [x] Deleting a review removes the record from the database.
- [x] Sidebar displays "College Reviews" link and pending count pill.
- [x] All Pest tests in `CollegeReviewModerationTest` pass (100% green).
- [x] Entire test suite passes without regressions (42 tests, 234 assertions).
- [x] Clean Pint formatting.
