<?php

namespace App\Filament\Resources\CollegeReviews;

use App\Filament\Resources\CollegeReviews\Pages\CreateCollegeReview;
use App\Filament\Resources\CollegeReviews\Pages\EditCollegeReview;
use App\Filament\Resources\CollegeReviews\Pages\ListCollegeReviews;
use App\Filament\Resources\CollegeReviews\Schemas\CollegeReviewForm;
use App\Filament\Resources\CollegeReviews\Tables\CollegeReviewsTable;
use App\Models\CollegeReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CollegeReviewResource extends Resource
{
    protected static ?string $model = CollegeReview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static string|UnitEnum|null $navigationGroup = 'Leads & Reviews';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'College Reviews';

    protected static ?string $pluralModelLabel = 'College Reviews';

    public static function form(Schema $schema): Schema
    {
        return CollegeReviewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CollegeReviewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCollegeReviews::route('/'),
            'create' => CreateCollegeReview::route('/create'),
            'edit' => EditCollegeReview::route('/{record}/edit'),
        ];
    }
}
