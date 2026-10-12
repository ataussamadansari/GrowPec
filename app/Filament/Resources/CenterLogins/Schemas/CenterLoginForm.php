<?php

namespace App\Filament\Resources\CenterLogins\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CenterLoginForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Center Login Portal')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(100)
                            ->label('Portal Title')
                            ->placeholder('e.g. Student Portal, Admission CRM')
                            ->columnSpanFull(),
                        TextInput::make('url')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->label('Login Portal URL')
                            ->placeholder('https://portal.growpec.com/login')
                            ->columnSpanFull(),
                        TextInput::make('index')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first'),
                        Toggle::make('is_active')
                            ->label('Active / Visible')
                            ->default(true),
                    ]),
            ]);
    }
}
