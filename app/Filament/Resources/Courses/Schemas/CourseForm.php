<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Course Details')
                    ->columns(2)
                    ->components([
                        Select::make('stream_id')
                            ->relationship('stream', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Stream'),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('e.g. B.Tech, MBA, BCA')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(150)
                            ->unique(ignoreRecord: true),
                        Select::make('level')
                            ->options([
                                'UG' => 'UG (Undergraduate)',
                                'PG' => 'PG (Postgraduate)',
                                'Diploma' => 'Diploma',
                                'PhD' => 'PhD / Doctorate',
                                'Certificate' => 'Certificate',
                            ])
                            ->default('UG')
                            ->required(),
                        Select::make('degree_type')
                            ->options([
                                'Degree' => 'Degree',
                                'Diploma' => 'Diploma',
                                'Certificate' => 'Certificate',
                            ])
                            ->default('Degree')
                            ->required(),
                        TextInput::make('duration')
                            ->required()
                            ->maxLength(50)
                            ->default('3 Years')
                            ->placeholder('e.g. 3 Years, 4 Years'),
                    ]),
            ]);
    }
}
