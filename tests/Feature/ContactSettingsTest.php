<?php

use App\Models\SystemSetting;

test('system setting model can store and retrieve structured contact details', function () {
    SystemSetting::clearCache();

    $phones = [
        ['title' => 'Admission Cell', 'number' => '+91 98765 43210'],
        ['title' => 'Toll Free Helpline', 'number' => '1800 123 4567'],
    ];
    $emails = [
        ['title' => 'Admissions', 'email' => 'admissions@growpec.com'],
        ['title' => 'General Inquiries', 'email' => 'support@growpec.com'],
    ];
    $addresses = [
        [
            'title' => 'Headquarters - Noida',
            'address' => 'Plot 10, Sector 62, Noida, Uttar Pradesh 201309',
            'map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1!2d77.3!3d28.6!2m3',
        ],
        [
            'title' => 'Branch Office - Bangalore',
            'address' => '4th Floor, MG Road, Bangalore, Karnataka 560001',
            'map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2!2d77.5!3d12.9!2m3',
        ],
    ];

    SystemSetting::set('general.support_phones', json_encode($phones));
    SystemSetting::set('general.support_emails', json_encode($emails));
    SystemSetting::set('general.office_addresses', json_encode($addresses));
    SystemSetting::set('general.support_phone', '+91 98765 43210');
    SystemSetting::set('general.support_email', 'admissions@growpec.com');
    SystemSetting::set('general.office_address', 'Plot 10, Sector 62, Noida, Uttar Pradesh 201309');

    // Check SystemSetting::getPhones()
    $storedPhones = SystemSetting::getPhones();
    expect($storedPhones)->toHaveCount(2)
        ->and($storedPhones[0]['title'])->toBe('Admission Cell')
        ->and($storedPhones[0]['number'])->toBe('+91 98765 43210')
        ->and($storedPhones[1]['title'])->toBe('Toll Free Helpline')
        ->and($storedPhones[1]['number'])->toBe('1800 123 4567');

    // Check SystemSetting::getEmails()
    $storedEmails = SystemSetting::getEmails();
    expect($storedEmails)->toHaveCount(2)
        ->and($storedEmails[0]['title'])->toBe('Admissions')
        ->and($storedEmails[0]['email'])->toBe('admissions@growpec.com')
        ->and($storedEmails[1]['title'])->toBe('General Inquiries')
        ->and($storedEmails[1]['email'])->toBe('support@growpec.com');

    // Check SystemSetting::getAddresses()
    $storedAddresses = SystemSetting::getAddresses();
    expect($storedAddresses)->toHaveCount(2)
        ->and($storedAddresses[0]['title'])->toBe('Headquarters - Noida')
        ->and($storedAddresses[0]['address'])->toContain('Noida')
        ->and($storedAddresses[1]['title'])->toBe('Branch Office - Bangalore')
        ->and($storedAddresses[1]['address'])->toContain('Bangalore');

    // Check backwards compatibility sync for single fields
    expect(SystemSetting::get('general.support_phone'))->toBe('+91 98765 43210')
        ->and(SystemSetting::get('general.support_email'))->toBe('admissions@growpec.com')
        ->and(SystemSetting::get('general.office_address'))->toContain('Noida');
});

test('contact us page displays multiple phones, emails, addresses and maps', function () {
    SystemSetting::clearCache();

    SystemSetting::set('general.support_phones', json_encode([
        ['title' => 'Counseling Desk', 'number' => '+91 91111 22222'],
        ['title' => 'Student Support', 'number' => '+91 93333 44444'],
    ]));

    SystemSetting::set('general.support_emails', json_encode([
        ['title' => 'Counseling', 'email' => 'counsel@growpec.com'],
        ['title' => 'Verification', 'email' => 'verify@growpec.com'],
    ]));

    SystemSetting::set('general.office_addresses', json_encode([
        [
            'title' => 'Corporate Office',
            'address' => 'Express Trade Tower, Sector 132, Noida',
            'map_url' => 'https://maps.google.com/embed1',
        ],
        [
            'title' => 'Regional Center',
            'address' => 'Indiranagar 100ft Road, Bengaluru',
            'map_url' => 'https://maps.google.com/embed2',
        ],
    ]));

    $response = $this->get(route('contact'));

    $response->assertStatus(200);

    // Phones
    $response->assertSee('Counseling Desk');
    $response->assertSee('+91 91111 22222');
    $response->assertSee('Student Support');
    $response->assertSee('+91 93333 44444');

    // Emails
    $response->assertSee('counsel@growpec.com');
    $response->assertSee('verify@growpec.com');

    // Addresses & Maps
    $response->assertSee('Corporate Office');
    $response->assertSee('Sector 132, Noida');
    $response->assertSee('Regional Center');
    $response->assertSee('Indiranagar 100ft Road, Bengaluru');
});

test('public website layout displays multiple contact details in header and footer', function () {
    SystemSetting::clearCache();

    SystemSetting::set('general.support_phones', json_encode([
        ['title' => 'Admission Line', 'number' => '+91 97777 88888'],
        ['title' => 'Toll Free', 'number' => '1800 890 0000'],
    ]));

    SystemSetting::set('general.support_emails', json_encode([
        ['title' => 'Help', 'email' => 'help@growpec.com'],
    ]));

    SystemSetting::set('general.office_addresses', json_encode([
        [
            'title' => 'Main Campus Office',
            'address' => 'Knowledge Park II, Greater Noida',
            'map_url' => '',
        ],
    ]));

    $response = $this->get(route('home'));

    $response->assertStatus(200);

    // Topbar & Header
    $response->assertSee('+91 97777 88888');
    $response->assertSee('1800 890 0000');
    $response->assertSee('Admission Line');

    // Footer
    $response->assertSee('help@growpec.com');
    $response->assertSee('Knowledge Park II, Greater Noida');
});
