<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name', fn($query) => $query->select('id', 'name', 'email'))
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} ({$record->email})")
                    ->searchable()
                    ->preload(),
                TextInput::make('vcc_id'),
                TextInput::make('transactionId'),
                TextInput::make('cardNum'),
                TextInput::make('clientId'),
                TextInput::make('type'),
                TextInput::make('status'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('merchantName'),
                TextInput::make('recordTime'),
            ]);
    }
}
