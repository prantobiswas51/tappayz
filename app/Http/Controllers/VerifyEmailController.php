<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {

        $email = $request->query('email');
        $token = $request->query('token');

        // Find the user
        $user = User::where('email', $email)
            ->where('email_verification_token', $token)
            ->first();

        $user->email_verified_at = now();
        $user->save();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid verification link.',
            ]);
        }

        // If already verified
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('success', 'Your email is already verified.');
        }

        // Mark verified
        $user->email_verified_at = now();
        $user->email_verification_token = null; // Optional: remove token so link can't be reused
        $user->save();

        return redirect()->route('login')->with('success', 'Email verified successfully! You can now login.');
    }
}
