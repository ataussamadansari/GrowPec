# Project Roadmap: GrowPec Education Portal

**Current Milestone:** v1.5 — College Comparison & Advanced Search Filters  
**Updated:** 2026-10-18  
**Mode:** Agile / Structured  

---

## Milestone v1.5 Phases Overview

```
┌─────────────────────────────────────────────────────────────────┐
│ Phase 21: College Comparison Engine & Public Matrix View        │
│ (Route /compare, CollegeComparisonController, eager-loaded rows)│
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 22: Comparison Dock & "Add to Compare" Actions            │
│ (Floating comparison tray, card/profile compare buttons)        │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 23: Advanced Multi-Dimensional Search & Filtering         │
│ (Streams, degrees, locations, fee brackets, sorting & tags)     │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 24: Comprehensive Pest Feature Tests, Pint & Verification │
│ (CollegeComparisonTest, FilterTest, 100% green tests, Pint)     │
└─────────────────────────────────────────────────────────────────┘
```

---

## Detailed Phase Breakdown

### Phase 21: College Comparison Engine & Public Matrix View
- **Goal:** Implement the backend comparison query engine and public responsive comparison view (`/compare`).
- **Tasks:**
  - Register route `GET /compare` in `routes/web.php`.
  - Create or extend `CollegeComparisonController@index` to parse `?colleges=slug1,slug2,slug3` (2 to 4 colleges).
  - Eager load `courses.course.stream`, `highlights`, `facilities`, `placementStats`, `recruiters`, `scholarships`, `admissionSections`, `approvedReviews`, `state`, `city`.
  - Build `resources/views/colleges/compare.blade.php`:
    - Responsive comparison table with sticky headers.
    - Side-by-side metric comparison rows: Overview, Accreditations, Ratings & Reviews, Fee Range, Placements, Top Recruiters, Key Courses, Facilities, and Scholarships.
    - "Apply / Enquire Now" button for each college triggering the lead modal with pre-populated college ID.
    - Launcher state with popular comparison shortcuts when < 2 colleges are requested.
- **Success Criteria:** `GET /compare?colleges=galgotias-university,bennett-university` renders a clean, fully populated comparison table.

### Phase 22: Comparison Dock & "Add to Compare" Actions
- **Goal:** Enable users to pick and manage colleges for comparison from any listing or profile page.
- **Tasks:**
  - Add "Add to Compare" quick toggle buttons to:
    - College cards in `resources/views/colleges/index.blade.php`.
    - Hero and header actions in `resources/views/colleges/show.blade.php`.
  - Implement a lightweight floating comparison tray/dock at the bottom of the viewport:
    - Displays selected college logos and names (up to 4 colleges).
    - "Compare Now" button navigating directly to `/compare?colleges=...`.
    - "Clear" button and individual remove tags.
    - Local storage persistence so selections survive navigation across pages.
  - Implement the "Change College" / "Add College" modal switcher inside the `/compare` matrix.
- **Success Criteria:** Users can click "Add to Compare" on multiple college cards, see the comparison dock update, and click "Compare Now" to view the side-by-side table.

### Phase 23: Advanced Multi-Dimensional Search & Filtering
- **Goal:** Upgrade public college listings with powerful multi-dimensional filters, active filter chips, and smooth sorting.
- **Tasks:**
  - Update `CollegeController@regularColleges` and `CollegeController@onlineColleges` query builders:
    - Support filtering by `stream` / `stream_id`.
    - Support filtering by `course` / `course_id`.
    - Support filtering by `state_id` and `city_id`.
    - Support filtering by fee brackets (e.g. `<100000`, `100000-300000`, etc.).
    - Support sorting parameters: `rating_desc`, `fees_asc`, `fees_desc`, `name_asc`.
  - Update `resources/views/colleges/index.blade.php`:
    - Clean faceted filter sidebar with accordions.
    - Active filter tags/chips bar with 1-click removal ("Clear all", "B.Tech ×").
    - Results counter ("Showing X colleges matching your criteria").
    - Preserve query parameters across pagination links (`$colleges->appends(request()->query())`).
- **Success Criteria:** Filtering by stream, degree, state, or fee returns the correct subset of colleges, with active chips displayed and pagination links retaining filters.

### Phase 24: Comprehensive Pest Feature Tests, Pint & Verification
- **Goal:** Author exhaustive automated test suites covering comparison and filtering workflows, ensure strict code standards, and verify zero regressions.
- **Tasks:**
  - Create `tests/Feature/CollegeComparisonTest.php`:
    - Asserts `/compare` with 2, 3, and 4 colleges returns HTTP 200.
    - Asserts eager loaded data and metric rows are present.
    - Asserts empty state and invalid slug handling.
  - Create `tests/Feature/AdvancedCollegeSearchFilterTest.php`:
    - Asserts filtering regular colleges by stream/degree.
    - Asserts filtering by state, city, and fee range.
    - Asserts sorting options (`rating_desc`, `fees_asc`, `name_asc`).
    - Asserts query retention across pagination.
  - Format modified PHP files using `vendor/bin/pint --format agent`.
  - Run full test suite with `php artisan test --compact` to achieve 100% green tests (135+ tests).
- **Success Criteria:** Full test suite passes without any failures or regressions.

---

## Milestone Archive
- **Milestone v1.0 (Archived):** Project initialization, architecture mapping (`.planning/codebase/`), and distance/online university catalog foundation.
- **Milestone v1.1 (Archived):** Public guest college review system with honeypot anti-spam, rate throttling, public show integration, admin moderation, and 100% passing Pest tests.
- **Milestone v1.2 (Archived):** Filament Admin Panel v5 Migration — Replaced custom Blade admin controllers with Filament v5 Resources, RelationManagers, and Dashboard widgets (116 tests passing).
- **Milestone v1.3 (Archived):** Architecture Cleanup & Schema Normalization — Dropped 4 redundant tables, pruned obsolete models, simplified relationships, and verified 118 green tests.
- **Milestone v1.4 (Archived):** Regular College Catalog Expansion — Researched and seeded 15 authentic regular on-campus universities with 720+ courses, 180+ highlights, and verified 127 green tests.
