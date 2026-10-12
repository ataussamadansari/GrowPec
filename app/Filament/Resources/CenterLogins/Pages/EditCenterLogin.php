<?php

namespace App\Filament\Resources\CenterLogins\Pages;

use App\Filament\Resources\CenterLogins\CenterLoginResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCenterLogin extends EditRecord
{
    protected static string $resource = CenterLoginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
