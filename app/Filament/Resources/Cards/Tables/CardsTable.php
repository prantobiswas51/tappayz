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
                TextColumn::make('organization')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('state')
                    ->label('State')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            '1' => 'Active',
                            '2' => 'Frozen',
                            '0' => 'Canceled',
                            '4' => 'Pending',
                            default => 'Unknown',
                        };
                    })
                    ->color(function ($state) {
                        return match ($state) {
                            '1' => 'success',
                            '2' => 'warning',
                            '0' => 'danger',
                            '4' => 'green',
                            default => 'gray',
                        };
                    })
                    ->searchable(),
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
                Action::make('send_mail')
                    ->label('Notify')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->action(function ($record) {

                        // Get card owner's email + card number
                        $email = $record->email;
                        $card_number = $record->number;

                        $html = '
                                <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                                    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; 
                                                box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                                        <div style="background-color: #4a90e2; color: #ffffff; padding: 20px; text-align: center;">
                                            <h1 style="margin: 0; font-size: 22px;">New Virtual Card Created</h1>
                                        </div>
                                        <div style="padding: 30px; text-align: center;">
                                            <h2 style="color: #333333;">Your Card Is Ready!</h2>
                                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                                Congratulations! Your new virtual card has been created successfully.
                                            </p>
                                            <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px; 
                                                        padding: 15px; max-width: 400px; font-size: 18px; color: #222; font-weight: bold;">
                                                Card Number: ' . $card_number . '
                                            </div>
                                            <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                                                You can now use this card for secure online transactions directly through your Tappayz dashboard.
                                            </p>
                                            <a href="https://tappayz.com/cards" 
                                            style="display: inline-block; background-color: #4a90e2; color: #ffffff; 
                                                    padding: 12px 25px; border-radius: 6px; text-decoration: none; 
                                                    font-weight: bold; margin-top: 15px;">
                                                View My Cards
                                            </a>
                                        </div>
                                        <div style="background-color: #f1f3f5; padding: 15px; text-align: center; font-size: 13px; color: #777;">
                                            <p>Need help? Contact our support at 
                                                <a href="mailto:support@tappayz.com" style="color: #4a90e2;">support@tappayz.com</a>
                                            </p>
                                            <p>© ' . date("Y") . ' Tappayz. All rights reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            ';

                        // Send email to card owner
                        sendCustomMail($email, 'New Virtual Card Created', $html);

                        Notification::make()
                            ->title('Email sent successfully!')
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
