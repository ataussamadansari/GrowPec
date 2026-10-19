<?php

namespace App\Filament\Resources\WebsiteReviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WebsiteReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Website Review Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('reviewer_name')
                            ->required()
                            ->maxLength(100)
                            ->label('Reviewer Name'),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(150)
                            ->label('Email Address'),
                        Select::make('rating')
                            ->options([
                                5 => '★★★★★ (5 Stars - Outstanding)',
                                4 => '★★★★☆ (4 Stars - Very Good)',
                                3 => '★★★☆☆ (3 Stars - Average)',
                                2 => '★★☆☆☆ (2 Stars - Needs Improvement)',
                                1 => '★☆☆☆☆ (1 Star - Poor)',
                            ])
                            ->default(5)
                            ->required()
                            ->label('Rating Score'),
                        TextInput::make('title')
                            ->maxLength(150)
                            ->placeholder('e.g. Great guidance for MBA admissions')
                            ->label('Review Headline (Optional)'),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending Moderation',
                                'approved' => 'Approved & Public on Homepage',
                                'rejected' => 'Rejected',
                                'flagged' => 'Flagged for Review',
                            ])
                            ->default('pending')
                            ->required()
                            ->label('Moderation Status'),
                        Toggle::make('is_featured')
                            ->label('Pin / Feature on Homepage')
                            ->default(false),
                        TextInput::make('moderation_reason')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Reason for rejection or moderation note')
                            ->label('Moderation Reason / Note'),
                        Textarea::make('review')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->label('Review Content'),
                        TextInput::make('ip_address')
                            ->disabled()
                            ->dehydrated(false)
                            ->label('Submission IP Address'),
                    ]),
            ]);
    }
}
