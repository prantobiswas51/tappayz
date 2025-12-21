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
        $response = Http::get("https://apilist.tronscan.org/api/transaction-info?hash={$deposit->tx_id}");
        if (!$response->successful()) return;

        $tx = $response->json();

        if (!($tx['confirmed'] ?? false)) return;

        if (($tx['contractRet'] ?? null) !== 'SUCCESS') {
            $deposit->update(['status' => 'FAILED']);
            return;
        }

        Log::info("checkAndUpdate Function - passed 47 line");

        $token = $tx['tokenTransferInfo'] ?? null;
        if (!$token) return;

        // Validate token + address
        if (
            $token['to_address'] !== Setting::value('main_deposit_address') ||
            $token['contract_address'] !== config('tokens.usdt_tron')
        ) {
            $deposit->update(['status' => 'FAILED']);
            return;
        }

        $amount = $token['amount_str'] / 1_000_000;

        DB::transaction(function () use ($deposit, $amount) {

            if ($deposit->status === 'SUCCESS') return;

            $deposit->update([
                'status'        => 'SUCCESS',
                'amount'        => $amount,
                'credited_at'   => now(),
            ]);

            User::where('id', $deposit->user_id)
                ->increment('balance', $amount);
        });

        DepositConfirmedJob::dispatch($deposit);
    }
}
