# Phase 25: Master Relational Architecture & Safe Database Normalization — Context & Decisions

**Phase:** Phase 25 — Master Relational Architecture & Safe Database Normalization  
**Status:** Context Defined / In Discussion  
**Date:** 2026-10-18  
**Domain:** Database Architecture, Relational Normalization, Filament Admin & Public Forms  

---

## 1. Executive Summary & Intent
The GrowPec application features rich master datasets (`states`, `cities`, `streams`, `courses`, `specializations`). However, legacy string fields (`state`, `city`, `specialization`, etc.) co-exist alongside foreign keys, admin forms allow freeform strings instead of referencing master records, public lead forms send raw text, and dual-mode colleges are stored as duplicate rows.

The user's direct instruction is:
> *"complete database and app check karo. main apna explain nahi kar paa raha hoon sayad but tum pakad lo. jaise states, cities, streams, courses, specializations, master tables h to wo use karo. database and backend clear karo."*

This phase establishes the master tables as the single canonical source of truth across the database, backend Eloquent models, Filament admin interfaces, public views, and lead capture workflows, while guaranteeing 100% data preservation and zero regressions.

---

## 2. Locked Core Decisions

### Decision 1: Strict Preservation of Existing Production Data
- **Zero Data Loss Guarantee:** All existing college profiles (26 live colleges), courses (720 offerings), specializations, fee structures, leads, student reviews, and editorial content must be strictly preserved.
- **No Destructive DB Operations:** Never execute `migrate:fresh`, `db:wipe`, destructive seeders, unverified table drops, or bulk un-scoped deletes.
- **Historical Migration Immutability:** Historical migration files that have already run must not be altered. All schema adjustments must be performed through reviewed, forward-only migrations.

### Decision 2: Canonical Master Data Hierarchy & Sources of Truth
Every domain in GrowPec will have exactly one canonical relational source:
1. **Geographic Master:**
   - **Canonical:** `states` table (`id`, `name`, `slug`) $\rightarrow$ `cities` table (`id`, `state_id`, `name`, `slug`).
   - **College Location:** `colleges.state_id` and `colleges.city_id` are authoritative. Redundant `state` and `city` varchar columns will be phased out safely with virtual model accessors (`getStateAttribute()`, `getCityAttribute()`) providing backward compatibility.
2. **Academic Master:**
   - **Canonical:** `streams` (`id`, `name`, `slug`) $\rightarrow$ `courses` (`id`, `stream_id`, `name`, `level`, `duration`) $\rightarrow$ `specializations` (`id`, `course_id`, `name`, `slug`).
   - **College Offerings:** `college_courses` links `college_id` + `course_id` + `specialization_id`.
   - The 8 legacy offerings in `college_courses` currently having `specialization_id IS NULL` will be mapped and enriched into the `specializations` master table so 100% of college courses are relationally linked.
3. **Institutional Content & Assets:**
   - Accreditations: authoritative in `college_accreditations` table.
   - Highlights: authoritative in `college_highlights` table.
   - Facilities: authoritative in `college_facilities` table.
   - Placements: authoritative in `college_placement_stats` and `college_recruiters`.
   - FAQs: authoritative in `college_faqs`.

### Decision 3: Filament Admin Panel Modernization
- **College Courses Management:** In `CollegeCoursesRelationManager`, replace the free-text `TextInput::make('specialization')` with a reactive, searchable `Select::make('specialization_id')` that dynamically filters specializations belonging to the selected `course_id`.
- **College Location Management:** In `CollegeForm`, streamline the location section to use searchable `state_id` and cascading `city_id` selects without requiring redundant duplicate text typing.
- **Leads Management:** In `LeadForm`, update student location fields to use searchable `state_id` and `city_id` selectors.
- **Master Data Protection:** Enforce database foreign key constraints (`RESTRICT` on delete) or Filament validation rules to prevent deletion of master records (e.g. deleting a State or Course) that are actively referenced by colleges, college courses, or leads.

### Decision 4: Public Frontend & Lead Capture Modernization
- **Global & College Lead Modals:**
  - Modernize lead capture (`layouts/app.blade.php`, `colleges/show.blade.php`, `pages/contact.blade.php`) to use cascading dependent dropdowns: selecting a State dynamically loads active Cities via `/api/states/{id}/cities`.
  - When submitting course interest, submit `college_course_id` and/or `specialization_id` directly so the CRM captures exact student intent without ambiguity.
- **Public Views Relational Rendering:**
  - Standardize all public views (`index.blade.php`, `show.blade.php`, `compare.blade.php`) to resolve locations and courses through normalized relationships (`$college->cityRelation?->name`, `$college->stateRelation?->name`, `$cc->specializationRelation?->name`) with safe virtual fallbacks.

### Decision 5: College Dual-Mode Architecture Review
- Currently, institutions like IIMT University, Bennett University, and Teerthanker Mahaveer University have two separate rows (one for `regular` on-campus and one for `online` distance) due to a binary `college_mode` enum.
- To prevent SEO fragmentation, review the architecture:
  - Option A: Link regular and online institutional profiles via a `parent_college_id` self-referential relationship.
  - Option B: Introduce a `both` mode or mode-tagged course offerings while preserving dedicated landing URLs if required for admissions.
- Any merge or linkage must have an explicit source-to-destination migration map verified prior to changes.

### Decision 6: Empty Tables & Legacy Columns Policy
- **Never drop solely based on zero rows:** Every table and column must be audited across models, relation managers, seeders, and migration history.
- `college_career_outcomes` and `college_gallery` have Filament relation managers and UI blocks; they are retained as active features.
- Truly orphaned tables (`college_documents`, `college_loan_options`, `college_alumni`) with zero rows, zero relation managers, and zero UI usage will be cleanly deprecated via forward-only reversible migrations only after approval.

---

## 3. Sub-Phase Execution Blueprint

```
┌────────────────────────────────────────────────────────────────────────┐
│ Phase 25.1: Comprehensive Relational Audit & Source-to-Dest Map        │
│ (Audit migrations, live rows, relations, models; write MIGRATION-MAP)  │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│ Phase 25.2: Master Data Enrichment & Referential Integrity             │
│ (Seed missing 8 specializations, backfill specialization_id to 100%)   │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│ Phase 25.3: Filament Admin Cascading Dropdowns & Master Protection     │
│ (CollegeCourses: course->specialization, College: state->city)         │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│ Phase 25.4: Public Lead Capture & Views Relational Alignment           │
│ (Cascading State->City dropdowns in lead modals, relational views)     │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│ Phase 25.5: Forward-Only Schema Migration, Dual-Mode Link & Tests      │
│ (Safe forward-only migrations, full test suite pass, Pint formatting)  │
└────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Verification & Quality Gates
- **Automated Tests:** 146+ Pest feature tests must remain 100% green without failures.
- **Code Standards:** `vendor/bin/pint --format agent` must pass with zero formatting issues.
- **Database Sanity Check:** Verify via CLI script that all 720 `college_courses` have valid `specialization_id`, all 26 colleges have valid `state_id`/`city_id`, and zero orphaned foreign keys exist.
- **Smoke Tests:** Test live `/colleges`, `/college/{slug}`, `/compare`, `/lead/submit`, and `/admin` panel in the browser.
