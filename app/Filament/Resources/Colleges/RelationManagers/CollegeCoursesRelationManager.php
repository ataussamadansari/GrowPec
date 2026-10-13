<?php

namespace App\Filament\Resources\Colleges\RelationManagers;

use App\Models\CollegeCourse;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CollegeCoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'collegeCourses';

    protected static ?string $title = 'Courses Offered';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Course / Degree'),
                TextInput::make('specialization')
                    ->maxLength(255)
                    ->placeholder('e.g. Computer Science, AI & ML, Finance')
                    ->label('Specialization'),
                TextInput::make('fee_amount')
                    ->numeric()
                    ->placeholder('e.g. 125000')
                    ->label('Fee Amount (₹)'),
                Select::make('fee_type')
                    ->options([
                        'per_year' => 'Per Year',
                        'per_semester' => 'Per Semester',
                        'total_course' => 'Total Course',
                    ])
                    ->default('per_year')
                    ->label('Fee Structure'),
                TextInput::make('duration')
                    ->maxLength(50)
                    ->placeholder('e.g. 4 Years')
                    ->label('Duration'),
                TextInput::make('eligibility')
                    ->maxLength(255)
                    ->placeholder('e.g. 10+2 with 50% in PCM')
                    ->label('Eligibility Criteria'),
                TextInput::make('seats')
                    ->numeric()
                    ->placeholder('e.g. 60')
                    ->label('Total Seats'),
                Toggle::make('status')
                    ->default(true)
                    ->label('Active Offering'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('specialization')
            ->columns([
                TextColumn::make('course.name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->label('Course'),
                TextColumn::make('specialization')
                    ->searchable()
                    ->sortable()
                    ->placeholder('General / Core')
                    ->label('Specialization'),
                TextColumn::make('fee_amount')
                    ->label('Fee Structure')
                    ->formatStateUsing(fn (CollegeCourse $record): string => $record->formatted_fee),
                TextColumn::make('duration')
                    ->placeholder('—')
                    ->label('Duration'),
                TextColumn::make('seats')
                    ->placeholder('—')
                    ->label('Seats'),
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
