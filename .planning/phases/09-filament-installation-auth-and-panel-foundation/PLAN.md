# Phase 9 Plan: Filament Installation, Auth & Panel Foundation

**Phase:** 9  
**Milestone:** v1.2 — Filament Admin Panel v3 Migration  
**Goal:** Install Filament v3 into Laravel 12, configure `AdminPanelProvider` on path `/admin` with GrowPec branding, implement `FilamentUser` access control on `User`, and verify authentication security with automated Pest tests.  
**Status:** Ready to Execute  

---

## 1. Context & Architecture

### Existing State:
- Admin routes are managed by custom Blade controllers under `routes/web.php` lines 108–158 guarded by `['web', 'auth', AdminMiddleware::class]`.
- User model has an `enum('role', ['super_admin', 'sub_admin', 'student'])` column.
- Filament is not yet installed in `composer.json`.

### Planned State:
- Dependency `filament/filament:"^3.2"` installed via Composer.
- `app/Providers/Filament/AdminPanelProvider.php` created and registered in `bootstrap/providers.php`.
- Panel configured with:
  - Panel ID: `'admin'`
  - Path: `'admin'`
  - Brand Name: `'GrowPec Administration'`
  - Primary colors: Custom theme / brand hex colors (`#002B67`, `#008A43`, `#D9A400`).
  - Native Filament login page enabled (`->login()`).
- `App\Models\User` implements `Filament\Models\Contracts\FilamentUser` with `canAccessPanel(Panel $panel): bool` restricting access to `'super_admin'` and `'sub_admin'`.
- Route alignment ensured: named route `'login'` cleanly maps so unauthenticated requests and existing feature tests redirect seamlessly without collisions.
- Automated Pest feature test suite `tests/Feature/FilamentAdminAuthTest.php` verifying authorization gates.

---

## 2. Tasks & Execution Steps

### Task 9.1: Install Filament v3 Dependency
- **Command:** `composer require filament/filament:"^3.2" -W --no-interaction`
- **Actions:**
  1. Run Composer require with `-W` to update dependencies safely.
  2. Verify package installation with `composer show filament/filament`.

### Task 9.2: Install Filament Panel Provider
- **Command:** `php artisan filament:install --panels --no-interaction`
- **Actions:**
  1. Run artisan command to scaffold `AdminPanelProvider`.
  2. Verify that `app/Providers/Filament/AdminPanelProvider.php` exists.
  3. Ensure `bootstrap/providers.php` registers `App\Providers\Filament\AdminPanelProvider::class`.

### Task 9.3: Configure `AdminPanelProvider` & Brand System
- **Artifact:** `app/Providers/Filament/AdminPanelProvider.php`
- **Actions:**
  1. Configure branding:
     - `->brandName('GrowPec Administration')`
     - Custom brand colors via `Filament\Support\Colors\Color`:
       - `primary` => `#002B67` (GrowPec Navy) or `Color::Indigo`
       - `success` => `#008A43` (GrowPec Emerald)
       - `warning` => `#D9A400` (GrowPec Gold)
  2. Configure discovery paths:
     - Resources in `app/Filament/Resources`
     - Pages in `app/Filament/Pages`
     - Widgets in `app/Filament/Widgets`
  3. Organize default navigation groups:
     - `'Academics & Geography'`
     - `'College Management'`
     - `'Leads & Reviews'`
     - `'Marketing & Settings'`
  4. Ensure route coexistence in `routes/web.php` so `route('login')` seamlessly aligns with `filament.admin.auth.login`.

### Task 9.4: Implement `FilamentUser` on `User` Model
- **Artifact:** [app/Models/User.php](file:///d:/GrowPec/GrowPec/app/Models/User.php)
- **Actions:**
  1. Import `Filament\Models\Contracts\FilamentUser` and `Filament\Panel`.
  2. Add `implements FilamentUser` to class definition.
  3. Implement `canAccessPanel(Panel $panel): bool`:
     ```php
     public function canAccessPanel(Panel $panel): bool
     {
         return in_array($this->role, ['super_admin', 'sub_admin']);
     }
     ```

### Task 9.5: Author Pest Automated Authentication Tests
- **Artifact:** `tests/Feature/FilamentAdminAuthTest.php`
- **Actions:**
  1. Test unauthenticated guest redirect when accessing `/admin`.
  2. Test student role user rejection (403 Forbidden) when accessing `/admin`.
  3. Test super admin access (200 OK) when visiting `/admin`.
  4. Test sub admin access (200 OK) when visiting `/admin`.
  5. Test Filament login page renders correctly.
  6. Execute tests: `php artisan test --filter=FilamentAdminAuthTest`.
  7. Run complete test suite: `php artisan test --compact` to guarantee zero regressions.
  8. Format code using Laravel Pint: `vendor/bin/pint --dirty --format agent`.

---

## 3. Verification & Acceptance Criteria
- [ ] Filament v3.2+ installed in `composer.json` and `composer.lock`.
- [ ] `AdminPanelProvider` registered in `bootstrap/providers.php`.
- [ ] `/admin` loads the Filament panel with GrowPec branding and navigation structure.
- [ ] `User` model implements `FilamentUser` and enforces `canAccessPanel()`.
- [ ] Unauthenticated guests are redirected to login.
- [ ] Students are blocked with 403 Forbidden.
- [ ] Super Admins and Sub Admins have full access.
- [ ] All new Pest tests pass (100% green).
- [ ] Existing 42 tests continue to pass without regressions.
- [ ] Clean Pint formatting (`vendor/bin/pint --dirty --format agent`).
