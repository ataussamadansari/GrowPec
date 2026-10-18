# Project Roadmap: GrowPec Education Portal

**Current Milestone:** v2.0 — Flexible JSON-Based College Content Architecture & Schema Simplification  
**Updated:** 2026-10-18  
**Mode:** Agile / Structured  

---

## Milestone v2.0 Phases Overview

```
┌─────────────────────────────────────────────────────────────────┐
│ Phase 25: Full Existing-Code Audit & Migration Matrix           │
│ (Audit schema, models, views, controllers -> docs/AUDIT.md)     │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 26: Generic JSON Content Section Foundation               │
│ (college_content_sections migration, model, block validation)   │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 27: Reusable Dynamic Content Block Editor Component       │
│ (Reusable admin block editor: headings, tables, lists, notes)   │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 28: Fixed Mode-Based Quick Tabs Engine & Public Views     │
│ (config/college_tabs.php, Online 11 & Regular 10 tabs, renderer)│
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 29: Safe Content Migration to JSON System                 │
│ (php artisan content:migrate-to-json --dry-run, data integrity) │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 30: End-to-End Integration Tests & Migration Report       │
│ (Full suite green tests, docs/JSON_CONTENT_MIGRATION_REPORT.md) │
└─────────────────────────────────────────────────────────────────┘
```

---

## Detailed Phase Breakdown

### Phase 25: Full Existing-Code Audit & Migration Matrix
- **Goal:** Perform a complete read-only codebase and database audit; produce `docs/JSON_CONTENT_MIGRATION_AUDIT.md`.
- **Tasks:**
  - Audit all table schemas and foreign keys relating to colleges, content child tables, and master tables.
  - Audit every model relation, controller query, validation rule, Filament form input, Blade section, and JS handler.
  - Construct a comprehensive section-by-section migration matrix.
  - Catalog duplicated sources of truth (e.g. `colleges` columns vs child tables).
  - Define exact files that must change and files that must remain untouched.
  - Formulate safe backfill and rollback plan.
- **Success Criteria:** `docs/JSON_CONTENT_MIGRATION_AUDIT.md` created with exhaustive grounding across the codebase.

### Phase 26: Generic JSON Content Section Foundation
- **Goal:** Implement the `college_content_sections` additive migration, model, and server-side validation engine.
- **Tasks:**
  - Add migration `create_college_content_sections_table` with `(college_id, section_key)` unique index.
  - Create model `App\Models\CollegeContentSection` with JSON casting and relationships.
  - Create `ContentBlockValidator` service verifying valid block types (`heading`, `paragraph`, `bullet_list`, `numbered_list`, `table`, `note`, `image`, `divider`) and structure.
  - Add Pest unit and feature tests for JSON content section persistence and validation.
- **Success Criteria:** Additive migration runs cleanly on MySQL; block validation passes tests.

### Phase 27: Reusable Dynamic Content Block Editor Component
- **Goal:** Build one reusable, flexible content block editor for the Filament/admin panel.
- **Tasks:**
  - Build dynamic block editor supporting add, edit, reorder, delete of blocks.
  - Table block editor supporting arbitrary column/row additions and header/cell editing.
  - Live preview and JSON view tabs.
  - Integrate into college management so it is reused for Admission, Scholarships, Approvals, Learning, Degree, Placements, Campus, Rankings, FAQ.
- **Success Criteria:** Admin can edit and save structured multi-block content (paragraphs, dynamic tables, bullet points) through one unified editor.

### Phase 28: Fixed Mode-Based Quick Tabs Engine & Public Views
- **Goal:** Implement fixed quick tabs in `config/college_tabs.php` and public rendering on college profiles.
- **Tasks:**
  - Create `config/college_tabs.php` with exact tab orders (Online: 11 tabs; Regular: 10 tabs).
  - Update `CollegeController::show()` to load active tabs from config and eager-load content sections.
  - Create unified Blade component `components/content-section.blade.php` to render blocks securely with XSS prevention.
  - Synchronize left sticky navigation anchors with tab definitions.
- **Success Criteria:** Visiting an Online university shows the 11 online tabs; visiting a Regular university shows the 10 regular tabs, rendering JSON blocks faithfully.

### Phase 29: Safe Content Migration to JSON System
- **Goal:** Implement an idempotent Artisan command to backfill existing child tables and columns into JSON.
- **Tasks:**
  - Create `app/Console/Commands/MigrateContentToJsonCommand.php` with `--dry-run` and `--force` options.
  - Map legacy content (highlights, admission sections, scholarships, accreditations, placement stats, FAQs) into version 1 block JSON.
  - Verify zero data loss and compare source vs destination record summaries.
- **Success Criteria:** `php artisan content:migrate-to-json --dry-run` executes with clean summary; actual run populates `college_content_sections` without altering original source rows.

### Phase 30: End-to-End Integration Tests & Migration Report
- **Goal:** Author integration tests, verify the complete application health, and write final documentation.
- **Tasks:**
  - author feature tests covering admin JSON editing, public tab rendering, invalid block rejection, and regression prevention.
  - Run full test suite (`php artisan test --compact`) ensuring 100% green tests.
  - Format all modified code via `vendor/bin/pint --format agent`.
  - Create `docs/JSON_CONTENT_MIGRATION_REPORT.md` documenting schema changes, counts, test results, and deployment steps.
- **Success Criteria:** 146+ tests passing, zero formatting violations, and comprehensive final report delivered.

---

## Milestone Archive
- **Milestone v1.0 (Archived):** Project initialization and distance/online university catalog foundation.
- **Milestone v1.1 (Archived):** Public guest college review system with honeypot, moderation, and Pest tests.
- **Milestone v1.2 (Archived):** Filament Admin Panel v5 Migration.
- **Milestone v1.3 (Archived):** Architecture Cleanup & Initial Schema Normalization.
- **Milestone v1.4 (Archived):** Regular College Catalog Expansion (15 authentic universities, 720+ courses).
- **Milestone v1.5 (Archived):** College Comparison Engine (`/compare`), floating dock, and advanced faceted search.
