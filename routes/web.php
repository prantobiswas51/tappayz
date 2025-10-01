<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cards', [CardController::class, 'index'])->name('cards');
    Route::get('/cards/create', [CardController::class, 'show_bins'])->name('show_bins');

    // cards
    Route::get('/cards/fetch', [CardController::class, 'fetch_bins'])->name('fetch_bins');
    Route::get('/cards/get_all_cards', [CardController::class, 'get_all_cards'])->name('get_all_cards');
    Route::get('/cards/get_card_balance', [CardController::class, 'get_card_balance'])->name('get_card_balance'); //get the card balance
    Route::post('/cards/opencard', [CardController::class, 'open_card'])->name('open_card');

    Route::get('/fundings', [FundController::class, 'index'])->name('fundings');
    Route::post('/fundings/deposit', [FundController::class, 'deposit'])->name('deposit');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');

    Route::get('/kyc', [DashboardController::class, 'kyc'])->name('kyc');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
});

require __DIR__.'/auth.php';
