<?php

namespace App\Filament\Resources\Deposits\Tables;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class DepositsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tx_id')
                    ->searchable(),
                TextColumn::make('amount')
                    ->searchable(),
                TextColumn::make('status')
                ->color(fn ($state) => match ($state) {
                    'Pending' => 'warning',
                    'Approved' => 'success',
                    'Rejected' => 'danger',
                    default => 'secondary',
                })
                ->searchable(),
                TextColumn::make('sender_id')
                    ->searchable(),
                TextColumn::make('receiver_id')
                    ->searchable(),
                TextColumn::make('token')
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

                Action::make('approve')
                    ->label('Approve')
                    ->action(function ($record) {
                        $user = User::findOrFail($record->user_id);
                        $user->balance += $record->amount;
                        $user->save();                        
                        $record->status = 'Approved';
                        $record->save();
                    })->visible(fn ($record) => $record->status == 'Pending')
                    ->requiresConfirmation()
                    ->color('success'),

                Action::make('reject')
                    ->label('Reject')
                    ->action(function ($record) {
                        $record->status = 'Rejected';
                        $record->save();
                    })->visible(fn ($record) => $record->status == 'Pending')
                    ->requiresConfirmation()
                    ->color('danger'),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
