<?php

namespace App\Filament\Resources\Leads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Student')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('college.name')
                    ->label('College')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->limit(25)
                    ->placeholder('Direct / General'),
                TextColumn::make('course.name')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->limit(20)
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',
                        'contacted' => 'primary',
                        'counseling' => 'warning',
                        'admitted' => 'success',
                        'closed' => 'gray',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'counseling' => 'Counseling',
                        'admitted' => 'Admitted',
                        'closed' => 'Closed',
                        default => ucfirst($state),
                    })
                    ->sortable(),
                TextColumn::make('assignedCounselor.name')
                    ->label('Counselor')
                    ->badge()
                    ->color('gray')
                    ->placeholder('Unassigned'),
                TextColumn::make('next_followup_at')
                    ->label('Next Follow-up')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'counseling' => 'In Counseling',
                        'admitted' => 'Admitted',
                        'closed' => 'Closed',
                    ]),
                SelectFilter::make('college_id')
                    ->relationship('college', 'name')
                    ->searchable()
                    ->preload()
                    ->label('College'),
                SelectFilter::make('course_id')
                    ->relationship('course', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Course'),
                SelectFilter::make('assigned_to')
                    ->relationship('assignedCounselor', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Counselor'),
            ])
            ->recordActions([
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
