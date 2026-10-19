<?php

namespace App\Filament\Resources\WebsiteReviews\Tables;

use App\Models\WebsiteReview;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WebsiteReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reviewer_name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->label('Reviewer'),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->color('gray')
                    ->label('Email'),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => "★ {$state}/5")
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Headline')
                    ->searchable()
                    ->limit(30)
                    ->placeholder('—'),
                TextColumn::make('review')
                    ->label('Review')
                    ->limit(50)
                    ->tooltip(fn (WebsiteReview $record): string => $record->review)
                    ->wrap(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        'flagged' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                TextColumn::make('moderatedBy.name')
                    ->label('Moderated By')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Moderation',
                        'approved' => 'Approved (Live on Homepage)',
                        'rejected' => 'Rejected',
                        'flagged' => 'Flagged',
                    ]),
                SelectFilter::make('rating')
                    ->options([
                        5 => '5 Stars',
                        4 => '4 Stars',
                        3 => '3 Stars',
                        2 => '2 Stars',
                        1 => '1 Star',
                    ])
                    ->label('Rating'),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (WebsiteReview $record): bool => $record->status !== 'approved')
                    ->requiresConfirmation()
                    ->action(function (WebsiteReview $record) {
                        $record->update([
                            'status' => 'approved',
                            'moderated_by' => auth()->id(),
                            'moderated_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Website Review Approved')
                            ->body('Review is now live on the GrowPec homepage.')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (WebsiteReview $record): bool => $record->status !== 'rejected')
                    ->form([
                        TextInput::make('moderation_reason')
                            ->label('Rejection Reason')
                            ->placeholder('e.g. Inappropriate language, spam, or promotional text')
                            ->maxLength(255),
                    ])
                    ->action(function (WebsiteReview $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'moderation_reason' => $data['moderation_reason'] ?? null,
                            'moderated_by' => auth()->id(),
                            'moderated_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Website Review Rejected')
                            ->body('Review has been rejected and hidden from public display.')
                            ->warning()
                            ->send();
                    }),
                Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon(Heroicon::OutlinedEyeSlash)
                    ->color('gray')
                    ->visible(fn (WebsiteReview $record): bool => $record->status === 'approved')
                    ->requiresConfirmation()
                    ->action(function (WebsiteReview $record) {
                        $record->update([
                            'status' => 'pending',
                            'moderated_by' => auth()->id(),
                            'moderated_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Website Review Unpublished')
                            ->body('Review status reset to pending and taken down from homepage.')
                            ->info()
                            ->send();
                    }),
                Action::make('flag')
                    ->label('Flag')
                    ->icon(Heroicon::OutlinedFlag)
                    ->color('warning')
                    ->visible(fn (WebsiteReview $record): bool => $record->status !== 'flagged')
                    ->requiresConfirmation()
                    ->action(function (WebsiteReview $record) {
                        $record->update([
                            'status' => 'flagged',
                            'moderated_by' => auth()->id(),
                            'moderated_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Website Review Flagged')
                            ->body('Review marked as flagged for secondary administrative inspection.')
                            ->warning()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
