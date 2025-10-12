<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CardController extends Controller
{
    protected string $baseUrl = 'http://api.vcc.center';

    protected string $userSerial = '0852811946422621';

    protected string $secretKey = 'Okfc-yMDRgKig4E2V75pxw==';

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

        return back();
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

        $response = Http::asForm()->post($this->baseUrl.'/bank_card/open_card', $params);

        if ($response->failed()) {
            Log::error('Failed to open card: ' . $response->body());
            return redirect()->route('status')->with('error', 'Failed to open card. Please try again.');
        }

        $data = $response->json();
        $orderId = $data['content']['id'];
        // $orderId = "C251012142546325264";

        Log::info('OrderId is : ' . $orderId);

        // next call
        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'orderId' => $orderId,
        ];

        $params['sign'] = $this->sign($params);

        // ✅ Must be form-data, not JSON
        $details_response = Http::asForm()->post($this->baseUrl . '/bank_card/open_detail', $params);
        $responseData = $details_response->json(); // returns the order related details
        $card_number = $responseData['content']['userBankCardNum'];
        // $card_number = '4938751973059576';

        $card = new Card();
        $card->number = $card_number;
        $card->user_id = Auth::id();
        $card->save();

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

        if (! isset($responseData['content']) || ! is_array($responseData['content'])) {
            return response()->json(['success' => false, 'status' => 'Invalid response format'], 400);
        }

        // 🎯 Filter out the target card
        $cardData = collect($responseData['content'])->first(function ($card) use ($card_number) {
            return $card['number'] === $card_number || $card['hiddenNum'] === substr($card_number, -5);
        });

        if (! $cardData) {
            return response()->json(['success' => false, 'status' => 'Card not found in list'], 404);
        }

        // 🧩 Prevent duplicate in DB
        if (Card::where('number', $card_number)->exists()) {
            return response()->json(['success' => false, 'status' => 'Card already exists in database'], 400);
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

        return redirect()
            ->route('view_card', $card->id)
            ->with('status', 'Card updated successfully.');
    }

    public function view_card(Request $request, $id)
    {
        $card = Card::findOrFail($id);

        return view('dashboard.view_card', compact('card'));
    }

    public function card_cashout(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

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
                ->with('error', 'Cashout request failed. Please try again.');
        }

        if ($response->successful()) {
            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Cashout ' . $request->amount . ' successfully.');
        }
    }
}
