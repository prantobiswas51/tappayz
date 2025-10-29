<?php

namespace App\Filament\Resources\Bins\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BinForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('bin')
                    ->required(),
                TextInput::make('cr')
                    ->required(),
                TextInput::make('organization')
                    ->required(),
                TextInput::make('actualOpenCardPrice')
                    ->required(),
                TextInput::make('actualRechargeFeeRate')
                    ->required(),
                Toggle::make('enable')
                    ->required(),
                TextInput::make('description'),
            ]);
    }
}
