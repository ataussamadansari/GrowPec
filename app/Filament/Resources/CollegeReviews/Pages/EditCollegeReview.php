<?php

namespace App\Filament\Resources\CollegeReviews\Pages;

use App\Filament\Resources\CollegeReviews\CollegeReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCollegeReview extends EditRecord
{
    protected static string $resource = CollegeReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
