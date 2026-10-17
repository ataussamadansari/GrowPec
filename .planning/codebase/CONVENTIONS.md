# Code Conventions & Patterns

**Analysis Date:** 2026-10-10

## Overview
GrowPec adheres to official modern Laravel 12 development conventions and PSR standards, formatted uniformly through Laravel Pint.

## PHP & Laravel Guidelines

### 1. Language Standards & Types
- **PHP Version:** PHP 8.2+.
- **Control Structures:** Strict curly braces used for all control flow structures (`if`, `for`, `foreach`, `while`), even single-line blocks.
- **Return Types & Type Hinting:** Explicit return types (`void`, `bool`, `View`, `RedirectResponse`, `JsonResponse`) and typed method parameters are used across controllers and services.
- **Constructor Property Promotion:** Preferred for services, action classes, and dependency injection:
  ```php
  public function __construct(public CollegeService $collegeService) {}
  ```
- **PHPDoc & Comments:** Descriptive PHPDocs used on methods and classes; inline comments are reserved for complex business logic.

### 2. Eloquent Models
- **Table & Key Conventions:** Standard plural snake_case table names (e.g., `colleges`, `college_courses`) and auto-incrementing integer IDs or UUIDs.
- **Guarded vs Fillable:** Protected mass-assignment using `$guarded = []` or explicit `$fillable` arrays.
- **Casting:** Modern Laravel `casts()` method preferred over legacy `$casts` array property:
  ```php
  protected function casts(): array
  {
      return [
          'status' => 'boolean',
          'established_year' => 'integer',
      ];
  }
  ```
- **Relationships:** Return types explicitly specified on relationship methods:
  ```php
  public function courses(): HasMany
  {
      return $this->hasMany(CollegeCourse::class);
  }
  ```

### 3. Routing & Controllers
- **Resourceful Routing:** Resource naming adheres to standard Laravel conventions: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`.
- **Named Routes:** Named routes preferred everywhere (`colleges.regular`, `college.show`, `college.reviews.store`, `lead.submit`).
- **Route URL Generation:** Always generated via `route('name', $params)` helper rather than hardcoded URLs.
- **Admin Control Plane:** Back-office administrative functionality is strictly managed through Filament Resources (`App\Filament\Resources\*`) and Pages (`App\Filament\Pages\*`), while public web routes are handled by dedicated controllers in `App\Http\Controllers`.

### 4. Blade View Conventions
- **Layout Inheritance:** Public portal views extend the master layout `@extends('layouts.app')`.
- **Admin Panel UI:** Administrative views are generated dynamically through Filament v5 forms, tables, and widget components.
- **Section & Stacks:** Standard content injection using `@yield('content')` or `@section('content')`, with `@push('styles')` and `@push('scripts')` for page-specific assets.
- **HTML Escaping:** Standard Blade `{{ $variable }}` escaping used for user-generated or dynamic data to prevent XSS. Raw output `{!! $html !!}` strictly limited to sanitized HTML snippets.

### 5. Code Formatting & Linting
- **Pint Formatter:** Formatted using Laravel Pint (`vendor/bin/pint --format agent`).
- **Git Commits:** Conventional commit message syntax (`feat:`, `fix:`, `docs:`, `refactor:`, `test:`).
