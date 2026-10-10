# Requirements: Distance & Online University Catalog

**Project:** GrowPec Distance & Online University Catalog  
**Status:** Approved  
**Version:** 1.0  
**Date:** 2026-10-10  

---

## 1. Functional Requirements

### FR-1: Seed Data Audit & Authentic Enrichment
- **FR-1.1:** Audit existing data for the 11 target universities in `DistanceOnlineCollegeSeeder.php` (IIMT, Bennett, TMU, SGT, Subharti, Mangalayatan, CCSU, Amity, LPU, Chandigarh University, Shobhit).
- **FR-1.2:** Ensure authentic details for every university: established year, official website, campus/digital headquarters, address, approvals, NAAC grade, NIRF rankings, and placement statistics.

### FR-2: Academic Course, Fee & Specialization Matrix
- **FR-2.1:** Seed 100% authentic course offerings for each university (e.g. Online MBA, MCA, BCA, BBA, B.Com, M.Com, BA, MA, M.Sc).
- **FR-2.2:** Populate accurate fee structures in `college_course_fees`:
  - Per-semester fee
  - Per-year fee
  - Total course fee
  - One-time registration / admission fee
  - Exam fee per semester
- **FR-2.3:** Map approved specializations under each course (e.g., MBA in Marketing, Finance, HR, IT, Analytics, Healthcare).

### FR-3: Accreditation, Compliance & Approvals
- **FR-3.1:** Verify UGC-DEB (Distance Education Bureau) approval status for all distance/online offerings.
- **FR-3.2:** Record official regulatory affiliations (AICTE, AIU, NAAC grade with cycle, NIRF ranking where applicable).

### FR-4: Public Online Colleges Directory (`/online-colleges`)
- **FR-4.1:** Display curated distance and online institutions filtered strictly by `college_mode = 'online'` or `is_online = true`.
- **FR-4.2:** Provide functional multi-faceted filters:
  - Stream (Management, IT, Commerce, Humanities, Science)
  - Degree (Undergraduate, Postgraduate, Diploma, Certificate)
  - State / City location
  - Fee range slider
  - Accreditation filter (NAAC A++, UGC-DEB)
- **FR-4.3:** Ensure badge and ribbon indicators ("UGC-DEB Approved", "NAAC A+", "Online & Distance") render cleanly without HTML entity double-escaping.

### FR-5: College Profile & Detail Page Experience (`/college/{slug}`)
- **FR-5.1:** Render all overview cards: Key Highlights, Approvals & Accreditations, Admission Process, Scholarship Info, and LMS features.
- **FR-5.2:** Render interactive tab navigation:
  - "Overview": About, Quick Facts, Virtual Tour/Campus gallery.
  - "Courses & Fees": Full list of online degrees with expandable syllabus and semester fee breakdown.
  - "Placements": Top recruitment partners, average CTC, and career outcomes.
  - "Reviews & FAQs": Student reviews and verified answers to frequently asked questions.

### FR-6: Lead Capture & Inquiry Workflow
- **FR-6.1:** Connect "Apply Now" and "Download Brochure" modal CTAs directly to `LeadController@store`.
- **FR-6.2:** Associate leads with the specific college and online course being viewed.

---

## 2. Non-Functional Requirements

### NFR-1: Data Integrity & Transactions
- All seed operations must run within database transactions (`DB::transaction`) to prevent partial or corrupted catalog state.
- Foreign key relations must be validated against `courses` and `specializations` taxonomy before insertion.

### NFR-2: Test Automation & Regression Safety
- Automated Pest tests must cover the `/online-colleges` directory and individual `/college/{slug}` profile routes.
- Verify that seeding is idempotent and can re-run without throwing duplicate slug errors.

### NFR-3: Code Quality & Style
- All PHP code must adhere strictly to Laravel 12 conventions and pass Laravel Pint formatting (`vendor/bin/pint --format agent`).

---

## 3. Requirement Traceability Matrix

| Requirement | Target Component | Verification Method |
|---|---|---|
| FR-1 (Seeder Audit) | `database/seeders/DistanceOnlineCollegeSeeder.php` | Artisan `db:seed` execution & DB verification |
| FR-2 (Courses & Fees) | `college_courses`, `college_course_fees` | Database query & UI Courses tab check |
| FR-3 (Approvals) | `colleges.approvals`, `college_accreditations` | UI Badges & Accreditation inspection |
| FR-4 (Online Directory) | `app/Http/Controllers/CollegeController.php`, `colleges/index.blade.php` | Browser navigation to `/online-colleges` |
| FR-5 (Profile Experience) | `resources/views/colleges/show.blade.php` | Visual and functional inspection of `/college/{slug}` |
| FR-6 (Lead Capture) | `LeadController@store`, inquiry modal | Pest Feature test & form submission |
| NFR-2 (Test Automation) | `tests/Feature/OnlineCollegesTest.php` | Pest test execution (`php artisan test`) |
| NFR-3 (Code Quality) | Entire codebase | `vendor/bin/pint --format agent` |
