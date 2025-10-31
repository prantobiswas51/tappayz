<?php

namespace App\Filament\Resources\Kycs\Schemas;

use Faker\Core\File;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class KycForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->label('User ID')
                    ->disabled(),
                Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        'Rejected' => 'Rejected',
                    ]),
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
                FileUpload::make('passport_img_path')
                    ->label('Passport Image')
                    ->disk('public')
                    ->image(),

            ]);
    }
}
