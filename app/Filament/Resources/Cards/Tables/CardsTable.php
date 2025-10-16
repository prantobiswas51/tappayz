<?php

namespace App\Filament\Resources\Cards\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class CardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('expiryDate')
                    ->searchable(),
                TextColumn::make('cvv')
                    ->searchable(),
                TextColumn::make('organization')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('cardBalance')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('state')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('remark')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('totalConsume')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('totalRefund')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('totalRecharge')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('totalCashOut')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ViewAction::make(),
                Action::make('get_data')
                    ->label('Get Data')
                    ->icon('heroicon-o-arrow-path')
                    ->color('amber')
                    ->action(function ($record) {
                        // Call your controller logic here or use a service
                        app(\App\Http\Controllers\CardController::class)->get_data($record->id);

                        Notification::make()
                            ->title('Data fetched successfully!')
                            ->success()
                            ->send();
                    }),
                Action::make('freeze')
                    ->label('Freeze')
                    ->icon('heroicon-o-lock-closed')
                    ->color('amber')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $card = \App\Models\Card::findOrFail($record->id);
                        $timestamp = (string) round(microtime(true) * 1000);
                        $baseUrl = 'http://api.vcc.center';
                        $userSerial = '0852811946422621';
                        $secretKey = 'Okfc-yMDRgKig4E2V75pxw=='; // <-- set your secret key

                        // Inline sign function
                        $sign = function (array $params) use ($secretKey): string {
                            $filtered = array_filter($params, fn($value) => !is_null($value) && $value !== '');
                            ksort($filtered);
                            $query = urldecode(http_build_query($filtered));
                            $query = str_replace('+', '%20', $query);
                            $stringToSign = $query . '&key=' . $secretKey;

                            return strtoupper(md5($stringToSign));
                        };

                        $params = [
                            'userSerial' => $userSerial,
                            'timeStamp' => $timestamp,
                            'cardNum' => $card->number,
                        ];
                        $params['sign'] = $sign($params);

                        $response = \Illuminate\Support\Facades\Http::asForm()->put(
                            $baseUrl . '/bank_card/suspend',
                            $params
                        );

                        if ($response->failed()) {
                            \Filament\Notifications\Notification::make()
                                ->title('Card freeze request failed. Please try again.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $card->state = '2';
                        $card->save();

                        \Filament\Notifications\Notification::make()
                            ->title('Card frozen successfully!')
                            ->success()
                            ->send();
                    }),


            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
