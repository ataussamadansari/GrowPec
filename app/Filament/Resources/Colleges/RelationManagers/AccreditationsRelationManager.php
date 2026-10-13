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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccreditationsRelationManager extends RelationManager
{
    protected static string $relationship = 'accreditations';

    protected static ?string $title = 'Accreditations & Recognitions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('authority')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. NAAC, NBA, NIRF, UGC')
                    ->label('Accrediting Body / Authority'),
                TextInput::make('accreditation')
                    ->required()
                    ->maxLength(150)
                    ->placeholder('e.g. National Assessment and Accreditation Council')
                    ->label('Accreditation Title'),
                TextInput::make('grade')
                    ->maxLength(50)
                    ->placeholder('e.g. A++, Tier-1')
                    ->label('Awarded Grade'),
                TextInput::make('rank')
                    ->maxLength(50)
                    ->placeholder('e.g. Rank 12')
                    ->label('Rank / Score'),
                TextInput::make('year')
                    ->numeric()
                    ->placeholder('e.g. 2025')
                    ->label('Year Awarded'),
                FileUpload::make('certificate_image')
                    ->image()
                    ->disk('public')
                    ->directory('colleges/accreditations')
                    ->label('Certificate / Proof Image'),
                Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull()
                    ->label('Additional Details'),
                Toggle::make('status')
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('accreditation')
            ->columns([
                TextColumn::make('authority')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->label('Authority'),
                TextColumn::make('accreditation')
                    ->searchable()
                    ->weight('medium')
                    ->label('Accreditation'),
                TextColumn::make('grade')
                    ->badge()
                    ->color('success')
                    ->placeholder('—')
                    ->label('Grade'),
                TextColumn::make('rank')
                    ->placeholder('—')
                    ->label('Rank'),
                TextColumn::make('year')
                    ->placeholder('—')
                    ->label('Year'),
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
