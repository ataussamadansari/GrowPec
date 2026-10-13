<?php

namespace App\Filament\Resources\Colleges\RelationManagers;

use App\Models\CollegeScholarship;
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

class ScholarshipsRelationManager extends RelationManager
{
    protected static string $relationship = 'scholarships';

    protected static ?string $title = 'Scholarships & Concessions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(150)
                    ->placeholder('e.g. Chancellor Merit Scholarship, Need-Based Aid')
                    ->label('Scholarship Name'),
                TextInput::make('amount_label')
                    ->maxLength(100)
                    ->placeholder('e.g. 100% Tuition Fee Waiver, ₹50,000 / Year')
                    ->label('Benefit Label'),
                TextInput::make('amount')
                    ->numeric()
                    ->placeholder('e.g. 50000')
                    ->label('Benefit Amount (₹)'),
                TextInput::make('percentage')
                    ->numeric()
                    ->placeholder('e.g. 50')
                    ->label('Waiver Percentage (%)'),
                TextInput::make('eligibility')
                    ->maxLength(255)
                    ->placeholder('e.g. Scored 90%+ in Qualifying Examination')
                    ->label('Eligibility Terms'),
                TextInput::make('criteria')
                    ->maxLength(255)
                    ->placeholder('e.g. Family annual income under ₹6 LPA')
                    ->label('Selection Criteria'),
                Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull()
                    ->label('Additional Terms & Application Procedure'),
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
                TextColumn::make('name')
                    ->searchable()
                    ->weight('medium')
                    ->label('Scholarship'),
                TextColumn::make('amount_label')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn (CollegeScholarship $record): string => $record->display_amount)
                    ->label('Benefit'),
                TextColumn::make('eligibility')
                    ->limit(35)
                    ->placeholder('—')
                    ->label('Eligibility'),
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
