<?php

namespace App\Filament\Resources\Colleges\RelationManagers;

use App\Models\CollegeCourse;
use App\Models\Course;
use App\Models\Specialization;
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
use Illuminate\Support\Str;

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
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $course = Course::find($state);
                            if ($course?->duration) {
                                $set('duration', $course->duration);
                            }
                        }
                    })
                    ->label('Course / Degree'),
                Select::make('specialization_id')
                    ->label('Specialization (from Master)')
                    ->placeholder('Select specialization or create new')
                    ->options(function (callable $get) {
                        $courseId = $get('course_id');
                        if (! $courseId) {
                            return Specialization::orderBy('name')->pluck('name', 'id');
                        }

                        return Specialization::where('course_id', $courseId)
                            ->orderBy('name')
                            ->pluck('name', 'id');
                    })
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $spec = Specialization::find($state);
                            if ($spec) {
                                $set('specialization', $spec->name);
                            }
                        }
                    })
                    ->createOptionUsing(function (array $data, callable $get): int {
                        $courseId = $get('course_id');
                        $spec = Specialization::create([
                            'course_id' => $courseId,
                            'name' => $data['name'],
                            'slug' => Str::slug($data['name']),
                            'status' => true,
                        ]);

                        return $spec->id;
                    })
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->label('New Specialization Name')
                            ->placeholder('e.g. Artificial Intelligence, Data Science'),
                    ]),
                TextInput::make('specialization')
                    ->maxLength(255)
                    ->placeholder('e.g. Computer Science, AI & ML, Finance')
                    ->helperText('Auto-filled from selection above, or type custom specialization')
                    ->label('Specialization Title'),
                TextInput::make('duration')
                    ->maxLength(50)
                    ->placeholder('e.g. 4 Years')
                    ->helperText('Auto-filled from Course master, can be modified')
                    ->label('Duration'),
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
