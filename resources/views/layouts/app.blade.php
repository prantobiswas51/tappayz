<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/fev.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/fev.ico') }}">

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


    <style>
        /* Hide sidebar on small screens */
        @media (max-width: 870px) {
            #sidebar_id {
                display: none;
            }

            #mobile_bottom_nav {
                display: flex;
            }

            #chatway_widget_trigger {
                margin-bottom: 60px;
            }
        }

        /* Show sidebar on larger screens */
        @media (min-width: 871px) {
            #mobile_bottom_nav {
                display: none;
            }

            
        }
    </style>


    <div class="app min-h-screen bg-gray-100">

        @include('layouts.aside')

        {{-- mobile nav bottom --}}
        <div id="mobile_bottom_nav" class="p-2 py-4 bg-gray-900 bottom-0 fixed flex justify-evenly w-full">
            <a href="{{ route('dashboard') }}">
                <x-heroicon-o-queue-list class="h-8 w-8 mr-2" />
            </a>
            <a href="{{ route('cards') }}">
                <x-heroicon-o-credit-card class="h-8 w-8 mr-2" />
            </a>
            <a href="{{ route('transactions') }}">
                <x-heroicon-o-document-text class="h-8 w-8 mr-2" />
            </a>
            <a href="{{ route('fundings') }}">
                <x-heroicon-o-banknotes class="h-8 w-8 mr-2" />
            </a>
            <a href="{{ route('kyc') }}">
                <x-heroicon-o-document-currency-dollar class="h-8 w-8 mr-2" />
            </a>
            <a href="{{ route('settings') }}">
                <x-heroicon-o-cog-6-tooth class="h-8 w-8 mr-2" />
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <x-heroicon-o-arrow-left-on-rectangle class="h-8 w-8" />
                </button>
            </form>
        </div>

        <main class="min-h-screen bg-white">
            {{ $slot }}
        </main>
    </div>
</body>

</html>