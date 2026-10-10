# Phase 10 Plan: Academic & Geographic Master Resources

**Phase:** 10  
**Milestone:** v1.2 — Filament Admin Panel v5 Migration  
**Goal:** Create native Filament v5 Resources for Geographic (`State`, `City`) and Academic (`Stream`, `Course`, `Specialization`) entities under `/admin` with full schema definitions, relationships, validation constraints, table filters, actions, and Pest test coverage.  
**Status:** Planned  

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
- **Action:**
  - Generate resources via `php artisan make:filament-resource State --no-interaction` and `City --no-interaction`.
  - Configure `StateResource`:
    - Navigation group: `'Academics & Geography'`, sort: 1, icon: `Heroicon::OutlinedMapPin`.
    - Form: `name` (required, unique, live auto-slug), `slug` (required, unique), `status` (Toggle, default true).
    - Table: Columns for name, slug, cities count, status toggle. Pre-delete check preventing deletion if cities exist.
  - Configure `CityResource`:
    - Navigation group: `'Academics & Geography'`, sort: 2, icon: `Heroicon::OutlinedBuildingOffice2`.
    - Form: `state_id` (Select relation to State, searchable, required), `name` (required, live auto-slug), `slug` (required), `is_popular` (Toggle), `image` (FileUpload, disk 'public', directory 'cities', max 4MB, required if is_popular), `status` (Toggle).
    - Table: Columns for image, name, state name, is_popular toggle, status toggle. Filters by state, popular, and status.

### Task 10.2: Scaffold and Implement Academic Resources (`StreamResource`, `CourseResource`, `SpecializationResource`)
- **Action:**
  - Generate resources via `php artisan make:filament-resource Stream --no-interaction`, `Course --no-interaction`, and `Specialization --no-interaction`.
  - Configure `StreamResource`:
    - Navigation group: `'Academics & Geography'`, sort: 3, icon: `Heroicon::OutlinedAcademicCap`.
    - Form: `name` (required, unique, live auto-slug), `slug` (required, unique), `icon` (nullable string, max 50).
    - Table: Name, slug, icon, courses count. Deletion guard if courses exist.
  - Configure `CourseResource`:
    - Navigation group: `'Academics & Geography'`, sort: 4, icon: `Heroicon::OutlinedBookOpen`.
    - Form: `stream_id` (Select relation to Stream, searchable, required), `name` (required, live auto-slug), `slug` (required), `level` (Select UG/PG/Diploma/PhD/Certificate), `degree_type` (Select Degree/Diploma/Certificate), `duration` (Select or TextInput with default '3 Years').
    - Table: Name, stream name, level badge, degree_type badge, duration, college courses count, specializations count. Filters by stream, level, and degree_type.
  - Configure `SpecializationResource`:
    - Navigation group: `'Academics & Geography'`, sort: 5, icon: `Heroicon::OutlinedTag`.
    - Form: `course_id` (Select relation to Course, searchable, required), `name` (required, live auto-slug), `slug` (required), `status` (Toggle, default true).
    - Table: Name, course name, stream name, status toggle. Filter by course, status.

### Task 10.3: Author Automated Pest Feature Tests
- **Action:**
  - Create `tests/Feature/FilamentAcademicGeographicTest.php`.
  - Test suites:
    1. `StateResource`: List, create, update, delete guard when cities exist.
    2. `CityResource`: List, create with state relation, popular city toggle and validation.
    3. `StreamResource`: List, create, delete guard when courses exist.
    4. `CourseResource`: List, create with stream relation, level/degree_type validation, table filters.
    5. `SpecializationResource`: List, create with course relation, status toggle.
    6. Role Security: Student and guest users blocked with 403 / redirect.

### Task 10.4: Code Formatting & Regression Verification
- **Action:**
  - Run `vendor/bin/pint --dirty --format agent`.
  - Run `php artisan test --compact` to verify 100% test pass rate with 0 regressions.

---

## 3. Verification & Acceptance Criteria
- [ ] All 5 Filament v5 resources accessible at `/admin/states`, `/admin/cities`, `/admin/streams`, `/admin/courses`, `/admin/specializations`.
- [ ] Grouped under `'Academics & Geography'` navigation group in sidebar with order 1 through 5.
- [ ] CRUD operations work with proper validation, auto-slugging, and relationship bindings.
- [ ] State and Stream deletion protections prevent orphan records when children exist.
- [ ] City popular limit and image uploads work as expected.
- [ ] Course levels, degree types, and durations match database enums and existing data.
- [ ] Automated Pest tests in `FilamentAcademicGeographicTest.php` pass 100%.
- [ ] All existing 47 tests continue to pass without regressions.
- [ ] Laravel Pint code style checks pass cleanly.
