<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Partner Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(150)
                            ->label('Partner Name')
                            ->placeholder('e.g. Google Cloud, AWS Educate, IIT Madras')
                            ->columnSpanFull(),
                        FileUpload::make('logo')
                            ->image()
                            ->disk('public')
                            ->directory('partners')
                            ->label('Partner Logo')
                            ->helperText('PNG / SVG / WebP recommended, transparent background')
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers display first'),
                        Toggle::make('status')
                            ->label('Active / Visible')
                            ->default(true),
                    ]),
            ]);
    }
}
