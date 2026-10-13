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

class CollegeFaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'collegeFaqs';

    protected static ?string $title = 'Frequently Asked Questions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Does the college provide hostel accommodation?')
                    ->columnSpanFull()
                    ->label('Question'),
                Textarea::make('answer')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull()
                    ->placeholder('e.g. Yes, separate boys and girls hostels are located within the campus.')
                    ->label('Answer'),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->label('Display Order'),
                Toggle::make('status')
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('question')
                    ->searchable()
                    ->weight('medium')
                    ->wrap()
                    ->label('Question'),
                TextColumn::make('answer')
                    ->limit(60)
                    ->color('gray')
                    ->label('Answer'),
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
            ])
            ->defaultSort('sort_order', 'asc');
    }
}
