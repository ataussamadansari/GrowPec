<?php

use App\Models\CenterLogin;

test('center login can be created and persisted in database', function () {
    $login = CenterLogin::create([
        'title' => 'Bangalore Center Portal',
        'url' => 'https://bangalore.growpec.com/login',
        'index' => 1,
        'is_active' => true,
    ]);

    expect($login->exists)->toBeTrue();
    $this->assertDatabaseHas('center_logins', [
        'title' => 'Bangalore Center Portal',
        'url' => 'https://bangalore.growpec.com/login',
        'index' => 1,
        'is_active' => true,
    ]);
});

test('center login can be updated', function () {
    $login = CenterLogin::factory()->create([
        'title' => 'Old Title',
        'url' => 'https://old.com',
    ]);

    $login->update([
        'title' => 'Updated Title',
        'url' => 'https://updated.com/login',
        'index' => 5,
        'is_active' => true,
    ]);

    $this->assertDatabaseHas('center_logins', [
        'id' => $login->id,
        'title' => 'Updated Title',
        'url' => 'https://updated.com/login',
        'index' => 5,
    ]);
});

test('center login can be deleted', function () {
    $login = CenterLogin::factory()->create();

    $login->delete();

    $this->assertDatabaseMissing('center_logins', [
        'id' => $login->id,
    ]);
});

test('center login active scope filters and orders correctly', function () {
    CenterLogin::query()->delete();

    $second = CenterLogin::factory()->create(['is_active' => true, 'index' => 2]);
    $first = CenterLogin::factory()->create(['is_active' => true, 'index' => 1]);
    $inactive = CenterLogin::factory()->create(['is_active' => false, 'index' => 0]);

    $activeLogins = CenterLogin::active()->get();

    expect($activeLogins->pluck('id')->all())->toEqual([$first->id, $second->id]);
    expect($activeLogins->pluck('id')->contains($inactive->id))->toBeFalse();
});

test('center login caching and cache clearing work properly', function () {
    CenterLogin::clearCache();

    $login = CenterLogin::factory()->create(['is_active' => true, 'index' => 1]);
    $cached = CenterLogin::getAllCached();
    expect($cached->pluck('id')->contains($login->id))->toBeTrue();

    CenterLogin::clearCache();
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
