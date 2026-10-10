# Application Architecture

**Analysis Date:** 2026-10-10

## Architectural Pattern
GrowPec follows a traditional **Model-View-Controller (MVC)** architectural pattern within a monolithic Laravel 12 application.

```
                    ┌───────────────────────────┐
                    │      HTTP Request         │
                    └─────────────┬─────────────┘
                                  │
                       ┌──────────┴──────────┐
                       │   Middleware Stack   │
                       │ (Maintenance, Auth, │
                       │   AdminMiddleware)  │
                       └──────────┬──────────┘
                                  │
                                  ▼
                    ┌───────────────────────────┐
                    │      Routing Layer        │
                    │      (routes/web.php)     │
                    └──────┬─────────────┬──────┘
                           │             │
              Public Flow  │             │ Admin Flow
                           ▼             ▼
       ┌────────────────────────┐   ┌────────────────────────┐
       │ Public Controllers     │   │ Admin Controllers      │
       │ (Home, College, Lead)  │   │ (CollegeMgr, LeadMgr)  │
       └───────────┬────────────┘   └───────────┬────────────┘
                   │                            │
                   └─────────────┬──────────────┘
                                 │
                                 ▼
                     ┌───────────────────────┐
                     │    Eloquent Models    │
                     │  (33 Domain Entities) │
                     └───────────┬───────────┘
                                 │
                                 ▼
                     ┌───────────────────────┐
                     │  MySQL Persistence    │
                     └───────────────────────┘
```

## Route Segregation & Security Layers

1. **Authentication Layer (`routes/web.php:36-41`)**:
   - `GET /admin/login` & `POST /admin/login` guarded by `guest` middleware.
   - `POST /admin/logout` guarded by `auth` middleware.
   - Ensures administrative login and logout are decoupled from maintenance filters.

2. **Public Website Layer (`routes/web.php:48-96`)**:
   - Wrapped inside `web` and `CheckMaintenanceMode` middleware.
   - Evaluates system-wide maintenance status configured dynamically in `system_settings`.
   - Handles public homepage (`HomeController`), regular/online college listings and profile views (`CollegeController`), lead submission (`LeadController`), static content (`LeadershipMessagePageController`), and JSON lookup endpoints.

3. **Admin Panel Layer (`routes/web.php:103-148`)**:
   - Prefixed with `/admin` and named `admin.*`.
   - Protected by `web`, `auth`, and `AdminMiddleware`.
   - `AdminMiddleware` checks user authentication and validates whether `auth()->user()->role === 'admin'`.
   - Full CRUD control over streams, courses, specializations, colleges, locations (states/cities), banners, partner strips, leadership messages, center logins, leads CRM, and master settings.

## Domain Model & Data Relationships

### 1. The College Aggregate Root
The `College` model (`app/Models/College.php`) acts as the primary aggregate root for the education catalog. It coordinates over 18 direct Eloquent relations:
- `courses` / `collegeCourses`: Academic offerings linked to global courses.
- `fees`: Comprehensive fee breakdowns per program.
- `specializations`: Specific degree tracks and specializations.
- `accreditations`: UGC, AICTE, NAAC, NBA, and DEB accreditations.
- `admissionSections`: Step-by-step admission criteria and eligibility.
- `alumnis`: Notable alumni profiles with companies and roles.
- `careerOutcomes`: Employment tracks and average starting compensation.
- `comparisons`: Benchmark data comparing institutions.
- `documents`: Downloadable brochures, application guides, and forms.
- `facilities`: Campus and digital infrastructure highlights.
- `faqs`: Common questions and answers.
- `galleries`: Photos, campus imagery, and facilities media.
- `highlights`: Key selling points (e.g., placement records, rankings).
- `learningExperiences`: LMS features and student support frameworks.
- `loanOptions`: Financial aid and banking tie-ups.
- `placementStats`: Placement percentages, average packages, and top packages.
- `recruiters`: Corporate hiring partners and logos.
- `reviews`: Student testimonials and ratings.
- `scholarships`: Merit and need-based financial concessions.

### 2. Academics Taxonomy
- `Stream`: Broad educational classification (e.g., Engineering, Management, Healthcare).
- `Course`: Specific degree programs (e.g., B.Tech, MBA, MCA).
- `Specialization`: Concentration areas under a course (e.g., Data Science, Finance).

### 3. Geographical Hierarchy
- `State` has many `City` records.
- Colleges are mapped to `state_id` and `city_id` to enable precise geographic and regional filtering.

### 4. Lead Capture & CRM Workflow
- Visitors submit inquiries via `LeadController@store`.
- Creates a `Lead` record storing contact details, academic preferences, and source UTM tags.
- Logs transitions and interactions in `LeadActivity` for admin follow-ups.
- Admin manages status changes (`new`, `contacted`, `converted`, `rejected`) and CSV exports via `LeadManagerController`.

## Blade View Architecture
- **Public View Stack**: `resources/views/layouts/app.blade.php` defines the base HTML5 structure, navigation bar, top alert bars, footer, inquiry modal, and dynamic `@yield('content')`, `@stack('styles')`, `@stack('scripts')`.
- **Admin View Stack**: `resources/views/admin/layout.blade.php` implements an administrative layout with a collateral sidebar, metrics bar, flash message alerts, and content slots.
