# Phase 6 Plan: Public Submission Controller & Security

**Phase:** 6  
**Milestone:** v1.1 — Public Guest College Review System (Without Login)  
**Goal:** Implement a secure, rate-limited public POST endpoint for visitor college review submissions with strict validation and honeypot spam protection.  
**Status:** Ready to Execute  

---

## 1. Context & Architecture

Existing state:
- Schema and models ([College.php](file:///d:/GrowPec/GrowPec/app/Models/College.php), [CollegeReview.php](file:///d:/GrowPec/GrowPec/app/Models/CollegeReview.php)) updated and verified in Phase 5.
- The public college detail page route is `GET /college/{slug}` (`college.show`).
- Currently, there is no public endpoint or controller to receive visitor reviews.

Planned state:
- Form Request: `App\Http\Requests\StoreCollegeReviewRequest` with strict validation rules and honeypot bot trap (`website_hp`).
- Public Controller: `App\Http\Controllers\CollegeReviewController@store` mapping input, sanitizing review text, logging client IP, setting `status = 'pending'`, and returning flash or JSON responses.
- Route: `POST /college/{slug}/reviews` named `college.reviews.store` wrapped with `throttle:5,60` in `routes/web.php`.
- Comprehensive Pest tests in `tests/Feature/CollegeReviewSubmissionTest.php`.

---

## 2. Tasks & Execution Steps

### Task 6.1: Create Form Request `StoreCollegeReviewRequest`
- **Artifact:** `app/Http/Requests/StoreCollegeReviewRequest.php`
- **Actions:**
  1. Generate request class using `php artisan make:request StoreCollegeReviewRequest --no-interaction`.
  2. Implement `authorize()` returning `true` (open to all visitors/guests).
  3. Implement `rules()`:
     - `reviewer_name`: `['required', 'string', 'min:2', 'max:100']`
     - `email`: `['required', 'email', 'max:150']`
     - `course`: `['nullable', 'string', 'max:120']`
     - `rating`: `['required', 'integer', 'between:1,5']`
     - `review`: `['required', 'string', 'min:15', 'max:1500']`
     - `website_hp`: `['nullable', 'max:0']` (honeypot trap: must remain empty)
  4. Add `withValidator()` hook to reject any submission where `website_hp` contains text with custom validation message: *"Spam submission detected."*
  5. Add user-friendly custom validation messages in `messages()`.

### Task 6.2: Create `CollegeReviewController`
- **Artifact:** `app/Http/Controllers/CollegeReviewController.php`
- **Actions:**
  1. Generate controller using `php artisan make:controller CollegeReviewController --no-interaction`.
  2. Implement `store(StoreCollegeReviewRequest $request, string $slug)`:
     - Find active college via `College::where('slug', $slug)->firstOrFail()`.
     - Sanitize input fields (`strip_tags` on `reviewer_name`, `course`, `review`).
     - Create review via `$college->reviews()->create(...)`:
       - `reviewer_name`
       - `email` (lowercased, trimmed)
       - `course` (optional)
       - `rating` (int)
       - `review`
       - `ip_address` => `$request->ip()`
       - `status` => `'pending'`
       - `is_verified` => `false`
     - Return appropriate response:
       - If AJAX / JSON (`$request->expectsJson()`): return HTTP 201 with `{ success: true, message: '...', review_id: ... }`.
       - If standard web submission: `return back()->with('review_success', 'Thank you! Your review has been submitted and is awaiting administrator moderation.');`.

### Task 6.3: Register Route with Rate Limiting
- **Artifact:** [routes/web.php](file:///d:/GrowPec/GrowPec/routes/web.php)
- **Actions:**
  1. In the public website route group (guarded by `web` and `CheckMaintenanceMode`), add:
     ```php
     Route::post('/college/{slug}/reviews', [CollegeReviewController::class, 'store'])
         ->name('college.reviews.store')
         ->middleware('throttle:5,60');
     ```
  2. Verify route list with `php artisan route:list --name=college.reviews.store`.

### Task 6.4: Author Automated Pest Feature Tests
- **Artifact:** `tests/Feature/CollegeReviewSubmissionTest.php`
- **Actions:**
  1. Generate feature test using `php artisan make:test CollegeReviewSubmissionTest --pest --no-interaction`.
  2. Implement Pest tests:
     - Guest can submit valid review via `POST /college/{slug}/reviews`.
     - Valid submission creates database record with `status = 'pending'`, captures IP, and flashes success message.
     - Submissions with invalid rating (e.g. 0 or 6) fail with validation error on `rating`.
     - Submissions with short review text (<15 chars) fail with validation error on `review`.
     - Submissions with invalid email format fail validation.
     - Honeypot bot submission (where `website_hp` is populated) is blocked.
     - JSON request receives HTTP 201 JSON payload.
     - Rate limiter allows up to 5 submissions within 60 minutes and blocks the 6th with HTTP 429.
  3. Execute tests: `php artisan test --filter=CollegeReviewSubmissionTest`.
  4. Run Laravel Pint: `vendor/bin/pint --dirty --format agent`.

---

## 3. Verification & Acceptance Criteria
- [ ] Route `POST /college/{slug}/reviews` registered and visible in `php artisan route:list`.
- [ ] Honeypot field blocks bots silently/with validation error.
- [ ] Rate limiting throttles excessive requests to 5 per hour per IP.
- [ ] Review is inserted with `status = 'pending'` and user's client IP.
- [ ] Both standard Blade form redirects and AJAX responses are supported.
- [ ] All Pest tests in `CollegeReviewSubmissionTest` pass (100% green).
- [ ] Code formatted with Laravel Pint.
