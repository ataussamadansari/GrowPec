<?php

namespace App\Filament\Resources\CollegeReviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CollegeReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Review Details')
                    ->columns(2)
                    ->components([
                        Select::make('college_id')
                            ->relationship('college', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('College'),
                        TextInput::make('reviewer_name')
                            ->required()
                            ->maxLength(150)
                            ->label('Reviewer Name'),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(150),
                        TextInput::make('course')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('e.g. B.Tech Computer Science'),
                        Select::make('rating')
                            ->options([
                                5 => '★★★★★ (5 Stars - Excellent)',
                                4 => '★★★★☆ (4 Stars - Very Good)',
                                3 => '★★★☆☆ (3 Stars - Average)',
                                2 => '★★☆☆☆ (2 Stars - Below Average)',
                                1 => '★☆☆☆☆ (1 Star - Poor)',
                            ])
                            ->default(5)
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending Moderation',
                                'approved' => 'Approved & Published',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->required(),
                        Textarea::make('review')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->label('Review Text'),
                        Toggle::make('is_verified')
                            ->label('Verified Review')
                            ->default(false),
                        TextInput::make('ip_address')
                            ->disabled()
                            ->dehydrated(false)
                            ->label('Submission IP Address'),
                    ]),
            ]);
    }
}
