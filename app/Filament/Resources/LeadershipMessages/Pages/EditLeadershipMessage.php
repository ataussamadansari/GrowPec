<?php

namespace App\Filament\Resources\LeadershipMessages\Pages;

use App\Filament\Resources\LeadershipMessages\LeadershipMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeadershipMessage extends EditRecord
{
    protected static string $resource = LeadershipMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
