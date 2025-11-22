<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('maileroo_api_key')
                    ->searchable(),
                TextColumn::make('vcc_user_serial')
                    ->searchable(),
                TextColumn::make('vcc_secret_key')
                    ->searchable(),
                TextColumn::make('main_deposit_address')
                    ->searchable(),
                TextColumn::make('paypal_email')
                    ->searchable(),
                TextColumn::make('payoneer_email')
                    ->searchable(),
                TextColumn::make('skrill_email')
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
