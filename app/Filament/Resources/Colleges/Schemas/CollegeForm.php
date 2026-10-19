<?php

namespace App\Filament\Resources\Colleges\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class CollegeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('CollegeDetails')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Overview & Location')
                            ->icon(Heroicon::OutlinedBuildingOffice)
                            ->components([
                                Section::make('Basic Information')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('College / University Name')
                                            ->placeholder('e.g. Indian Institute of Technology Delhi')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->label('URL Slug'),
                                        Select::make('college_mode')
                                            ->options([
                                                'regular' => 'Regular (On-Campus Physical University)',
                                                'online' => 'Online (Distance / Online Degree University)',
                                            ])
                                            ->default('regular')
                                            ->required()
                                            ->live()
                                            ->label('Education Mode'),
                                        TextInput::make('short_name')
                                            ->maxLength(100)
                                            ->placeholder('e.g. IITD, BITS Pilani')
                                            ->label('Short / Abbreviated Name'),
                                        Select::make('college_type')
                                            ->options([
                                                'Private' => 'Private',
                                                'Govt' => 'Government (Central / State)',
                                                'Deemed' => 'Deemed / Deemed-to-be University',
                                                'Autonomous' => 'Autonomous Institute',
                                            ])
                                            ->default('Private')
                                            ->required()
                                            ->label('Institution Ownership (Private / Government)'),
                                        Select::make('institution_category')
                                            ->options([
                                                'University' => 'University (Degree Awarding)',
                                                'College' => 'College (Affiliated)',
                                                'Institute' => 'Institute (Autonomous / Standalone)',
                                            ])
                                            ->default('University')
                                            ->required()
                                            ->live()
                                            ->label('Institution Category (College / University)'),
                                        TextInput::make('university_name')
                                            ->maxLength(150)
                                            ->placeholder('e.g. AKTU, GGSIPU, University of Delhi')
                                            ->label('Affiliated University')
                                            ->helperText('Specify affiliated parent university if this is a College or Institute'),
                                        TextInput::make('established_year')
                                            ->numeric()
                                            ->maxLength(4)
                                            ->placeholder('e.g. 1961')
                                            ->label('Established Year'),
                                        TextInput::make('campus_size')
                                            ->maxLength(100)
                                            ->placeholder('e.g. 320 Acres')
                                            ->label('Campus Size')
                                            ->visible(fn (Get $get) => $get('college_mode') !== 'online'),
                                        TextInput::make('website')
                                            ->url()
                                            ->maxLength(255)
                                            ->placeholder('https://www.college.ac.in')
                                            ->label('Official Website'),
                                        Toggle::make('is_featured')
                                            ->label('Featured on Homepage')
                                            ->default(false),
                                        Toggle::make('status')
                                            ->label('Published & Visible')
                                            ->default(true),
                                    ]),

                                Section::make('Location & Address')
                                    ->columns(2)
                                    ->components([
                                        Select::make('state_id')
                                            ->relationship('state', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->label('Select State')
                                            ->live()
                                            ->afterStateUpdated(fn (Set $set) => $set('city_id', null)),
                                        Select::make('city_id')
                                            ->relationship(
                                                'city',
                                                'name',
                                                modifyQueryUsing: fn ($query, Get $get) => $query->when(
                                                    $get('state_id'),
                                                    fn ($q, $stateId) => $q->where('state_id', $stateId)
                                                )
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->label('Select City'),
                                        Textarea::make('address')
                                            ->rows(2)
                                            ->columnSpanFull()
                                            ->label('Campus Address'),
                                    ]),
                            ]),

                        Tab::make('Media & Documents')
                            ->icon(Heroicon::OutlinedPhoto)
                            ->components([
                                Section::make('Images & Media Assets')
                                    ->columns(2)
                                    ->components([
                                        FileUpload::make('logo')
                                            ->image()
                                            ->disk('public')
                                            ->directory('colleges/logos')
                                            ->label('College Logo')
                                            ->helperText('Square or circular logo image'),
                                        FileUpload::make('banner_image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('colleges/banners')
                                            ->label('Hero Banner Image')
                                            ->helperText('Recommended 1200x400px wide photo'),
                                        FileUpload::make('sample_certificate_image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('colleges/certificates')
                                            ->label('Sample Degree / Certificate (Online Authenticity)')
                                            ->helperText('Sample certificate awarded to graduates')
                                            ->visible(fn (Get $get) => $get('college_mode') === 'online'),
                                        FileUpload::make('brochure_pdf')
                                            ->disk('public')
                                            ->directory('colleges/brochures')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->label('Admission Brochure (PDF)')
                                            ->helperText('Official downloadable PDF prospectus'),
                                    ]),
                            ]),

                        Tab::make('Rankings & Placements')
                            ->icon(Heroicon::OutlinedTrophy)
                            ->components([
                                Section::make('Accreditations & Ratings')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('rating')
                                            ->numeric()
                                            ->default(4.5)
                                            ->minValue(1.0)
                                            ->maxValue(5.0)
                                            ->step(0.1)
                                            ->label('Rating (out of 5)'),
                                        Select::make('naac_grade')
                                            ->options([
                                                'A++' => 'A++ Grade',
                                                'A+' => 'A+ Grade',
                                                'A' => 'A Grade',
                                                'B++' => 'B++ Grade',
                                                'B+' => 'B+ Grade',
                                                'B' => 'B Grade',
                                                'C' => 'C Grade',
                                                'NA' => 'Not Applicable',
                                            ])
                                            ->label('NAAC Accreditation Grade'),
                                        Toggle::make('ugc_approved')
                                            ->default(true)
                                            ->label('UGC Approved'),
                                        TextInput::make('nirf_rank')
                                            ->numeric()
                                            ->label('NIRF All India Rank')
                                            ->visible(fn (Get $get) => $get('college_mode') !== 'online'),
                                        TextInput::make('nirf_year')
                                            ->numeric()
                                            ->placeholder('e.g. 2025')
                                            ->label('NIRF Ranking Year')
                                            ->visible(fn (Get $get) => $get('college_mode') !== 'online'),
                                        TextInput::make('approvals')
                                            ->placeholder('e.g. AICTE, UGC, BCI, PCI')
                                            ->label('Accreditations & Approvals'),
                                        TextInput::make('entrance_exams')
                                            ->placeholder('e.g. JEE Main, GATE, CAT, CUET')
                                            ->label('Accepted Entrance Exams')
                                            ->visible(fn (Get $get) => $get('college_mode') !== 'online'),
                                    ]),

                                Section::make('Placements & Hostel Amenities')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('highest_package')
                                            ->maxLength(100)
                                            ->placeholder('e.g. 54 LPA')
                                            ->label('Highest Salary Package'),
                                        TextInput::make('average_package')
                                            ->maxLength(100)
                                            ->placeholder('e.g. 12.5 LPA')
                                            ->label('Average Salary Package'),
                                        Toggle::make('has_boys_hostel')
                                            ->default(false)
                                            ->label('Boys Hostel Facility Available')
                                            ->visible(fn (Get $get) => $get('college_mode') !== 'online'),
                                        Toggle::make('has_girls_hostel')
                                            ->default(false)
                                            ->label('Girls Hostel Facility Available')
                                            ->visible(fn (Get $get) => $get('college_mode') !== 'online'),
                                    ]),
                            ]),

                        Tab::make('Editorial & SEO')
                            ->icon(Heroicon::OutlinedDocumentText)
                            ->components([
                                Section::make('Editorial Content')
                                    ->components([
                                        Textarea::make('overview')
                                            ->rows(5)
                                            ->label('College Overview & History'),
                                        Textarea::make('admission_process')
                                            ->rows(4)
                                            ->label('Admission Process & Criteria'),
                                        Textarea::make('scholarship_info')
                                            ->rows(4)
                                            ->label('Scholarships & Financial Aid Overview')
                                            ->visible(fn (Get $get) => $get('college_mode') !== 'online'),
                                    ]),

                                Section::make('Search Engine Optimization (SEO)')
                                    ->components([
                                        TextInput::make('seo_title')
                                            ->maxLength(255)
                                            ->label('Meta Title')
                                            ->placeholder('e.g. IIT Delhi - Admissions, Courses, Fees, Placements & Cutoff'),
                                        Textarea::make('seo_description')
                                            ->rows(3)
                                            ->label('Meta Description')
                                            ->placeholder('Brief description shown in Google search results'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
