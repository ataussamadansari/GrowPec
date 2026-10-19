# Project State & Memory

**Project:** GrowPec Education Portal  
**Current Milestone:** v2.1 — GrowPec Platform Reviews & Ratings System  
**Last Updated:** 2026-10-19  
**Milestone Status:** Completed & Polished (158 Tests Passing, 100% Green, 725 Assertions)  

---

## Reviews & Ratings System & UI Redesign (v2.1)
- **Backend Foundation:**
  - Table: `website_reviews` with status (`pending`, `approved`, `rejected`, `flagged`), IP tracking, email privacy protection, and honeypot field.
  - Model: `App\Models\WebsiteReview` with auto-clearing public stats cache (`growpec_website_reviews_stats`).
  - Controller: `App\Http\Controllers\WebsiteReviewController` with rate limiting (`throttle:5,60`).
  - Filament Resource: `WebsiteReviewsResource` with moderation actions, tabs (`All`, `Pending`, `Approved`, `Rejected`, `Flagged`), and reason modals.
- **UI Redesign Execution:**
  - Contract: `.planning/phases/26-reviews-and-rating-ui-redesign/UI-SPEC.md`.
  - Homepage (`home.blade.php`): Radial backdrop glow, oversized gold gradient score numeral (`gp-score-numeral`), animated progress bar tracks (`IntersectionObserver`), hover elevated cards (`translateY(-5px)`), verified student pill badges, accessible 5-star selector modal with live scale physics and character counter.
  - College Profile (`colleges/show.blade.php`): Harmonized metrics card, gold score numeral, pill progress tracks, verified badges, and character counter.
- **Quality Gates:**
  - Laravel Pint: Passed agent formatting.
  - Tests: 158 passed (725 assertions).

---

## Milestone v2.0 Phase Progress Tracker

| Phase | Description | Status | Target |
|---|---|---|---|
| **Phase 25** | Full Existing-Code Audit & Migration Matrix | **In Progress** | Create `docs/JSON_CONTENT_MIGRATION_AUDIT.md`, audit all schema, models, views, controllers |
| **Phase 26** | Generic JSON Content Section Foundation | **Pending** | `college_content_sections` additive migration, model, block validator service |
| **Phase 27** | Reusable Dynamic Content Block Editor Component | **Pending** | Reusable admin editor for tables, lists, text, headings, preview |
| **Phase 28** | Fixed Mode-Based Quick Tabs Engine & Public Views | **Pending** | `config/college_tabs.php` (Online 11 tabs, Regular 10 tabs), public Blade renderer |
| **Phase 29** | Safe Content Migration to JSON System | **Pending** | `content:migrate-to-json --dry-run`, data preservation & validation |
| **Phase 30** | End-to-End Integration Tests & Migration Report | **Pending** | Full test suite green, `docs/JSON_CONTENT_MIGRATION_REPORT.md` |

---

## Active Context & Decisions
- **Milestone v2.0 Initialized:**
  - Full prompt specification loaded from user.
  - Project naming preserved as `colleges` / `College`.
  - Core relational tables preserved: `states`, `cities`, `streams`, `courses`, `specializations`, `college_courses`, `leads`, `college_reviews`.
  - Quick Tabs set as fixed configuration via `config/college_tabs.php`:
    - Online: Highlights, Overview, Courses, Admission, Approvals, Learning, Degree, Placements, Fee/EMI, FAQ, Reviews (11 tabs).
    - Regular: Highlights, Overview, Courses, Admission, Scholarships, Placements, Campus, Rankings, FAQ, Reviews (10 tabs).
  - Executing Prompt 1 (Phase 25): Full read-only audit to produce `docs/JSON_CONTENT_MIGRATION_AUDIT.md`.
