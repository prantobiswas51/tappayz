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

<body class="font-sans antialiased">
    <div class="app min-h-screen bg-gray-100">

        <aside class="sidebar bg-gray-300 text-gray-700" style="background-color: aliceblue !important;">
            <div class="brand">
                <div class="brand-badge"></div>
                <div>Tappayz</div>
            </div>

            <nav class="nav flex flex-col">
                <a class="hover:text-green-600 hover:bg-gray-300/30 active py-4 border-gray-400/50 border px-2 rounded-md  flex"
                    href="{{ route('dashboard') }}">
                    <x-heroicon-o-queue-list class="h-6 w-6 mr-2" /> Dashboard
                </a>
                <a class="hover:text-green-600 py-4 flex" href="{{ route('cards') }}">
                    <x-heroicon-o-credit-card class="h-6 w-6 mr-2" /> Cards
                </a>
                <a class="hover:text-green-600 py-4 flex" href="{{ route('transactions') }}">
                    <x-heroicon-o-document-text class="h-6 w-6 mr-2" /> Transactions
                </a>
                <a class="hover:text-green-600 py-4 flex" href="{{ route('fundings') }}">
                    <x-heroicon-o-banknotes class="h-6 w-6 mr-2" /> Funding
                </a>
                <a class="hover:text-green-600 py-4 flex" href="{{ route('kyc') }}">
                    <x-heroicon-o-document-currency-dollar class="h-6 w-6 mr-2" />KYC
                </a>
                <a class="hover:text-green-600 py-4 flex" href="{{ route('settings') }}">
                    <x-heroicon-o-cog-6-tooth class="h-6 w-6 mr-2" />Settings
                </a>
                <a class="hover:text-green-600 py-4 flex" href="{{ route('contact') }}">
                    <x-heroicon-o-phone class="h-6 w-6 mr-2" />Support
                </a>
            </nav>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn">Logout</button>
                </form>
            </div>
        </aside>

        <main class="min-h-screen bg-white">
            {{ $slot }}
        </main>
    </div>
</body>

</html>