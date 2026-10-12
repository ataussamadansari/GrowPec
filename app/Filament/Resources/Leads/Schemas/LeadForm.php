<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Student Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(150)
                            ->label('Student Name'),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(20)
                            ->label('Phone Number'),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(150)
                            ->label('Email Address'),
                        TextInput::make('city')
                            ->maxLength(100)
                            ->label('City'),
                        TextInput::make('state')
                            ->maxLength(100)
                            ->label('State'),
                        TextInput::make('source')
                            ->maxLength(100)
                            ->placeholder('e.g. Website, Facebook, Direct')
                            ->label('Lead Source'),
                        Select::make('preferred_mode')
                            ->options([
                                'call' => 'Phone Call',
                                'whatsapp' => 'WhatsApp',
                                'email' => 'Email',
                            ])
                            ->label('Preferred Mode'),
                        Textarea::make('message')
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Student Query / Message'),
                    ]),

                Section::make('Academic Interest & CRM')
                    ->columns(2)
                    ->components([
                        Select::make('college_id')
                            ->relationship('college', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Interested College'),
                        Select::make('course_id')
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Interested Course'),
                        Select::make('specialization_id')
                            ->relationship('specialization', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Specialization'),
                        Select::make('status')
                            ->options([
                                'new' => 'New Lead',
                                'contacted' => 'Contacted',
                                'counseling' => 'In Counseling',
                                'admitted' => 'Admitted',
                                'closed' => 'Closed',
                            ])
                            ->default('new')
                            ->required()
                            ->label('Lead Status'),
                        Select::make('assigned_to')
                            ->relationship('assignedCounselor', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Assigned Counselor'),
                        DateTimePicker::make('next_followup_at')
                            ->label('Next Follow-up Date & Time'),
                        DateTimePicker::make('contacted_at')
                            ->label('First Contacted At'),
                        DateTimePicker::make('closed_at')
                            ->label('Closed At'),
                        Textarea::make('notes')
                            ->rows(4)
                            ->columnSpanFull()
                            ->label('Counselor Internal Notes'),
                    ]),
            ]);
    }
}
