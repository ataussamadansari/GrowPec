<?php

namespace App\Filament\Resources\Colleges\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlacementStatsRelationManager extends RelationManager
{
    protected static string $relationship = 'placementStats';

    protected static ?string $title = 'Placement Records';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->numeric()
                    ->placeholder('e.g. 2025')
                    ->label('Placement Year'),
                TextInput::make('label')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. Highest CTC, Median Package, Offers Made')
                    ->label('Metric Label'),
                TextInput::make('value')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. 54 LPA, 14.2 LPA, 1200+')
                    ->label('Metric Value'),
                TextInput::make('placement_percentage')
                    ->numeric()
                    ->placeholder('e.g. 95')
                    ->label('Placement Percentage (%)'),
                TextInput::make('course')
                    ->maxLength(100)
                    ->placeholder('e.g. B.Tech, MBA, Overall')
                    ->label('Course / Program Focus'),
                Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull()
                    ->label('Remarks / Top Highlights'),
                Toggle::make('status')
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->columns([
                TextColumn::make('year')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->placeholder('—')
                    ->label('Year'),
                TextColumn::make('label')
                    ->searchable()
                    ->weight('medium')
                    ->label('Metric'),
                TextColumn::make('value')
                    ->badge()
                    ->color('success')
                    ->label('Value'),
                TextColumn::make('placement_percentage')
                    ->formatStateUsing(fn ($state): string => $state ? "{$state}%" : '—')
                    ->label('Placement %'),
                TextColumn::make('course')
                    ->placeholder('Overall')
                    ->label('Course'),
                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
            ])
            ->headerActions([
                CreateAction::make(),
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
