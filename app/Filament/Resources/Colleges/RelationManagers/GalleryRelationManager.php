<?php

namespace App\Filament\Resources\Colleges\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleryRelationManager extends RelationManager
{
    protected static string $relationship = 'gallery';

    protected static ?string $title = 'Campus Photo Gallery';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(150)
                    ->placeholder('e.g. Central Auditorium, Robotics Lab, Sports Meet')
                    ->label('Photo Title / Caption'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('colleges/gallery')
                    ->required()
                    ->label('Photo Upload'),
                TextInput::make('category')
                    ->maxLength(100)
                    ->placeholder('e.g. Campus, Events, Hostel, Sports')
                    ->label('Category'),
                TextInput::make('alt_text')
                    ->maxLength(150)
                    ->placeholder('Accessibility alt description')
                    ->label('Alt Text'),
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
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Preview')
                    ->height(50),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('medium')
                    ->label('Caption'),
                TextColumn::make('category')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->placeholder('General')
                    ->label('Category'),
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
