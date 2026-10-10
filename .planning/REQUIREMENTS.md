# Requirements: Milestone v1.1 — Public Guest College Review System

**Milestone:** v1.1 — Public Guest College Review System (Without Login)  
**Status:** Approved  
**Version:** 1.1  
**Date:** 2026-10-10  

---

## 1. Functional Requirements

### FR-1: Database Schema & Eloquent Relationships
- **FR-1.1:** Extend or migrate `college_reviews` schema to include:
  - `college_id`: Foreign key pointing to `colleges.id` (cascade on delete).
  - `user_id`: Nullable foreign key for backward compatibility with registered users.
  - `reviewer_name`: String (required, max 100).
  - `email`: String (required, valid email address format).
  - `course`: String (nullable, course attended/enrolled).
  - `rating`: Unsigned tiny integer (required, strictly 1 to 5).
  - `review`: Text (required, minimum 15 characters, maximum 1500 characters).
  - `ip_address`: String (nullable, storing submitter's IP for spam analysis).
  - `status`: String/Enum (`pending`, `approved`, `rejected`) defaulting to `pending`.
  - `is_verified`: Boolean defaulting to `false`.
  - `timestamps`: Standard `created_at` and `updated_at`.
- **FR-1.2:** Update `CollegeReview` model:
  - Fillable properties: `college_id`, `reviewer_name`, `email`, `course`, `rating`, `review`, `ip_address`, `status`, `is_verified`.
  - Casts: `rating` => integer, `is_verified` => boolean.
  - Scopes:
    - `scopeApproved($query)`: Filters where `status === 'approved'`.
    - `scopePending($query)`: Filters where `status === 'pending'`.
    - `scopeRejected($query)`: Filters where `status === 'rejected'`.
- **FR-1.3:** Update `College` model:
  - `reviews()`: HasMany relationship to `CollegeReview`.
  - `approvedReviews()`: HasMany relationship returning only approved reviews.
  - Helper / Attribute: `averageRating()` calculating dynamically from approved reviews with fallback to college base rating.

### FR-2: Public Controller, Routing & Anti-Spam
- **FR-2.1:** Public Route:
  - `POST /college/{slug}/reviews` (named `college.reviews.store`) handled by `App\Http\Controllers\CollegeReviewController@store`.
- **FR-2.2:** Form Request Validation (`StoreCollegeReviewRequest`):
  - `reviewer_name`: `required|string|min:2|max:100`
  - `email`: `required|email|max:150`
  - `course`: `nullable|string|max:120`
  - `rating`: `required|integer|min:1|max:5`
  - `review`: `required|string|min:15|max:1500`
  - Honeypot check: `website_hp` must be empty / absent.
- **FR-2.3:** Anti-Spam & Rate Limiting:
  - Honeypot: An invisible input field `website_hp` hidden via CSS. If filled, the request is silently treated as spam or rejected with a 422 error.
  - Rate Limiting: Middleware throttling applied (e.g. `throttle:5,60` — max 5 submissions per 60 minutes per IP).
  - IP Capture: Capture client IP via `$request->ip()` and save in `college_reviews.ip_address`.
- **FR-2.4:** Response Handling:
  - Store record with `status = 'pending'`.
  - Flash success message: *"Thank you! Your review has been submitted and is awaiting administrator moderation."*
  - Support both standard redirect back with session flash and AJAX JSON response (`{ success: true, message: '...' }`).

### FR-3: Public Frontend UI (College Detail Page)
- **FR-3.1:** Display Reviews Section on `/college/{slug}`:
  - Aggregate rating summary card (overall score out of 5.0, total approved reviews count, and star rating bar distribution).
  - List of approved reviews showing reviewer name, course/degree (if provided), star rating, date, and review body.
  - Empty state when no reviews exist yet (*"Be the first student to review this institution!"*).
- **FR-3.2:** "Write a Review" Form:
  - Clean card or modal layout with:
    - Interactive 5-star rating selector with hover/click effects.
    - Full Name input.
    - Email address input (with helper note: *"Your email will remain private"*).
    - Course / Branch input (optional).
    - Detailed feedback textarea with character counter.
    - Honeypot field (hidden from view).
    - Submit button with loading state.
  - Client-side and server-side validation error handling.

### FR-4: Admin Moderation Panel
- **FR-4.1:** Admin Controller: `App\Http\Controllers\Admin\ReviewManagerController`.
- **FR-4.2:** Admin Routes (`routes/web.php` under `admin.`):
  - `GET /admin/reviews` (`admin.reviews.index`)
  - `POST /admin/reviews/{id}/approve` (`admin.reviews.approve`)
  - `POST /admin/reviews/{id}/reject` (`admin.reviews.reject`)
  - `DELETE /admin/reviews/{id}` (`admin.reviews.destroy`)
- **FR-4.3:** Admin Moderation View (`resources/views/admin/reviews/index.blade.php`):
  - Filter tabs: Pending (with badge counter), Approved, Rejected, All.
  - Data table showing College Name, Reviewer, Email, Course, Rating, Review excerpt, IP address, Submission Date, and Action buttons.
  - One-click "Approve" (turns status to `approved`), "Reject" (turns status to `rejected`), and "Delete".
  - Flash notifications on status changes.

---

## 2. Non-Functional Requirements

### NFR-1: Security & Anti-Abuse
- HTML text sanitization on review text (strip dangerous tags to prevent XSS).
- Strict throttling and honeypot field to resist automated spam bots.

### NFR-2: Test Automation
- Pest feature tests in `tests/Feature/CollegeReviewTest.php`:
  - Guests can submit valid review and status is set to `pending`.
  - Submissions with invalid rating (>5 or <1) fail validation.
  - Honeypot bot submissions are rejected.
  - Rate limiting blocks excessive submissions from the same IP.
  - Unapproved/pending reviews do NOT appear on the public college page.
  - Approved reviews display on the public page and affect rating calculation.
  - Admin can approve and reject reviews.

### NFR-3: Code Quality
- Strict PSR-12 and Laravel 12 formatting passing `vendor/bin/pint --format agent`.
