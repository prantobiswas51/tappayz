<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        // ✅ Log everything once (success or failure)
        Log::info('Open card API call', [
            'params' => $params,
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'API request failed',
                'error'   => $response->body(),
            ], 500);
        }

        $data = $response->json();

        // Optionally save card info to DB here
        // Example:
        // Card::create([...]);

        return response()->json($data);
    }
}
