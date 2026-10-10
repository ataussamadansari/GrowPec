# Project Roadmap: GrowPec Education Portal

**Current Milestone:** v1.1 — Public Guest College Review System (Without Login)  
**Updated:** 2026-10-10  
**Mode:** Agile / Fast  

---

## Milestone v1.1 Phases Overview

```
┌────────────────────────────────────────────────────────┐
│ Phase 5: Schema Migration & Eloquent Models            │
│ (Extend college_reviews: email, IP, status enum)       │
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 6: Public Submission Controller & Security       │
│ (Throttling, honeypot, validation, store endpoint)     │
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 7: Public Frontend UI (Detail Page Integration)  │
│ (Ratings summary, approved reviews & star form)        │
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 8: Admin Moderation Suite & Pest Testing         │
│ (Admin moderation UI, approve/reject & feature tests)  │
└────────────────────────────────────────────────────────┘
```

---

## Detailed Phase Breakdown

### Phase 5: Schema Migration & Eloquent Models
- **Goal:** Update `college_reviews` database table and Eloquent models to support guest submissions with pending status by default.
- **Tasks:**
  - Create migration `add_guest_fields_to_college_reviews_table.php` adding `email`, `ip_address`, and changing `status` to string (`pending`, `approved`, `rejected`) with default `'pending'`.
  - Update [app/Models/CollegeReview.php](file:///d:/GrowPec/GrowPec/app/Models/CollegeReview.php) with `$fillable`, `casts()`, and query scopes (`scopeApproved`, `scopePending`, `scopeRejected`).
  - Update [app/Models/College.php](file:///d:/GrowPec/GrowPec/app/Models/College.php) with `approvedReviews()` relationship and dynamic rating helpers.
- **Success Criteria:** Migration runs cleanly (`php artisan migrate`), unit checks verify model relations and scopes.

### Phase 6: Public Submission Controller & Security
- **Goal:** Implement secure, throttled POST endpoint for unauthenticated visitors.
- **Tasks:**
  - Create `StoreCollegeReviewRequest` with strict validation rules (rating 1-5, email format, minimum length) and invisible honeypot check (`website_hp`).
  - Create `App\Http\Controllers\CollegeReviewController@store` capturing client IP and setting `status = 'pending'`.
  - Add route in `routes/web.php`: `POST /college/{slug}/reviews` protected by rate-limiting middleware (`throttle:5,60`).
  - Handle both Blade redirect with flash feedback and JSON AJAX responses.
- **Success Criteria:** Submissions from valid guests are saved with `status = 'pending'`; spam bots filling the honeypot are rejected; excessive submissions from the same IP receive HTTP 429.

### Phase 7: Public Frontend UI (Detail Page Integration)
- **Goal:** Integrate a modern student review showcase and review submission card on the public college profile page.
- **Tasks:**
  - In [resources/views/colleges/show.blade.php](file:///d:/GrowPec/GrowPec/resources/views/colleges/show.blade.php), add a "Student Reviews" section:
    - Overall rating metric card (average score, star visualization, approved count).
    - Feed of approved reviews with verified badges, dates, and courses.
    - Friendly empty state when no approved reviews exist.
  - Add "Write a Review" form:
    - Interactive 5-star selector with hover/click preview.
    - Clean form inputs (Name, Email, Course, Review body).
    - Hidden honeypot input field.
    - Clear client feedback and moderation notice.
- **Success Criteria:** Verified reviews display correctly; new submissions show immediate feedback stating review is pending moderation; zero visual glitches or layout shifts.

### Phase 8: Admin Moderation Suite & Pest Testing
- **Goal:** Provide administrative controls for review approval/rejection and ensure end-to-end reliability through automated tests.
- **Tasks:**
  - Create `App\Http\Controllers\Admin\ReviewManagerController` with `index`, `approve`, `reject`, and `destroy` methods.
  - Add admin routes in `routes/web.php` under `admin.reviews.*`.
  - Create Blade view `resources/views/admin/reviews/index.blade.php` with filter tabs (Pending, Approved, Rejected), review excerpts, and quick action buttons.
  - Link "Reviews" with a pending badge counter in admin sidebar layout `resources/views/admin/layout.blade.php`.
  - Create Pest feature test `tests/Feature/CollegeReviewTest.php` covering guest submission, honeypot blocking, throttling, public visibility filters, and admin moderation actions.
  - Run Laravel Pint formatter (`vendor/bin/pint --format agent`).
- **Success Criteria:** Admin can view, approve, and reject reviews seamlessly; all Pest tests pass with 100% green status.

---

## Milestone Archive
- **Milestone v1.0 (Archived):** Project initialization, architecture mapping (`.planning/codebase/`), and distance/online university catalog foundation.
