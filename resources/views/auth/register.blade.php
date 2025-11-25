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

               
            </div>
        </div>
    </section>

</x-guest-layout>