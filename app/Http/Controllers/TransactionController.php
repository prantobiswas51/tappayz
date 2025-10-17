<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $cardNumbers = Card::where('user_id', Auth::id())->pluck('number');

        $transactions = Transaction::whereIn('cardNum', $cardNumbers)
            ->orderBy('recordTime', 'desc')
            ->get();
        return view('dashboard/transactions', compact('transactions'));
    }
}
