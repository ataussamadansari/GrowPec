<?php

namespace App\Filament\Resources\Colleges\RelationManagers;

use App\Models\College;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CollegeFacilitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'collegeFacilities';

    protected static ?string $title = 'Campus Facilities';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord instanceof College && $ownerRecord->isRegular();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. Central Library, Supercomputer Lab, Sports Arena')
                    ->label('Facility Name'),
                TextInput::make('icon')
                    ->maxLength(50)
                    ->placeholder('e.g. fa-book, fa-wifi, fa-laptop')
                    ->label('FontAwesome Icon Class'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('colleges/facilities')
                    ->label('Facility Photo'),
                Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull()
                    ->label('Facility Description'),
                Toggle::make('status')
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->circular()
                    ->label('Photo')
                    ->placeholder('—'),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('medium')
                    ->label('Facility Name'),
                TextColumn::make('icon')
                    ->placeholder('—')
                    ->label('Icon'),
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
