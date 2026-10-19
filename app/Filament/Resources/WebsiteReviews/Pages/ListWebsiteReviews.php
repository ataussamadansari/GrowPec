<?php

namespace App\Filament\Resources\WebsiteReviews\Pages;

use App\Filament\Resources\WebsiteReviews\WebsiteReviewResource;
use App\Models\WebsiteReview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListWebsiteReviews extends ListRecords
{
    protected static string $resource = WebsiteReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Reviews'),
            'pending' => Tab::make('Pending Moderation')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'pending'))
                ->badge(WebsiteReview::where('status', 'pending')->count())
                ->badgeColor('warning'),
            'approved' => Tab::make('Approved & Live')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'approved'))
                ->badge(WebsiteReview::where('status', 'approved')->count())
                ->badgeColor('success'),
            'rejected' => Tab::make('Rejected')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'rejected')),
            'flagged' => Tab::make('Flagged')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'flagged')),
        ];
    }
}
