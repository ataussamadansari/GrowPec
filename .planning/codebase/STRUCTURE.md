# Directory Structure & File Map

**Analysis Date:** 2026-10-17

## Top-Level Repository Organization

```
d:\GrowPec\GrowPec\
├── app/                      # Core application code (Controllers, Models, Filament, Middleware)
│   ├── Filament/             # Filament v5 Administrative Control Plane
│   │   ├── Pages/            # Custom panel pages (ManageSettings.php)
│   │   ├── Resources/        # 12 Administrative Domain Resources & RelationManagers
│   │   │   ├── Colleges/     # CollegeResource with 8 inline RelationManagers
│   │   │   ├── CollegeReviews/ # Moderation & ratings review resource
│   │   │   ├── Streams/, Courses/, Specializations/ # Academic taxonomy
│   │   │   ├── States/, Cities/ # Geographic data resources
│   │   │   ├── Leads/        # CRM lead management & activity logs
│   │   │   └── Banners/, Partners/, LeadershipMessages/, CenterLogins/
│   │   └── Widgets/          # Dashboard widgets (StatsOverview, LatestLeads, PendingReviews)
│   ├── Http/
│   │   ├── Controllers/      # 7 Public Request Handlers
│   │   │   ├── AuthController.php
│   │   │   ├── CollegeController.php
│   │   │   ├── CollegeReviewController.php
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   ├── LeadController.php
│   │   │   └── LeadershipMessagePageController.php
│   │   └── Middleware/       # Application middleware
│   │       ├── AdminMiddleware.php
│   │       └── CheckMaintenanceMode.php
│   ├── Models/               # 29 Eloquent Domain Models
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── Filament/
│           └── AdminPanelProvider.php # Filament v5 Admin Panel Configuration
├── bootstrap/                # Application bootstrapping & container configuration
│   ├── app.php               # Laravel 12 configuration entry point
│   └── providers.php         # Application service providers
├── config/                   # Configuration files (app, auth, database, mail, etc.)
├── database/                 # Database migrations, seeders, factories
│   ├── factories/            # Model factories for testing and seeding
│   ├── migrations/           # 25 Schema migrations
│   └── seeders/              # 10 Data seeders (Taxonomy, Locations, 30 Colleges)
├── public/                   # Web root accessible via HTTP server
│   ├── css/, js/, images/    # Static assets
│   ├── index.php             # Laravel frontend controller entry point
│   └── storage               # Symlink to storage/app/public
├── resources/                # Uncompiled frontend assets & public Blade views
│   ├── css/                  # app.css (Tailwind/custom stylesheets)
│   ├── js/                   # app.js & bootstrap.js
│   └── views/                # Public Blade template hierarchy
│       ├── colleges/         # College listing (index) and details (show)
│       ├── errors/           # Custom error pages (404, 500)
│       ├── layouts/          # Base public layout (app.blade.php)
│       ├── pages/            # Static pages (about, contact)
│       └── sitemap.blade.php # XML sitemap template
├── routes/                   # Route definition files
│   ├── console.php           # Artisan command definitions
│   └── web.php               # Public website routes & admin redirects
├── storage/                  # Generated caches, logs, uploaded files
│   ├── app/public/           # Persistent public uploads (logos, brochures)
│   ├── framework/            # Sessions, views, cache
│   └── logs/                 # Laravel application logs
├── tests/                    # Pest & PHPUnit test suites (127 passing tests)
│   ├── Feature/              # 15 Feature test suites (Filament, Catalog, Reviews, Leads)
│   ├── Unit/                 # Unit tests
│   ├── Pest.php              # Global Pest configuration
│   └── TestCase.php          # Base test case class
├── .env                      # Local environment configuration
├── artisan                   # Command-line interface executable
├── composer.json             # PHP dependencies and script definitions
├── package.json              # Node dependencies and build scripts
└── vite.config.js            # Vite bundler configuration
```

## Key File Locations & Roles

| Path | Purpose |
|---|---|
| `app/Providers/Filament/AdminPanelProvider.php` | Main administrative panel provider defining colors, pages, widgets, middleware, and route prefix (`/admin`). |
| `app/Filament/Resources/Colleges/CollegeResource.php` | Full administrative CRUD for colleges, media uploads, SEO fields, and 8 inline child RelationManagers. |
| `app/Filament/Pages/ManageSettings.php` | Dynamic settings management page with tabbed form for brand identity, contact, social links, SEO, and maintenance mode. |
| `app/Http/Controllers/CollegeController.php` | Public regular & online college listings, multi-filter search, and profile page rendering. |
| `app/Http/Controllers/CollegeReviewController.php` | Handles public student/guest review submissions with honeypot validation and rate limiting. |
| `app/Http/Controllers/HomeController.php` | Manages landing page content, featured colleges, stats counters, and live search endpoint. |
| `app/Http/Controllers/LeadController.php` | Validates, stores, and logs incoming student admission inquiries. |
| `app/Models/College.php` | Eloquent model for colleges containing 11 normalized relationships and dynamic rating calculations. |
| `app/Models/CollegeReview.php` | Eloquent model for reviews with moderation scope, approval workflow, and rating sync triggers. |
| `app/Models/Lead.php` | Manages student lead persistence, academic preferences, and status flags. |
| `resources/views/layouts/app.blade.php` | Master Blade layout for public visitors (header, navigation, lead modal, footer, scripts). |
| `resources/views/colleges/index.blade.php` | Multi-filter college search page with stream, degree, state, and fee selectors. |
| `resources/views/colleges/show.blade.php` | Detailed college overview containing tabs for courses, fees, placements, scholarships, and reviews. |
| `database/seeders/DatabaseSeeder.php` | Master database seeder coordinating academic taxonomy, states, cities, and 30 authentic college catalogs. |
| `routes/web.php` | Public web routes, API endpoints, sitemap, and `/admin` redirect handlers. |

