<?php

namespace App\Filament\Resources\Colleges;

use App\Filament\Resources\Colleges\Pages\CreateCollege;
use App\Filament\Resources\Colleges\Pages\EditCollege;
use App\Filament\Resources\Colleges\Pages\ListColleges;
use App\Filament\Resources\Colleges\RelationManagers\AccreditationsRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\CareerOutcomesRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\CollegeCoursesRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\CollegeFacilitiesRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\CollegeFaqsRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\GalleryRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\PlacementStatsRelationManager;
use App\Filament\Resources\Colleges\RelationManagers\ScholarshipsRelationManager;
use App\Filament\Resources\Colleges\Schemas\CollegeForm;
use App\Filament\Resources\Colleges\Tables\CollegesTable;
use App\Models\College;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CollegeResource extends Resource
{
    protected static ?string $model = College::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'College Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Colleges';

    protected static ?string $pluralModelLabel = 'Colleges';

    public static function form(Schema $schema): Schema
    {
        return CollegeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CollegesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CollegeCoursesRelationManager::class,
            AccreditationsRelationManager::class,
            CollegeFacilitiesRelationManager::class,
            PlacementStatsRelationManager::class,
            CareerOutcomesRelationManager::class,
            ScholarshipsRelationManager::class,
            CollegeFaqsRelationManager::class,
            GalleryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListColleges::route('/'),
            'create' => CreateCollege::route('/create'),
            'edit' => EditCollege::route('/{record}/edit'),
        ];
    }
}
