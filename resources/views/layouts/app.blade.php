<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cards') }}</title>
    <meta name="google-adsense-account" content="ca-pub-1076115507843658">
    <meta name="description"
        content="TapPayz offers instant virtual payment cards with 3DS support for secure online transactions. Create your card today and shop with confidence!">
    <meta name="keywords"
        content="virtual payment cards, 3DS support, secure online transactions, instant card creation, TapPayz, online shopping, digital payments, prepaid cards, virtual credit cards, secure payments">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script id="chatway" async="true" src="https://cdn.chatway.app/widget.js?id=ZiAPCuGL3IpX"></script>
</head>

<body class="font-sans antialiased">

    @if (session('status'))
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
        <div id="alertBox"
            class="flex items-center justify-between bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-xl shadow-lg max-w-md animate-fade-in">
            <span>{{ session('status') }}</span>
            <button onclick="document.getElementById('alertBox').remove()"
                class="ml-4 text-green-700 hover:text-green-900 font-bold text-2xl">X</button>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
    @endif


    <div class="app min-h-screen bg-gray-100">

        <aside class="sidebar bg-gray-300 text-gray-700" style="background-color: aliceblue !important;">
            <div class="brand flex flex-col">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Tappayz">
                </div>
                <div class="text-white">{{ Auth::user()->name }}</div>
            </div>

            <nav class="nav flex flex-col">
                <a href="{{ route('dashboard') }}"
                    @class([ 'py-4 border-gray-400/50 border px-2 rounded-md flex items-center gap-2'
                    , 'text-green-600 bg-gray-500/60'=> request()->routeIs('dashboard'),
                    'hover:text-green-600 hover:bg-gray-300/30' => !request()->routeIs('dashboard'),
                    ])>
                    <x-heroicon-o-queue-list class="h-6 w-6 mr-2" /> Dashboard
                </a>

                <a href="{{ route('cards') }}" @class([ 'py-4 flex items-center gap-2'
                    , 'text-green-600 bg-gray-500/60'=> request()->routeIs('cards') || request()->is('cards/*'),
                    'hover:text-green-600' => ! (request()->routeIs('cards') || request()->is('cards/*')),
                    ])>
                    <x-heroicon-o-credit-card class="h-6 w-6 mr-2" /> Cards
                </a>

                <a href="{{ route('transactions') }}" @class([ 'py-4 flex items-center gap-2'
                    , 'text-green-600 bg-gray-500/60'=> request()->routeIs('transactions') ||
                    request()->is('transactions/*'),
                    'hover:text-green-600' => ! (request()->routeIs('transactions') || request()->is('transactions/*')),
                    ])>
                    <x-heroicon-o-document-text class="h-6 w-6 mr-2" /> Transactions
                </a>

                <a href="{{ route('fundings') }}" @class([ 'py-4 flex items-center gap-2'
                    , 'text-green-600 bg-gray-500/60'=> request()->routeIs('fundings'),
                    'hover:text-green-600' => ! request()->routeIs('fundings'),
                    ])>
                    <x-heroicon-o-banknotes class="h-6 w-6 mr-2" /> Funding
                </a>

                <a href="{{ route('kyc') }}" @class([ 'py-4 flex items-center gap-2' , 'text-green-600 bg-gray-500/60'=>
                    request()->routeIs('kyc'),
                    'hover:text-green-600' => ! request()->routeIs('kyc'),
                    ])>
                    <x-heroicon-o-document-currency-dollar class="h-6 w-6 mr-2" />KYC
                </a>

                <a href="{{ route('settings') }}" @class([ 'py-4 flex items-center gap-2'
                    , 'text-green-600 bg-gray-500/60'=> request()->routeIs('settings'),
                    'hover:text-green-600' => ! request()->routeIs('settings'),
                    ])>
                    <x-heroicon-o-cog-6-tooth class="h-6 w-6 mr-2" />Settings
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