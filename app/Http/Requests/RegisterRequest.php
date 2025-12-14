<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
            'recaptcha_token' => ['required', function ($attribute, $value, $fail) {
                $this->validateRecaptcha($value, $fail);
            }],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone.required' => 'Phone number is required.',
            'country.required' => 'Please select your country.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.accepted' => 'You must agree to the Terms & Conditions and Privacy Policy.',
            'recaptcha_token.required' => 'reCAPTCHA verification failed. Please try again.',
        ];
    }

    /**
     * Validate the reCAPTCHA token.
     */
    protected function validateRecaptcha(string $token, callable $fail): void
    {
        $secretKey = config('services.recaptcha.secret_key');
        
        if (empty($secretKey)) {
            // Skip validation in development if keys not configured
            if (config('app.debug')) {
                return;
            }
            $fail('reCAPTCHA is not configured properly.');
            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!$result['success'] || $result['score'] < 0.5) {
                $fail('reCAPTCHA verification failed. Please try again.');
            }
        } catch (\Exception $e) {
            $fail('reCAPTCHA verification failed. Please try again.');
        }
    }
}
