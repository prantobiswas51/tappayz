<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Setting;
use Illuminate\Console\Command;
use App\Jobs\DepositConfirmedJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CardController;

class GetTransactions extends Command
{

    protected $signature = 'app:get-transactions';
    protected $description = 'Fetch transactions from the API';

    public function handle()
    {
        $controller = new CardController();
        $controller->get_transactions();

        // Users deposits processing
        $deposits = Deposit::where('status', 'PENDING')->get();

        foreach ($deposits as $deposit) {
            $this->checkAndUpdate($deposit);
        }
    }

    private function checkAndUpdate(Deposit $deposit)
    {
        $response = Http::get(
            "https://apilist.tronscan.org/api/transaction-info?hash={$deposit->tx_id}"
        );

        if (!$response->successful()) return;

        $tx = $response->json();

        if (!($tx['confirmed'] ?? false)) return;

        if (($tx['contractRet'] ?? null) !== 'SUCCESS') {
            $deposit->update(['status' => 'FAILED']);
            return;
        }

        // Log::channel('dev_error')->info('line 51');

        $usdAmount = null;
        $tokenName = null;

        /*
        |--------------------------------------------------------------------------
        | TRX Transfer
        |--------------------------------------------------------------------------
        */
        if ($tx['contractType'] == 1) {

            $success = $tx['contractRet'] == 'SUCCESS';
            if (!$success) return;

            if ($tx['toAddress'] !== Setting::value('main_deposit_address')) {
                $deposit->update(['status' => 'FAILED']);
                return;
            }


            $trxAmount = $tx['contractData']['amount'] / 1000000;
            $usdAmount = $trxAmount * $this->trxUsdPrice();
            $tokenName = 'TRX';
        }

        /*
        |--------------------------------------------------------------------------
        | USDT (TRC20)
        |--------------------------------------------------------------------------
        */
        if ($tx['contractType'] == 31) {

            // Log::info($tx['trc20TransferInfo']);

            $transfer = $tx['trc20TransferInfo'][0] ?? null;
            if (!$transfer) return;

            // Validate receiver address
            if ($transfer['to_address'] !== Setting::value('main_deposit_address')) {
                $deposit->update(['status' => 'FAILED']);
                return;
            }

            // Validate USDT contract
            if ($transfer['contract_address'] !== "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t") {
                $deposit->update(['status' => 'FAILED']);
                return;
            }

            $usdAmount = $transfer['amount_str'] / 1_000_000; // USDT = USD

            $tokenName = 'USDT';
        }


        if (!$usdAmount || $usdAmount <= 0) return;

        DB::transaction(function () use ($deposit, $usdAmount, $tokenName) {

            if ($deposit->status === 'SUCCESS') return;

            $deposit->update([
                'status'      => 'SUCCESS',
                'currency'       => $tokenName,
                'amount'      => $usdAmount, // stored as USD
                'credited_at' => now(),
            ]);

            User::where('id', $deposit->user_id)
                ->increment('balance', $usdAmount);
        });

        DepositConfirmedJob::dispatch($deposit);
    }


    private function trxUsdPrice(): float
    {
        return cache()->remember('trx_usd_price', 60, function () {
            $res = Http::get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => 'tron',
                'vs_currencies' => 'usd'
            ]);

            return (float) ($res->json('tron.usd') ?? 0);
        });
    }
}
