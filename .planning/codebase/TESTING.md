# Testing Strategy & Guidelines

**Analysis Date:** 2026-10-10

## Framework & Tooling
- **Test Framework:** Pest 3.8 (`pestphp/pest: ^3.8`) with `pestphp/pest-plugin-laravel: ^3.2`
- **Underlying Runner:** PHPUnit 11 (`phpunit/phpunit: ^11.5`)
- **Assertions & Mocks:** Pest built-in expectations, PHPUnit assertions, Mockery (`mockery/mockery: ^1.6`), FakerPHP (`fakerphp/faker: ^1.23`)

## Test Organization

```
tests/
├── Feature/                    # Integration & HTTP endpoint tests
│   ├── CenterLoginTest.php     # Feature tests for partner center portal logins
│   ├── ContactSettingsTest.php # Tests for system settings and contact configuration
│   ├── ExampleTest.php         # Basic smoke test
│   └── NotFoundPageTest.php    # Tests 404 response handling and view rendering
├── Unit/                       # Isolated class and helper unit tests
│   └── ExampleTest.php         # Basic PHPUnit unit test
├── Pest.php                    # Global Pest configuration, custom expectations, helpers
└── TestCase.php                # Base test case extending Orchestra/Laravel TestCase
```

## Database Handling in Tests
- **Refresh Database:** Configured in `tests/Pest.php` across all Feature tests:
  ```php
  pest()->extend(TestCase::class)
      ->use(RefreshDatabase::class)
      ->in('Feature');
  ```
- **Execution:** Feature tests execute migrations on test databases to ensure isolation between test runs.

## Running Tests
Run tests using Artisan or the Pest binary directly:

```bash
# Run the complete test suite
php artisan test --compact

# Run a specific test file
vendor/bin/pest tests/Feature/ContactSettingsTest.php

# Filter tests by name
php artisan test --filter=CenterLoginTest
```

## Best Practices & Patterns
1. **Pest Syntax:** Prefer Pest's functional test format:
   ```php
   test('guests cannot access admin panel', function () {
       $response = $this->get('/admin/dashboard');
       $response->assertRedirect('/admin/login');
   });
   ```
2. **Factories Over Manual Seeding:** Use model factories (`database/factories/`) when setting up mock records for tests to maintain resilience against schema modifications.
3. **HTTP Status Assertions:** Verify HTTP responses explicitly (`assertOk()`, `assertRedirect()`, `assertNotFound()`, `assertSessionHasErrors()`).
4. **Authentication Testing:** Use `$this->actingAs($user)` to simulate logged-in states for admin route verification.
