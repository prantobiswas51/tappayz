<?php

namespace App\Filament\Resources\Kycs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KycForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                DatePicker::make('date_of_birth'),
                TextInput::make('street_address'),
                TextInput::make('apt_unit'),
                TextInput::make('zip_code'),
                TextInput::make('phone_number')
                    ->tel(),
                TextInput::make('email_address')
                    ->email(),
                TextInput::make('country'),
                TextInput::make('passport_number'),
                TextInput::make('passport_img_path'),
            ]);
    }
}
