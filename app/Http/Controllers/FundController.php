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

        $deposits = Deposit::where('user_id', Auth::id())->get();

        return view('dashboard/funding', compact('trx_address', 'deposits'));
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
        // dd($json);

        $contractType = $json['contractType'] ?? null;
        $confirmed = $json['confirmed'] ?? null;
        $contractRet = $json['contractRet'];
        $amountUsdtRaw = $json['tokenTransferInfo']['amount_str'] ?? 0;
        $amountUsdt = $amountUsdtRaw / 1000000;
        $tokenTransferInfo = $json['tokenTransferInfo']['to_address'];

        // Check destination address
        if ($tokenTransferInfo !== "TCMVbfPmQnFa6Aw9FT4GM5QDNAU2t5ftxK") {
            return redirect()->route('fundings')->with('status', 'Transaction does not belong to mentioned funding address.');
        }

        if (!$contractRet) {
            return redirect()->route('fundings')->with('status', 'Something went wrong. Please Contact Customer Support.');
        }

        // Check if the amount is valid
        if ($amountUsdt <= 0 || ($contractType != 31)) {
            return redirect()->route('fundings')->with('status', 'Invalid deposit amount or Token. Contact Customer Support.');
        }

        // Prevent duplicate processing
        $existing = Deposit::where('user_id', $user_id)->where('tx_id', $tx_id)->first();

        if ($existing) {
            return redirect()->route('fundings')->with('status', 'This transaction is already recorded.');
        }

        // Create new deposit record
        $deposit = Deposit::create([
            'user_id' => $user_id,
            'tx_id' => $tx_id,
            'status' => $contractRet,
            'amount' => $amountUsdt,
            'token' => 'USDT',
        ]);


        if ($confirmed && $contractRet == 'SUCCESS') {
            $user->increment('balance', $amountUsdt);

            return redirect()->route('fundings')->with('status', '✅ USDT deposit confirmed.');
        }

        return redirect()->route('fundings')->with('status', '⚠ Unknown transaction type.');
    }


    public function manual_payment(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'payment_method' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'currency' => 'nullable|string',
            'tx_id' => 'required|string',
            'notes' => 'nullable|string',
            'screenshot' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
        ]);

        // dd($request->all());

        if ($request->file('screenshot')->getSize() > 3 * 1024 * 1024) {
            return redirect()->route('fundings')->with('status', 'File size exceeds the maximum limit of 3MB.');
        }

        $ss_path = $request->file('screenshot')->store('manual_deposits', 'public');

        $payment_method = $request->input('payment_method');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $tx_id = $request->input('tx_id');
        $notes = $request->input('notes');

        // Create a new deposit record with 'PENDING' status
        Deposit::create([
            'user_id' => Auth::id(),
            'tx_id' => $tx_id,
            'amount' => $amount,
            'currency' => $currency,
            'notes' => $notes,
            'method' => $payment_method,
            'screenshot_path' => $ss_path,
            'type' => 'Manual',
            'status' => 'Pending',
        ]);

        return redirect()->route('fundings')->with('status', '✅ Manual payment submitted. Awaiting admin approval.');
    }
}
