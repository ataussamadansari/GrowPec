# Milestone v1.4 Requirements: Regular College Catalog Expansion (Colleges 9–15)

**Milestone:** v1.4 — Regular College Catalog Expansion  
**Status:** In Planning  
**Created:** 2026-10-17  

---

## 1. Overview & Objective
GrowPec currently features 8 fully-detailed regular colleges in `database/seeders/RegularCollegeSeeder.php`:
1. Graphic Era (Deemed to be University), Dehradun
2. IIMT University, Meerut
3. Bennett University, Greater Noida
4. Metro College of Health Sciences & Research, Greater Noida
5. Dr. K.N. Modi University / Institute of Engineering & Technology, Modinagar
6. Galgotias University, Greater Noida
7. Teerthanker Mahaveer University (TMU), Moradabad
8. Amrapali University, Haldwani

The objective of Milestone v1.4 is to seed the remaining 7 institutions (Colleges 9–15) with 100% authentic, real-world data (degrees, specializations, verified annual/semester fees, real placement CTC metrics, authentic recruiter logos/lists, campus facilities, verified approvals, scholarships, and step-by-step admissions guide), execute database seeding, and verify end-to-end functionality via an automated Pest test suite.

---

## 2. Functional Requirements: College Definitions

### REQ-REG-09: Maharishi University of Information Technology (MUIT), Noida
- **Entity Identity:** `Maharishi University of Information Technology`, Noida, Uttar Pradesh (UP State Private University Act 31 of 2001, amended 2013).
- **Approvals & Accreditations:** UGC (2f), AICTE, BCI, PCI.
- **Academic Programs & Real Fees:**
  - B.Tech CSE (AI & Data Science): 4 Years, ~₹1,40,000/yr.
  - B.Tech CSE (Cyber Security): 4 Years, ~₹1,40,000/yr.
  - BCA / MCA: 3 Years / 2 Years.
  - BBA / MBA (Dual Specialization in Marketing, Finance, HR): ~₹1,20,000/yr.
  - LL.B (3 Yrs) & B.A. LL.B (Hons, 5 Yrs): BCI-approved law curriculum.
  - B.Pharm (4 Yrs) & D.Pharm (2 Yrs): PCI-approved pharmaceutical programs.
- **Relational Data:** Highlights, Placement Stats (Highest ₹15 LPA, Avg ₹4.2 LPA), Top Recruiters (TCS, Infosys, Tech Mahindra, HCL, Genpact), Facilities (Transcendental Meditation & Yoga Center, High-Tech Labs), FAQs, Scholarships, Admission Guide.

### REQ-REG-10: Future University, Bareilly
- **Entity Identity:** `Future University` (established from Future Institute of Engineering & Technology / Future Group of Institutions), Bareilly, Uttar Pradesh.
- **Approvals & Accreditations:** UGC, AICTE, PCI, BCI, INC.
- **Academic Programs & Real Fees:**
  - B.Tech Computer Science & Engineering: 4 Years, ~₹1,15,000/yr.
  - B.Tech AI & Data Science: 4 Years, ~₹1,15,000/yr.
  - Polytechnic Diploma in Mechanical/Civil Engineering: 3 Years, ~₹45,000/yr.
  - MBA / BBA: 2 Years / 3 Years.
  - B.Pharm (4 Yrs) & D.Pharm (2 Yrs).
  - B.Sc Nursing & GNM.
