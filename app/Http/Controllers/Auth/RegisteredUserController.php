<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Process;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required'],
            'country' => ['required'],
            'terms' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'g-recaptcha-response' => ['required', function ($attribute, $value, $fail) {
                $recaptcha = new ReCaptcha(config('services.recaptcha.secret_key'));

                $response = $recaptcha
                    ->setExpectedAction('register')
                    ->setScoreThreshold(0.5)
                    ->verify($value, request()->ip());

                if (!$response->isSuccess()) {
                    $fail('reCAPTCHA verification failed.');
                }
            }],
        ]);

         $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(40),
        ]);

        // Generate verification link
        $verifyUrl = URL::to('/email-check?token=' . $user->remember_token . '&email=' . urlencode($user->email));

        // Email content
        $html = '
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6;">
                <tr>
                    <td align="center" style="padding: 40px 20px;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" 
                            style="background-color: #ffffff; border-radius: 12px; 
                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">

                            <!-- Header -->
                            <tr>
                                <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                    padding: 40px 30px; text-align: center;">
                                    <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">
                                        Tappayz Limited
                                    </h1>
                                    <p style="margin: 8px 0 0 0; color: #e0e7ff; font-size: 14px; font-weight: 400;">
                                        Welcome to our platform, ' . e($user->name) . '
                                    </p>
                                </td>
                            </tr>
                            
                            <!-- Content -->
                            <tr>
                                <td style="padding: 40px 30px;">
                                    <h2 style="margin: 0 0 20px 0; color: #1f2937; font-size: 24px; font-weight: 600;">
                                        Activate Your Account
                                    </h2>
                                    
                                    <p style="margin: 0 0 20px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                        Thank you for registering with 
                                        <strong style="color: #667eea;">Tappayz Limited</strong>! We\'re excited to have you on board.
                                    </p>
                                    
                                    <p style="margin: 0 0 30px 0; color: #4b5563; font-size: 16px; line-height: 1.6;">
                                        To complete your registration and start using your account, click the button below:
                                    </p>
                                    
                                    <!-- Activation Button -->
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td align="center" style="padding: 0 0 30px 0;">
                                                <a href="' . e($verifyUrl) . '" 
                                                    style="display: inline-block; padding: 16px 40px; 
                                                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                                    color: #ffffff; text-decoration: none; border-radius: 8px; 
                                                    font-weight: 600; font-size: 16px; 
                                                    box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3); 
                                                    transition: all 0.3s ease;">
                                                    Activate Account
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <!-- Alternative Link -->
                                    <p style="margin: 0 0 30px 0; color: #6b7280; font-size: 14px; 
                                        line-height: 1.6; text-align: center;">
                                        Or copy and paste this link into your browser:<br>
                                        <a href="' . e($verifyUrl) . '" 
                                            style="color: #667eea; text-decoration: underline; word-break: break-all;">
                                            ' . e($verifyUrl) . '
                                        </a>
                                    </p>
                                    
                                    <!-- Info Box -->
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td style="background-color: #f0f9ff; border-left: 4px solid #667eea; 
                                                padding: 20px; border-radius: 6px;">
                                                <p style="margin: 0; color: #1e40af; font-size: 14px; line-height: 1.6;">
                                                    <strong>⚠️ Important:</strong> This activation link will expire in 24 hours. 
                                                    If you didn\'t create an account with us, you can safely ignore this email.
                                                </p>
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            
                            <!-- Footer -->
                            <tr>
                                <td style="background-color: #f9fafb; padding: 30px; text-align: center; 
                                    border-top: 1px solid #e5e7eb;">
                                    <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 14px;">
                                        Need help? Contact us at 
                                        <a href="mailto:support@tappayz.com" 
                                            style="color: #667eea; text-decoration: none;">
                                            support@tappayz.com
                                        </a>
                                    </p>

                                    <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                        © ' . date("Y") . ' Tappayz Limited. All rights reserved.
                                    </p>

                                    <p style="margin: 15px 0 0 0; color: #9ca3af; font-size: 12px;">
                                        This is an automated email, please do not reply.
                                    </p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
            ';


        sendCustomMail($request->email, 'Verify Your Email - Tappayz', $html);

        return redirect()->route('check_mail')->with('success', 'Please check your email to verify your account.');
    }
}
