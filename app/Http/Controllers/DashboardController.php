<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $cardNumbers = Card::where('user_id', Auth::id())->pluck('number');

        $transactions = Transaction::whereIn('cardNum', $cardNumbers)
            ->orderBy('recordTime', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard', compact('transactions'));
    }

    public function kyc()
    {
        return view('dashboard.kyc');
    }

    public function settings()
    {
        return view('dashboard.settings');
    }
}
