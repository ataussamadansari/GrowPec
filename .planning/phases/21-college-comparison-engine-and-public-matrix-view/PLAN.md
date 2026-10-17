# Phase 21 Plan: College Comparison Engine & Public Matrix View

**Phase:** Phase 21 — College Comparison Engine & Public Matrix View  
**Milestone:** v1.5 — College Comparison & Advanced Search Filters  
**Status:** In Progress / Ready for Execution  
**Created:** 2026-10-18  

---

## 1. Phase Objective
Build an end-to-end, high-performance **College Comparison Engine** and responsive **Side-by-Side Matrix View** (`/compare`) that empowers prospective students to benchmark 2 to 4 universities simultaneously across accreditations, tuition fees, placement packages, recruiters, student reviews, facilities, and academic programs.

---

## 2. Technical Architecture & Design

### 2.1 Route & Controller Layer
- **Route:** `GET /compare` named `colleges.compare` registered in `routes/web.php` within the public website group (`CheckMaintenanceMode` middleware).
- **Controller:** Dedicated `App\Http\Controllers\CollegeComparisonController@index`.
- **Query Resolution:**
  - Parses comma-separated slugs from `request('colleges')` (e.g. `colleges=bennett-university,galgotias-university`).
  - Limits selection to a maximum of 4 colleges per comparison to maintain visual readability and avoid unbounded query overhead.
  - Eager-loads relational data in a single optimized query:
    - `state`, `city`
    - `collegeCourses.course.stream`
    - `collegeCourses.specialization`
    - `collegeHighlights`
    - `accreditations`
    - `placementStats`
    - `recruiters`
    - `collegeFacilities`
    - `scholarships`
    - `approvedReviews`
  - Reorders Eloquent results to mirror the order specified in the query string.
  - Loads lightweight college list (`id`, `name`, `short_name`, `slug`, `logo`, `mode`) for quick-switch dropdowns.

### 2.2 Presentation Layer (`resources/views/colleges/compare.blade.php`)
- **Master Layout:** Extends `resources/views/layouts/app.blade.php`.
- **Launcher State (when < 2 colleges specified):**
  - Interactive selection cards allowing students to pick College 1 and College 2 from searchable select dropdowns.
  - Curated popular benchmark shortcut buttons (e.g., "Bennett vs Galgotias", "Graphic Era vs COER", "IIMT vs TMU", "Amity Online vs Manipal Online").
- **Matrix View State (when 2 to 4 colleges selected):**
  - **Sticky Top Bar:** College logo, short name, city/state badge, remove (`×`) action button.
  - **Comparative Metric Rows:**
    1. **Overview & Heritage:** Short Name, Ownership (Private / Deemed / Public), Established Year, Campus Location, Mode (Regular vs Online).
    2. **Accreditations & Approvals:** UGC, AICTE, NAAC Grade (A++, A+, A), NIRF Ranking.
    3. **Student Sentiment & Ratings:** Average star rating, approved reviews count, link to public reviews.
    4. **Tuition & Fees:** Minimum and maximum annual fees across all academic offerings.
    5. **Placements & Career Outcomes:** Highest package (LPA), Average package (LPA), top recruiters badges/logos.
    6. **Academic Offerings:** Major streams and popular courses offered.
    7. **Campus Infrastructure:** Amenities (Hostel, Sports, Hospital, Labs, Wi-Fi).
    8. **Scholarships & Financial Aid:** Concessions and eligibility.
    9. **Direct Conversion CTA:** "Apply / Enquire Now" button per college with `data-bs-toggle="modal" data-bs-target="#counselingModal"` and `data-college-id="{{ $col->id }}"` to pre-populate the lead capture modal.
- **Header Navigation:**
  - Add "Compare" link with an icon in the global navbar of `resources/views/layouts/app.blade.php`.

---

## 3. Detailed Implementation Tasks

### Task 21.1: Register Route & Create `CollegeComparisonController`
- Define `Route::get('/compare', [CollegeComparisonController::class, 'index'])->name('colleges.compare');` in `routes/web.php`.
- Create `app/Http/Controllers/CollegeComparisonController.php`:
  - `public function index(Request $request)`
  - Slug parsing, deduplication, and eager loading of relationships.
  - Prepare popular benchmark comparisons for the launcher.
  - Return `view('colleges.compare', ...)`.

### Task 21.2: Build the Comparison View (`resources/views/colleges/compare.blade.php`)
- Implement responsive CSS:
  - Sticky table headers on vertical scroll.
  - Horizontal overflow support for mobile devices.
  - Visual color highlights for differences.
- Build launcher cards and quick selection pills for empty/single-college requests.
- Implement side-by-side metric tables with clear headings, badges, and icon markers.
- Implement modal / dropdown switcher allowing users to add or swap an institution on the fly.
- Connect "Apply Now" buttons with the existing `#counselingModal`.

### Task 21.3: Update Global Navigation in `layouts/app.blade.php`
- Add "Compare Colleges" navigation item in `layouts/app.blade.php` with active route detection (`request()->routeIs('colleges.compare')`).

### Task 21.4: Author Automated Pest Feature Tests & Lint Hygiene
- Create `tests/Feature/CollegeComparisonTest.php`:
  - `test('compare page loads successfully in launcher mode when no colleges specified')`
  - `test('compare page renders comparison matrix for 2 colleges')`
  - `test('compare page supports up to 4 colleges simultaneously')`
  - `test('invalid or inactive slugs are safely ignored')`
  - `test('lead modal trigger attributes are correctly rendered for each compared college')`
- Run `vendor/bin/pint --format agent` to verify clean PHP code formatting.
- Execute `php artisan test --compact` to confirm all 127+ tests pass.

---

## 4. Verification & Success Criteria
- [ ] `GET /compare` responds with HTTP 200.
- [ ] `GET /compare?colleges=bennett-university,galgotias-university` displays both institutions in a side-by-side comparison table.
- [ ] Comparison correctly displays Accreditations, Fees, Placements, Ratings, and Facilities.
- [ ] Clicking "Apply Now" on any compared college opens the lead modal with that college pre-selected.
- [ ] All automated Pest feature tests pass with 0 regressions.
- [ ] 100% compliant with Laravel Pint standards.
