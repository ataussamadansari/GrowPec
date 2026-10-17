# Phase 17 Plan: Research & Implement Colleges 9–11 in RegularCollegeSeeder

**Phase:** Phase 17 — Research & Implement Colleges 9–11  
**Milestone:** v1.4 — Regular College Catalog Expansion (Colleges 9–15)  
**Status:** In Progress / Ready for Execution  
**Created:** 2026-10-17  

---

## 1. Phase Objective
Research, formulate, and implement 100% authentic, verified higher-education data into `database/seeders/RegularCollegeSeeder.php` for three prominent regular on-campus universities:
1. **College 9: Maharishi University of Information Technology (MUIT), Noida**
2. **College 10: Future University, Bareilly**
3. **College 11: Haridwar University, Roorkee / Haridwar**

Every institution must follow the exact schema and relational structure established by Colleges 1–8, providing comprehensive coverage across courses, fee structures, admissions, placements, scholarships, and campus facilities.

---

## 2. Institutional Details & Specifications

### 2.1 College 9: Maharishi University of Information Technology (MUIT), Noida
- **Name:** Maharishi University of Information Technology
- **Short Name:** MUIT Noida
- **Slug:** `maharishi-university-of-information-technology-noida`
- **Type:** Private
- **University:** Maharishi University of Information Technology
- **Website:** `https://www.muitnoida.edu.in`
- **Location:** Sector 110, Noida, Gautam Buddha Nagar, Uttar Pradesh - 201304
- **Established:** 2001 (Act No. 31 of 2001, amended 2013)
- **Campus:** Modern Noida NCR campus with smart classrooms, advanced AI & Data Science labs, legal aid clinic, and Transcendental Meditation & Yoga Center
- **Approvals:** UGC (2f), AICTE, BCI, PCI
- **Ratings & Reviews:** Rating 4.3 (720 reviews)
- **Placements:** Highest ₹15.00 LPA, Average ₹4.20 LPA
- **Top Recruiters:** TCS, Infosys, Tech Mahindra, HCL, Genpact, Wipro, Paytm, Justdial, Capgemini, Tommy Hilfiger
- **Programs (Real Fees & Eligibility):**
  - B.Tech CSE (AI & Data Science): 4 Yrs, ₹1,40,000/yr (₹70,000/sem), 10+2 PCM min 50%
  - B.Tech CSE (Cyber Security): 4 Yrs, ₹1,40,000/yr, 10+2 PCM min 50%
  - BCA: 3 Yrs, ₹90,000/yr (₹45,000/sem), 10+2 with Math/CS min 45%
  - MCA: 2 Yrs, ₹1,00,000/yr (₹50,000/sem), BCA/B.Sc IT min 50%
  - BBA: 3 Yrs, ₹80,000/yr (₹40,000/sem), 10+2 any stream min 45%
  - MBA (Dual Specialization): 2 Yrs, ₹1,20,000/yr (₹60,000/sem), Graduation min 50%
  - B.A. LL.B (Hons): 5 Yrs, ₹90,000/yr, 10+2 min 45% (BCI approved)
  - LL.B: 3 Yrs, ₹60,000/yr, Graduation min 45%
  - B.Pharm: 4 Yrs, ₹1,20,000/yr, 10+2 PCM/PCB min 50% (PCI approved)
  - D.Pharm: 2 Yrs, ₹80,000/yr, 10+2 PCM/PCB min 50%

---

### 2.2 College 10: Future University, Bareilly
- **Name:** Future University
- **Short Name:** Future University Bareilly
- **Slug:** `future-university-bareilly`
- **Type:** Private
- **University:** Future University
- **Website:** `https://futureuniversity.in`
- **Location:** Bareilly-Lucknow Road, Near Faridpur, Bareilly, Uttar Pradesh - 243123
- **Established:** 2009 (conferred Private University status under UP State Private University Act)
- **Campus:** 35+ Acres state-of-the-art campus, multi-specialty clinical hospital tie-up, engineering workshops, Olympic sports arena
- **Approvals:** UGC, AICTE, PCI, BCI, INC
- **Ratings & Reviews:** Rating 4.2 (580 reviews)
- **Placements:** Highest ₹18.00 LPA, Average ₹3.80 LPA
- **Top Recruiters:** Infosys, Wipro, TCS, Axis Bank, Policybazaar, BYJU'S, Genpact, HCL, Bajaj Finserv, Tech Mahindra
- **Programs (Real Fees & Eligibility):**
  - B.Tech CSE: 4 Yrs, ₹1,15,000/yr (₹57,500/sem), 10+2 PCM min 45%
  - B.Tech CSE (AI & Data Science): 4 Yrs, ₹1,15,000/yr, 10+2 PCM min 45%
  - B.Tech Mechanical Engineering: 4 Yrs, ₹85,000/yr, 10+2 PCM min 45%
  - Polytechnic Diploma (Mechanical/Civil/Electrical): 3 Yrs, ₹45,000/yr, 10th pass min 35%
  - BCA: 3 Yrs, ₹60,000/yr (₹30,000/sem), 10+2 with Math/CS min 45%
  - MCA: 2 Yrs, ₹75,000/yr (₹37,500/sem), Graduation in BCA/CS min 50%
  - BBA: 3 Yrs, ₹55,000/yr (₹27,500/sem), 10+2 any stream min 45%
  - MBA: 2 Yrs, ₹95,000/yr (₹47,500/sem), Graduation min 50%
  - B.Pharm: 4 Yrs, ₹1,05,000/yr, 10+2 PCM/PCB min 50%
  - D.Pharm: 2 Yrs, ₹75,000/yr, 10+2 PCM/PCB min 50%
  - B.Sc Nursing: 4 Yrs, ₹1,20,000/yr, 10+2 PCB min 45% + English

