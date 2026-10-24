<?php

namespace App\Filament\Pages;

use App\Models\SystemSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ManageSettings extends Page
{
    protected string $view = 'filament.pages.manage-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|UnitEnum|null $navigationGroup = 'Marketing & Settings';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'System Settings';

    protected static ?string $title = 'System & Marketing Settings';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $settings = SystemSetting::getAllCached();

        // 1. Decode multi-phone list
        $phones = [];
        if (! empty($settings['general.support_phones'])) {
            $decoded = json_decode($settings['general.support_phones'], true);
            if (is_array($decoded)) {
                $phones = $decoded;
            }
        }
        if (empty($phones) && ! empty($settings['general.support_phone'])) {
            $phones = [
                ['title' => 'Helpline', 'number' => $settings['general.support_phone']],
            ];
            if (! empty($settings['general.support_phone_secondary'])) {
                $phones[] = ['title' => 'Admission Desk', 'number' => $settings['general.support_phone_secondary']];
            }
        }

        // 2. Decode multi-email list
        $emails = [];
        if (! empty($settings['general.support_emails'])) {
            $decoded = json_decode($settings['general.support_emails'], true);
            if (is_array($decoded)) {
                $emails = $decoded;
            }
        }
        if (empty($emails) && ! empty($settings['general.support_email'])) {
            $emails = [
                ['title' => 'Support Email', 'email' => $settings['general.support_email']],
            ];
        }

        // 3. Decode multi-address list
        $addresses = [];
        if (! empty($settings['general.office_addresses'])) {
            $decoded = json_decode($settings['general.office_addresses'], true);
            if (is_array($decoded)) {
                $addresses = $decoded;
            }
        }
        if (empty($addresses) && ! empty($settings['general.office_address'])) {
            $addresses = [
                [
                    'title' => 'Head Office',
                    'address' => $settings['general.office_address'],
                    'map_url' => $settings['general.map_embed_url'] ?? '',
                ],
            ];
        }

        $this->form->fill([
            // General & Brand
            'general_site_name' => $settings['general.site_name'] ?? 'GrowPec',
            'general_tagline' => $settings['general.tagline'] ?? '',
            'general_office_address' => $settings['general.office_address'] ?? '',
            'general_map_embed_url' => $settings['general.map_embed_url'] ?? '',
            'general_office_addresses' => $addresses,

            // Support & Helplines
            'general_support_phone' => $settings['general.support_phone'] ?? '',
            'general_support_phone_secondary' => $settings['general.support_phone_secondary'] ?? '',
            'general_support_email' => $settings['general.support_email'] ?? '',
            'general_whatsapp_number' => $settings['general.whatsapp_number'] ?? '',
            'general_support_phones' => $phones,
            'general_support_emails' => $emails,

            // Feature Toggles & System Controls
            'features_enable_floating_whatsapp' => (bool) ($settings['features.enable_floating_whatsapp'] ?? true),
            'features_enable_lead_email_alert' => (bool) ($settings['features.enable_lead_email_alert'] ?? false),
            'features_enable_comparison_dock' => (bool) ($settings['features.enable_comparison_dock'] ?? true),
            'features_enable_online_colleges' => (bool) ($settings['features.enable_online_colleges'] ?? true),
            'features_enable_partner_strip' => (bool) ($settings['features.enable_partner_strip'] ?? true),
            'features_maintenance_mode' => (bool) ($settings['features.maintenance_mode'] ?? false),

            // Social Profiles
            'social_facebook' => $settings['social.facebook'] ?? '',
            'social_instagram' => $settings['social.instagram'] ?? '',
            'social_linkedin' => $settings['social.linkedin'] ?? '',
            'social_twitter' => $settings['social.twitter'] ?? '',
            'social_youtube' => $settings['social.youtube'] ?? '',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make('SettingsTabs')
                    ->tabs([
                        Tab::make('General & Branding')
                            ->icon(Heroicon::OutlinedBuildingOffice)
                            ->components([
                                Section::make('Brand & Identity')
                                    ->description('Basic branding and primary platform metadata.')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('general_site_name')
                                            ->label('Platform / Brand Name')
                                            ->required()
                                            ->maxLength(100),
                                        TextInput::make('general_tagline')
                                            ->label('Tagline / Slogan')
                                            ->maxLength(180)
                                            ->placeholder('e.g. Empowering Education & Growth'),
                                    ]),

                                Section::make('Office Locations & Addresses')
                                    ->description('Manage head office and branch/regional office locations.')
                                    ->components([
                                        TextInput::make('general_office_address')
                                            ->label('Primary Head Office Address')
                                            ->maxLength(500)
                                            ->placeholder('e.g. Plot 10, Sector 62, Noida, Uttar Pradesh 201309'),
                                        TextInput::make('general_map_embed_url')
                                            ->label('Google Maps Embed URL / Iframe src')
                                            ->maxLength(1000)
                                            ->placeholder('https://www.google.com/maps/embed?...')
                                            ->helperText('Direct embed URL or iframe src from Google Maps.'),
                                        Repeater::make('general_office_addresses')
                                            ->label('Additional Office Locations & Regional Centers')
                                            ->addActionLabel('Add Office Location')
                                            ->collapsible()
                                            ->defaultItems(0)
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Location Name / Branch Title')
                                                    ->placeholder('e.g. Bangalore Regional Office')
                                                    ->required()
                                                    ->columnSpan(1),
                                                TextInput::make('map_url')
                                                    ->label('Google Maps Embed URL')
                                                    ->placeholder('https://www.google.com/maps/embed?...')
                                                    ->columnSpan(1),
                                                Textarea::make('address')
                                                    ->label('Full Postal Address')
                                                    ->placeholder('Street, building, city, state, pin code')
                                                    ->required()
                                                    ->rows(2)
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        Tab::make('Support & Helplines')
                            ->icon(Heroicon::OutlinedPhone)
                            ->components([
                                Section::make('Direct Communications')
                                    ->description('Quick contact numbers displayed in headers, footers, and contact cards.')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('general_support_phone')
                                            ->label('Primary Helpline Phone')
                                            ->tel()
                                            ->maxLength(30)
                                            ->placeholder('+91 98765 43210'),
                                        TextInput::make('general_support_phone_secondary')
                                            ->label('Secondary / Admission Helpline Phone')
                                            ->tel()
                                            ->maxLength(30)
                                            ->placeholder('+91 98765 43211'),
                                        TextInput::make('general_support_email')
                                            ->label('Official Support Email')
                                            ->email()
                                            ->maxLength(100)
                                            ->placeholder('support@growpec.com'),
                                        TextInput::make('general_whatsapp_number')
                                            ->label('WhatsApp Support Number')
                                            ->maxLength(30)
                                            ->placeholder('919876543210')
                                            ->helperText('Include country code without + or spaces (e.g. 919876543210).'),
                                    ]),

                                Section::make('Multiple Helplines & Department Directory')
                                    ->description('Configure multiple categorized helpline numbers and emails.')
                                    ->components([
                                        Repeater::make('general_support_phones')
                                            ->label('Multiple Support & Admission Helplines')
                                            ->addActionLabel('Add Helpline')
                                            ->collapsible()
                                            ->defaultItems(0)
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Department / Helpline Label')
                                                    ->placeholder('e.g. Counseling Desk, Toll Free')
                                                    ->required(),
                                                TextInput::make('number')
                                                    ->label('Contact Number')
                                                    ->tel()
                                                    ->placeholder('+91 98765 43210')
                                                    ->required(),
                                            ])
                                            ->columns(2),

                                        Repeater::make('general_support_emails')
                                            ->label('Multiple Support & Departmental Emails')
                                            ->addActionLabel('Add Email')
                                            ->collapsible()
                                            ->defaultItems(0)
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Department Label')
                                                    ->placeholder('e.g. Admissions, Verification')
                                                    ->required(),
                                                TextInput::make('email')
                                                    ->label('Email Address')
                                                    ->email()
                                                    ->placeholder('admissions@growpec.com')
                                                    ->required(),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        Tab::make('Feature Controls')
                            ->icon(Heroicon::OutlinedSparkles)
                            ->components([
                                Section::make('Website Features & Automation')
                                    ->description('Enable or disable major features and automated actions across the platform.')
                                    ->columns(2)
                                    ->components([
                                        Toggle::make('features_enable_floating_whatsapp')
                                            ->label('Floating WhatsApp Quick CTA')
                                            ->helperText('Displays the bottom floating WhatsApp chat button for instant counselor guidance.')
                                            ->default(true),
                                        Toggle::make('features_enable_lead_email_alert')
                                            ->label('Lead Instant Email Alerts')
                                            ->helperText('Dispatches automated email notifications whenever a student enquiry or lead is submitted.')
                                            ->default(false),
                                        Toggle::make('features_enable_comparison_dock')
                                            ->label('Floating College Comparison Dock')
                                            ->helperText('Enables the interactive comparison tray allowing students to select and compare colleges side-by-side.')
                                            ->default(true),
                                        Toggle::make('features_enable_online_colleges')
                                            ->label('Online / Distance Colleges Section')
                                            ->helperText('Displays online degree navigation links and filter options in public listings.')
                                            ->default(true),
                                        Toggle::make('features_enable_partner_strip')
                                            ->label('Partner Institutions Strip')
                                            ->helperText('Displays approved partner university logos across public pages.')
                                            ->default(true),
                                        Toggle::make('features_maintenance_mode')
                                            ->label('Website Maintenance Mode')
                                            ->helperText('Restricts public access with a maintenance screen while keeping admin panel accessible.')
                                            ->default(false),
                                    ]),
                            ]),

                        Tab::make('Social Networks')
                            ->icon(Heroicon::OutlinedShare)
                            ->components([
                                Section::make('Social Profiles')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('social_facebook')
                                            ->label('Facebook Page URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->placeholder('https://facebook.com/growpec'),
                                        TextInput::make('social_instagram')
                                            ->label('Instagram Profile URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->placeholder('https://instagram.com/growpec'),
                                        TextInput::make('social_linkedin')
                                            ->label('LinkedIn Profile URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->placeholder('https://linkedin.com/company/growpec'),
                                        TextInput::make('social_twitter')
                                            ->label('Twitter / X Profile URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->placeholder('https://x.com/growpec'),
                                        TextInput::make('social_youtube')
                                            ->label('YouTube Channel URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->placeholder('https://youtube.com/@growpec')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make([
                    Action::make('save')
                        ->label('Save All Settings')
                        ->icon(Heroicon::OutlinedCheck)
                        ->submit('save')
                        ->keyBindings(['mod+s']),
                ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        // 1. Process Multi-Phone & Single Phone
        $rawPhones = $state['general_support_phones'] ?? [];
        $cleanPhones = [];
        if (is_array($rawPhones)) {
            foreach ($rawPhones as $p) {
                $num = trim($p['number'] ?? '');
                if ($num !== '') {
                    $cleanPhones[] = [
                        'title' => trim($p['title'] ?? 'Helpline') ?: 'Helpline',
                        'number' => $num,
                    ];
                }
            }
        }

        $primaryPhone = trim($state['general_support_phone'] ?? '');
        $secondaryPhone = trim($state['general_support_phone_secondary'] ?? '');

        if (empty($cleanPhones) && $primaryPhone !== '') {
            $cleanPhones[] = ['title' => 'Helpline', 'number' => $primaryPhone];
            if ($secondaryPhone !== '') {
                $cleanPhones[] = ['title' => 'Admission Desk', 'number' => $secondaryPhone];
            }
        } elseif (! empty($cleanPhones)) {
            $primaryPhone = $cleanPhones[0]['number'];
            if (isset($cleanPhones[1])) {
                $secondaryPhone = $cleanPhones[1]['number'];
            }
        }

        // 2. Process Multi-Email & Single Email
        $rawEmails = $state['general_support_emails'] ?? [];
        $cleanEmails = [];
        if (is_array($rawEmails)) {
            foreach ($rawEmails as $e) {
                $em = trim($e['email'] ?? '');
                if ($em !== '') {
                    $cleanEmails[] = [
                        'title' => trim($e['title'] ?? 'Support Email') ?: 'Support Email',
                        'email' => $em,
                    ];
                }
            }
        }

        $primaryEmail = trim($state['general_support_email'] ?? '');
        if (empty($cleanEmails) && $primaryEmail !== '') {
            $cleanEmails[] = ['title' => 'Support Email', 'email' => $primaryEmail];
        } elseif (! empty($cleanEmails)) {
            $primaryEmail = $cleanEmails[0]['email'];
        }

        // 3. Process Multi-Address & Single Address
        $rawAddresses = $state['general_office_addresses'] ?? [];
        $cleanAddresses = [];
        if (is_array($rawAddresses)) {
            foreach ($rawAddresses as $a) {
                $addr = trim($a['address'] ?? '');
                if ($addr !== '') {
                    $cleanAddresses[] = [
                        'title' => trim($a['title'] ?? 'Office Location') ?: 'Office Location',
                        'address' => $addr,
                        'map_url' => trim($a['map_url'] ?? ''),
                    ];
                }
            }
        }

        $primaryAddress = trim($state['general_office_address'] ?? '');
        $primaryMapUrl = trim($state['general_map_embed_url'] ?? '');
        if (empty($cleanAddresses) && $primaryAddress !== '') {
            $cleanAddresses[] = [
                'title' => 'Head Office',
                'address' => $primaryAddress,
                'map_url' => $primaryMapUrl,
            ];
        } elseif (! empty($cleanAddresses)) {
            $primaryAddress = $cleanAddresses[0]['address'];
            $primaryMapUrl = ! empty($cleanAddresses[0]['map_url']) ? $cleanAddresses[0]['map_url'] : $primaryMapUrl;
        }

        // Persist General & Brand
        SystemSetting::set('general.site_name', (string) ($state['general_site_name'] ?? 'GrowPec'), 'general', 'string');
        SystemSetting::set('general.tagline', (string) ($state['general_tagline'] ?? ''), 'general', 'string');
        SystemSetting::set('general.office_address', $primaryAddress, 'general', 'text');
        SystemSetting::set('general.map_embed_url', $primaryMapUrl, 'general', 'string');
        SystemSetting::set('general.office_addresses', json_encode($cleanAddresses), 'general', 'json');

        // Persist Support & Helplines
        SystemSetting::set('general.support_phone', $primaryPhone, 'general', 'string');
        SystemSetting::set('general.support_phone_secondary', $secondaryPhone, 'general', 'string');
        SystemSetting::set('general.support_phones', json_encode($cleanPhones), 'general', 'json');
        SystemSetting::set('general.support_email', $primaryEmail, 'general', 'string');
        SystemSetting::set('general.support_emails', json_encode($cleanEmails), 'general', 'json');
        SystemSetting::set('general.whatsapp_number', (string) ($state['general_whatsapp_number'] ?? ''), 'general', 'string');

        // Persist Features
        SystemSetting::set('features.enable_floating_whatsapp', ! empty($state['features_enable_floating_whatsapp']) ? '1' : '0', 'features', 'boolean');
        SystemSetting::set('features.enable_lead_email_alert', ! empty($state['features_enable_lead_email_alert']) ? '1' : '0', 'features', 'boolean');
        SystemSetting::set('features.enable_comparison_dock', ! empty($state['features_enable_comparison_dock']) ? '1' : '0', 'features', 'boolean');
        SystemSetting::set('features.enable_online_colleges', ! empty($state['features_enable_online_colleges']) ? '1' : '0', 'features', 'boolean');
        SystemSetting::set('features.enable_partner_strip', ! empty($state['features_enable_partner_strip']) ? '1' : '0', 'features', 'boolean');
        SystemSetting::set('features.maintenance_mode', ! empty($state['features_maintenance_mode']) ? '1' : '0', 'features', 'boolean');

        // Persist Social Profiles
        SystemSetting::set('social.facebook', (string) ($state['social_facebook'] ?? ''), 'social', 'string');
        SystemSetting::set('social.instagram', (string) ($state['social_instagram'] ?? ''), 'social', 'string');
        SystemSetting::set('social.linkedin', (string) ($state['social_linkedin'] ?? ''), 'social', 'string');
        SystemSetting::set('social.twitter', (string) ($state['social_twitter'] ?? ''), 'social', 'string');
        SystemSetting::set('social.youtube', (string) ($state['social_youtube'] ?? ''), 'social', 'string');

        SystemSetting::clearCache();

        Notification::make()
            ->title('Settings Saved')
            ->body('System configuration, multi-contact directory, and feature toggles updated successfully.')
            ->success()
            ->send();
    }
}
