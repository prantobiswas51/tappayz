<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\Process\Process;

class FundController extends Controller
{
    public function index()
    {
        $trx_address = Auth::user()->trx_address;
        return view('dashboard/funding', compact('trx_address'));
    }

    public function deposit(Request $request)
    {
        $user = Auth::user();
        $this->checkUserTRXDeposits($user);
        $this->checkUserUSDTDeposits($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Deposits checked and balance updated!',
            'balance' => $user->balance
        ]);
    }

    public function checkDeposits()
    {
        $users = User::all();

        foreach ($users as $user) {
            $this->checkUserTRXDeposits($user);
            $this->checkUserUSDTDeposits($user);
        }

        return 'Deposits checked';
    }

    private function checkUserTRXDeposits($user)
    {
        $response = Http::withHeaders([
            'TRON-PRO-API-KEY' => env('TRONGRID_API_KEY'),
        ])->get("https://api.trongrid.io/v1/accounts/{$user->trx_address}/transactions");

        $txs = $response->json()['data'] ?? [];

        foreach ($txs as $tx) {
            $txId = $tx['txID'];

            if (Deposit::where('tx_id', $txId)->exists()) continue;

            $amount = $tx['raw_data']['contract'][0]['parameter']['value']['amount'] / 1e6;

            if ($amount > 0) {
                Deposit::create([
                    'user_id' => $user->id,
                    'tx_id' => $txId,
                    'amount' => $amount,
                    'token' => 'TRX',
                ]);

                $user->balance += $amount;
                $user->save();

                // sweep to main wallet
                $this->sweepFunds($user, $amount, 'TRX');
            }
        }
    }

    private function checkUserUSDTDeposits($user)
    {
        $usdtContract = 'TXLAQ63Xg1NAzckPwKHvzw7CSEmLMEqcdj';
        $response = Http::withHeaders([
            'TRON-PRO-API-KEY' => env('TRONGRID_API_KEY'),
        ])->get("https://api.trongrid.io/v1/accounts/{$user->trx_address}/transactions/trc20?limit=50&contract_address={$usdtContract}");

        $txs = $response->json()['data'] ?? [];

        foreach ($txs as $tx) {
            $txId = $tx['transaction_id'];

            if (Deposit::where('tx_id', $txId)->exists()) continue;

            $amount = $tx['value'] / 1e6;

            if ($amount > 0) {
                Deposit::create([
                    'user_id' => $user->id,
                    'tx_id' => $txId,
                    'amount' => $amount,
                    'token' => 'USDT',
                ]);

                $user->balance += $amount;
                $user->save();

                $this->sweepFunds($user, $amount, 'USDT');
            }
        }
    }

    private function sweepFunds($user, $amount, $token)
    {
        $serverPath = base_path('resources/js/server.js'); // <- use server.js
        $privateKey = Crypt::decryptString($user->trx_private_key); // decrypt key

        $args = [
            'node',
            $serverPath,
            'sweep',
            $user->trx_address,
            $privateKey,
            env('MAIN_WALLET'),
            (string)($amount * 1e6),
            $token,
            $token === 'USDT' ? env('USDT_CONTRACT') : ''
        ];

        $process = new Process($args);
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error("{$token} Sweep failed: " . $process->getErrorOutput());
        } else {
            Log::info("{$token} Sweep success: " . $process->getOutput());
        }
    }
}
