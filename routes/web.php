<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KycController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailerooController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VerifyEmailController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/service_agreement', function () {
    return view('service_agreement');
})->name('service_agreement');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/check_mail', function () {
    return view('check_mail');
})->name('check_mail');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/email-check', [VerifyEmailController::class, 'verify'])->name('verify');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cards', [CardController::class, 'index'])->name('cards');
    Route::get('/cards/create', [CardController::class, 'show_bins'])->name('show_bins');

    // cards
    Route::get('/cards/fetch', [CardController::class, 'fetch_bins'])->name('fetch_bins');
    Route::get('/cards/get_all_cards', [CardController::class, 'get_all_cards'])->name('get_all_cards');

    Route::get('/cards/{id}', [CardController::class, 'view_card'])->name('view_card');
    Route::get('/cards/update/{id}', [CardController::class, 'update_balance'])->name('update_balance');
    Route::post('/cards/cashout', [CardController::class, 'card_cashout'])->name('card_cashout');
    Route::post('/cards/recharge', [CardController::class, 'card_recharge'])->name('card_recharge');

    Route::post('/cards/freeze', [CardController::class, 'freeze_card'])->name('freeze_card');
    Route::post('/cards/cancel', [CardController::class, 'cancel_card'])->name('cancel_card');
    Route::post('/cards/unfreeze', [CardController::class, 'unfreeze_card'])->name('unfreeze_card');

    Route::get('/cards/single_card', [CardController::class, 'get_single_card'])->name('get_single_card');
    Route::get('/transactions/get', [CardController::class, 'get_transactions'])->name('get_transactions');
    Route::post('/cards/open_card', [CardController::class, 'open_card'])->name('open_card');

    Route::get('/getrate', [FundController::class, 'getTrxToUsdtRate']);

    Route::get('/fundings', [FundController::class, 'index'])->name('fundings');
    Route::post('/fundings/deposit', [FundController::class, 'check_deposit'])->name('check_deposit');

    Route::post('/fundings/manual/deposit', [FundController::class, 'manual_payment'])->name('manual_payment');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');

    Route::get('/kyc', [DashboardController::class, 'kyc'])->name('kyc');
    Route::post('/kyc/submit', [KycController::class, 'submit_kyc'])->name('submit_kyc');

    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');

    // Admin panel
    Route::get('/admin/cards/get/{id}', [CardController::class, 'get_data'])->name('get_data');
    

});

require __DIR__ . '/auth.php';
