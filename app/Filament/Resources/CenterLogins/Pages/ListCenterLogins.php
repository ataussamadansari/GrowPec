<?php

namespace App\Filament\Resources\CenterLogins\Pages;

use App\Filament\Resources\CenterLogins\CenterLoginResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCenterLogins extends ListRecords
{
    protected static string $resource = CenterLoginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
