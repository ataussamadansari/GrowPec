# Integrations & External Services

**Analysis Date:** 2026-10-10

## Overview
GrowPec functions primarily as a self-contained monolith with key data persistence integrations, asynchronous file asset management, lead generation hooks, and CDN dependencies.

## Internal & Infrastructure Integrations

### Database (MySQL)
- **Engine:** MySQL 8.x / MariaDB
- **Connection Details:** Configured in `.env` via `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE=growpec_db`.
- **Database Tables:** 25 migrations creating core tables:
  - System: `users`, `cache`, `jobs`, `system_settings`
  - Academics: `streams`, `courses`, `specializations`
  - Colleges & Details: `colleges`, `college_courses`, `college_accreditations`, `college_admission_sections`, `college_facilities`, `college_faqs`, `college_highlights`, `college_placement_stats`, `college_recruiters`, `college_reviews`, `college_scholarships`, `college_quick_facts`
  - Geographic: `states`, `cities`
  - Leads CRM: `leads`, `lead_activities`
  - Administration: `banners`, `partners`, `leadership_messages`, `center_logins`

### Storage & Media
- **Local Public Disk:** Media uploaded through Admin panel (college logos, hero images, brochure PDFs, partner university logos, leadership portraits, banner images).
- **Symlink:** `public/storage` linked to `storage/app/public`.
- **Image Fallbacks:** Inline placeholder URLs and default SVGs when assets are absent.

### Mailing & Notifications
- **Mail Driver:** Standard Laravel `MAIL_MAILER` (SMTP / log driver).
- **Usage:** Configured for administrative communication, system alerts, and notification dispatches.

## Public Endpoints & AJAX APIs

### Lead Intake API
- **Route:** `POST /lead/submit` (`LeadController@store`)
- **Purpose:** Captures visitor enquiries submitted through admission modal forms, quick enquiry popups, and course enquiry forms.
- **Payload:** Name, email, phone, city, state, course/stream interests, source tracking, and custom inquiry notes.
- **Persistence:** Creates record in `leads` table and logs initial event in `lead_activities`.

### Public College Review Submission API
- **Route:** `POST /college/{slug}/reviews` (`CollegeReviewController@store`)
- **Purpose:** Captures public guest and student reviews for colleges.
- **Protection:** Honeypot field (`website_url` spam trap) and IP-based rate throttling (`throttle:5,60`).
- **Persistence:** Inserts pending review into `college_reviews` requiring admin moderation before appearing publicly.

### Live Autocomplete & Cascading APIs
- **Route:** `GET /api/live-search` (`HomeController@liveSearch`)
  - Provides instantaneous search across colleges, courses, and locations.
- **Route:** `GET /api/states/{state_id}/cities`
  - Returns active cities for a selected state to populate cascading dropdowns in dynamic forms.
- **Route:** `GET /api/courses/{course_id}/specializations`
  - Returns active specializations under a specified academic course.

### SEO & Discovery
- **Route:** `GET /sitemap.xml`
  - Generates dynamic XML sitemap containing all published college detail pages (`/college/{slug}`).

## Third-Party Services & CDNs
- **Bootstrap CDN:** `https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css` & JS bundle.
- **Bootstrap Icons:** `https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css`.
- **Google Fonts:** Inter, Outfit, and related typography stylesheets.
- **Font Awesome:** Icon assets used in admin views and selected components.
