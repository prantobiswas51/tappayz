<?php

namespace App\Filament\Resources\Bins\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class BinsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('bin')
                    ->searchable(),
                TextColumn::make('cr')
                    ->searchable(),
                TextColumn::make('organization')
                    ->searchable(),
                TextColumn::make('actualOpenCardPrice')
                    ->searchable(),
                TextColumn::make('actualRechargeFeeRate')
                    ->searchable(),
                IconColumn::make('enable')
                    ->boolean(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('syncBin')
                    ->label('Sync Bin')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->url(fn() => route('fetch_bins')) // ✅ use url() instead of route()
                    ->openUrlInNewTab(false) // set to true if you want a new tab
                    ->successNotificationTitle('Bin synced successfully!'),
            ])

            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
