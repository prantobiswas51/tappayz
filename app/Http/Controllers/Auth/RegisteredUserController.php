<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Process;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Run Node script
        // $process = Process::run('node '.base_path('resources/js/tron.js'));
        // if ($process->successful()) {
        //     $account = json_decode($process->output(), true);

        //     $user->trx_address = $account['address']['base58'];
        //     $user->trx_private_key = Crypt::encryptString($account['privateKey']); // encrypted in DB
        //     $user->save();
        // }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
