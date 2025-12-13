<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bin;
use App\Models\Card;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CardController extends Controller
{

    protected string $baseUrl = 'http://api.vcc.center';
    protected string $userSerial;
    protected string $secretKey;

    public function __construct()
    {
        $this->userSerial = Setting::value('vcc_user_serial') ?? "";
        $this->secretKey = Setting::value('vcc_secret_key') ?? "";
    }

    public function index()
    {
        $mycards = Card::where('user_id', Auth::id())->get();

        return view('dashboard/cards', compact('mycards'));
    }

    protected function sign(array $params): string
    {
        $filtered = array_filter($params, fn($value) => ! is_null($value) && $value !== '');
        ksort($filtered);
        $query = urldecode(http_build_query($filtered));
        $query = str_replace('+', '%20', $query);
        $stringToSign = $query . '&key=' . $this->secretKey;

        return strtoupper(md5($stringToSign));
    }

    public function fetch_bins()
    {
        $timestamp = round(microtime(true) * 1000); // current time in ms

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
        ];

        $params['sign'] = $this->sign($params);

        Log::info('Test logging status at ' . now());

        // Send GET request
        $response = Http::get($this->baseUrl . '/bank_card/enable_bin', $params);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch BINs'], 500);
        }

        $data = $response->json();

        if (isset($data['code']) && $data['code'] === 0) {
            foreach ($data['content'] as $bin) {

                if ($bin['bin'] == '49387519') {
                    continue;
                }

                Bin::updateOrCreate(
                    ['id' => $bin['id']], // ✅ use API id column
                    [
                        'bin' => $bin['bin'],
                        'cr' => $bin['cr'],
                        'organization' => $bin['organization'],
                        'actualOpenCardPrice' => $bin['actualOpenCardPrice'],
                        'actualRechargeFeeRate' => $bin['actualRechargeFeeRate'],
                        'enable' => $bin['enable'],
                        'description' => $bin['description'],
                    ]
                );
            }
        }

        return redirect('/admin/bins');
    }

    public function show_bins()
    {
        $bins = Bin::all();
        $organizations = $bins->pluck('organization')->unique();
        $currencies = $bins->pluck('currency')->unique(); // Unique currencies
        $amounts = $bins->pluck('actualOpenCardPrice')->unique(); // Unique amounts based on BIN

        return view('dashboard.create_card', compact('bins', 'organizations', 'currencies', 'amounts')); // Pass unique data
    }

    public function open_card(Request $request)
    {

        $timestamp = (string) round(microtime(true) * 1000);

        $request->validate([
            'email' => 'required|email',
            'bin' => 'required|numeric',
            'amount' => 'required|numeric|min:1',
            'card_holder' => 'required|string',
            'remark' => 'nullable|string|max:50',
        ]);

        // get balance info
        $balance = Auth::user()->balance;
        $request_balance = $request->amount;

        // Check BIN
        $specialBins = [428852, 517746];

        if (in_array($request->bin, $specialBins)) {
            $total_balance_to_cut = $request_balance + 10 + (0.05 * $request_balance);
        } else {
            $total_balance_to_cut = $request_balance + 5 + (0.06 * $request_balance);
        }

        if ($balance < $total_balance_to_cut) {
            return redirect()->route('cards')->with('status', 'Insufficient balance');
        }

        if ($request->bin != '49387520') {
            // cut balance from user
            $user = Auth::user();
            $user->balance = $balance - $total_balance_to_cut;
            $user->save();

            $card = new Card();
            $card->user_id = Auth::id();

            // Generate 12-digit random card number safely
            $cardNumber = '';
            for ($i = 0; $i < 12; $i++) {
                $cardNumber .= random_int(0, 9);
            }

            $card->hiddenNum = $cardNumber;
            $card->organization = 'Pending';
            $card->cardBalance = $request->amount;
            $card->state = '4';
            $card->email = $request->email;
            $card->bin = $request->bin;
            $card->remark = $request->remark;
            $card->save();

            $transaction = new Transaction();
            $transaction->user_id = Auth::id();
            $transaction->cardNum = $cardNumber;
            $transaction->amount = $total_balance_to_cut;
            $transaction->type = 'Debit';
            $transaction->status = 'Pending';
            $transaction->merchantName = 'Open Virtual Card';
            $transaction->save();

            return redirect()->route('cards')->with('status', 'Your Card is being processed. It will appear in your card list shortly.');
        }


        // First call to open card
        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'cardBin' => $request->bin,
            'amount' => (string) $request->amount,
            'eMail' => $request->email,
            'remark' => $request->remark,
        ];

        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->post($this->baseUrl . '/bank_card/open_card', $params);

        if ($response->failed()) {
            Log::error('Failed to open card: ' . $response->body());
            return redirect()->route('cards')->with('status', 'First Function Failed');
        }

        $data = json_decode($response, true); // decode JSON string to PHP array

        if (!$data || !isset($data['content']['id'])) {
            Log::error('Failed to open card: Invalid JSON or missing ID');
            return redirect()->route('cards')->with('status', 'Failed to open card. Please try again.');
        }

        Log::info('Open Card Success');

        // cut balance from user
        $balance -= $total_balance_to_cut;
        Auth::user()->update(['balance' => $balance]);

        $orderId = $data['content']['id'];
        Log::info('OrderId is: ' . $orderId);

        // $orderId = "C251012152540064266";

        // next call to get card details
        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'orderId' => $orderId,
        ];

        $params['sign'] = $this->sign($params);

        // ✅ Must be form-data, not JSON
        $maxRetries = 10;
        $attempt = 0;
        $card_number = null;
        $userBankCardId = null;

        while ($attempt < $maxRetries && !$card_number) {
            $details_response = Http::asForm()->post($this->baseUrl . '/bank_card/open_detail', $params);

            if ($details_response->failed()) {
                Log::error('Failed to fetch card details: ' . $details_response->body());
                return redirect()->route('cards')->with('status', 'Failed to fetch card details. Please try again.');
            }

            $responseData = $details_response->json();

            $card_number = $responseData['content']['userBankCardNum'] ?? null;
            $userBankCardId = $responseData['content']['userBankCardId'] ?? null;

            if (!$card_number) {
                $attempt++;
                Log::info("Card not ready, retrying in 5 seconds... (Attempt $attempt/$maxRetries)");
                sleep(5); // wait before next retry
            }
        }

        if (!$card_number) {
            Log::error('Card number still not available after 5 attempts.');
            return redirect()->route('cards')->with('status', 'Card not ready. Please try again later.');
        }

        Log::info('Card number is: ' . $card_number);
        Log::info('User Bank Card ID is: ' . $userBankCardId);

        // third request
        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'userBankNum' => $card_number, // Add specific card number parameter
        ];

        $params['sign'] = $this->sign($params);

        // Use card detail endpoint for single card
        $response = Http::asJson()->get($this->baseUrl . '/bank_card/my_cards', $params);
        $responseData = $response->json();

        //
        if (! isset($responseData['content']) || ! is_array($responseData['content'])) {
            Log::info('Invalid response format when fetching card details.');
            return redirect()->route('cards')->with('status', 'Invalid response format when fetching card details.');
        }

        // 🎯 Filter out the target card
        $cardData = collect($responseData['content'])->first(function ($card) use ($card_number) {
            return $card['number'] === $card_number || $card['hiddenNum'] === substr($card_number, -5);
        });

        if (! $cardData) {
            Log::info('Card not found in list when fetching card details.');
            return redirect()->route('cards')->with('status', 'Something went wrong. Try again later or contact support.');
        }

        // 🧩 Prevent duplicate in DB
        if (Card::where('number', $card_number)->exists()) {
            Log::info('Card already exists in database.');
            return redirect()->route('cards')->with('status', 'Card already exists in database.');
        }

        // Create the card record with all available data
        $payload = [
            'user_id' => Auth::id(), // Associate with current user
            'number' => Arr::get($cardData, 'number', $card_number),
            'expiryDate' => Arr::get($cardData, 'expiryDate'),
            'cvv' => Arr::get($cardData, 'cvv'),
            'vcc_id' => Arr::get($cardData, 'id'),
            'bin' => Arr::get($cardData, 'bin'),
            'binId' => Arr::get($cardData, 'binId'),
            'organization' => Arr::get($cardData, 'organization'),
            'state' => Arr::get($cardData, 'state', 'Active'),
            'remark' => Arr::get($cardData, 'remark'),
            'createTime' => Arr::get($cardData, 'createTime') ? Carbon::parse($cardData['createTime']) : null,
            'modifyTime' => Arr::get($cardData, 'modifyTime') ? Carbon::parse($cardData['modifyTime']) : null,
            'cardBalance' => is_numeric(Arr::get($cardData, 'cardBalance')) ? (float) $cardData['cardBalance'] : 0,
            'adapterSign' => Arr::get($cardData, 'adapterSign'),
            'totalConsume' => is_numeric(Arr::get($cardData, 'totalConsume')) ? (float) $cardData['totalConsume'] : null,
            'totalRefund' => is_numeric(Arr::get($cardData, 'totalRefund')) ? (float) $cardData['totalRefund'] : null,
            'totalRecharge' => is_numeric(Arr::get($cardData, 'totalRecharge')) ? (float) $cardData['totalRecharge'] : null,
            'totalCashOut' => is_numeric(Arr::get($cardData, 'totalCashOut')) ? (float) $cardData['totalCashOut'] : null,
            'bankCardId' => Arr::get($cardData, 'bankCardId') ?: Arr::get($cardData, 'binId') ?: Arr::get($cardData, 'id'),
            'hiddenNum' => Arr::get($cardData, 'hiddenNum'),
            'hiddenCvv' => Arr::get($cardData, 'hiddenCvv'),
            'hiddenDate' => Arr::get($cardData, 'hiddenDate'),
            'isHidden' => Arr::get($cardData, 'isHidden') ? true : false,
            'email' => Arr::get($cardData, 'email'),
        ];

        Card::create($payload);

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

        sendCustomMail(Auth::user()->email, 'New Virtual Card Created', $html);

        return redirect()->route('cards')->with('status', 'Card created successfully.');
    }

    public function update_balance($id)
    {

        $timestamp = round(microtime(true) * 1000); // current time in ms
        $card = Card::FindOrFail($id);
        $card_number = $card->number;

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'userBankNum' => $card_number,
        ];

        $params['sign'] = $this->sign($params);

        $response = Http::asJson()->get($this->baseUrl . '/bank_card/my_cards', $params);
        $responseData = $response->json();

        if (! isset($responseData['content']) || ! is_array($responseData['content'])) {
            return response()->json(['success' => false, 'status' => 'Invalid response format'], 400);
        }

        $cardData = collect($responseData['content'])->first(function ($card) use ($card_number) {
            return $card['number'] === $card_number || $card['hiddenNum'] === substr($card_number, -5);
        });

        if (! $cardData) {
            return redirect()->route('cards')->with('status', 'Card has been canceled for multiple failed transactions. For more info, contact support.');
        }

        $payload = [
            'user_id' => Auth::id(),
            'number' => Arr::get($cardData, 'number', $card_number),
            'expiryDate' => Arr::get($cardData, 'expiryDate'),
            'cvv' => Arr::get($cardData, 'cvv'),
            'vcc_id' => Arr::get($cardData, 'id'),
            'bin' => Arr::get($cardData, 'bin'),
            'binId' => Arr::get($cardData, 'binId'),
            'organization' => Arr::get($cardData, 'organization'),
            'state' => Arr::get($cardData, 'state', 'Active'),
            'remark' => Arr::get($cardData, 'remark'),
            'createTime' => Arr::get($cardData, 'createTime') ? Carbon::parse($cardData['createTime']) : null,
            'modifyTime' => Arr::get($cardData, 'modifyTime') ? Carbon::parse($cardData['modifyTime']) : null,
            'cardBalance' => is_numeric(Arr::get($cardData, 'cardBalance')) ? (float) $cardData['cardBalance'] : 0,
            'adapterSign' => Arr::get($cardData, 'adapterSign'),
            'totalConsume' => is_numeric(Arr::get($cardData, 'totalConsume')) ? (float) $cardData['totalConsume'] : null,
            'totalRefund' => is_numeric(Arr::get($cardData, 'totalRefund')) ? (float) $cardData['totalRefund'] : null,
            'totalRecharge' => is_numeric(Arr::get($cardData, 'totalRecharge')) ? (float) $cardData['totalRecharge'] : null,
            'totalCashOut' => is_numeric(Arr::get($cardData, 'totalCashOut')) ? (float) $cardData['totalCashOut'] : null,
            'bankCardId' => Arr::get($cardData, 'bankCardId') ?: Arr::get($cardData, 'binId') ?: Arr::get($cardData, 'id'),
            'hiddenNum' => Arr::get($cardData, 'hiddenNum'),
            'hiddenCvv' => Arr::get($cardData, 'hiddenCvv'),
            'hiddenDate' => Arr::get($cardData, 'hiddenDate'),
            'isHidden' => Arr::get($cardData, 'isHidden') ? true : false,
            'email' => Arr::get($cardData, 'email'),
        ];

        // 🧩 Update if exists, otherwise create new
        Card::updateOrCreate(
            ['number' => $card_number],
            $payload
        );

        return redirect()
            ->route('view_card', $card->id)
            ->with('status', 'Card updated successfully.');
    }

    public function view_card(Request $request, $id)
    {
        $card = Card::findOrFail($id);
        $thisCardTransactions = Transaction::where('cardNum', $card->number)
            ->orderBy('recordTime', 'desc')
            ->get();

        return view('dashboard.view_card', compact('card', 'thisCardTransactions'));
    }

    public function card_cashout(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

        $request_amount = $request->amount;

        if ($request_amount > $card->cardBalance) {
            return redirect()->route('view_card', $card->id)->with('status', 'Insufficient card balance for this cashout.');
        }

        $amount_to_save = 0.10 * $request_amount;
        $total_deduction = $request_amount - $amount_to_save;

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'amount' => $request->amount,
            'bankCardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->post($this->baseUrl . '/bank_card/card_cash_out', $params);

        if ($response->failed()) {
            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Cashout request failed. Please try again.');
        }

        if ($response->successful()) {

            Auth::user()->balance += $total_deduction;
            Auth::user()->save();

            $card->cardBalance -= $request_amount;
            $card->save();

            $html = '
                <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                                box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                        <div style="background-color: #4a90e2; color: #ffffff; padding: 20px; text-align: center;">
                            <h1 style="margin: 0; font-size: 22px;">Card Cashout Successful</h1>
                        </div>
                        <div style="padding: 30px; text-align: center;">
                            <h2 style="color: #333333;">Cashout Completed Successfully!</h2>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                Your recent cashout from your virtual card has been completed.
                            </p>
                            <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                        padding: 15px; max-width: 400px; text-align: left; color: #222;">
                                <p><strong>Card Number:</strong> ' . $card->number . '</p>
                                <p><strong>Requested Amount:</strong> $' . number_format($request_amount, 2) . '</p>
                                <p><strong>Fee (10%):</strong> $' . number_format($amount_to_save, 2) . '</p>
                                <p><strong>Credited to Balance:</strong> $' . number_format($total_deduction, 2) . '</p>
                            </div>
                            <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                                You can view the full transaction details in your Tappayz dashboard.
                            </p>
                            <a href="https://tappayz.com/dashboard" 
                            style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                    padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                    font-weight: bold; margin-top: 15px;">
                                View Transaction
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

            sendCustomMail(Auth::user()->email, 'Tappayz - Cashout Successful', $html);

            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Cashout ' . $request->amount . ' successfully.');
        }
    }

    public function card_recharge(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'card_id' => 'required|numeric',
        ]);

        $balance = Auth::user()->balance;
        $request_balance = $request->amount;
        $total_balance_to_cut = $request_balance + (0.10 * $request_balance); // including fees

        // dd($total_balance_to_cut);

        if ($balance < $total_balance_to_cut) {
            return redirect()->route('cards')->with('status', 'Insufficient balance');
        }

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'amount' => $request->amount,
            'bankCardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->post($this->baseUrl . '/bank_card/recharge', $params);

        if ($response->failed()) {
            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Something went wrong. Please contact support.');
        }

        if ($response->successful()) {

            Auth::user()->balance -= $total_balance_to_cut;

            // After recharge is successful
            $html = '
                <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                                box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                        <div style="background-color: #4a90e2; color: #ffffff; padding: 20px; text-align: center;">
                            <h1 style="margin: 0; font-size: 22px;">Card Recharge Successful</h1>
                        </div>
                        <div style="padding: 30px; text-align: center;">
                            <h2 style="color: #333333;">Recharge Completed Successfully!</h2>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                Your virtual card has been recharged successfully.
                            </p>
                            <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                        padding: 15px; max-width: 400px; text-align: left; color: #222;">
                                <p><strong>Card Number:</strong> ' . $card->number . '</p>
                                <p><strong>Recharge Amount:</strong> $' . number_format($total_balance_to_cut, 2) . ' with fees </p>
                            </div>
                            <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                                You can now use your recharged balance for online payments or card transactions.
                            </p>
                            <a href="https://tappayz.com/dashboard"
                            style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                    padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                    font-weight: bold; margin-top: 15px;">
                                View My Card
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

            sendCustomMail(Auth::user()->email, 'Tappayz - Card Recharge Successful', $html);


            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Cashout ' . $request->amount . ' successfully.');
        }
    }

    public function get_transactions()
    {
        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'page' => '0',
            'pageSize' => '500000000',
        ];

        $params['sign'] = $this->sign($params);
        $response = Http::asForm()->get($this->baseUrl . '/bank_card/consume_order', $params);

        if ($response->failed()) {
            Log::error('Transaction fetch failed: ' . $response->body());
            return back()->with('status', 'Failed to fetch transactions.');
        }

        $data = $response->json();

        if ($data['code'] !== 0 || empty($data['rows'])) {
            return back()->with('status', 'No transactions found.');
        }

        foreach ($data['rows'] as $row) {
            Transaction::updateOrCreate(
                ['transactionId' => $row['transactionId']], // prevent duplicates
                [
                    'vcc_id'        => $row['id'] ?? null,
                    'transactionId' => $row['transactionId'] ?? null,
                    'cardNum'       => $row['cardNum'] ?? null,
                    'clientId'      => $row['clientId'] ?? null,
                    'type'          => $row['type'] ?? null,
                    'status'        => $row['status'] ?? null,
                    'amount'        => $row['amount'] ?? 0,
                    'merchantName'  => $row['merchantName'] ?? null,
                    'recordTime'    => $row['recordTime'] ?? null,
                ]
            );
        }

        return back()->with('status', 'Transactions synced successfully.');
    }

    public function cancel_card(Request $request)
    {
        $request->validate([
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);

        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'cardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->delete($this->baseUrl . '/bank_card/cancel', $params);

        if ($response->failed()) {
            return redirect()->route('cards')->with('status', 'Card Delete request failed. Please try again.');
        }

        if ($response->successful()) {
            $card->state = '0';
            $card->save();

            $html = '
                <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                                box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                        <div style="background-color: #d9534f; color: #ffffff; padding: 20px; text-align: center;">
                            <h1 style="margin: 0; font-size: 22px;">Virtual Card Canceled</h1>
                        </div>
                        <div style="padding: 30px; text-align: center;">
                            <h2 style="color: #333333;">Card Successfully Canceled</h2>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                This is to confirm that your virtual card has been <strong>successfully canceled</strong>.
                                You will no longer be able to use it for any transactions.
                            </p>
                            <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                        padding: 15px; max-width: 400px; text-align: left; color: #222;">
                                <p><strong>Card Number:</strong> ' . $card->number . '</p>
                                <p><strong>Status:</strong> Canceled</p>
                                <p><strong>Remaining Balance (if any):</strong> $' . number_format($card->cardBalance, 2) . '</p>
                            </div>
                            <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                                If you did not request this cancellation, please contact Tappayz Support immediately.
                            </p>
                            <a href="https://tappayz.com/dashboard"
                            style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                    padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                    font-weight: bold; margin-top: 15px;">
                                Go to Dashboard
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

            sendCustomMail(Auth::user()->email, 'Tappayz - Virtual Card Canceled', $html);


            return redirect()->route('cards')->with('status', 'Card deleted successfully.');
        }
    }

    public function freeze_card(Request $request)
    {
        $request->validate([
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'cardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->put($this->baseUrl . '/bank_card/suspend', $params);

        if ($response->failed()) {
            return redirect()->route('cards')->with('status', 'Card Freeze request failed. Please try again.');
        }

        if ($response->successful()) {
            $card->state = '2';
            $card->save();

            $html = '
                <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                                box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                        <div style="background-color: #f0ad4e; color: #ffffff; padding: 20px; text-align: center;">
                            <h1 style="margin: 0; font-size: 22px;">Virtual Card Frozen</h1>
                        </div>
                        <div style="padding: 30px; text-align: center;">
                            <h2 style="color: #333333;">Your Card Has Been Temporarily Frozen</h2>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                Your virtual card has been <strong>temporarily frozen</strong> for security reasons.
                                While frozen, this card cannot be used for any transactions until reactivated.
                            </p>
                            <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                        padding: 15px; max-width: 400px; text-align: left; color: #222;">
                                <p><strong>Card Number:</strong> ' . $card->number . '</p>
                                <p><strong>Status:</strong> Frozen</p>
                                <p><strong>Current Balance:</strong> $' . number_format($card->cardBalance, 2) . '</p>
                            </div>
                            <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                                You can unfreeze this card anytime from your Tappayz dashboard if you wish to resume its use.
                            </p>
                            <a href="https://tappayz.com/dashboard"
                            style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                    padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                    font-weight: bold; margin-top: 15px;">
                                Manage My Card
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

            sendCustomMail(Auth::user()->email, 'Tappayz - Virtual Card Frozen', $html);


            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Card Freezed successfully.');
        }
    }

    public function unfreeze_card(Request $request)
    {
        $request->validate([
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'cardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->put($this->baseUrl . '/bank_card/enable', $params);

        if ($response->failed()) {
            return redirect()->route('cards')->with('status', 'Card Unfreeze request failed. Please try again.');
        }

        if ($response->successful()) {
            $card->state = '1';
            $card->save();

            $html = '
                <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                                box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                        <div style="background-color: #5cb85c; color: #ffffff; padding: 20px; text-align: center;">
                            <h1 style="margin: 0; font-size: 22px;">Virtual Card Reactivated</h1>
                        </div>
                        <div style="padding: 30px; text-align: center;">
                            <h2 style="color: #333333;">Your Card Is Active Again</h2>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                Good news! Your virtual card has been <strong>successfully unfrozen</strong> and is now active again.
                                You can continue using it for all your online transactions.
                            </p>
                            <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                        padding: 15px; max-width: 400px; text-align: left; color: #222;">
                                <p><strong>Card Number:</strong> ' . $card->number . '</p>
                                <p><strong>Status:</strong> Active</p>
                                <p><strong>Current Balance:</strong> $' . number_format($card->cardBalance, 2) . '</p>
                            </div>
                            <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                                You can manage or freeze your card anytime from your Tappayz dashboard.
                            </p>
                            <a href="https://tappayz.com/dashboard"
                            style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                    padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                    font-weight: bold; margin-top: 15px;">
                                Manage My Card
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

            sendCustomMail(Auth::user()->email, 'Tappayz - Virtual Card Reactivated', $html);

            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Card unfreezed successfully.');
        }
    }

    // admin side
    public function get_data($id)
    {

        $timestamp = round(microtime(true) * 1000); // current time in ms
        $card = Card::FindOrFail($id);
        $card_number = $card->number;

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'userBankNum' => $card_number,
        ];

        $params['sign'] = $this->sign($params);

        $response = Http::asJson()->get($this->baseUrl . '/bank_card/my_cards', $params);
        $responseData = $response->json();

        if (! isset($responseData['content']) || ! is_array($responseData['content'])) {
            return response()->json(['success' => false, 'status' => 'Invalid response format'], 400);
        }

        $cardData = collect($responseData['content'])->first(function ($card) use ($card_number) {
            return $card['number'] === $card_number || $card['hiddenNum'] === substr($card_number, -5);
        });

        if (! $cardData) {
            return response()->json(['success' => false, 'status' => 'Card not found in list'], 404);
        }

        $payload = [
            'user_id' => Auth::id(),
            'number' => Arr::get($cardData, 'number', $card_number),
            'expiryDate' => Arr::get($cardData, 'expiryDate'),
            'cvv' => Arr::get($cardData, 'cvv'),
            'vcc_id' => Arr::get($cardData, 'id'),
            'bin' => Arr::get($cardData, 'bin'),
            'binId' => Arr::get($cardData, 'binId'),
            'organization' => Arr::get($cardData, 'organization'),
            'state' => Arr::get($cardData, 'state', 'Active'),
            'remark' => Arr::get($cardData, 'remark'),
            'createTime' => Arr::get($cardData, 'createTime') ? Carbon::parse($cardData['createTime']) : null,
            'modifyTime' => Arr::get($cardData, 'modifyTime') ? Carbon::parse($cardData['modifyTime']) : null,
            'cardBalance' => is_numeric(Arr::get($cardData, 'cardBalance')) ? (float) $cardData['cardBalance'] : 0,
            'adapterSign' => Arr::get($cardData, 'adapterSign'),
            'totalConsume' => is_numeric(Arr::get($cardData, 'totalConsume')) ? (float) $cardData['totalConsume'] : null,
            'totalRefund' => is_numeric(Arr::get($cardData, 'totalRefund')) ? (float) $cardData['totalRefund'] : null,
            'totalRecharge' => is_numeric(Arr::get($cardData, 'totalRecharge')) ? (float) $cardData['totalRecharge'] : null,
            'totalCashOut' => is_numeric(Arr::get($cardData, 'totalCashOut')) ? (float) $cardData['totalCashOut'] : null,
            'bankCardId' => Arr::get($cardData, 'bankCardId') ?: Arr::get($cardData, 'binId') ?: Arr::get($cardData, 'id'),
            'hiddenNum' => Arr::get($cardData, 'hiddenNum'),
            'hiddenCvv' => Arr::get($cardData, 'hiddenCvv'),
            'hiddenDate' => Arr::get($cardData, 'hiddenDate'),
            'isHidden' => Arr::get($cardData, 'isHidden') ? true : false,
            'email' => Arr::get($cardData, 'email'),
        ];

        // 🧩 Update if exists, otherwise create new
        Card::updateOrCreate(
            ['number' => $card_number],
            $payload
        );
    }
}
