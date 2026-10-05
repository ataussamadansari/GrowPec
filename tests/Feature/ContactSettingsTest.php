<?php

use App\Models\SystemSetting;
use App\Models\User;

test('guest cannot update admin contact settings', function () {
    $response = $this->post(route('admin.settings.update'), [
        'general' => [
            'support_phones' => [
                ['title' => 'Admission Helpline', 'number' => '+91 99999 11111'],
            ],
        ],
    ]);

    $response->assertRedirect(route('login'));
});

test('admin can save multiple phones, emails and office addresses', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);

    $response = $this->actingAs($admin)->from(route('admin.settings.index'))->post(route('admin.settings.update'), [
        'support_phones' => [
            ['title' => 'Admission Cell', 'number' => '+91 98765 43210'],
            ['title' => 'Toll Free Helpline', 'number' => '1800 123 4567'],
        ],
        'support_emails' => [
            ['title' => 'Admissions', 'email' => 'admissions@growpec.com'],
            ['title' => 'General Inquiries', 'email' => 'support@growpec.com'],
        ],
        'office_addresses' => [
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
        ],
        'general' => [
            'site_name' => 'GrowPec Education',
        ],
    ]);

    $response->assertRedirect(route('admin.settings.index'));

    // Check SystemSetting::getPhones()
    $phones = SystemSetting::getPhones();
    expect($phones)->toHaveCount(2)
        ->and($phones[0]['title'])->toBe('Admission Cell')
        ->and($phones[0]['number'])->toBe('+91 98765 43210')
        ->and($phones[1]['title'])->toBe('Toll Free Helpline')
        ->and($phones[1]['number'])->toBe('1800 123 4567');

    // Check SystemSetting::getEmails()
    $emails = SystemSetting::getEmails();
    expect($emails)->toHaveCount(2)
        ->and($emails[0]['title'])->toBe('Admissions')
        ->and($emails[0]['email'])->toBe('admissions@growpec.com')
        ->and($emails[1]['title'])->toBe('General Inquiries')
        ->and($emails[1]['email'])->toBe('support@growpec.com');

    // Check SystemSetting::getAddresses()
    $addresses = SystemSetting::getAddresses();
    expect($addresses)->toHaveCount(2)
        ->and($addresses[0]['title'])->toBe('Headquarters - Noida')
        ->and($addresses[0]['address'])->toContain('Noida')
        ->and($addresses[1]['title'])->toBe('Branch Office - Bangalore')
        ->and($addresses[1]['address'])->toContain('Bangalore');

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
