<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class FundController extends Controller
{
    public function index()
    {
        $trx_address = Auth::user()->trx_address;
        return view('dashboard/funding', compact('trx_address'));
    }

    // User-triggered deposit check (TRX only)
    public function deposit(Request $request)
    {
        $user = Auth::user();
        $this->checkUserTRXDeposits($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Deposits checked and balance updated!',
            'balance' => $user->balance
        ]);
    }

    // Automatic deposit checker for all users (TRX + TRC20 USDT)
    public function checkDeposits()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Check TRX deposits
            $this->checkUserTRXDeposits($user);

            // Check USDT (TRC20) deposits
            $this->checkUserUSDTDeposits($user);
        }

        return 'Deposits checked';
    }

    // Helper: Check TRX deposits for a single user
    private function checkUserTRXDeposits($user)
    {
        $response = Http::get("https://api.trongrid.io/v1/accounts/{$user->trx_address}/transactions");
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
            }
        }
    }

    // Helper: Check TRC20 USDT deposits for a single user
    private function checkUserUSDTDeposits($user)
    {
        $usdtContract = 'TXLAQ63Xg1NAzckPwKHvzw7CSEmLMEqcdj';
        $response = Http::get("https://api.trongrid.io/v1/accounts/{$user->trx_address}/transactions/trc20?limit=50&contract_address={$usdtContract}");
        $txs = $response->json()['data'] ?? [];

        foreach ($txs as $tx) {
            $txId = $tx['transaction_id'];

            if (Deposit::where('tx_id', $txId)->exists()) continue;

            $amount = $tx['value'] / 1e6; // USDT decimals

            if ($amount > 0) {
                Deposit::create([
                    'user_id' => $user->id,
                    'tx_id' => $txId,
                    'amount' => $amount,
                    'token' => 'USDT',
                ]);

                $user->balance += $amount;
                $user->save();
            }
        }
    }
}
