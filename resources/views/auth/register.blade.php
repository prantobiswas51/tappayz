<x-guest-layout>

    <section class="min-h-screen flex items-center justify-center pt-12 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-black mb-2">Create Account</h2>
                <p class="text-gray-600">Join Tappayz and start using virtual cards today</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')"
                            class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input id="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            placeholder="John Doe" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')"
                            class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input id="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                            type="email" name="email" :value="old('email')" required autocomplete="username"
                            placeholder="john@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Phone Number -->
                    <div> 
                        <x-input-label for="phone" :value="__('Phone Number')"
                            class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input id="phone"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                            type="tel" name="phone" :value="old('phone')" required
                            placeholder="+1 (234) 567-890" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')"
                            class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input id="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                            type="password" name="password" required autocomplete="new-password"
                            placeholder="Create a strong password" />
                        <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters with uppercase, lowercase,
                            and number</p>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                            class="block text-sm font-medium text-gray-700 mb-2" />
                        <x-text-input id="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                            type="password" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirm your password" />
                        <x-input-error :messages="$errors->get('password_confirmation')"
                            class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Country -->
                    <div>
                        <x-input-label for="country" :value="__('Country')"
                            class="block text-sm font-medium text-gray-700 mb-2" />
                        <select id="country" name="country" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent">
                            <option value="">Select your country</option>
                            <option value="US" {{ old('country') === 'US' ? 'selected' : '' }}>United States</option>
                            <option value="CA" {{ old('country') === 'CA' ? 'selected' : '' }}>Canada</option>
                            <option value="GB" {{ old('country') === 'GB' ? 'selected' : '' }}>United Kingdom</option>
                            <option value="AU" {{ old('country') === 'AU' ? 'selected' : '' }}>Australia</option>
                            <option value="DE" {{ old('country') === 'DE' ? 'selected' : '' }}>Germany</option>
                            <option value="FR" {{ old('country') === 'FR' ? 'selected' : '' }}>France</option>
                            <option value="IT" {{ old('country') === 'IT' ? 'selected' : '' }}>Italy</option>
                            <option value="ES" {{ old('country') === 'ES' ? 'selected' : '' }}>Spain</option>
                            <option value="BD" {{ old('country') === 'BD' ? 'selected' : '' }}>Bangladesh</option>
                            <option value="IN" {{ old('country') === 'IN' ? 'selected' : '' }}>India</option>
                            <option value="PK" {{ old('country') === 'PK' ? 'selected' : '' }}>Pakistan</option>
                            <option value="other" {{ old('country') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <x-input-error :messages="$errors->get('country')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <!-- Terms -->
                    <div>
                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox" required value="1"
                                class="h-4 w-4 text-primary-blue focus:ring-primary-blue border-gray-300 rounded"
                                {{ old('terms') ? 'checked' : '' }}>
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                I agree to the
                                <a href="" class="text-primary-blue hover:text-blue-600">Terms & Conditions</a>
                                and
                                <a href="" class="text-primary-blue hover:text-blue-600">Privacy Policy</a>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('terms')" class="mt-2 text-sm text-red-500" />
                    </div>

                    <x-primary-button
                        class="w-full bg-primary-blue text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-600 transition-colors justify-center">
                        {{ __('Create Account') }}
                    </x-primary-button>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-primary-blue hover:text-blue-600 font-medium">Sign in here</a>
                        </p>
                    </div>
                </form>

                <!-- Social Register -->
                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button type="button"
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <svg class="h-5 w-5" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="currentColor"
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="currentColor"
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                <path fill="currentColor"
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            <span class="ml-2">Google</span>
                        </button>

                        <button type="button"
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12S0 5.446 0 12.073C0 18.062 4.388 23.027 10.125 23.927v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            <span class="ml-2">Facebook</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>