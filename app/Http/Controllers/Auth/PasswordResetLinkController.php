<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => __('passwords.user'),
            ]);
        }

        // Generate Laravel password reset token
        $token = Password::createToken($user);

        // Secure reset URL (Laravel default)
        $resetUrl = URL::route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);

        // Email HTML
        $html = '
        <table width="100%" style="background:#f3f4f6;padding:40px;">
            <tr>
                <td align="center">
                    <table width="600" style="background:#ffffff;border-radius:10px;padding:40px;">
                        <tr>
                            <td style="text-align:center;">
                                <h2>Password Reset Request</h2>
                                <p>Hello ' . e($user->name) . ',</p>
                                <p>Click the button below to reset your password.</p>

                                <a href="' . e($resetUrl) . '" 
                                style="display:inline-block;margin:30px 0;
                                padding:14px 30px;background:#667eea;color:#fff;
                                text-decoration:none;border-radius:6px;">
                                    Reset Password
                                </a>

                                <p style="font-size:14px;color:#6b7280;">
                                    This link will expire in 60 minutes.
                                </p>

                                <p style="font-size:12px;color:#9ca3af;">
                                    If you didn’t request this, ignore this email.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';

        // Send custom mail
        sendCustomMail(
            to: $user->email,
            subject: 'Reset Your Password',
            htmlContent: $html
        );

        return back()->with('status', __('passwords.sent'));
    }
}
