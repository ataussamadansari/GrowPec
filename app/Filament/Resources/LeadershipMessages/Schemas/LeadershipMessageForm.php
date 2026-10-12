<?php

namespace App\Filament\Resources\LeadershipMessages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadershipMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Leadership Message')
                    ->columns(2)
                    ->components([
                        Select::make('role')
                            ->options([
                                'director' => 'Director',
                                'ceo' => 'CEO / Executive Head',
                            ])
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Role / Position'),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(150)
                            ->label('Leader Full Name')
                            ->placeholder('e.g. Dr. John Doe'),
                        TextInput::make('designation')
                            ->required()
                            ->maxLength(150)
                            ->label('Official Designation')
                            ->placeholder('e.g. Managing Director & Co-Founder'),
                        Toggle::make('status')
                            ->label('Active / Visible')
                            ->default(true),
                        FileUpload::make('photo')
                            ->image()
                            ->disk('public')
                            ->directory('leadership')
                            ->label('Photo')
                            ->helperText('Professional portrait photo')
                            ->columnSpanFull(),
                        Textarea::make('message')
                            ->required()
                            ->rows(8)
                            ->columnSpanFull()
                            ->label('Message / Statement'),
                    ]),
            ]);
    }
}
