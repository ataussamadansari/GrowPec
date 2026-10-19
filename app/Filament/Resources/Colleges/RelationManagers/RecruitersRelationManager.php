<?php

namespace App\Filament\Resources\Colleges\RelationManagers;

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

class RecruitersRelationManager extends RelationManager
{
    protected static string $relationship = 'recruiters';

    protected static ?string $title = 'Top Corporate Recruiters';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. Google, Microsoft, Amazon, Deloitte')
                    ->label('Company / Recruiter Name'),
                FileUpload::make('logo')
                    ->image()
                    ->disk('public')
                    ->directory('colleges/recruiters')
                    ->label('Company Logo'),
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
                    ->label('Recruitment Notes / Description'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public')
                    ->label('Logo')
                    ->placeholder('—'),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('medium')
                    ->label('Company Name'),
                TextColumn::make('description')
                    ->limit(40)
                    ->placeholder('—')
                    ->label('Description'),
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
