<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Phone number'),
                TextInput::make('country'),
                TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->default(0.0),
                TextInput::make('number'),
                DateTimePicker::make('email_verified_at'),
            ]);
    }
}
