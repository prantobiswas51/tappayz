<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bin;
use App\Models\Card;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CardController extends Controller
{
    protected string $baseUrl = "http://api.vcc.center";
    protected string $userSerial = "0852811946422621";
    protected string $secretKey = "Okfc-yMDRgKig4E2V75pxw==";


    public function index()
    {
        return view('dashboard/cards');
    }

    protected function sign(array $params): string
    {
        $filtered = array_filter($params, fn($value) => !is_null($value) && $value !== '');
        ksort($filtered);
        $query = urldecode(http_build_query($filtered));
        $query = str_replace('+', '%20', $query);
        $stringToSign = $query . "&key=" . $this->secretKey;

        return strtoupper(md5($stringToSign));
    }

    // 🔹 Fetch BINs and save into database
    public function fetch_bins()
    {
        $timestamp = round(microtime(true) * 1000); // current time in ms

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp'  => $timestamp,
        ];

        $params['sign'] = $this->sign($params);

        Log::info('Test logging message at ' . now());

        // Send GET request
        $response = Http::get($this->baseUrl . "/bank_card/enable_bin", $params);

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

        $request->validate([
            'user_id' => 'required|numeric',
            'email'  => 'required|email',
            'bin' => 'required|numeric',
            'amount' => 'required|numeric|min:1',
            'card_holder' => 'required|string',
            'remark' => 'nullable|string|max:50',
        ]);

        // dd($request->all());

        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp'  => $timestamp,
            'cardBin'    => $request->bin,
            'amount'     => (string) $request->amount,
            'eMail' => $request->email,
            'remark' => $request->remark,
        ];

        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->post($this->baseUrl . '/bank_card/open_card', $params);



        if ($response->failed()) {
            // ✅ Log everything once (success or failure)
            Log::info('Open card API call', [
                'params' => $params,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'API request failed',
                'error'   => $response->body(),
            ], 500);
        }

        $data = $response->json();

        $orderId = $data['content']['id'] ?? null;

        // next call
        $timeStamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp'  => $timeStamp,
            'orderId'    => $orderId,
        ];

        $params['sign'] = $this->sign($params);

        // ✅ Must be form-data, not JSON
        $response = Http::asForm()->post($this->baseUrl . '/bank_card/open_detail', $params);

        if ($response->failed()) {
            Log::info('Card detail API call', [
                'params' => $params,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Card detail request failed',
                'error'   => $response->body(),
            ], 500);
        }

        $card = new Card();
        $card->number  = $response['content']['userBankCardNum'];
        $card->user_id = Auth::id();
        $card->save();

        return response()->json($response->json());
    }

    public function get_all_cards()
    {

        $timeStamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp'  => $timeStamp,
        ];

        $params['sign'] = $this->sign($params);

        // ✅ Must be form-data, not JSON
        $response = Http::asJson()->get($this->baseUrl . '/bank_card/my_cards', $params);

        Log::info('Card detail API call', [
            'params' => $params,
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Card detail request failed',
                'error'   => $response->body(),
            ], 500);
        }

        $cards = $response->json('content', []);

        foreach ($cards as $c) {
            $bankCardId = Arr::get($c, 'bankCardId') ?: Arr::get($c, 'binId') ?: Arr::get($c, 'id');

            // Skip if this card number already exists
            if (Card::where('number', $c['number'])->exists()) {
                continue;
            }

            $payload = [
                'number'         => Arr::get($c, 'number'),
                'expiryDate'     => Arr::get($c, 'expiryDate'),
                'cvv'            => Arr::get($c, 'cvv'),
                'vcc_id'         => Arr::get($c, 'id'),
                'bin'            => Arr::get($c, 'bin'),
                'binId'          => Arr::get($c, 'binId'),
                'organization'   => Arr::get($c, 'organization'),
                'state'          => Arr::get($c, 'state'),
                'remark'         => Arr::get($c, 'remark'),
                'createTime'     => Arr::get($c, 'createTime') ? Carbon::parse($c['createTime']) : null,
                'modifyTime'     => Arr::get($c, 'modifyTime') ? Carbon::parse($c['modifyTime']) : null,

                'cardBalance'    => is_numeric(Arr::get($c, 'cardBalance')) ? (float)$c['cardBalance'] : 0,

                'adapterSign'    => Arr::get($c, 'adapterSign'),
                'totalConsume'   => is_numeric(Arr::get($c, 'totalConsume')) ? (float)$c['totalConsume'] : null,
                'totalRefund'    => is_numeric(Arr::get($c, 'totalRefund')) ? (float)$c['totalRefund'] : null,
                'totalRecharge'  => is_numeric(Arr::get($c, 'totalRecharge')) ? (float)$c['totalRecharge'] : null,
                'totalCashOut'   => is_numeric(Arr::get($c, 'totalCashOut')) ? (float)$c['totalCashOut'] : null,
                'bankCardId'     => $bankCardId,
                'hiddenNum'      => Arr::get($c, 'hiddenNum'),
                'hiddenCvv'      => Arr::get($c, 'hiddenCvv'),
                'hiddenDate'     => Arr::get($c, 'hiddenDate'),
                'isHidden'       => Arr::get($c, 'isHidden') ? true : false,
                'email'          => Arr::get($c, 'email'),
            ];

            Card::create($payload);
        }


        return response()->json(['success' => true, 'message' => 'Cards synced', 'count' => count($cards)]);
    }
}
