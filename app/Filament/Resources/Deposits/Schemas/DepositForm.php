<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepositForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('tx_id'),
                TextInput::make('amount')
                    ->required(),
                TextInput::make('status')
                    ->required(),
                TextInput::make('sender_id'),
                TextInput::make('receiver_id'),
                TextInput::make('token')
                    ->required()
                    ->default('TRX'),
            ]);
    }
}
