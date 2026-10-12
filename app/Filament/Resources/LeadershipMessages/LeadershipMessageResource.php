<?php

namespace App\Filament\Resources\LeadershipMessages;

use App\Filament\Resources\LeadershipMessages\Pages\CreateLeadershipMessage;
use App\Filament\Resources\LeadershipMessages\Pages\EditLeadershipMessage;
use App\Filament\Resources\LeadershipMessages\Pages\ListLeadershipMessages;
use App\Filament\Resources\LeadershipMessages\Schemas\LeadershipMessageForm;
use App\Filament\Resources\LeadershipMessages\Tables\LeadershipMessagesTable;
use App\Models\LeadershipMessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LeadershipMessageResource extends Resource
{
    protected static ?string $model = LeadershipMessage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static string|UnitEnum|null $navigationGroup = 'Marketing & Settings';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Leadership Messages';

    protected static ?string $pluralModelLabel = 'Leadership Messages';

    public static function form(Schema $schema): Schema
    {
        return LeadershipMessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeadershipMessagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeadershipMessages::route('/'),
            'create' => CreateLeadershipMessage::route('/create'),
            'edit' => EditLeadershipMessage::route('/{record}/edit'),
        ];
    }
}
