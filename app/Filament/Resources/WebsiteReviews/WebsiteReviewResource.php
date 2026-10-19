<?php

namespace App\Filament\Resources\WebsiteReviews;

use App\Filament\Resources\WebsiteReviews\Pages\CreateWebsiteReview;
use App\Filament\Resources\WebsiteReviews\Pages\EditWebsiteReview;
use App\Filament\Resources\WebsiteReviews\Pages\ListWebsiteReviews;
use App\Filament\Resources\WebsiteReviews\Schemas\WebsiteReviewForm;
use App\Filament\Resources\WebsiteReviews\Tables\WebsiteReviewsTable;
use App\Models\WebsiteReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WebsiteReviewResource extends Resource
{
    protected static ?string $model = WebsiteReview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static string|UnitEnum|null $navigationGroup = 'Leads & Reviews';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Website Reviews';

    protected static ?string $pluralModelLabel = 'Website Reviews';

    public static function getNavigationBadge(): ?string
    {
        $count = WebsiteReview::where('status', 'pending')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return WebsiteReviewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WebsiteReviewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWebsiteReviews::route('/'),
            'create' => CreateWebsiteReview::route('/create'),
            'edit' => EditWebsiteReview::route('/{record}/edit'),
        ];
    }
}
