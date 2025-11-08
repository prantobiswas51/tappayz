<?php

namespace App\Http\Controllers;

use App\Models\Kyc;
use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $cardNumbers = Card::where('user_id', Auth::id())->pluck('number');

        $activeCardsCount = Card::where('user_id', Auth::id())
            ->where('state', 1)
            ->count();
        $pendingCardsCount = Card::where('user_id', Auth::id())
            ->where('state', 4)
            ->count();

        $freezedCardsCount = Card::where('user_id', Auth::id())
            ->where('state', 2)
            ->count();

        $transactions = Transaction::whereIn('cardNum', $cardNumbers)
            ->orderBy('recordTime', 'desc')
            ->take(8)
            ->get();

        

        return view('dashboard', compact('transactions', 'activeCardsCount', 'pendingCardsCount', 'freezedCardsCount'));
    }

    public function kyc()
    {
        $status = Kyc::where('user_id', Auth::id())->value('status');
        return view('dashboard.kyc', compact('status'));
    }

    public function settings()
    {
        return view('dashboard.settings');
    }
}
