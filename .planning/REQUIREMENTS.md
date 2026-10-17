# Milestone v1.5 Requirements: College Comparison & Advanced Search Filters

**Milestone:** v1.5 — College Comparison & Advanced Search Filters  
**Status:** In Planning  
**Created:** 2026-10-18  

---

## 1. Overview & Objective
GrowPec has a rich, verified catalog of 30 premier institutions (15 regular on-campus universities and 15 distance/online universities) featuring over 720 courses, comprehensive fee structures, placement statistics, and facilities.

The objective of Milestone v1.5 is to:
1. Provide a public **Side-by-Side College Comparison Tool (`/compare`)** that allows prospective students to benchmark 2 to 4 colleges across accreditations, fees, placements, ratings, amenities, and courses.
2. Provide **Advanced Multi-Dimensional Search & Filtering** on regular and online listings (`/colleges` and `/online-colleges`) covering streams, specific degrees, states, cities, fee brackets, and ratings.
3. Verify all features with comprehensive automated Pest feature tests.

---

## 2. Functional Requirements

### REQ-CMP-01: Public College Comparison Route & Controller
- **Route:** `GET /compare` (`CollegeController@compare` or dedicated `CollegeComparisonController@index`).
- **Query Parameter:** `colleges` accepting a comma-separated list of college slugs or IDs (e.g. `colleges=galgotias-university,bennett-university,iimt-university`).
- **College Eager Loading:** Eager loads in a single optimized query:
  - `state`, `city`
  - `courses.course.stream`
  - `highlights`
  - `facilities`
  - `placementStats`
  - `recruiters`
  - `scholarships`
  - `admissionSections`
  - `approvedReviews`
- **Slot Capacity:** Supports comparing between 2 and 4 colleges simultaneously.
- **Empty / Incomplete State:** If fewer than 2 colleges are provided, renders a comparison launchpad with college selectors and popular comparison shortcuts (e.g. "Galgotias vs Bennett", "Graphic Era vs COER").

### REQ-CMP-02: Side-by-Side Comparison Matrix View (`resources/views/colleges/compare.blade.php`)
- **Comparison Table Layout:** Responsive table layout with sticky college header cards and side-by-side metric rows:
  - **Card Header:** College logo, full name, short name, location (city, state), type (Private/Deemed), established year, and remove button.
  - **Accreditations & Approvals:** UGC, AICTE, NAAC grade badges, NIRF rank.
  - **Ratings & Reviews:** Dynamic average star rating, total approved review count.
  - **Tuition & Fees:** Minimum and maximum annual fee range across programs.
  - **Placements:** Highest package, average package, top recruiters list with logos.
  - **Courses & Programs:** Key degrees offered grouped by stream.
  - **Campus & Facilities:** Infrastructure tags (Wi-Fi, Hostel, Sports, Hospital, Labs).
  - **Scholarships:** Available concessions and eligibility summaries.
  - **Lead Conversion CTAs:** Prominent "Apply / Enquire Now" button per college triggering the lead inquiry modal with `college_id` pre-populated.

### REQ-CMP-03: Dynamic College Switcher & Search in Matrix
- In each comparison slot header:
  - "Change College" dropdown or modal with live autocomplete search across all 30 published colleges.
  - "Add Another College" slot when fewer than 4 colleges are compared.
  - "Remove" action updating the URL and reloading or dynamically updating the comparison view.

### REQ-CMP-04: Comparison Tray & "Add to Compare" Quick Actions
- Add an "Add to Compare" button/checkbox on:
  - College cards in `resources/views/colleges/index.blade.php`.
  - College profile hero in `resources/views/colleges/show.blade.php`.
- Client-side floating dock / comparison bar appearing when colleges are selected, showing selected college icons and a "Compare (N)" button linking to `/compare?colleges=...`.

### REQ-FLT-01: Multi-Faceted Filter Controls in Listings (`colleges/index.blade.php`)
- **Stream Filter:** Filter colleges by academic stream (Engineering, Management, Computer Applications, Medical/Healthcare, etc.).
- **Degree / Course Filter:** Filter by specific degree programs (B.Tech, MBA, BCA, MCA, B.Pharm, etc.).
- **Location Filter:** State dropdown with cascading City dropdown.
- **Fee Range Brackets:**
  - Under ₹1,00,000 / year
  - ₹1,00,000 – ₹3,00,000 / year
  - ₹3,00,000 – ₹5,00,000 / year
  - Above ₹5,00,000 / year
- **Sorting Options:**
  - `rating_desc` (Highest Rated First)
  - `fees_asc` (Lowest Annual Fee First)
  - `fees_desc` (Highest Annual Fee First)
  - `name_asc` (A to Z)
  - `popular` (Default featured)
- **Active Filter Chips:** Visual tags above results showing applied filters with 1-click removal and a "Clear All Filters" button.

### REQ-FLT-02: Controller Query Handling & Pagination
- Refactor `CollegeController@regularColleges` and `CollegeController@onlineColleges` with clean, composable Eloquent query scopes.
- Ensure pagination preserves active query strings (`$colleges->appends(request()->query())`).
- Include accurate live result count indicator ("Showing 12 Colleges matching your criteria").

### REQ-TST-01: Automated Pest Feature Testing Suite
- Create `tests/Feature/CollegeComparisonTest.php`:
  - Test `/compare` with 2 valid colleges returns HTTP 200 and renders comparison matrix.
  - Test `/compare` with 3 and 4 colleges.
  - Test empty `/compare` renders launcher with selection prompt.
  - Test invalid slug handling.
  - Test lead modal trigger attributes on comparison page.
- Create `tests/Feature/AdvancedCollegeSearchFilterTest.php`:
  - Test filtering regular colleges by stream returns expected records.
  - Test filtering by course, state, city, and fee range.
  - Test sorting parameters (`rating_desc`, `fees_asc`, `name_asc`).
  - Test pagination links retain filter query parameters.
- Achieve 100% green test suite (135+ passing tests) with 0 regressions.

---

## 3. Non-Functional Requirements (NFR)
- **NFR-1 (Performance):** Comparison view must load in < 250ms by avoiding N+1 queries through comprehensive eager-loading.
- **NFR-2 (Responsive Design):** The comparison table must be seamlessly scrollable on mobile devices with sticky headers.
- **NFR-3 (Code Quality):** All PHP code formatted strictly with Laravel Pint (`vendor/bin/pint --format agent`).
- **NFR-4 (Zero Regressions):** All 127 existing tests must continue to pass without error.
