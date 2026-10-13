<?php

namespace App\Filament\Resources\Colleges\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CollegesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public')
                    ->label('Logo')
                    ->circular()
                    ->placeholder('—'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap()
                    ->label('College Name'),
                TextColumn::make('college_mode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'online' => 'primary',
                        default => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable()
                    ->label('Mode'),
                TextColumn::make('state')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->label('State'),
                TextColumn::make('city')
                    ->searchable()
                    ->sortable()
                    ->label('City'),
                TextColumn::make('rating')
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        (float) $state >= 4.0 => 'success',
                        (float) $state >= 3.0 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn ($state): string => '★ '.number_format((float) $state, 1))
                    ->sortable()
                    ->label('Rating'),
                TextColumn::make('college_courses_count')
                    ->counts('collegeCourses')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->label('Courses'),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('college_mode')
                    ->options([
                        'regular' => 'Regular (On-Campus)',
                        'online' => 'Online / Distance',
                    ])
                    ->label('Mode'),
                SelectFilter::make('state_id')
                    ->relationship('stateRelation', 'name')
                    ->searchable()
                    ->preload()
                    ->label('State'),
                TernaryFilter::make('is_featured')
                    ->label('Featured'),
                TernaryFilter::make('status')
                    ->label('Active Status'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
