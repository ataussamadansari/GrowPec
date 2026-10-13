<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Models\Lead;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestLeadsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Recent Student Enquiries';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Lead::query()->with(['college', 'course'])->latest()->limit(6))
            ->columns([
                TextColumn::make('name')
                    ->label('Student')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Phone / WhatsApp')
                    ->copyable()
                    ->color('primary'),

                TextColumn::make('college.name')
                    ->label('College')
                    ->placeholder('General Enquiry')
                    ->limit(25),

                TextColumn::make('course.name')
                    ->label('Course')
                    ->placeholder('—')
                    ->limit(20),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'contacted' => 'warning',
                        'counseling' => 'info',
                        'admitted' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->since(),
            ])
            ->recordActions([
                Action::make('edit')
                    ->label('Manage')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->url(fn (Lead $record): string => LeadResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
