<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('maileroo_api_key'),
                TextInput::make('vcc_user_serial'),
                TextInput::make('vcc_secret_key'),
                TextInput::make('main_deposit_address'),
                TextInput::make('paypal_email')
                    ->email(),
                TextInput::make('payoneer_email')
                    ->email(),
                TextInput::make('skrill_email')
                    ->email(),
            ]);
    }
}
