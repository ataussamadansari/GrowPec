<?php

namespace App\Filament\Widgets;

use App\Models\CollegeReview;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingReviewsWidget extends TableWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Reviews Awaiting Moderation';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => CollegeReview::query()->where('status', 'pending')->with(['college'])->latest()->limit(5))
            ->columns([
                TextColumn::make('reviewer_name')
                    ->label('Reviewer')
                    ->weight('bold'),

                TextColumn::make('college.name')
                    ->label('College')
                    ->badge()
                    ->color('info')
                    ->limit(25),

                TextColumn::make('course')
                    ->label('Course')
                    ->limit(20)
                    ->placeholder('—'),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => "★ {$state}/5")
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('review')
                    ->label('Review')
                    ->limit(40),

                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->since(),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (CollegeReview $record) {
                        $record->update([
                            'status' => 'approved',
                            'is_verified' => true,
                        ]);

                        Notification::make()
                            ->title('Review Approved')
                            ->body('Review approved and published to the college profile.')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (CollegeReview $record) {
                        $record->update([
                            'status' => 'rejected',
                        ]);

                        Notification::make()
                            ->title('Review Rejected')
                            ->body('Review rejected successfully.')
                            ->warning()
                            ->send();
                    }),
            ]);
    }
}
