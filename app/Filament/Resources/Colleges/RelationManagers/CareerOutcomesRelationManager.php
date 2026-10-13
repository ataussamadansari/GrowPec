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

class CareerOutcomesRelationManager extends RelationManager
{
    protected static string $relationship = 'careerOutcomes';

    protected static ?string $title = 'Career Outcomes & Job Roles';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('career_role')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. Machine Learning Engineer, Financial Analyst')
                    ->label('Target Career Role'),
                TextInput::make('industry')
                    ->maxLength(100)
                    ->placeholder('e.g. Technology, Banking & Finance, Healthcare')
                    ->label('Hiring Industry'),
                TextInput::make('average_salary')
                    ->maxLength(50)
                    ->placeholder('e.g. 15.5 LPA')
                    ->label('Average Package'),
                TextInput::make('salary_range')
                    ->maxLength(50)
                    ->placeholder('e.g. 10 - 26 LPA')
                    ->label('Package Range'),
                Textarea::make('job_scope')
                    ->rows(2)
                    ->columnSpanFull()
                    ->label('Role Scope & Responsibilities'),
                Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull()
                    ->label('Industry Demand & Growth Highlights'),
                Toggle::make('status')
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('career_role')
            ->columns([
                TextColumn::make('career_role')
                    ->searchable()
                    ->weight('medium')
                    ->label('Career Role'),
                TextColumn::make('industry')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->placeholder('—')
                    ->label('Industry'),
                TextColumn::make('average_salary')
                    ->badge()
                    ->color('success')
                    ->placeholder('—')
                    ->label('Avg Package'),
                TextColumn::make('salary_range')
                    ->placeholder('—')
                    ->label('Range'),
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
