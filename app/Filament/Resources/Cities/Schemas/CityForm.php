<?php

namespace App\Filament\Resources\Cities\Schemas;

use App\Models\City;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('City Details')
                    ->columns(2)
                    ->components([
                        Select::make('state_id')
                            ->relationship('state', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('State'),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->unique(
                                table: 'cities',
                                column: 'name',
                                ignoreRecord: true,
                                modifyRuleUsing: fn (Unique $rule, Get $get) => $rule->where('state_id', $get('state_id'))
                            ),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(100),
                        Toggle::make('is_popular')
                            ->label('Mark as Popular City')
                            ->live()
                            ->rules([
                                fn (?City $record) => function (string $attribute, $value, Closure $fail) use ($record) {
                                    if ($value) {
                                        $query = City::where('is_popular', true);
                                        if ($record) {
                                            $query->where('id', '!=', $record->id);
                                        }
                                        if ($query->count() >= 10) {
                                            $fail('You can select a maximum of 10 popular cities.');
                                        }
                                    }
                                },
                            ])
                            ->helperText('Maximum 10 popular cities allowed globally.'),
                        FileUpload::make('image')
                            ->disk('public')
                            ->directory('cities')
                            ->image()
                            ->maxSize(4096)
                            ->required(fn (Get $get): bool => (bool) $get('is_popular'))
                            ->helperText('Required when city is marked as popular (max 4MB).')
                            ->columnSpanFull(),
                        Toggle::make('status')
                            ->label('Active Status')
                            ->default(true),
                    ]),
            ]);
    }
}
