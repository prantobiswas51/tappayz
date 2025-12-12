<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Setting;
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
        $trx_address = Setting::value('main_deposit_address');

        $deposits = Deposit::where('user_id', Auth::id())->get();

        return view('dashboard/funding', compact('trx_address', 'deposits'));
    }

    public function check_deposit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'tx_id' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return redirect()->route('fundings')->with('status', 'Invalid user.');
        }

        // Fetch Tron transaction
        $response = Http::withoutVerifying()
            ->get("https://apilist.tronscan.org/api/transaction-info?hash={$request->tx_id}");

        if (!$response->successful()) {
            return redirect()->route('fundings')->with('status', 'Failed to fetch transaction details.');
        }

        $json = $response->json();

        // Safe extraction
        $contractType      = $json['contractType'] ?? null;
        $contractRet       = $json['contractRet'] ?? null;
        $confirmed         = $json['confirmed'] ?? false;
        $tokenInfo         = $json['tokenTransferInfo'] ?? null;

        $amountUsdtRaw     = $tokenInfo['amount_str'] ?? 0;
        $amountUsdt        = $amountUsdtRaw / 1000000;
        $toAddress         = $tokenInfo['to_address'] ?? null;

        // Check destination address
        if ($toAddress !== Setting::value('main_deposit_address')) {
            return redirect()->route('fundings')->with('status', 'Transaction sent to wrong address.');
        }

        // Immediately reject non-USDT transfers
        if ($contractType != 31) {
            return redirect()->route('fundings')->with('status', 'Invalid token. Only USDT TRC20 accepted.');
        }

        // Check TRON success
        if ($contractRet !== 'SUCCESS') {
            return redirect()->route('fundings')->with('status', 'Transaction failed on blockchain.');
        }


        // Check amount
        if ($amountUsdt <= 0) {
            return redirect()->route('fundings')->with('status', 'Invalid amount.');
        }

        // Check duplicate
        if (Deposit::where('tx_id', $request->tx_id)->exists()) {
            return redirect()->route('fundings')->with('status', 'This transaction already exists.');
        }

        // Create deposit log
        $deposit = Deposit::create([
            'user_id' => $user->id,
            'tx_id'   => $request->tx_id,
            'status'  => $contractRet,
            'amount'  => $amountUsdt,
            'token'   => 'USDT',
        ]);

        // If confirmed and success → credit user
        if ($confirmed && $contractRet === 'SUCCESS') {

            // Increment balance first
            $user->increment('balance', $amountUsdt);

            // Reload correct latest balance
            $user->refresh();

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
                            <p><strong>Transaction ID:</strong> ' . $request->tx_id . '</p>
                            <p><strong>Deposit Amount:</strong> $' . number_format($amountUsdt, 2) . '</p>
                            <p><strong>Current Wallet Balance:</strong> $' . number_format($user->balance, 2) . '</p>
                            <p><strong>Date:</strong> ' . now()->format("F j, Y, g:i A") . '</p>
                        </div>
                    </div>
                </div>
            </div>';

            sendCustomMail($user->email, 'Tappayz - Deposit Successful', $html);

            return redirect()->route('fundings')->with('status', '✅ USDT deposit confirmed.');
        }

        return redirect()->route('fundings')->with('status', '⚠ Transaction pending or unknown.');
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

        $html = '
            <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                    <div style="background-color: #f0ad4e; color: #ffffff; padding: 20px; text-align: center;">
                        <h1 style="margin: 0; font-size: 22px;">Manual Payment Request Received</h1>
                    </div>
                    <div style="padding: 30px; text-align: center;">
                        <h2 style="color: #333333;">We\'ve Received Your Payment Request</h2>
                        <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                            Thank you for submitting your manual payment request. Our finance team has received your request 
                            and it is currently <strong>pending verification</strong>.
                        </p>
                        <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                    padding: 15px; max-width: 400px; text-align: left; color: #222;">
                            <p><strong>Requested Amount:</strong> $' . number_format($request->amount, 2) . '</p>
                            <p><strong>Status:</strong> Pending Review</p>
                            <p><strong>Date Submitted:</strong> ' . now()->format("F j, Y, g:i A") . '</p>
                        </div>
                        <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                            You will receive another email once our team verifies and approves your payment. 
                            Please allow some time for processing.
                        </p>
                        <a href="https://tappayz.com/dashboard"
                        style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                font-weight: bold; margin-top: 15px;">
                            View Payment Status
                        </a>
                    </div>
                    <div style="background-color: #f1f3f5; padding: 15px; text-align: center; font-size: 13px; color: #777;">
                        <p>If you have already made the transfer, please upload proof of payment or contact support.</p>
                        <p>Need help? Email us at 
                            <a href="mailto:support@tappayz.com" style="color: #4a90e2;">support@tappayz.com</a>
                        </p>
                        <p>© ' . date("Y") . ' Tappayz. All rights reserved.</p>
                    </div>
                </div>
            </div>
        ';

        sendCustomMail(Auth::user()->email, 'Tappayz - Manual Payment Request Received', $html);


        return redirect()->route('fundings')->with('status', '✅ Manual payment submitted. Awaiting admin approval.');
    }
}
