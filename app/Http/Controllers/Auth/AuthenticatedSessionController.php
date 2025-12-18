<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || is_null($user->email_verified_at)) {

            // Generate token if not exists
            if (!$user->email_verification_token) {
                $user->update([
                    'email_verification_token' => Str::random(64),
                ]);
            }
            // Secure signed verification URL (Laravel default way)
            $verifyUrl = URL::temporarySignedRoute('verify',
                Carbon::now()->addMinutes(10),
                [
                    'token' => $user->email_verification_token,
                    'email' => $user->email,
                ]
            );

            // Email HTML (your template)
            $html = '
            <table role="presentation" width="100%" style="background-color:#f3f4f6;">
                <tr>
                    <td align="center" style="padding:40px 20px;">
                        <table width="600" style="background:#ffffff;border-radius:12px;box-shadow:0 4px 6px rgba(0,0,0,.1);">
                            
                            <tr>
                                <td style="background:linear-gradient(135deg,#667eea,#764ba2);padding:40px;text-align:center;">
                                    <h1 style="color:#fff;margin:0;">Tappayz Limited</h1>
                                    <p style="color:#e0e7ff;">Welcome, ' . e($user->name) . '</p>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:40px;">
                                    <h2>Activate Your Account</h2>
                                    <p>Click the button below to verify your email:</p>

                                    <div style="text-align:center;margin:30px 0;">
                                        <a href="' . e($verifyUrl) . '" 
                                        style="padding:16px 40px;background:#667eea;color:#fff;text-decoration:none;border-radius:8px;font-weight:600;">
                                        Activate Account
                                        </a>
                                    </div>

                                    <p style="font-size:14px;color:#6b7280;text-align:center;">
                                        Or copy this link:<br>
                                        <a href="' . e($verifyUrl) . '">' . e($verifyUrl) . '</a>
                                    </p>

                                    <p style="font-size:14px;color:#1e40af;background:#f0f9ff;padding:15px;border-left:4px solid #667eea;">
                                        ⚠️ Link expires in 24 hours.
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:center;padding:20px;font-size:12px;color:#9ca3af;">
                                    © ' . date('Y') . ' Tappayz Limited
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>';

            // Send mail
            sendCustomMail(
                to: $user->email,
                subject: 'Verify Your Email - Tappayz',
                htmlContent: $html
            );

            return back()->withErrors([
                'email' => 'Please verify your email before login. Check your Inbox or Spam for the verification link.',
            ]);
        }

        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
