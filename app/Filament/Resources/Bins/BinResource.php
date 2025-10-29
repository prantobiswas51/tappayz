<?php

namespace App\Filament\Resources\Bins;

use App\Filament\Resources\Bins\Pages\CreateBin;
use App\Filament\Resources\Bins\Pages\EditBin;
use App\Filament\Resources\Bins\Pages\ListBins;
use App\Filament\Resources\Bins\Schemas\BinForm;
use App\Filament\Resources\Bins\Tables\BinsTable;
use App\Models\Bin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BinResource extends Resource
{
    protected static ?string $model = Bin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Bin';

    public static function form(Schema $schema): Schema
    {
        return BinForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BinsTable::configure($table);
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
            'index' => ListBins::route('/'),
            'create' => CreateBin::route('/create'),
            'edit' => EditBin::route('/{record}/edit'),
        ];
    }
}