---

### 2.3 College 11: Haridwar University, Roorkee / Haridwar
- **Name:** Haridwar University
- **Short Name:** Haridwar University Roorkee
- **Slug:** `haridwar-university-roorkee`
- **Type:** Private
- **University:** Haridwar University
- **Website:** `https://www.haridwaruniversity.edu.in`
- **Location:** 5th Km, Roorkee-Haridwar Canal Road, Bajuheri, Roorkee, Haridwar, Uttarakhand - 247667
- **Established:** 2010 (elevated to Private University by Uttarakhand State Legislature)
- **Campus:** 20+ Acres lush green eco-friendly campus, advanced robotics center, high-tech automotive workshop, on-campus hostels
- **Approvals:** UGC, AICTE, PCI, UBTER
- **Ratings & Reviews:** Rating 4.4 (810 reviews)
- **Placements:** Highest ₹85.00 LPA (International) / ₹24.00 LPA (Domestic), Average ₹4.80 LPA
- **Top Recruiters:** Microsoft, Amazon, Infosys, IBM, Capgemini, Tata Motors, Ashok Leyland, Bajaj Auto, Tech Mahindra, Tommy Hilfiger
- **Programs (Real Fees & Eligibility):**
  - B.Tech CSE (AI & ML, Cloud Computing): 4 Yrs, ₹1,35,000/yr (₹67,500/sem), 10+2 PCM min 50%
  - B.Tech Mechanical Engineering: 4 Yrs, ₹95,000/yr (₹47,500/sem), 10+2 PCM min 45%
  - B.Tech Civil Engineering: 4 Yrs, ₹95,000/yr, 10+2 PCM min 45%
  - Polytechnic Diploma (Mechanical/Civil/Electrical): 3 Yrs, ₹50,000/yr, 10th pass min 35%
  - BCA: 3 Yrs, ₹65,000/yr (₹32,500/sem), 10+2 min 45%
  - MCA: 2 Yrs, ₹85,000/yr, BCA/B.Sc CS min 50%
  - BBA: 3 Yrs, ₹65,000/yr, 10+2 min 45%
  - MBA: 2 Yrs, ₹1,10,000/yr, Graduation min 50%
  - B.Sc (Hons) Agriculture: 4 Yrs, ₹80,000/yr, 10+2 PCB/PCM/Agri min 50%
  - B.Pharm: 4 Yrs, ₹1,15,000/yr, 10+2 PCM/PCB min 50%
  - D.Pharm: 2 Yrs, ₹75,000/yr, 10+2 PCM/PCB min 50%

---

## 3. Tasks Breakdown

### Task 17.1: Author `maharishiUniversityNoida()` Method
- **File:** `database/seeders/RegularCollegeSeeder.php`
- **Action:** Add private method returning complete definition for MUIT Noida, with 10 academic programs, 5 institutional highlights, 6 facilities, 6 FAQs, 3 placement stats, 10 recruiters, 4 scholarship schemes, and 2 admission sections.

### Task 17.2: Author `futureUniversityBareilly()` Method
- **File:** `database/seeders/RegularCollegeSeeder.php`
- **Action:** Add private method returning complete definition for Future University Bareilly, with 11 academic programs, 5 institutional highlights, 6 facilities, 6 FAQs, 3 placement stats, 10 recruiters, 4 scholarship schemes, and 2 admission sections.

### Task 17.3: Author `haridwarUniversity()` Method
- **File:** `database/seeders/RegularCollegeSeeder.php`
- **Action:** Add private method returning complete definition for Haridwar University Roorkee, with 11 academic programs, 5 institutional highlights, 6 facilities, 6 FAQs, 3 placement stats, 10 recruiters, 4 scholarship schemes (including Uttarakhand domicile waiver), and 2 admission sections.

### Task 17.4: Register in `collegeList()` & Verify City Resolvers
- **File:** `database/seeders/RegularCollegeSeeder.php`
- **Action:**
  - Append `$this->maharishiUniversityNoida()`, `$this->futureUniversityBareilly()`, and `$this->haridwarUniversity()` to `collegeList()`.
  - Ensure cities `'Noida'`, `'Bareilly'`, and `'Roorkee'` are marked popular and map cleanly to states `'Uttar Pradesh'` and `'Uttarakhand'`.

### Task 17.5: Code Hygiene & Validation
- **Action:**
  - Verify PHP syntax via `php -l database/seeders/RegularCollegeSeeder.php`.
  - Run `vendor/bin/pint --dirty --format agent` to maintain code standards.
  - Run existing test suite (`php artisan test --compact`) to ensure 0 regressions.

---

## 4. Success Criteria
- [ ] `RegularCollegeSeeder.php` contains clean, well-formed methods for Colleges 9, 10, and 11.
- [ ] All 3 colleges registered in `collegeList()`.
- [ ] 0 syntax errors or missing array keys.
- [ ] Pint code formatting passes cleanly.
- [ ] Existing 118 tests remain 100% green.