- **Relational Data:** Highlights, Placement Stats (Highest ₹18 LPA, Avg ₹3.8 LPA), Top Recruiters (Infosys, Wipro, TCS, Axis Bank, Policybazaar, BYJU'S), Facilities, FAQs, Scholarships, Admission Guide.

### REQ-REG-11: Haridwar University, Roorkee / Haridwar
- **Entity Identity:** `Haridwar University` (formerly Roorkee College of Engineering - RCE), Bajuheri, Roorkee-Haridwar Canal Road, Uttarakhand.
- **Approvals & Accreditations:** UGC, AICTE, PCI, UBTER.
- **Academic Programs & Real Fees:**
  - B.Tech CSE (AI & ML, Cloud Computing): 4 Years, ~₹1,35,000/yr.
  - B.Tech Mechanical / Civil / Electrical Engineering: 4 Years, ~₹95,000/yr.
  - Polytechnic Diploma in Engineering: 3 Years, ~₹50,000/yr.
  - BCA / MCA: 3 Years / 2 Years.
  - MBA / BBA: 2 Years / 3 Years.
  - B.Sc (Hons) Agriculture: 4 Years, ICAR-aligned curriculum.
  - B.Pharm & D.Pharm.
- **Relational Data:** Highlights, Placement Stats (Highest ₹85 LPA International / ₹24 LPA Domestic, Avg ₹4.8 LPA), Top Recruiters (Microsoft, Amazon, Infosys, IBM, Capgemini, Tata Motors), Facilities, FAQs, Uttarakhand Domicile & Merit Scholarships, Admission Guide.

### REQ-REG-12: COER University, Roorkee
- **Entity Identity:** `COER University` (founded in 1998 as College of Engineering Roorkee by Seth Roshan Lal Jain Trust; elevated to University in 2021), Vardhman Puram, Roorkee, Uttarakhand.
- **Approvals & Accreditations:** UGC, AICTE, PCI, BCI.
- **Academic Programs & Real Fees:**
  - B.Tech Computer Science & Engineering: 4 Years, ~₹1,60,000/yr.
  - B.Tech AI & ML / Data Science / Cyber Security: 4 Years, ~₹1,60,000/yr.
  - B.Tech Mechanical / Civil / Electrical: 4 Years, ~₹1,10,000/yr.
  - BCA / MCA: 3 Years / 2 Years.
  - MBA / BBA / B.Com: 2 Years / 3 Years.
  - B.Pharm & D.Pharm.
  - B.Sc Nursing & GNM.
  - B.A. LL.B (5 Yrs) & LL.B (3 Yrs).
- **Relational Data:** Highlights (75+ acre heritage green campus, High Performance Computing labs), Placement Stats (Highest ₹44 LPA, Avg ₹5.5 LPA), Top Recruiters (Google, Amazon, Microsoft, Infosys, Cognizant, Wipro, Morgan Stanley), Facilities, FAQs, Scholarships, Admission Guide.

### REQ-REG-13: HRIT Group of Institutions, Ghaziabad
- **Entity Identity:** `HRIT Group of Institutions` (Harish Chandra Ram Kali Charitable Trust, est. 2005), 7th Km Milestone, Delhi-Meerut Road, Morta, Ghaziabad, Uttar Pradesh.
- **Approvals & Accreditations:** UGC, AICTE, PCI, BCI, INC, affiliated with AKTU & CCSU.
- **Academic Programs & Real Fees:**
  - B.Tech CSE: 4 Years, ~₹1,05,000/yr.
  - B.Tech AI & Data Science: 4 Years, ~₹1,05,000/yr.
  - B.Tech Mechanical / ECE / Civil: 4 Years, ~₹85,000/yr.
  - Polytechnic Diploma in Engineering: 3 Years, ~₹45,000/yr.
  - BCA / MCA / BBA / MBA: Standard affiliated fee slabs.
  - B.Pharm (4 Yrs) & D.Pharm (2 Yrs): NBA-accredited pharmacy division.
  - BHMCT (Hotel Management): 4 Years.
- **Relational Data:** Highlights, Placement Stats (Highest ₹15 LPA, Avg ₹4.0 LPA), Top Recruiters (Infosys, TCS, Wipro, Tech Mahindra, Samsung, Lupin, Sun Pharma), Facilities, FAQs, Scholarships, Admission Guide.

### REQ-REG-14: SRM Institute of Science and Technology (NCR Campus), Modinagar, Ghaziabad
- **Entity Identity:** `SRM Institute of Science and Technology` (Delhi-NCR Campus), Delhi-Meerut Road, Modinagar, Ghaziabad, Uttar Pradesh (Deemed to be University under Section 3 of UGC Act).
- **Approvals & Accreditations:** UGC, AICTE, NAAC A++ (Highest Grade), NBA, MHRD Category 1.
- **Academic Programs & Real Fees:**
  - B.Tech Computer Science & Engineering: 4 Years, ~₹3,00,000/yr.
  - B.Tech CSE with AI & ML / Data Science / Cloud Computing: 4 Years, ~₹3,00,000/yr.
  - B.Tech ECE / Mechanical: 4 Years, ~₹1,75,000/yr.
  - BCA / MCA: 3 Years / 2 Years.
  - MBA (Dual Specialization): 2 Years, ~₹2,25,000/yr.
  - BBA: 3 Years, ~₹1,15,000/yr.
  - B.Pharm & M.Pharm.
  - Hotel Management & Catering Technology: 3 Years.
- **Relational Data:** Highlights (NAAC A++, 25-acre lush NCR campus, centralized placements with main Kattankulathur campus), Placement Stats (Highest ₹50 LPA domestic / ₹1.02 Crore international, Avg ₹7.7 LPA), Top Recruiters (Amazon, Microsoft, Adobe, Cisco, Google, TCS Digital, Cognizant, Optum), Facilities, FAQs, Founder's & Merit Scholarships, Admission Guide.

### REQ-REG-15: Noida International University (NIU), Greater Noida
- **Entity Identity:** `Noida International University`, Yamuna Expressway, Greater Noida, Uttar Pradesh (UP State Private University Act).
- **Approvals & Accreditations:** UGC (2f), AICTE, BCI, PCI, INC, Council of Architecture (CoA), National Medical Commission (NMC).
- **Academic Programs & Real Fees:**
  - B.Tech CSE (AI & ML, Data Science): 4 Years, ~₹1,50,000/yr.
  - B.Tech Mechanical / Civil / Electrical: 4 Years, ~₹1,10,000/yr.
  - BCA / MCA: 3 Years / 2 Years.
  - BBA / MBA: 3 Years / 2 Years.
  - MBBS: 5.5 Years (affiliated with 750+ bed NIIMS Super-Specialty Hospital).
  - B.Sc Nursing & GNM.
  - B.Pharm & D.Pharm.
  - B.A. LL.B / BBA LL.B (5 Yrs) & LL.M (1 Yr).
  - B.Arch (5 Yrs, CoA-approved).
- **Relational Data:** Highlights (75-acre campus on Yamuna Expressway, NIIMS hospital, 30+ foreign university collaborations), Placement Stats (Highest ₹32 LPA, Avg ₹5.2 LPA), Top Recruiters (Amazon, TCS, Infosys, Cognizant, Apollo Hospitals, Max Healthcare, HDFC Bank), Facilities, FAQs, Chancellor's Scholarships, Admission Guide.

---

## 3. Structural & Execution Requirements

### REQ-SEED-01: Idempotent Seeder Architecture
- `RegularCollegeSeeder` must execute without duplicate key violations or constraint failures.
- State and City foreign keys must resolve accurately (using existing records or creating missing cities/states dynamically).
- All 15 colleges must be included in `collegeList()` and processed by `seedSingleCollege()`.

### REQ-TEST-01: Comprehensive Pest Test Suite
- Create feature test `tests/Feature/RegularCollegesComprehensiveSeederTest.php` asserting:
  1. `RegularCollegeSeeder` seeds exactly 15 colleges into `colleges` table.
  2. All 15 colleges possess at least 6+ active course offerings with valid fees and eligibility.
  3. Relational child records exist for all 15 colleges (highlights, facilities, FAQs, placement stats, recruiters, scholarships, admission sections).
  4. Public profile route `/college/{slug}` returns HTTP 200 for all 15 colleges.
- Existing 118 tests in the suite continue to pass with 0 regressions.
