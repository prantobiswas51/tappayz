<?php

namespace App\Filament\Resources\Cards\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class CardForm
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
                    ->preload()
                    ->required(),

                TextInput::make('number'),
                TextInput::make('expiryDate'),
                TextInput::make('cvv'),
                TextInput::make('vcc_id'),
                TextInput::make('organization'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('cardBalance')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('bin'),
                TextInput::make('binId'),
                TextInput::make('state'),
                TextInput::make('remark'),
                TextInput::make('createTime'),
                TextInput::make('modifyTime'),
                TextInput::make('adapterSign'),
                TextInput::make('totalConsume'),
                TextInput::make('totalRefund'),
                TextInput::make('totalRecharge'),
                TextInput::make('totalCashOut'),
                TextInput::make('bankCardId'),
                TextInput::make('hiddenNum'),
                TextInput::make('hiddenCvv'),
                TextInput::make('hiddenDate'),
                TextInput::make('isHidden'),
            ]);
    }
}
