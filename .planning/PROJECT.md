# Project: GrowPec Education Portal

**Current State:** Completed Milestone v1.4 — Regular College Catalog Expansion (Colleges 9–15)  
**Updated:** 2026-10-17  
**Framework:** Laravel 12 on PHP 8.2+  
**Admin Tool:** Filament Admin Panel v5 (`filament/filament:"^5.0"`)  
**Database:** MySQL (growpec_db)  
**Test Suite Health:** 127 passed tests (555 assertions), 100% green  

---

## 1. Project Overview & Current State
GrowPec is an education portal empowering students across India to discover, compare, and enroll in top regular and distance/online colleges.

Following the successful completion of **Milestone v1.3 (Architecture Cleanup & Schema Normalization)**:
- All dead controllers and legacy admin routes have been removed.
- Redundant database tables (`college_comparisons`, `college_course_fees`, `college_course_specializations`, `college_learning_experiences`) were cleanly dropped.
- Filament Admin Panel v5 manages all college and relational child records.
- 118 automated Pest feature tests verify all public and administrative workflows with 0 regressions.

---

## 2. Active Milestone Goals: v1.4 Regular College Catalog Expansion (Colleges 9–15)
The active milestone expands the curated on-campus college catalog from 8 institutions to 15 institutions by adding authentic, research-backed data into `database/seeders/RegularCollegeSeeder.php`:

### Colleges in Scope:
1. **Graphic Era (Deemed to be University), Dehradun** (Already implemented)
2. **IIMT University, Meerut** (Already implemented)
3. **Bennett University, Greater Noida** (Already implemented)
4. **Metro College of Health Sciences & Research, Greater Noida** (Already implemented)
5. **Dr. K.N. Modi University / Foundation, Modinagar** (Already implemented)
6. **Galgotias University, Greater Noida** (Already implemented)
7. **Teerthanker Mahaveer University (TMU), Moradabad** (Already implemented)
8. **Amrapali University, Haldwani** (Already implemented)
9. **Maharishi University of Information Technology (MUIT), Noida** (Phase 17)
10. **Future University, Bareilly** (Phase 17)
11. **Haridwar University, Roorkee / Haridwar** (Phase 17)
12. **COER University, Roorkee** (Phase 18)
13. **HRIT Group of Institutions, Ghaziabad** (Phase 18)
14. **SRM Institute of Science and Technology (NCR Campus), Modinagar, Ghaziabad** (Phase 19)
15. **Noida International University (NIU), Greater Noida** (Phase 19)

### Technical Objectives:
- 100% real and authentic details for every institution (verified fees, approved curricula, genuine NAAC/UGC credentials, NIRF rankings, highest/average placement packages, top recruiters, and real admission guidelines).
- Comprehensive relational child record creation (courses, highlights, facilities, FAQs, placement statistics, recruiters, scholarships, admission steps).
- Automated Pest feature test suite `RegularCollegesComprehensiveSeederTest.php` asserting that all 15 colleges seed cleanly, link all foreign relations, and respond with HTTP 200 on public show routes.

---

## 3. Technology Stack & Architecture
- **Backend:** Laravel 12, PHP 8.2+
- **Admin Panel:** Filament v5 (`filament/filament:"^5.0"`)
- **Database:** MySQL with Eloquent models
- **Frontend / Public:** Blade templates, Bootstrap 5.3.3
- **Testing:** Pest 3.8 / PHPUnit 11 with `RefreshDatabase`
- **Code Standards:** Laravel Pint (`vendor/bin/pint --format agent`)

---

## 4. Milestone History
- **v1.0 — Architecture Mapping & Foundational Setup:** Codebase mapping and catalog foundation.
- **v1.1 — Public Guest College Review System:** Unauthenticated visitor review submission, honeypot & throttling, public showcase, and moderation suite.
- **v1.2 — Filament Admin Panel v5 Migration:** Replaced custom Blade admin controllers with Filament v5 Resources, RelationManagers, and Dashboard widgets.
- **v1.3 — Architecture Cleanup & Schema Normalization:** Dropped 4 redundant tables, pruned obsolete models, simplified relationships, and verified 118 green tests.
