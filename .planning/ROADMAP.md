# Project Roadmap: GrowPec Distance & Online University Catalog

**Project:** GrowPec Distance & Online University Catalog  
**Generated:** 2026-10-10  
**Mode:** Agile / Fast  

---

## Phases Overview

```
┌────────────────────────────────────────────────────────┐
│ Phase 1: Audit & Enrich Universities 1 - 6             │
│ (IIMT, Bennett, TMU, SGT, Subharti, Mangalayatan)      │
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 2: Audit & Enrich Universities 7 - 11            │
│ (CCSU, Amity, LPU, Chandigarh University, Shobhit)     │
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 3: Seeder Execution & Database Synchronization  │
│ (Run seeder, verify relationships & foreign keys)      │
└───────────────────────────┬────────────────────────────┘
                            │
                            ▼
┌────────────────────────────────────────────────────────┐
│ Phase 4: UI/UX Verification & Automated Pest Testing   │
│ (Route testing, filter checks, Pest Feature tests)     │
└────────────────────────────────────────────────────────┘
```

---

## Detailed Phase Breakdown

### Phase 1: Audit & Enrich Universities 1 to 6
- **Goal:** Verify and enrich the first batch of 6 universities in `DistanceOnlineCollegeSeeder.php` with 100% authentic courses, fee breakdowns, and specializations.
- **Scope:**
  - 1. IIMT University Online, Meerut
  - 2. Bennett University Online, Greater Noida
  - 3. Teerthanker Mahaveer University Online (TMU), Moradabad
  - 4. SGT University Online, Gurugram
  - 5. Swami Vivekanand Subharti University Online & Distance, Meerut
  - 6. Mangalayatan University Online, Aligarh
- **Deliverables:** Verified course offerings (MBA, MCA, BCA, BBA, BA, etc.), authentic per-semester and total fees, UGC-DEB accreditations, and highlights in `DistanceOnlineCollegeSeeder.php`.

### Phase 2: Audit & Enrich Universities 7 to 11
- **Goal:** Verify and enrich the second batch of 5 universities in `DistanceOnlineCollegeSeeder.php` with 100% authentic courses, fee breakdowns, and specializations.
- **Scope:**
  - 7. Chaudhary Charan Singh University Online & Distance (CCSU), Meerut
  - 8. Amity University Online, Noida
  - 9. Lovely Professional University Online (LPU), Phagwara
  - 10. Chandigarh University Online (CU), Mohali
  - 11. Shobhit University CDOE, Meerut
- **Deliverables:** Verified course offerings, accurate fee schedules, approved specializations, and placement figures in `DistanceOnlineCollegeSeeder.php`.

### Phase 3: Seeder Execution & Database Synchronization
- **Goal:** Execute `DistanceOnlineCollegeSeeder` cleanly into the active database, ensuring all relational entities link properly.
- **Scope:**
  - Run `php artisan db:seed --class=DistanceOnlineCollegeSeeder`.
  - Validate database count and foreign key associations (`college_courses`, `college_course_fees`, `college_course_specializations`, `college_faqs`, `college_highlights`).
  - Ensure re-runnability/idempotency without key duplication.
- **Deliverables:** All 11 distance/online institutions fully populated with live relations in `growpec_db`.

### Phase 4: UI/UX Verification & Automated Pest Testing
- **Goal:** Test public catalog listing, detail views, and author comprehensive automated feature tests.
- **Scope:**
  - Verify `/online-colleges` search and filtering (degree, stream, fee range).
  - Inspect sample university detail profiles (`/college/iimt-university-online`, `/college/amity-university-online`, `/college/chandigarh-university-online`).
  - Create and execute `tests/Feature/OnlineCollegesTest.php` with Pest.
  - Run Laravel Pint formatter (`vendor/bin/pint --format agent`).
- **Deliverables:** Passing Pest test suite, verified UI rendering, and clean git commit.
