# Phase 23 Plan: Advanced Multi-Dimensional Search & Filtering

**Phase:** Phase 23 — Advanced Multi-Dimensional Search & Filtering  
**Milestone:** v1.5 — College Comparison & Advanced Search Filters  
**Status:** In Progress / Ready for Execution  
**Created:** 2026-10-18  

---

## 1. Phase Objective
Upgrade GrowPec's public university search and discovery system (`/colleges` and `/online-universities`) with advanced multi-dimensional faceted filtering, active filter chips with 1-click removal, dynamic sorting options, query-preserving pagination, and responsive results feedback.

---

## 2. Technical Architecture & Component Flow

```
┌─────────────────────────────────────────────────────────────┐
│ 1. User Filter / Sort Request:                              │
│ • Stream (e.g. ?stream=engineering or ?streams[]=...)       │
│ • Course (e.g. ?course=b-tech or ?courses[]=...)            │
│ • Location (e.g. ?state=Uttar+Pradesh&city=Noida)           │
│ • Annual Fees (e.g. ?fee_ranges[]=under_1l)                 │
│ • Sort (e.g. ?sort=rating_desc or ?sort=name_asc)           │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│ 2. CollegeController Query Builder:                         │
│ • Normalizes singular and array parameters                  │
│ • Eager-loads courses.stream & collegeCourses               │
│ • Builds multidimensional AND/OR queries across relations   │
│ • Applies ordering with featured precedence                 │
│ • Computes activeFilterChips metadata structure for view    │
│ • Preserves all parameters via paginate()->withQueryString()│
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│ 3. Faceted Filter UI & Active Chips (colleges/index):       │
│ • Results Bar: Count ("Showing X-Y of Z") + Sort Dropdown   │
│ • Active Chips Bar: Clickable pill tags with "×" removal    │
│ • Filter Accordion Sidebar: Streams, Courses, States, Fees  │
│ • "Clear All Filters" button resetting to base listing URL  │
└─────────────────────────────────────────────────────────────┘
```

---

## 3. Detailed Implementation Tasks

### Task 23.1: Enhanced Query Engine & Normalization in `CollegeController.php`
- **Location:** `app/Http/Controllers/CollegeController.php` (`getFilteredColleges`).
- **Parameter Normalization:**
  - Support both singular and array keys:
    - Streams: `stream` (string) or `streams` (array). Check `slug`, `id`, or `name`.
    - Courses: `course` (string) or `courses` (array). Check `slug`, `id`, `name`, or `short_name`.
    - Locations: `state` / `states` (name or ID) and `city` / `cities` (name or ID).
    - Degree types: `degree_type` / `degree_types`.
    - Durations: `duration` / `durations`.
    - Fee ranges: `fee_range` / `fee_ranges` (`under_1l`, `1l_to_2l`, `2l_to_3l`, `3l_to_5l`, `5l_to_10l`, `above_10l`).
- **Dynamic Sorting:**
  - Handle `request('sort')`:
    - `'rating_desc'` or `'rating'`: `orderByDesc('rating')->orderByDesc('is_featured')`
    - `'name_asc'`: `orderBy('name', 'asc')`
    - `'name_desc'`: `orderBy('name', 'desc')`
    - `'established_desc'`: `orderByDesc('established_year')`
    - Default / `'popular'`: `orderByDesc('is_featured')->orderByDesc('rating')->orderByDesc('id')`
- **Active Filter Chips Computation:**
  - Build `$activeFilterChips` array passed to view:
    - `['key' => 'streams', 'value' => 'engineering', 'label' => 'Stream: Engineering', 'remove_url' => '...']`
    - Provides ready-to-render tokens so the Blade template renders clickable removal chips with zero client JS overhead.
- **State-aware City Filtering:**
  - If a state filter is active, narrow `$allCities` query to matching state(s) so users only see applicable cities.

### Task 23.2: Upgraded Faceted UI, Active Chips & Sort Bar in `colleges/index.blade.php`
- **Location:** `resources/views/colleges/index.blade.php`.
- **Top Controls Bar (above college cards):**
  - Left: Results summary counter: `"Showing {{ $colleges->firstItem() ?? 0 }}-{{ $colleges->lastItem() ?? 0 }} of {{ $colleges->total() }} Universities"`.
  - Right: Sort Select Box:
    - Automatically submits form on change: `<select name="sort" onchange="this.form.submit()">`.
- **Active Filter Chips Container:**
  - Displayed prominently above cards when any filter is active.
  - Interactive pill tags with badge styling:
    - Text label + bold "×" button.
    - Clicking the chip navigates to its `remove_url`.
    - "Clear All Filters" button on the right resetting all parameters.
- **Faceted Sidebar Polish:**
  - Stream & Course list counts.
  - Clean filter search inputs.
  - Quick "Reset" and "Apply" buttons.

### Task 23.3: Automated Feature Tests in `tests/Feature/AdvancedCollegeSearchFilterTest.php`
- **Create:** `tests/Feature/AdvancedCollegeSearchFilterTest.php`:
  1. `test_can_filter_colleges_by_stream_slug_and_id()`
  2. `test_can_filter_colleges_by_course_slug()`
  3. `test_can_filter_colleges_by_state_and_city()`
  4. `test_can_filter_colleges_by_annual_fee_ranges()`
  5. `test_can_sort_colleges_by_rating_and_name()`
  6. `test_active_filter_chips_render_with_removal_urls()`
  7. `test_pagination_links_preserve_active_filter_queries()`

### Task 23.4: Code Style Hygiene & Full Verification
- Format modified PHP code using `vendor/bin/pint --format agent`.
- Execute narrow test suite: `php artisan test --filter=AdvancedCollegeSearchFilterTest`.
- Execute full application test suite: `php artisan test --compact` to verify 140+ green tests.

---

## 4. Verification & Success Criteria
- [ ] Filtering regular or online colleges by stream, course, state, city, or fee returns the exact subset.
- [ ] Both singular (`?stream=...`) and array (`?streams[]=...`) parameter formats are handled smoothly.
- [ ] Active filter chips appear with correct labels and clicking "×" cleanly drops that parameter.
- [ ] Sorting changes order as expected (`rating_desc`, `name_asc`, etc.).
- [ ] Pagination links preserve all query parameters (`$colleges->withQueryString()`).
- [ ] All tests pass 100% green with zero regressions (`php artisan test --compact`).
