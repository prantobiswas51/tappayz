<?php

namespace App\Filament\Resources\Kycs;

use App\Filament\Resources\Kycs\Pages\CreateKyc;
use App\Filament\Resources\Kycs\Pages\EditKyc;
use App\Filament\Resources\Kycs\Pages\ListKycs;
use App\Filament\Resources\Kycs\Schemas\KycForm;
use App\Filament\Resources\Kycs\Tables\KycsTable;
use App\Models\Kyc;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KycResource extends Resource
{
    protected static ?string $model = Kyc::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Kyc';

    public static function form(Schema $schema): Schema
    {
        return KycForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KycsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKycs::route('/'),
            'create' => CreateKyc::route('/create'),
            'edit' => EditKyc::route('/{record}/edit'),
        ];
    }
}
