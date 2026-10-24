<?php

namespace App\Filament\Pages;

use App\Models\SystemSetting;
use BackedEnum;
use Filament\Actions\Action;
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

        $this->form->fill([
            'general_site_name' => $settings['general.site_name'] ?? 'GrowPec',
            'general_tagline' => $settings['general.tagline'] ?? '',
            'general_office_address' => $settings['general.office_address'] ?? '',
            'general_support_phone' => $settings['general.support_phone'] ?? '',
            'general_support_email' => $settings['general.support_email'] ?? '',
            'general_whatsapp_number' => $settings['general.whatsapp_number'] ?? '',
            'features_enable_floating_whatsapp' => (bool) ($settings['features.enable_floating_whatsapp'] ?? true),
            'features_enable_lead_email_alert' => (bool) ($settings['features.enable_lead_email_alert'] ?? false),
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
                                        Textarea::make('general_office_address')
                                            ->label('Registered Office Address')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Support & Communications')
                            ->icon(Heroicon::OutlinedPhone)
                            ->components([
                                Section::make('Helpline & Messaging')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('general_support_phone')
                                            ->label('Support Helpline Phone')
                                            ->tel()
                                            ->maxLength(30)
                                            ->placeholder('+91 98765 43210'),
                                        TextInput::make('general_support_email')
                                            ->label('Official Support Email')
                                            ->email()
                                            ->maxLength(100)
                                            ->placeholder('support@growpec.com'),
                                        TextInput::make('general_whatsapp_number')
                                            ->label('WhatsApp Support Number')
                                            ->maxLength(30)
                                            ->placeholder('919876543210'),
                                        Toggle::make('features_enable_floating_whatsapp')
                                            ->label('Enable Floating WhatsApp CTA on Website')
                                            ->default(true),
                                        Toggle::make('features_enable_lead_email_alert')
                                            ->label('Send Instant Email Alerts for Incoming Leads')
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

        $mapping = [
            'general_site_name' => ['key' => 'general.site_name', 'group' => 'general', 'type' => 'string'],
            'general_tagline' => ['key' => 'general.tagline', 'group' => 'general', 'type' => 'string'],
            'general_office_address' => ['key' => 'general.office_address', 'group' => 'general', 'type' => 'text'],
            'general_support_phone' => ['key' => 'general.support_phone', 'group' => 'general', 'type' => 'string'],
            'general_support_email' => ['key' => 'general.support_email', 'group' => 'general', 'type' => 'string'],
            'general_whatsapp_number' => ['key' => 'general.whatsapp_number', 'group' => 'general', 'type' => 'string'],
            'features_enable_floating_whatsapp' => ['key' => 'features.enable_floating_whatsapp', 'group' => 'features', 'type' => 'boolean'],
            'features_enable_lead_email_alert' => ['key' => 'features.enable_lead_email_alert', 'group' => 'features', 'type' => 'boolean'],
            'social_facebook' => ['key' => 'social.facebook', 'group' => 'social', 'type' => 'string'],
            'social_instagram' => ['key' => 'social.instagram', 'group' => 'social', 'type' => 'string'],
            'social_linkedin' => ['key' => 'social.linkedin', 'group' => 'social', 'type' => 'string'],
            'social_twitter' => ['key' => 'social.twitter', 'group' => 'social', 'type' => 'string'],
            'social_youtube' => ['key' => 'social.youtube', 'group' => 'social', 'type' => 'string'],
        ];

        foreach ($mapping as $field => $meta) {
            $val = $state[$field] ?? null;
            if (is_bool($val)) {
                $val = $val ? '1' : '0';
            }
            SystemSetting::set($meta['key'], (string) ($val ?? ''), $meta['group'], $meta['type']);
        }

        Notification::make()
            ->title('Settings Saved')
            ->body('System configuration and marketing settings updated successfully.')
            ->success()
            ->send();
    }
}
