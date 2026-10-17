# Application Architecture

**Analysis Date:** 2026-10-17

## Architectural Pattern
GrowPec follows a modern hybrid architecture within a monolithic Laravel 12 application: a high-performance **Model-View-Controller (MVC)** public portal paired with a reactive **Filament v5 / Livewire v4** administrative control plane.

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
              Public Flow  │             │ Admin Flow (/admin)
                           ▼             ▼
       ┌────────────────────────┐   ┌────────────────────────┐
       │ Public Controllers     │   │ Filament v5 Panel      │
       │ (Home, College, Lead,  │   │ (AdminPanelProvider,   │
       │  Review, Leadership)   │   │  Livewire Components)  │
       └───────────┬────────────┘   └───────────┬────────────┘
                   │                            │
                   │ Blade Views                │ 12 Resources
                   │ (resources/views)          │ 3 Dashboard Widgets
                   │                            │ 1 Custom Settings Page
                   └─────────────┬──────────────┘
                                 │
                                 ▼
                     ┌───────────────────────┐
                     │    Eloquent Models    │
                     │  (29 Domain Entities) │
                     └───────────┬───────────┘
                                 │
                                 ▼
                     ┌───────────────────────┐
                     │   MySQL Persistence   │
                     └───────────────────────┘
```

## Route Segregation & Security Layers

1. **Authentication Layer (`routes/web.php:24-26`)**:
   - `GET /login` automatically redirects visitors to the administrative entry point at `/admin/login`.
   - `POST /logout` is protected by `web` and `auth` middleware.
   - Authentication is handled natively through Filament's session authenticator.

2. **Public Website Layer (`routes/web.php:33-84`)**:
   - Wrapped inside `web` and `CheckMaintenanceMode` middleware.
   - Evaluates system-wide maintenance status configured dynamically in `system_settings`.
   - Handles public homepage (`HomeController`), regular/online college listings and profile views (`CollegeController`), student reviews (`CollegeReviewController`), lead submissions (`LeadController`), static content (`LeadershipMessagePageController`), XML sitemaps, and cascading JSON lookup endpoints.

3. **Admin Panel Layer (`app/Providers/Filament/AdminPanelProvider.php`)**:
   - Registered at path `/admin` and protected by `web`, `auth`, and `AdminMiddleware`.
   - Fully reactive dashboard powered by Filament v5 and Livewire v4.
   - Provides comprehensive administrative interfaces without legacy custom Blade controllers:
     - **Colleges Resource:** Profile editing, SEO metadata, and 8 inline RelationManagers.
     - **Academic Taxonomies:** Streams, Courses, and Specializations resources.
     - **Geographic Data:** States and Cities management.
     - **CRM & Inquiries:** Leads resource with status tracking, notes, and activity timeline.
     - **Student Feedback:** College Reviews resource with moderation and approval toggles.
     - **Marketing & Content:** Banners, University Partners, Leadership Messages.
     - **System Configuration:** Dynamic single-page `ManageSettings` with tabbed controls for site identity, contact info, SEO, and maintenance mode.

## Domain Model & Data Relationships

### 1. The College Aggregate Root
The `College` model (`app/Models/College.php`) acts as the primary aggregate root for the education catalog. In Milestone v1.3, the schema was normalized to 11 streamlined relationships:
- `courses` (`CollegeCourse`): Academic degree programs, durations, eligibility, and fee breakdowns.
- `highlights` (`CollegeHighlight`): Key institutional USPs, rankings, and accreditation badges.
- `facilities` (`CollegeFacility`): Campus and digital learning infrastructure.
- `faqs` (`CollegeFaq`): Categorized frequently asked questions and official answers.
- `scholarships` (`CollegeScholarship`): Merit, defense, and need-based financial concessions.
- `admissionSections` (`CollegeAdmissionSection`): Step-by-step admissions guides and document checklists.
- `placementStats` (`CollegePlacementStat`): Annual placement statistics, average packages, and highest offers.
- `recruiters` (`CollegeRecruiter`): Corporate hiring partners and logos.
- `reviews` (`CollegeReview`): Moderated student/alumni ratings and reviews.
- `state` (`State`): Associated primary state.
- `city` (`City`): Associated primary city.

### 2. Academics Taxonomy
- `Stream`: Broad educational classification (e.g., Engineering, Management, Healthcare).
- `Course`: Specific degree programs (e.g., B.Tech, MBA, MCA) linked to a parent `Stream`.
- `Specialization`: Concentration tracks (e.g., Artificial Intelligence, Finance) linked to a `Course`.

### 3. Review Moderation & Dynamic Ratings Pipeline
- Visitors and students submit reviews via `POST /college/{slug}/reviews`.
- Protected by a hidden honeypot field (`website_url`) and IP throttling (`throttle:5,60`).
- Submitted reviews default to `is_approved = false` (pending status).
- Administrators review submissions via the Filament `CollegeReviews` resource or the dashboard's `PendingReviewsWidget`.
- Upon approval, `College` dynamically recalculates its average star rating and total approved review count.

### 4. Lead Capture & CRM Workflow
- Visitors submit inquiries via `POST /lead/submit` handled by `LeadController@store`.
- Creates a `Lead` record storing contact details, academic preferences, and UTM tags.
- Logs transitions and interactions in `LeadActivity` for administrative follow-ups.
- Admins manage lead lifecycle (`new`, `contacted`, `converted`, `rejected`) directly within Filament.

## View & Presentation Architecture
- **Public Portal:** Native Blade templates extending `resources/views/layouts/app.blade.php`, with multi-filter search views (`colleges/index.blade.php`), comprehensive profile views (`colleges/show.blade.php`), and shared modal components.
- **Admin Control Plane:** Native Filament v5 panel layout featuring dark mode support, responsive sidebar navigation, interactive modal drawers, and real-time dashboard analytics widgets.

