# Technology Stack

**Analysis Date:** 2026-10-10

## Overview
GrowPec is an education portal and admissions discovery web application providing comprehensive information on regular and distance/online colleges, courses, fee structures, and lead capture. It is built on modern PHP and the Laravel 12 framework.

## Core Runtime & Framework
- **Runtime:** PHP 8.2+ (`^8.2`)
- **Backend Framework:** Laravel 12 (`laravel/framework: ^12.0`)
- **Admin Panel Framework:** Filament v5 (`filament/filament: 5.0`) & Livewire v4 (`livewire/livewire: ^4.4`)
- **Architecture Style:** Monolithic Model-View-Controller (MVC) with Blade public templates and Filament v5 reactive admin dashboard
- **Application Structure:** Streamlined Laravel 12 structure with single configuration pipeline in `bootstrap/app.php` and declarative panel providers in `app/Providers/Filament/`

## Development & Ecosystem Tooling
- **Interactive Shell:** Laravel Tinker (`laravel/tinker: ^2.10.1`)
- **Developer Assistance:** Laravel Boost (`laravel/boost: ^2.2`)
- **Log Streaming:** Laravel Pail (`laravel/pail: ^1.2.2`)
- **Code Formatter:** Laravel Pint (`laravel/pint: ^1.24`)
- **Local Dev Environment:** Laravel Sail (`laravel/sail: ^1.41`)
- **CLI Concurrency:** `concurrently: ^9.0.1` (running server, queue worker, logs, and Vite simultaneously)

## Frontend & Asset Pipeline
- **Bundler:** Vite 7 (`vite: ^7.0.7`)
- **Vite Integration:** `laravel-vite-plugin: ^2.0.0`
- **CSS Frameworks:**
  - Tailwind CSS v4 (`tailwindcss: ^4.0.0`, `@tailwindcss/vite: ^4.0.0`) configured in `vite.config.js`
  - Bootstrap 5.3.3 & Bootstrap Icons loaded via CDN in public layout templates
- **HTTP Client:** Axios (`axios: ^1.11.0`)
- **Icons & Typography:** Bootstrap Icons, Inter & Google Fonts loaded via CDN

## Persistence & Storage
- **Database Engine:** MySQL / MariaDB (production/local via PDO)
- **ORM:** Laravel Eloquent ORM
- **Migration Engine:** Laravel Schema Builder (25 active migrations)
- **Local Filesystem Disk:** Public disk (`storage/app/public`) symlinked to `public/storage` for uploads (college logos, banners, brochures, leadership portraits)

## Testing Framework
- **Test Framework:** Pest 3.8 (`pestphp/pest: ^3.8`, `pestphp/pest-plugin-laravel: ^3.2`)
- **Underlying Engine:** PHPUnit 11 (`phpunit/phpunit: ^11.5`)
- **Mocking:** Mockery (`mockery/mockery: ^1.6`)
- **Data Generation:** FakerPHP (`fakerphp/faker: ^1.23`)
