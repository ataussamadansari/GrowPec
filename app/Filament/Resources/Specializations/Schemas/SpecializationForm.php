<?php

namespace App\Filament\Resources\Specializations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class SpecializationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Specialization Details')
                    ->columns(2)
                    ->components([
                        Select::make('course_id')
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Course'),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('e.g. Artificial Intelligence & ML, Marketing')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(150)
                            ->unique(
                                table: 'specializations',
                                column: 'slug',
                                ignoreRecord: true,
                                modifyRuleUsing: fn (Unique $rule, Get $get) => $rule->where('course_id', $get('course_id'))
                            ),
                        Toggle::make('status')
                            ->label('Active Status')
                            ->default(true),
                    ]),
            ]);
    }
}
