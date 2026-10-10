# Project: GrowPec Distance & Online University Catalog

**Initialized:** 2026-10-10  
**Mode:** Agile / Fast  
**Framework:** Laravel 12 on PHP 8.2+  
**Database:** MySQL (growpec_db)  

---

## 1. Executive Summary
GrowPec is an education portal empowering students across India to discover, compare, and enroll in top regular and distance/online colleges. This project cycle focuses on completing and auditing the **Distance & Online Universities Catalog** for 11 premier institutions:
1. IIMT University Online, Meerut
2. Bennett University Online, Greater Noida
3. Teerthanker Mahaveer University Online (TMU), Moradabad
4. SGT University Online, Gurugram
5. Swami Vivekanand Subharti University Online & Distance, Meerut
6. Mangalayatan University Online, Aligarh
7. Chaudhary Charan Singh University Online & Distance (CCSU), Meerut
8. Amity University Online, Noida
9. Lovely Professional University Online (LPU), Phagwara
10. Chandigarh University Online (CU), Mohali
11. Shobhit University CDOE, Meerut

---

## 2. Core Objectives & Non-Negotiables
- **100% Authentic Course & Fee Data:** Every seeded program must reflect real, authentic fee breakdowns (per semester, per year, total fee, exam fee), eligibility criteria, duration, and approved specializations.
- **Accreditation Integrity:** Verified UGC-DEB, AICTE, NAAC, NIRF, and AIU accreditations.
- **Data Completeness:** Comprehensive aggregate records including FAQs, alumni profiles, placement statistics, scholarships, and learning management system (LMS) highlights.
- **Flawless UI Integration:** Clean display on public discovery routes (`/online-colleges` and `/college/{slug}`) without rendering glitches, double-escaping issues (e.g. `&amp;`), or broken filters.

---

## 3. Technology Stack Summary
- **Backend:** Laravel 12 (`laravel/framework: ^12.0`, PHP 8.2+)
- **ORM & DB:** Eloquent ORM with MySQL
- **Frontend:** Vite 7, Blade templates, Bootstrap 5.3.3 + Bootstrap Icons
- **Testing:** Pest 3.8 / PHPUnit 11
- **Code Standards:** Laravel Pint (`vendor/bin/pint --format agent`)

---

## 4. Current State & Baseline
- 19 colleges are presently seeded in `colleges` (8 regular campus institutions, 11 online universities).
- `DistanceOnlineCollegeSeeder.php` contains the initial definitions for all 11 target universities.
- Detailed course fee matrices, specializations, and tab content need validation and enrichment against live university offerings.

---

## 5. Success Metrics
- [ ] All 11 distance/online universities have verified courses, fees, and specializations seeded.
- [ ] College detail pages (`/college/{slug}`) render all tabs (About, Courses & Fees, Placements, Approvals, FAQs) with zero errors.
- [ ] Filtering on `/online-colleges` operates smoothly across streams, degrees, and states.
- [ ] Pest test suite validates online college listing and detail route accessibility.
