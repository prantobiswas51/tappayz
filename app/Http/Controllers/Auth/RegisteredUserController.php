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

        $html = '
            <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                    <div style="background-color: #4a90e2; color: #ffffff; padding: 20px; text-align: center;">
                        <h1 style="margin: 0; font-size: 24px;">Welcome to <span style="color: #ffe082;">Tappayz</span>!</h1>
                    </div>
                    <div style="padding: 30px; text-align: center;">
                        <h2 style="color: #333333;">Hello and Welcome!</h2>
                        <p style="color: #555555; font-size: 16px; line-height: 1.5;">
                            We’re thrilled to have you onboard. Tappayz gives you fast, secure, and reliable Virtual Cards
                            — designed to make your payments effortless.
                        </p>
                        <p style="color: #555555; font-size: 16px; line-height: 1.5;">
                            Start exploring your dashboard and experience how simple managing your payments can be.
                        </p>
                        <a href="https://tappayz.com" 
                        style="display: inline-block; background-color: #4a90e2; color: #ffffff; 
                                padding: 12px 25px; border-radius: 6px; text-decoration: none; 
                                font-weight: bold; margin-top: 15px;">
                            Go to Dashboard
                        </a>
                    </div>
                    <div style="background-color: #f1f3f5; padding: 15px; text-align: center; font-size: 13px; color: #777;">
                        <p>Need help? Contact our support at <a href="mailto:support@tappayz.com" style="color: #4a90e2;">support@tappayz.com</a></p>
                        <p>© ' . date("Y") . ' Tappayz. All rights reserved.</p>
                    </div>
                </div>
            </div>
        ';

        sendCustomMail($request->email, 'Welcome to Tappayz!', $html);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
