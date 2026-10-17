# Project Roadmap: GrowPec Education Portal

**Current Milestone:** v1.4 — Regular College Catalog Expansion (Colleges 9–15)  
**Updated:** 2026-10-17  
**Mode:** Agile / Structured  

---

## Milestone v1.4 Phases Overview

```
┌─────────────────────────────────────────────────────────────────┐
│ Phase 17: Research & Implement Colleges 9–11                    │
│ (MUIT Noida, Future University Bareilly, Haridwar University)   │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 18: Research & Implement Colleges 12–13                   │
│ (COER University Roorkee, HRIT Group of Institutions Ghaziabad) │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 19: Research & Implement Colleges 14–15                   │
│ (SRM IST NCR Modinagar, Noida International University NIU)     │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│ Phase 20: Seeding Verification, Pint Hygiene & Full Test Suite  │
│ (Seeder execution, 15-college Pest test suite, zero regressions)│
└─────────────────────────────────────────────────────────────────┘
```

---

## Detailed Phase Breakdown

### Phase 17: Research & Implement Colleges 9–11
- **Goal:** Author 100% authentic, verified institution payloads in `RegularCollegeSeeder.php` for:
  - 9. **Maharishi University of Information Technology (MUIT), Noida**
  - 10. **Future University, Bareilly**
  - 11. **Haridwar University, Roorkee / Haridwar**
- **Tasks:**
  - Define full institutional profiles: name, short name, slug, campus, approvals, NAAC/NIRF credentials, real fees, placements, recruiters, facilities, FAQs, scholarships, admission guides.
  - Wire methods `maharishiUniversityNoida()`, `futureUniversityBareilly()`, and `haridwarUniversity()` into `collegeList()`.
- **Status:** Completed
- **Success Criteria:** Methods return complete arrays adhering to `seedSingleCollege` format without missing keys.

### Phase 18: Research & Implement Colleges 12–13
- **Goal:** Author 100% authentic, verified institution payloads in `RegularCollegeSeeder.php` for:
  - 12. **COER University, Roorkee**
  - 13. **HRIT Group of Institutions, Ghaziabad**
- **Tasks:**
  - Define full institutional profiles: verified B.Tech/Management/Pharmacy/Law fees, placement records, recruiters, facilities, FAQs, scholarships, admission guides.
  - Wire methods `coerUniversityRoorkee()` and `hritGhaziabad()` into `collegeList()`.
- **Status:** Completed
- **Success Criteria:** Both colleges structured with rich relational child data and connected into `collegeList()`.

### Phase 19: Research & Implement Colleges 14–15
- **Goal:** Author 100% authentic, verified institution payloads in `RegularCollegeSeeder.php` for:
  - 14. **SRM Institute of Science and Technology (SRM IST - Delhi-NCR Campus), Modinagar, Ghaziabad**
  - 15. **Noida International University (NIU), Greater Noida**
- **Tasks:**
  - Define full institutional profiles: verified programs (including MBBS/NIIMS hospital for NIU, NAAC A++ for SRM), verified fee structures, placement records, recruiters, facilities, FAQs, scholarships, admission guides.
  - Wire methods `srmGhaziabad()` and `noidaInternationalUniversity()` into `collegeList()`.
- **Status:** Completed
- **Success Criteria:** All 15 colleges defined in `RegularCollegeSeeder.php`.

### Phase 20: Seeding Verification, Pint Hygiene & Full Test Suite
- **Goal:** Execute database seeding, write comprehensive automated Pest tests covering all 15 colleges, format code with Pint, and verify 0 regressions.
- **Tasks:**
  - Run `php artisan db:seed --class=RegularCollegeSeeder` and verify all 15 colleges and child tables populate cleanly without errors.
  - Create feature test `tests/Feature/RegularCollegesCatalogTest.php` testing seeder idempotency, 15 colleges count, course relationships, and HTTP 200 responses on public show routes.
  - Run `vendor/bin/pint --format agent` to maintain strict code hygiene.
  - Run `php artisan test --compact` to confirm 100% green suite (127 tests passed).
- **Status:** Completed
- **Success Criteria:** All 15 colleges seeded and tested, 100% green test suite, zero regressions.

---

## Milestone Archive
- **Milestone v1.0 (Archived):** Project initialization, architecture mapping (`.planning/codebase/`), and distance/online university catalog foundation.
- **Milestone v1.1 (Archived):** Public guest college review system with honeypot anti-spam, rate throttling, public show integration, admin moderation, and 100% passing Pest tests.
- **Milestone v1.2 (Archived):** Filament Admin Panel v5 Migration — Replaced custom Blade admin controllers with Filament v5 Resources, RelationManagers, and Dashboard widgets (116 tests passing).
- **Milestone v1.3 (Archived):** Architecture Cleanup & Schema Normalization — Dropped 4 redundant tables, pruned obsolete models, simplified relationships, and verified 118 green tests.
