# Milestone v2.0 Requirements: Flexible JSON-Based College Content Architecture & Schema Simplification

**Milestone:** v2.0 — Flexible JSON-Based College Content Architecture & Schema Simplification  
**Status:** In Progress — Phase 25 (Audit)  
**Created:** 2026-10-18  

---

## 1. Executive Summary & Purpose
Migrate flexible institution-page content from fragmented child tables and duplicated string fields into one unified, reusable, versioned JSON-based content system (`college_content_sections`).

### Core Target Decisions
1. **Naming Stability:** Keep current project naming (`colleges` table, `College` model). Do not rename to `institutions`.
2. **Preserve Relational Master Data:** Keep strictly relational:
   - `states`, `cities`
   - `streams`, `courses`, `specializations`
   - `college_courses`
   - `leads`
   - `college_reviews`
   Do not put courses, specializations, fee comparison data, leads, or reviews into JSON.
3. **Static Quick Tabs:** Quick tabs are fixed configuration via `config/college_tabs.php` based on `college_mode`:
   - **Online Tabs (11 tabs, exact order):** Highlights, Overview, Courses, Admission, Approvals, Learning, Degree, Placements, Fee/EMI, FAQ, Reviews.
   - **Regular Tabs (10 tabs, exact order):** Highlights, Overview, Courses, Admission, Scholarships, Placements, Campus, Rankings, FAQ, Reviews.
4. **Generic JSON Table:** `college_content_sections` with versioned block structure (`heading`, `paragraph`, `bullet_list`, `numbered_list`, `table`, `note`, `image`, `divider`).
5. **No Blind Data Migration:** Migrate only flexible informational content after full audit and dry-run verification.

---

## 2. Functional Requirements Breakdown

### REQ-JSON-01: Full Existing-Code Audit
- Create `docs/JSON_CONTENT_MIGRATION_AUDIT.md` covering:
  - Existing table schema and foreign keys relevant to colleges/content.
  - Every model relation, controller read/write, validation rule, form input, Blade section, JavaScript field, seeder, and query.
  - Matrix for each section (source, editor, renderer, filtering use, proposed destination, risk).
  - Duplicated sources of truth (e.g. legacy columns on `colleges` vs child tables).
  - Exact files to change and keep unchanged.
  - Safe migration, verification, and rollback strategy.

### REQ-JSON-02: Generic JSON Content Foundation
- Add additive Laravel migration for `college_content_sections`:
  - `id`
  - `college_id` (foreign key to `colleges.id`)
  - `section_key` (string, indexed)
  - `title` (nullable string)
  - `content` (JSON, versioned block structure)
  - `status` (boolean, default true)
  - `sort_order` (unsigned integer, default 0)
  - `timestamps`
  - Unique constraint on `(college_id, section_key)`.
- Eloquent model `CollegeContentSection` with relationships and validation.
- Server-side block validation service ensuring safe structure, sanitization, and XSS prevention.

### REQ-JSON-03: Reusable Dynamic Content Block Editor
- Build one reusable editor component for college admin forms.
- Support block types: heading (level), paragraph, bullet_list, numbered_list, table (dynamic columns & rows), note, divider, image.
- Live preview and JSON view.
- Reused across all eligible sections (Admission, Scholarships, Approvals, Learning, Degree, Placements, Campus, Rankings, FAQ).

### REQ-JSON-04: Fixed Quick Tabs Engine
- Create `config/college_tabs.php` defining exact Online and Regular tab order and metadata.
- Update public `colleges/show.blade.php` to render tabs dynamically based on college mode.
- Render flexible sections from `college_content_sections` using a unified section/block component.

### REQ-JSON-05: Safe Data Migration Command
- Author idempotent Artisan command `php artisan content:migrate-to-json --dry-run`.
- Real dry-run simulation mode reporting migrated, skipped, conflicting, and empty records.
- Preserve all original source rows during migration.

### REQ-JSON-06: Verification & Final Report
- Comprehensive Pest tests verifying JSON validation, tab rendering, admin editing, and regression safety.
- Generate `docs/JSON_CONTENT_MIGRATION_REPORT.md` documenting schema changes, data counts, test results, and rollback guidance.
