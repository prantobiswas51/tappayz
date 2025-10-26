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

    public function check_deposit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'tx_id' => 'required|string',
        ]);

        $user_id = $request->input('user_id');
        $tx_id = $request->input('tx_id');

        $user = User::find($user_id);
        if (!$user) {
            return redirect()->route('fundings')->with('status', 'Invalid user.');
        }

        // Fetch transaction data from TRON API
        $response = Http::withoutVerifying()->get("https://apilist.tronscan.org/api/transaction-info?hash={$tx_id}");

        if (!$response->successful()) {
            return redirect()->route('fundings')->with('status', 'Failed to fetch transaction details.');
        }

        $json = $response->json();
        $contractType = $json['contractType'] ?? null;
        $confirmed = $json['confirmed'] ?? null;
        $contractRet = $json['contractRet'];
        $toAddress = $json['toAddress'] ?? null;

        // Check destination address
        if (strtolower($toAddress) !== strtolower("TXKeZZxtnpdMw7zup2wCJ6wSxzrNFaevNc")) {
            return redirect()->route('fundings')->with('status', 'Transaction does not belong to mentioned funding address.');
        }

        $amountSun = $json['contractData']['amount'] ?? 0;
        $amountTRX = $amountSun / 1_000_000; // Convert SUN → TRX

        // Prevent duplicate processing
        $existing = Deposit::where('user_id', $user_id)
            ->where('tx_id', $tx_id)
            ->first();

        if ($existing) {
            return redirect()->route('fundings')->with('status', 'This transaction is already recorded.');
        }

        // Create new deposit record
        $deposit = Deposit::create([
            'user_id' => $user_id,
            'tx_id' => $tx_id,
            'status' => $contractRet,
            'amount' => $amountTRX,
            'token' => $contractType == 31 ? 'USDT' : 'TRX',
        ]);

        // === Handle TRX Deposit ===
        if ($contractType == 1) {
            $amount_in_usdt = $amountTRX * 0.30; // Example: 1 TRX = 0.30 USD

            if ($contractRet == 'SUCCESS') {
                $user->increment('balance', $amount_in_usdt);
                return redirect()->route('fundings')->with('status', '✅ TRX deposit confirmed and converted to USD.');
            }

            return redirect()->route('fundings')->with('status', '⏳ TRX deposit pending confirmation.');
        }

        // === Handle USDT Deposit ===
        if ($contractType == 31) {
            if ($confirmed && $contractRet == 'SUCCESS') {
                $user->increment('balance', $amountTRX);
                $deposit->update(['status' => 'Confirmed']);

                return redirect()->route('fundings')->with('status', '✅ USDT deposit confirmed.');
            }

            return redirect()->route('fundings')->with('status', '⏳ USDT deposit pending confirmation.');
        }

        return redirect()->route('fundings')->with('status', '⚠ Unknown transaction type.');
    }


    public function getTrxToUsdtRate()
    {
        $response = Http::get('https://api.coingecko.com/api/v3/simple/price', [
            'ids' => 'tron',
            'vs_currencies' => 'usdt',
        ]);

        if ($response->successful()) {
            $rate = $response->json()['tron']['usdt'];
            return response()->json([
                'trx_to_usdt' => $rate,
            ]);
        }

        return response()->json(['error' => 'Failed to fetch rate'], 500);
    }
}
