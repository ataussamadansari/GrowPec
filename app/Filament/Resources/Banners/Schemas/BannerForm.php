<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Banner Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->maxLength(191)
                            ->label('Banner Title / Caption')
                            ->placeholder('e.g. Admissions Open 2026')
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->directory('banners')
                            ->required()
                            ->label('Banner Image')
                            ->helperText('Recommended size: 1920x600px, WebP/JPG/PNG')
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers display first'),
                        Toggle::make('status')
                            ->label('Active on Homepage')
                            ->default(true),
                    ]),
            ]);
    }
}
