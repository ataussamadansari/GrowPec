<?php

namespace App\Filament\Resources\WebsiteReviews\Pages;

use App\Filament\Resources\WebsiteReviews\WebsiteReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWebsiteReview extends EditRecord
{
    protected static string $resource = WebsiteReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
