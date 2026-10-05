<?php

use App\Models\CenterLogin;
use App\Models\User;

test('guest cannot access admin center logins', function () {
    $response = $this->get(route('admin.center-logins.index'));

    $response->assertRedirect(route('login'));
});

test('admin can access center logins index page', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);

    $response = $this->actingAs($admin)->get(route('admin.center-logins.index'));

    $response->assertStatus(200);
    $response->assertSee('Center Logins Manager');
});

test('admin can create a center login', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);

    $response = $this->actingAs($admin)->post(route('admin.center-logins.store'), [
        'title' => 'Bangalore Center Portal',
        'url' => 'https://bangalore.growpec.com/login',
        'index' => 1,
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('admin.center-logins.index'));
    $this->assertDatabaseHas('center_logins', [
        'title' => 'Bangalore Center Portal',
        'url' => 'https://bangalore.growpec.com/login',
        'index' => 1,
        'is_active' => true,
    ]);
});

test('admin can update a center login', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $login = CenterLogin::factory()->create([
        'title' => 'Old Title',
        'url' => 'https://old.com',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.center-logins.update', $login), [
        'title' => 'Updated Title',
        'url' => 'https://updated.com/login',
        'index' => 5,
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('admin.center-logins.index'));
    $this->assertDatabaseHas('center_logins', [
        'id' => $login->id,
        'title' => 'Updated Title',
        'url' => 'https://updated.com/login',
        'index' => 5,
    ]);
});

test('admin can delete a center login', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $login = CenterLogin::factory()->create();

    $response = $this->actingAs($admin)->delete(route('admin.center-logins.destroy', $login));

    $response->assertRedirect();
    $this->assertDatabaseMissing('center_logins', [
        'id' => $login->id,
    ]);
});

test('admin can toggle active status of center login', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $login = CenterLogin::factory()->create(['is_active' => true]);

    $this->actingAs($admin)->post(route('admin.center-logins.toggleStatus', $login));
    expect($login->fresh()->is_active)->toBeFalse();

    $this->actingAs($admin)->post(route('admin.center-logins.toggleStatus', $login));
    expect($login->fresh()->is_active)->toBeTrue();
});

test('active center login is displayed on website header and footer', function () {
    CenterLogin::clearCache();

    $login = CenterLogin::factory()->create([
        'title' => 'Exclusive Center Login',
        'url' => 'https://exclusive.growpec.com/portal',
        'is_active' => true,
        'index' => 0,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Exclusive Center Login');
    $response->assertSee('https://exclusive.growpec.com/portal');
});

test('inactive center login is hidden from website header and footer', function () {
    CenterLogin::clearCache();

    $login = CenterLogin::factory()->create([
        'title' => 'Hidden Center Login',
        'url' => 'https://hidden.growpec.com/portal',
        'is_active' => false,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertDontSee('Hidden Center Login');
});

test('website header contains Enquiry Now button opening counseling modal', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Enquiry Now');
    $response->assertSee('#counselingModal');
    $response->assertDontSee('Call Now');
});

test('center login dropdown displays multiple centers like IIMT and Amity in header and footer', function () {
    CenterLogin::clearCache();

    CenterLogin::factory()->create([
        'title' => 'IIMT',
        'url' => 'https://admissions.onlineiimtu.in/',
        'is_active' => true,
        'index' => 0,
    ]);

    CenterLogin::factory()->create([
        'title' => 'Amity University Online',
        'url' => 'https://amityonline.com/',
        'is_active' => true,
        'index' => 1,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Center Login');
    $response->assertSee('IIMT');
    $response->assertSee('https://admissions.onlineiimtu.in/');
    $response->assertSee('Amity University Online');
    $response->assertSee('https://amityonline.com/');
});
