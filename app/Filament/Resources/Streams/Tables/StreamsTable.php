<?php

namespace App\Filament\Resources\Streams\Tables;

use App\Models\Stream;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StreamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('slug')
                    ->searchable()
                    ->color('gray'),
                TextColumn::make('icon')
                    ->badge()
                    ->color('info')
                    ->default('None'),
                TextColumn::make('courses_count')
                    ->counts('courses')
                    ->label('Courses')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->before(function (DeleteAction $action, Stream $record) {
                        if ($record->courses()->count() > 0) {
                            Notification::make()
                                ->danger()
                                ->title('Cannot Delete Stream')
                                ->body('Cannot delete stream because it contains courses. Delete courses first.')
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
