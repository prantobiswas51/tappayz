<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900">

    {{-- client design --}}
     <header class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="index.html" class="text-2xl font-bold text-black"><img src="{{ asset('images/logo.png') }}" alt="Tappayz" class="w-150 h-12"></a>
                </div>
                <nav class=" md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-black font-medium">Home</a>
                    <a href="{{ route('pricing') }}" class="text-gray-700 hover:text-black font-medium">Pricing</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-black font-medium">Contact Us</a>
                </nav>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-black font-medium">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-black text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-800">Create Account</a>
                </div>
            </div>
        </div>
    </header>

    <div class="bg-gray-100">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 to-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
                <!-- Left Column - About Tappayz -->
                <div>
                    <!-- Logo and Company Name -->
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Tappayz" class="w-150 h-16">
                    </div>

                    <!-- Company Description -->
                    <div class="space-y-4 text-gray-300 leading-relaxed">
                        <p>Tappayz Limited is a leading virtual credit card issuance platform that partners with major
                            card issuers globally to provide innovative and secure virtual card services. We are
                            committed to offering efficient, reliable, and user-friendly payment solutions to both
                            enterprises and individuals.</p>
                        <p>Tappayz Limited remains dedicated to maintaining high standards of service excellence,
                            continuously refining products and services to meet evolving customer needs, and striving to
                            become a trusted, long-term payment partner worldwide.</p>
                    </div>

                    <!-- Social Media Links -->
                    <div class="flex space-x-4 mt-8">
                        <a href="#"
                            class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                            <span class="text-white font-bold">f</span>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Column - Contact Us -->
                <div>
                    <h4 class="text-2xl font-bold mb-6">Contact Us</h4>
                    <div class="space-y-4 text-gray-300">
                        <div>
                            <p class="font-semibold text-white mb-1">TG Customer Service:</p>
                            <p>@TappayzSupport</p>
                        </div>
                        <div>
                            <p class="font-semibold text-white mb-1">TG Channel:</p>
                            <p>https://t.me/tappayz</p>
                        </div>
                        <div>
                            <p class="font-semibold text-white mb-1">Email us:</p>
                            <p>support@tappayz.com</p>
                        </div>
                        <div>
                            <p class="font-semibold text-white mb-1">Company:</p>
                            <p>Tappayz Limited</p>
                        </div>
                        <div>
                            <p class="font-semibold text-white mb-1">Address:</p>
                            <p>123 Business District, Financial Center, Global City</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Legal Links and Copyright -->
            <div class="border-t border-gray-700 pt-8">
                <div class="text-center mb-6">
                    <div class="flex justify-center space-x-6 text-blue-400">
                        <a href="Service-agreement.html" class="hover:text-white transition-colors">Service
                            Agreement</a>
                        <span class="text-gray-500">|</span>
                        <a href="privacy.html" class="hover:text-white transition-colors">Privacy Policy</a>
                    </div>
                </div>

                <div class="text-center text-gray-400 mb-6">
                    <p>Copyright © 2024. Tappayz All Rights Reserved.</p>
                </div>

                <!-- Trademark Disclaimer -->
                <div class="text-xs text-gray-500 leading-relaxed max-w-4xl mx-auto">
                    <p class="mb-2">
                        "Facebook and the Facebook logo" are registered trademarks of Meta Platforms, Inc. "Google,
                        Google Ads, and the Google logo" are registered trademarks of Google, LLC. "PayPal and the
                        PayPal trademark" are registered trademarks of PayPal, Inc. "Visa" is a registered trademark of
                        Visa, USA Inc. "Mastercard" is a registered trademark of Mastercard International Incorporated.
                    </p>
                    <p>
                        Tappayz's solution may not be applicable to all customers. The terms and conditions apply and
                        may be subject to change.
                    </p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>