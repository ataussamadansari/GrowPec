# Phase 24 Plan: Comprehensive Pest Feature Tests, Pint & Verification

**Phase:** Phase 24 — Comprehensive Pest Feature Tests, Pint & Verification  
**Milestone:** v1.5 — College Comparison & Advanced Search Filters  
**Status:** Planned / Ready for Execution  
**Created:** 2026-10-18  

---

## 1. Phase Objective
Perform an exhaustive verification audit across Milestone v1.5 (College Comparison & Advanced Search Filters), extend automated Pest feature tests to cover compound multidimensional filters and online universities, enforce strict Laravel Pint formatting standards, and verify that the full test suite passes 100% green with zero regressions.

---

## 2. Technical Architecture & Verification Matrix

```
┌─────────────────────────────────────────────────────────────┐
│ 1. Milestone v1.5 Scope Under Verification:                 │
│ • Phase 21: /compare Engine & Public Matrix View            │
│ • Phase 22: Comparison Dock & Add-to-Compare Action Triggers│
│ • Phase 23: Advanced Faceted Filters, Chips & Dynamic Sort  │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│ 2. Automated Feature Test Suites:                           │
│ • tests/Feature/CollegeComparisonTest.php (6 tests)         │
│ • tests/Feature/CollegeComparisonDockTest.php (4 tests)     │
│ • tests/Feature/AdvancedCollegeSearchFilterTest.php         │
│   - Regular university filters                              │
│   - Online university filters (compound stream/degree)      │
│   - Compound multi-dimensional filter combinations          │
│   - Sort & pagination preservation                          │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│ 3. Quality & Regression Gate:                               │
│ • Laravel Pint Code Styling: vendor/bin/pint --format agent │
│ • Complete Test Suite Execution: php artisan test --compact │
│ • Target: 100% Green, 145+ passing tests, 0 failures        │
│ • Milestone v1.5 Completion & STATE.md update               │
└─────────────────────────────────────────────────────────────┘
```

---

## 3. Detailed Implementation Tasks

### Task 24.1: Extend Automated Feature Test Coverage
- **Location:** `tests/Feature/AdvancedCollegeSearchFilterTest.php` & `tests/Feature/CollegeComparisonTest.php`.
- **New Test Cases:**
  1. **Online College Multi-Dimensional Filtering:**
     - Query `/online-colleges` with `stream`, `level`, and `degree_type` parameters.
     - Assert that online universities with matching courses are returned while regular colleges or non-matching universities are excluded.
     - Assert active filter chips render properly on the online colleges listing page.
  2. **Compound Multi-Dimensional Cross-Filtering:**
     - Simultaneously apply `stream`, `state`, and `fee_range` parameters.
     - Assert only colleges matching *all* applied criteria appear in the paginated results.
  3. **Comparison Edge Cases & Enquiry Pre-population:**
     - Verify that the comparison matrix renders individual "Apply Now" buttons with valid `data-college-id` attributes.
     - Verify gracefully handling non-existent college slugs in comparison requests.

### Task 24.2: Code Quality, Styling & Hygiene Verification
- Run `vendor/bin/pint --format agent` across the entire codebase to ensure strict compliance with project style rules.
- Review view templates (`colleges/compare.blade.php`, `colleges/index.blade.php`, `colleges/show.blade.php`, and `layouts/app.blade.php`) to confirm all HTML entities, accessibility labels, and script dependencies are clean.

### Task 24.3: Complete Test Suite Execution & Regression Audit
- Run narrow test suites:
  - `php artisan test --filter=CollegeComparisonTest`
  - `php artisan test --filter=CollegeComparisonDockTest`
  - `php artisan test --filter=AdvancedCollegeSearchFilterTest`
- Run full application test suite:
  - `php artisan test --compact`
  - Confirm all 145+ tests pass with zero failures or deprecation warnings.

### Task 24.4: Milestone Documentation & Completion
- Update `.planning/STATE.md` marking Phase 24 and Milestone v1.5 complete.
- Verify git status and prepare clean commit for Phase 24.

---

## 4. Verification & Success Criteria
- [ ] Online universities filtering on `/online-colleges` is covered by automated feature tests.
- [ ] Compound cross-dimensional filtering (`stream` + `state` + `fee_range`) is tested and validated.
- [ ] Comparison enquiry trigger metadata is verified by tests.
- [ ] `vendor/bin/pint --format agent` passes without formatting errors.
- [ ] All 145+ tests pass 100% green (`php artisan test --compact`).
- [ ] Milestone v1.5 deliverables are documented and verified.
