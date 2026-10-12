<?php

namespace App\Filament\Resources\CenterLogins;

use App\Filament\Resources\CenterLogins\Pages\CreateCenterLogin;
use App\Filament\Resources\CenterLogins\Pages\EditCenterLogin;
use App\Filament\Resources\CenterLogins\Pages\ListCenterLogins;
use App\Filament\Resources\CenterLogins\Schemas\CenterLoginForm;
use App\Filament\Resources\CenterLogins\Tables\CenterLoginsTable;
use App\Models\CenterLogin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CenterLoginResource extends Resource
{
    protected static ?string $model = CenterLogin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowRightOnRectangle;

    protected static string|UnitEnum|null $navigationGroup = 'Marketing & Settings';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Center Logins';

    protected static ?string $pluralModelLabel = 'Center Logins';

    public static function form(Schema $schema): Schema
    {
        return CenterLoginForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CenterLoginsTable::configure($table);
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
            'index' => ListCenterLogins::route('/'),
            'create' => CreateCenterLogin::route('/create'),
            'edit' => EditCenterLogin::route('/{record}/edit'),
        ];
    }
}
