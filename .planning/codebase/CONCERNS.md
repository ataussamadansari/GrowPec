# Architecture Concerns & Technical Debt

**Analysis Date:** 2026-10-10

## Overview
This document records identified technical debt, potential architectural risks, and areas identified for optimization within the GrowPec codebase.

## 1. Schema & Migration Inconsistencies

### Missing `college_quick_facts` Table Migration
- **Observation:** `CollegeSeeder.php` attempts to seed `college_quick_facts`, but wraps execution in `if (Schema::hasTable('college_quick_facts'))`.
- **Impact:** No migration file creates the `college_quick_facts` table. Any features depending on quick facts will silently skip inserting or querying unless the table is added via a proper migration.
- **Recommendation:** Create a dedicated migration for `college_quick_facts` or retire unused references in the seeder.

## 2. Legacy & Dead Code

### Prototype Controller `v0_CollegeController.php`
- **Observation:** `app/Http/Controllers/v0_CollegeController.php` remains in the controllers directory.
- **Impact:** Unused code adds clutter and confusion during code searches and maintenance.
- **Recommendation:** Archive or delete `v0_CollegeController.php` once verified that all necessary logic exists in `CollegeController.php`.

## 3. Monolithic View Templates & UI Assets

### Large Blade Files
- **Observation:**
  - `resources/views/home.blade.php`: ~167 KB.
  - `resources/views/colleges/show.blade.php`: ~117 KB.
  - `resources/views/layouts/app.blade.php`: ~78 KB.
- **Impact:** Large Blade files containing inline CSS and JavaScript increase cognitive overhead and render times, while making collaborative editing prone to merge conflicts.
- **Recommendation:** Decompose complex sections into discrete Blade components (`<x-college.course-card>`, `<x-lead-modal>`, `<x-home.hero-slider>`).

### Dual CSS Styling Strategy
- **Observation:**
  - Tailwind CSS v4 is configured via Vite (`@tailwindcss/vite` in `vite.config.js`).
  - Public layouts (`app.blade.php`) heavily utilize Bootstrap 5.3.3 and Bootstrap Icons loaded via CDN, plus inline scoped styles.
- **Impact:** Styling collisions, increased download payloads, and potential inconsistencies between Bootstrap classes and Tailwind utility classes.
- **Recommendation:** Consolidate frontend styling onto a unified design system.

## 4. Large Data Sets Embedded in Seeders

### Voluminous Seeder Files
- **Observation:**
  - `database/seeders/DistanceOnlineCollegeSeeder.php`: ~433 KB.
  - `database/seeders/RegularCollegeSeeder.php`: ~248 KB.
  - `database/seeders/OnlineUniversitySeeder.php`: ~162 KB.
- **Impact:** Direct PHP arrays containing hundreds of college records, fee matrices, and FAQs can increase memory usage during `db:seed` operations and complicate version control diffs.
- **Recommendation:** Move raw university catalogs and course fee datasets into external structured JSON or CSV seed files (`database/data/*.json`) loaded by the seeders.

## 5. Test Coverage Expansion

### Public Flow Integration Tests
- **Observation:**
  - Existing feature tests (`tests/Feature/`) primarily cover `CenterLoginTest.php`, `ContactSettingsTest.php`, and `NotFoundPageTest.php`.
  - Core student discovery routes (`CollegeController@regularColleges`, `CollegeController@onlineColleges`, `CollegeController@show`) and lead intake (`LeadController@store`) lack comprehensive automated test suites.
- **Impact:** Regressions in filtering or lead validation could go undetected during refactoring.
- **Recommendation:** Add Pest feature tests for `CollegeController` filtering, search queries, and lead capture validation.
