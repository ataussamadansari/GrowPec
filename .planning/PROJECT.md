# Project: GrowPec Education Portal

**Current Milestone:** v1.2 — Filament Admin Panel v3 Migration  
**Updated:** 2026-10-11  
**Framework:** Laravel 12 on PHP 8.2+  
**Admin Tool:** Filament Admin Panel v3 (`filament/filament:"^3.2"`)  
**Database:** MySQL (growpec_db)  

---

## 1. Project Overview & Milestone v1.2 Context
GrowPec is an education portal empowering students across India to discover, compare, and enroll in top regular and distance/online colleges.

In **Milestone v1.2**, GrowPec is migrating its legacy custom Blade admin panel to **Filament Admin Panel v3**. The platform has grown to 33 Eloquent models, with `College` functioning as an 18-relation aggregate root, alongside Leads/CRM, Academics, Geography, and College Reviews. 

Migrating to Filament v3 provides:
- A standardized, reactive UI built on Livewire 3 and Tailwind CSS.
- First-class RelationManagers for managing complex child entities (CollegeCourses, Accreditations, Placement Stats, Documents, etc.).
- Integrated filtering, search, sorting, and bulk actions across all administrative data tables.
- Inline row actions (e.g. 1-click Approve/Reject buttons for student reviews).
- Role-based authorization via `FilamentUser` contracts and unified access control.
- An extensible dashboard with real-time metric widgets.

---

## 2. Milestone v1.2 Core Objectives
- **Filament Foundation & Auth:** Install Filament v3, configure `AdminPanelProvider` on path `/admin`, and enforce `FilamentUser` access policies based on user roles (`super_admin`, `sub_admin`).
- **Academic & Geographic Masters:** Implement Filament Resources for `State`, `City`, `Stream`, `Course`, and `Specialization` with schema validation, auto-slug, and reactive dropdown lookups.
- **Marketing, CRM & Review Moderation:** Implement `LeadResource` (with activity logs and status badges), `CollegeReviewResource` (with 1-click Approve/Reject table actions and status tabs), `BannerResource`, `PartnerResource`, `LeadershipMessageResource`, `CenterLoginResource`, and `MasterSettingResource`.
- **College Aggregate Root & Relation Managers:** Build `CollegeResource` with multi-tab layout and dedicated RelationManagers for courses & fees, accreditations, facilities, placement stats, FAQs, galleries, scholarships, and documents.
- **Dashboard & Legacy Cutover:** Provide overview stat widgets and safely deprecate/redirect legacy custom admin routes to Filament panel routes.

---

## 3. Technology Stack & Architecture
- **Backend:** Laravel 12, PHP 8.2+
- **Admin Panel:** Filament v3 (`filament/filament:"^3.2"`)
- **Database:** MySQL with Eloquent (33 domain models)
- **Frontend / Public:** Blade templates, Bootstrap 5.3.3
- **Testing:** Pest 3.8 / PHPUnit 11 with `RefreshDatabase`
- **Code Standards:** Laravel Pint (`vendor/bin/pint --format agent`)

---

## 4. Milestone History
- **v1.0 — Architecture Mapping & Foundational Setup:** Codebase mapping and architecture foundation.
- **v1.1 — Public Guest College Review System:** Unauthenticated visitor review submission, honeypot & throttling, public showcase, and moderation suite.
- **v1.2 — Filament Admin Panel v3 Migration (Active):** Complete replacement of custom Blade admin controllers with Filament v3 Resources, RelationManagers, and Dashboard widgets.
