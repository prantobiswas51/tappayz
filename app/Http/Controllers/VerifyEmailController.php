<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->where('remember_token', $request->token)
                    ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid verification link.');
        }

        $user->email_verified_at = now();
        $user->remember_token = null; // Clear token after verification
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
    }
}
