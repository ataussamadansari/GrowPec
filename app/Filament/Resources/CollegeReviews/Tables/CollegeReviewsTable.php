<?php

namespace App\Filament\Resources\CollegeReviews\Tables;

use App\Models\CollegeReview;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CollegeReviewsTable
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
                    ->color('gray'),
                TextColumn::make('college.name')
                    ->label('College')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('course')
                    ->searchable()
                    ->limit(30),
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
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_verified')
                    ->boolean()
                    ->label('Verified'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Moderation',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                SelectFilter::make('college_id')
                    ->relationship('college', 'name')
                    ->searchable()
                    ->preload()
                    ->label('College'),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (CollegeReview $record): bool => $record->status !== 'approved')
                    ->requiresConfirmation()
                    ->action(function (CollegeReview $record) {
                        $record->update([
                            'status' => 'approved',
                            'is_verified' => true,
                        ]);

                        Notification::make()
                            ->title('Review Approved')
                            ->body('Review approved successfully and published to the college profile.')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (CollegeReview $record): bool => $record->status !== 'rejected')
                    ->requiresConfirmation()
                    ->action(function (CollegeReview $record) {
                        $record->update([
                            'status' => 'rejected',
                        ]);

                        Notification::make()
                            ->title('Review Rejected')
                            ->body('Review rejected successfully and hidden from public display.')
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
            ]);
    }
}
