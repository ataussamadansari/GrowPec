<?php

test('visiting /404 returns 404 status and renders custom 404 page', function () {
    $response = $this->get('/404');

    $response->assertStatus(404);
    $response->assertSee('404');
    $response->assertSee("Oops! We Couldn't Find That College or Page", false);
    $response->assertSee('Regular Colleges');
    $response->assertSee('Online Universities');
    $response->assertSee('Free Counseling');
    $response->assertSee('Search Colleges');
});

test('visiting any non existent route returns custom 404 page', function () {
    $response = $this->get('/some-random-page-that-does-not-exist');

    $response->assertStatus(404);
    $response->assertSee('404');
    $response->assertSee("Oops! We Couldn't Find That College or Page", false);
    $response->assertSee('Search Colleges');
});

test('visiting invalid college slug triggers custom 404 page', function () {
    $response = $this->get('/college/completely-invalid-slug-9999');

    $response->assertStatus(404);
    $response->assertSee('404');
    $response->assertSee("Oops! We Couldn't Find That College or Page", false);
});
