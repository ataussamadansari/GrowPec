# Project: GrowPec Education Portal

**Current Milestone:** v1.1 — Public Guest College Review System (Without Login)  
**Updated:** 2026-10-10  
**Framework:** Laravel 12 on PHP 8.2+  
**Database:** MySQL (growpec_db)  

---

## 1. Project Overview & Milestone v1.1 Context
GrowPec is an education portal empowering students across India to discover, compare, and enroll in top regular and distance/online colleges. 

In **Milestone v1.1**, GrowPec is introducing a **Public Guest Review System**. Previously, college reviews could only be created manually via backend seeding/admin. This milestone allows genuine visitors, current students, and alumni to submit ratings and feedback for any college directly on the public details page without requiring account registration, while preventing spam through honeypots and rate limiting, and ensuring quality through admin moderation.

---

## 2. Milestone v1.1 Core Objectives
- **Frictionless Submission:** Visitors and students can submit honest college reviews without logging in.
- **Robust Anti-Spam & Security:** Invisible honeypot field, client IP logging, and strict rate throttling (e.g. max 5 reviews/hour/IP).
- **Quality Moderation:** All incoming guest reviews enter a `pending` status by default and require administrator approval before appearing publicly.
- **Authentic Presentation:** Public college profile pages (`/college/{slug}`) display verified/approved reviews alongside calculated average ratings and rating breakdowns.
- **Admin Management:** Dedicated moderation interface in the Admin Panel to review, approve, reject, or delete submissions.

---

## 3. Technology Stack & Architecture
- **Backend:** Laravel 12, PHP 8.2+
- **Security:** Laravel `ThrottleRequests` rate limiting, custom honeypot validation
- **Database:** MySQL with Eloquent (`CollegeReview` model & relations)
- **Frontend:** Blade templates, Bootstrap 5.3.3, SVG/Icon star rating widget
- **Testing:** Pest 3.8 / PHPUnit 11 feature tests with `RefreshDatabase`
- **Code Standards:** Laravel Pint (`vendor/bin/pint --format agent`)

---

## 4. Milestone History
- **v1.0 — Architecture Mapping & Distance/Online Catalog Planning:** Initialized codebase map (7 core documents) and foundational distance/online university definitions.
- **v1.1 — Public Guest College Review System (Active):** Unauthenticated guest reviews with rate limiting, honeypots, public display, and admin moderation workflow.
