<?php

namespace App\Filament\Resources\CollegeReviews\Pages;

use App\Filament\Resources\CollegeReviews\CollegeReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCollegeReviews extends ListRecords
{
    protected static string $resource = CollegeReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
