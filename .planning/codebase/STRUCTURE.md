# Directory Structure & File Map

**Analysis Date:** 2026-10-10

## Top-Level Repository Organization

```
d:\GrowPec\GrowPec\
├── app/                      # Core application code (Controllers, Models, Middleware)
│   ├── Http/
│   │   ├── Controllers/      # Request handlers (Public & Admin)
│   │   │   ├── Admin/        # 12 Administrative CRUD Controllers
│   │   │   ├── AuthController.php
│   │   │   ├── CollegeController.php
│   │   │   ├── HomeController.php
│   │   │   ├── LeadController.php
│   │   │   ├── LeadershipMessagePageController.php
│   │   │   ├── StudentProfileController.php
│   │   │   └── v0_CollegeController.php  (legacy/prototype)
│   │   └── Middleware/       # Custom application middleware
│   │       ├── AdminMiddleware.php
│   │       └── CheckMaintenanceMode.php
│   └── Models/               # 33 Eloquent Models
├── bootstrap/                # Application bootstrapping & container configuration
│   ├── app.php               # Laravel 12 configuration entry point
│   └── providers.php         # Application service providers
├── config/                   # Configuration files (app, auth, database, mail, etc.)
├── database/                 # Database migrations, seeders, factories
│   ├── factories/            # Model factories for testing and seeding
│   ├── migrations/           # 25 Schema migrations
│   └── seeders/              # 10 Data seeders
├── public/                   # Web root accessible via HTTP server
│   ├── css/, js/, images/    # Static assets
│   ├── index.php             # Laravel frontend controller entry point
│   └── storage               # Symlink to storage/app/public
├── resources/                # Uncompiled frontend assets & views
│   ├── css/                  # app.css (Tailwind/custom stylesheets)
│   ├── js/                   # app.js & bootstrap.js
│   └── views/                # Blade template hierarchy
│       ├── admin/            # Admin dashboard and resource views
│       ├── auth/             # Login / authentication views
│       ├── colleges/         # College listing (index) and details (show)
│       ├── errors/           # Custom error pages (404, 500)
│       ├── layouts/          # Base layouts (app.blade.php)
│       ├── pages/            # Static pages (about, contact)
│       └── student/          # Student portal templates
├── routes/                   # Route definition files
│   ├── console.php           # Artisan command definitions
│   └── web.php               # Public and Admin web routes
├── storage/                  # Generated caches, logs, uploaded files
│   ├── app/public/           # Persistent public uploads
│   ├── framework/            # Sessions, views, cache
│   └── logs/                 # Laravel application logs
├── tests/                    # Pest & PHPUnit test suites
│   ├── Feature/              # Feature & HTTP integration tests
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
| `app/Http/Controllers/CollegeController.php` | Handles public regular & online college listings, search filters, and detail page views. |
| `app/Http/Controllers/HomeController.php` | Manages landing page content, featured colleges, stats counters, and live search. |
| `app/Http/Controllers/LeadController.php` | Validates, stores, and notifies incoming student leads. |
| `app/Http/Controllers/Admin/CollegeManagerController.php` | Administrative management for colleges, related courses, fees, and media. |
| `app/Models/College.php` | Eloquent model for colleges containing 18+ relationship definitions. |
| `app/Models/Lead.php` | Manages lead persistence, status flags, and inquiry tracking. |
| `resources/views/layouts/app.blade.php` | Master Blade layout for public visitors (header, search, navigation, lead modal, footer). |
| `resources/views/colleges/index.blade.php` | Multi-filter college search page with stream, degree, state, and fee selectors. |
| `resources/views/colleges/show.blade.php` | Detailed college overview containing tabs for courses, fees, placements, rankings, and reviews. |
| `database/seeders/DatabaseSeeder.php` | Master database seeder coordinating academic taxonomy, states, cities, and college catalogs. |
| `routes/web.php` | Complete route registry distinguishing public website vs. secured admin panel. |
