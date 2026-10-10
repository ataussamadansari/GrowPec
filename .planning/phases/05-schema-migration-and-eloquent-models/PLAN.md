# Phase 5 Plan: Schema Migration & Eloquent Models

**Phase:** 5  
**Milestone:** v1.1 — Public Guest College Review System (Without Login)  
**Goal:** Enhance the `college_reviews` database schema and Eloquent models to support guest/visitor reviews with pending moderation status by default.  
**Status:** Ready to Execute  

---

## 1. Context & Architecture

Existing state:
- The `college_reviews` table was initially created in `2026_09_15_191011_update_college_table.php` with:
  `id`, `college_id`, `user_id` (nullable), `reviewer_name`, `course`, `rating`, `review`, `is_verified` (bool), `status` (tinyint bool), timestamps.
- Currently, `CollegeReview` casts `status` as `boolean`.
- `College` model has no `reviews()` or `approvedReviews()` relationship declared.
- No public review submission or moderation exists.

Planned state:
- Add `email` (`varchar(255)`) and `ip_address` (`varchar(45)` nullable) to `college_reviews`.
- Change `status` from `tinyint(1)` to `varchar(20)` with default `'pending'` (`pending`, `approved`, `rejected`).
- Support alias accessors on `CollegeReview` for `course_enrolled` (`course`) and `review_text` (`review`).
- Add query scopes on `CollegeReview`: `scopeApproved`, `scopePending`, `scopeRejected`.
- Add `reviews()`, `approvedReviews()`, `pendingReviews()`, and dynamic rating calculations to `College`.
- Add Pest test suite verifying model integrity and relationship queries.

---

## 2. Tasks & Execution Steps

### Task 5.1: Create & Run Schema Migration
- **Artifact:** `database/migrations/xxxx_xx_xx_xxxxxx_add_guest_fields_to_college_reviews_table.php`
- **Actions:**
  1. Generate migration using `php artisan make:migration add_guest_fields_to_college_reviews_table --table=college_reviews --no-interaction`.
  2. In `up()`:
     - Add `email` (`string(255)`) after `reviewer_name`.
     - Add `ip_address` (`string(45)->nullable()`) after `review`.
     - Change `status` column to `string(20)->default('pending')` (with index `['college_id', 'status']`).
  3. In `down()`:
     - Drop `email` and `ip_address` columns.
     - Revert `status` to `boolean()->default(true)`.
  4. Run `php artisan migrate --force --no-interaction`.
  5. Verify column listing via tinker / describe.

### Task 5.2: Update `CollegeReview` Eloquent Model
- **Artifact:** [app/Models/CollegeReview.php](file:///d:/GrowPec/GrowPec/app/Models/CollegeReview.php)
- **Actions:**
  1. Update `$fillable` array:
     ```php
     protected $fillable = [
         'college_id',
         'user_id',
         'reviewer_name',
         'email',
         'course',
         'course_enrolled',
         'rating',
         'review',
         'review_text',
         'ip_address',
         'is_verified',
         'status',
     ];
     ```
  2. Implement modern Laravel 12 `casts()` method:
     ```php
     protected function casts(): array
     {
         return [
             'rating' => 'integer',
             'is_verified' => 'boolean',
             'status' => 'string',
         ];
     }
     ```
  3. Add flexible accessors and mutators:
     - `course_enrolled` <-> `course`
     - `review_text` <-> `review`
  4. Add query scopes:
     - `scopeApproved(Builder $query): Builder`
     - `scopePending(Builder $query): Builder`
     - `scopeRejected(Builder $query): Builder`
  5. Add status helper methods: `isApproved(): bool`, `isPending(): bool`, `isRejected(): bool`.

### Task 5.3: Update `College` Eloquent Model
- **Artifact:** [app/Models/College.php](file:///d:/GrowPec/GrowPec/app/Models/College.php)
- **Actions:**
  1. Add relationships:
     - `public function reviews(): HasMany`
     - `public function approvedReviews(): HasMany`
     - `public function pendingReviews(): HasMany`
  2. Add computed helpers:
     - `public function getAverageRatingAttribute(): float`: computes `(float) round($this->approvedReviews()->avg('rating') ?: $this->rating ?: 0.0, 1)`.
     - `public function getApprovedReviewsCountAttribute(): int`: computes `$this->approvedReviews()->count()`.

### Task 5.4: Automated Pest Model Verification
- **Artifact:** `tests/Feature/CollegeReviewModelTest.php`
- **Actions:**
  1. Generate feature test using `php artisan make:test CollegeReviewModelTest --pest --no-interaction`.
  2. Write Pest tests covering:
     - Guest can create a review with `college_id`, `reviewer_name`, `email`, `course`, `rating`, `review`, `ip_address` without `user_id`.
     - Default review `status` is `'pending'`.
     - Query scopes (`approved`, `pending`, `rejected`) accurately filter review records.
     - `College` model `reviews()` and `approvedReviews()` relationships function properly.
     - Dynamic `average_rating` calculation correctly averages approved reviews and ignores pending ones.
  3. Execute test: `php artisan test --filter=CollegeReviewModelTest`.
  4. Format all changed PHP files using `vendor/bin/pint --format agent`.

---

## 3. Verification & Acceptance Criteria
- [ ] Migration runs cleanly with zero database errors.
- [ ] Schema of `college_reviews` contains `email`, `ip_address`, and string `status` with default `'pending'`.
- [ ] `CollegeReview` supports guest attributes, aliases (`course_enrolled`, `review_text`), and query scopes.
- [ ] `College` model exposes `reviews()`, `approvedReviews()`, and `average_rating`.
- [ ] All Pest tests in `CollegeReviewModelTest` pass (100% green).
- [ ] Code formatted with Laravel Pint.
