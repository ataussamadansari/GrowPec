<?php

use App\Models\User;

test('unauthenticated guest is redirected to login when accessing filament admin panel', function () {
    $response = $this->get('/admin');

    $response->assertRedirect('/admin/login');
});

test('student role user is forbidden from accessing filament admin panel', function () {
    $student = User::factory()->create([
        'role' => 'student',
    ]);

    $response = $this->actingAs($student)->get('/admin');

    $response->assertForbidden();
});

test('super admin can access filament admin panel dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'super_admin',
    ]);

    $response = $this->actingAs($admin)->get('/admin');

    $response->assertSuccessful();
    $response->assertSee('GrowPec Administration');
    $response->assertSee('Dashboard');
});

test('sub admin can access filament admin panel dashboard', function () {
    $subAdmin = User::factory()->create([
        'role' => 'sub_admin',
    ]);

    $response = $this->actingAs($subAdmin)->get('/admin');

    $response->assertSuccessful();
    $response->assertSee('GrowPec Administration');
    $response->assertSee('Dashboard');
});

test('filament login page renders successfully with brand title', function () {
    $response = $this->get('/admin/login');

    $response->assertSuccessful();
    $response->assertSee('GrowPec Administration');
});
