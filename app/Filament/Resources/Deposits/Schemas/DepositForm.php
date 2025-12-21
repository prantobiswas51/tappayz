<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Markdown;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ViewColumn;

class DepositForm
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
                TextInput::make('tx_id'),
                Select::make('type')->options([
                    'Manual' => 'Manual',
                    'Auto' => 'Auto',
                ])->required(),
                TextInput::make('amount')
                    ->required(),
                TextInput::make('method'),
                Select::make('status')->options([
                    'PENDING' => 'PENDING',
                    'SUCCESS' => 'SUCCESS',
                    'FAILED' => 'FAILED',
                    
                ])->required(),
                TextInput::make('sender_id'),
                TextInput::make('receiver_id'),
                FileUpload::make('screenshot_path')->disk('public')->label('Screenshot'),
                MarkdownEditor::make('notes'),
            ]);
    }
}
