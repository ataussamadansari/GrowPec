# Phase 10 Plan: Academic & Geographic Master Resources

**Phase:** 10  
**Milestone:** v1.2 — Filament Admin Panel v5 Migration  
**Goal:** Create native Filament v5 Resources for Geographic (`State`, `City`) and Academic (`Stream`, `Course`, `Specialization`) entities under `/admin` with full schema definitions, relationships, validation constraints, table filters, actions, and Pest test coverage.  
**Status:** Completed  

---

## 1. Context & Architecture

### Existing State:
- Academic and geographic entities were managed via legacy custom Blade controllers:
  - `LocationController.php` (States & Cities)
  - `StreamManagerController.php` (Streams)
  - `CourseManagerController.php` (Courses)
  - `SpecializationManagerController.php` (Specializations)
- Database schema:
  - `states`: `id`, `name`, `slug`, `status`, `timestamps`
  - `cities`: `id`, `state_id`, `name`, `slug`, `image`, `is_popular`, `status`, `timestamps`
  - `streams`: `id`, `name`, `slug`, `icon`, `timestamps`
  - `courses`: `id`, `stream_id`, `name`, `slug`, `level` (`UG`, `PG`, `Diploma`, `PhD`, `Certificate`), `degree_type` (`Degree`, `Diploma`, `Certificate`), `duration`, `timestamps`
  - `specializations`: `id`, `course_id`, `name`, `slug`, `status`, `timestamps`

### Target Architecture (Filament v5):
- Resources placed in `app/Filament/Resources/` under their respective domain namespaces:
  - `App\Filament\Resources\States\StateResource`
  - `App\Filament\Resources\Cities\CityResource`
  - `App\Filament\Resources\Streams\StreamResource`
  - `App\Filament\Resources\Courses\CourseResource`
  - `App\Filament\Resources\Specializations\SpecializationResource`
- All 5 resources registered in the `'Academics & Geography'` navigation group with intuitive icons and ordered navigation sort indexes (1 to 5).
- Schemas and tables conform to Filament v5 modular architecture (`Schemas/*Form.php`, `Tables/*Table.php`, and `Pages/*`).
- Business rules retained:
  - State deletion prohibited if child cities exist.
  - Stream deletion prohibited if child courses exist.
  - Max 10 popular cities constraint.
  - Slug auto-generation on name blur/change.
  - Cascading relationships and search filters.

---

## 2. Tasks & Execution Steps

### Task 10.1: Scaffold and Implement Geographic Resources (`StateResource` & `CityResource`)
- **Status:** [x] Completed
- **Artifacts:** `app/Filament/Resources/States/`, `app/Filament/Resources/Cities/`

### Task 10.2: Scaffold and Implement Academic Resources (`StreamResource`, `CourseResource`, `SpecializationResource`)
- **Status:** [x] Completed
- **Artifacts:** `app/Filament/Resources/Streams/`, `app/Filament/Resources/Courses/`, `app/Filament/Resources/Specializations/`

### Task 10.3: Author Automated Pest Feature Tests
- **Status:** [x] Completed
- **Artifacts:** `tests/Feature/FilamentAcademicGeographicTest.php` (20 passed tests, 66 assertions)

### Task 10.4: Code Formatting & Regression Verification
- **Status:** [x] Completed
- **Artifacts:** Pint clean, complete test suite passing (67 passed tests, 311 assertions)

---

## 3. Verification & Acceptance Criteria
- [x] All 5 Filament v5 resources accessible at `/admin/states`, `/admin/cities`, `/admin/streams`, `/admin/courses`, `/admin/specializations`.
- [x] Grouped under `'Academics & Geography'` navigation group in sidebar with order 1 through 5.
- [x] CRUD operations work with proper validation, auto-slugging, and relationship bindings.
- [x] State and Stream deletion protections prevent orphan records when children exist.
- [x] City popular limit and image uploads work as expected.
- [x] Course levels, degree types, and durations match database enums and existing data.
- [x] Automated Pest tests in `FilamentAcademicGeographicTest.php` pass 100% (20 tests, 66 assertions).
- [x] All existing tests continue to pass without regressions (67 total passed tests, 311 assertions).
- [x] Laravel Pint code style checks pass cleanly.

