<?php

namespace App\Filament\Resources\LeadershipMessages\Tables;

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

class LeadershipMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->disk('public')
                    ->circular()
                    ->label('Photo')
                    ->placeholder('—'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'director' => 'primary',
                        'ceo' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->sortable(),
                TextColumn::make('designation')
                    ->searchable()
                    ->limit(35),
                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'director' => 'Director',
                        'ceo' => 'CEO',
                    ]),
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
            ]);
    }
}
