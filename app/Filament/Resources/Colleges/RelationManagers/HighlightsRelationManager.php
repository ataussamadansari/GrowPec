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

class HighlightsRelationManager extends RelationManager
{
    protected static string $relationship = 'collegeHighlights';

    protected static ?string $title = 'Key Highlights';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. NIRF 2024 Ranking, Highest Package')
                    ->label('Highlight Title'),
                TextInput::make('value')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. Ranked #52, ₹84.88 LPA')
                    ->label('Highlight Value / Metric'),
                TextInput::make('icon')
                    ->maxLength(50)
                    ->placeholder('e.g. bi-award-fill, bi-star-fill, bi-briefcase-fill')
                    ->label('Bootstrap Icon Class'),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->label('Sort Order'),
                Toggle::make('status')
                    ->default(true)
                    ->label('Active'),
                Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull()
                    ->label('Detailed Note / Context'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->weight('medium')
                    ->label('Title'),
                TextColumn::make('value')
                    ->weight('bold')
                    ->label('Value'),
                TextColumn::make('icon')
                    ->placeholder('—')
                    ->label('Icon'),
                TextColumn::make('sort_order')
                    ->sortable()
                    ->label('Order'),
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
