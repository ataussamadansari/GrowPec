<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('stream.name')
                    ->label('Stream')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'UG' => 'success',
                        'PG' => 'primary',
                        'Diploma' => 'warning',
                        'PhD' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('degree_type')
                    ->label('Degree Type')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('duration')
                    ->sortable(),
                TextColumn::make('specializations_count')
                    ->counts('specializations')
                    ->label('Specializations')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('college_courses_count')
                    ->counts('collegeCourses')
                    ->label('Offered In')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('stream_id')
                    ->relationship('stream', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Stream'),
                SelectFilter::make('level')
                    ->options([
                        'UG' => 'UG',
                        'PG' => 'PG',
                        'Diploma' => 'Diploma',
                        'PhD' => 'PhD',
                        'Certificate' => 'Certificate',
                    ]),
                SelectFilter::make('degree_type')
                    ->options([
                        'Degree' => 'Degree',
                        'Diploma' => 'Diploma',
                        'Certificate' => 'Certificate',
                    ]),
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
