<?php

namespace App\Jobs;

use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DepositConfirmedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Deposit $deposit;
    public string $user_email;
    public float $usdAmount;

    public function __construct(Deposit $deposit, string $user_email, float $usdAmount)
    {
        $this->deposit = $deposit;
        $this->user_email = $user_email;
        $this->usdAmount = $usdAmount;
    }

    public function handle(): void
    {
        $user = $this->deposit->user;

        if (!$user) {
            return;
        }

        $html = '
            <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                    <div style="background-color: #4a90e2; color: #ffffff; padding: 20px; text-align: center;">
                        <h1 style="margin: 0; font-size: 22px;">Deposit Successful</h1>
                    </div>
                    <div style="padding: 30px; text-align: center;">
                        <h2 style="color: #333333;">Funds Added to Your Wallet</h2>
                        <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                            Your recent deposit has been processed successfully.
                        </p>
                        <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                    padding: 15px; max-width: 400px; text-align: left; color: #222;">
                            <p><strong>Transaction ID:</strong> ' . $this->deposit->tx_id . '</p>
                            <p><strong>Deposit Amount:</strong> $' . number_format($this->usdAmount , 2) . '</p>
                            <p><strong>Current Wallet Balance:</strong> $' . number_format($user->balance, 2) . '</p>
                            <p><strong>Date:</strong> ' . now()->format("F j, Y, g:i A") . '</p>
                        </div>
                    </div>
                </div>
            </div>';

            sendCustomMail($user->email, 'Tappayz - Deposit Successful', $html);
    }
}
