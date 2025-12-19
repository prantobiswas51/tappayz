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
        <div id="alertBox"
            class="flex items-center justify-between bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-xl shadow-lg max-w-md animate-fade-in">
            <span>{{ session('status') }}</span>
            <button onclick="document.getElementById('alertBox').remove()"
                class="ml-4 text-green-700 hover:text-green-900 font-bold text-2xl">X</button>
        </div>
    </div>
    @endif


    <style>
        /* GLOBAL FIX */

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Mobile */
        @media (max-width: 870px) {
            #sidebar_id {
                display: none;
            }

            .container_app {
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                width: 100%;
            }
        }

        /* Desktop */
        @media (min-width: 871px) {
            #mobile_top_nav {
                display: none;
            }

            .container_app {
                display: grid;
                grid-template-columns: minmax(0, 280px) minmax(0, 1fr);
                width: 100%;
            }
        }


        /* MOBILE DRAWER */
        #mob_sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: #1f2937;
            /* gray-800 */
            color: white;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 50;
        }

        /* OPEN STATE */
        #mob_sidebar.open {
            transform: translateX(0);
        }

        /* BACKDROP */
        #drawer_backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 40;
            display: none;
        }

        #drawer_backdrop.show {
            display: block;
        }
    </style>

    {{-- MOBILE DRAWER --}}
    <div id="mob_sidebar" class="fixed top-0 left-0 z-50 mt-12 h-[calc(100vh-3rem)] w-72
            bg-gray-900 text-gray-100 shadow-2xl
            rounded-r-2xl flex flex-col overflow-y-auto
            px-3 py-4 space-y-1">

        {{-- NAV ITEM --}}
        @php
        $item = fn ($active) => [
        'relative flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition',
        $active
        ? 'bg-emerald-600/20 text-emerald-400'
        : 'text-gray-300 hover:bg-gray-800 hover:text-emerald-400',
        ];
        @endphp

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" @class($item(request()->routeIs('dashboard')))>
            @if(request()->routeIs('dashboard'))
            <span class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r"></span>
            @endif
            <x-heroicon-o-queue-list class="h-5 w-5" />
            <span>Dashboard</span>
        </a>

        {{-- Cards --}}
        <a href="{{ route('cards') }}" @class($item(request()->routeIs('cards') || request()->is('cards/*')))>
            @if(request()->routeIs('cards') || request()->is('cards/*'))
            <span class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r"></span>
            @endif
            <x-heroicon-o-credit-card class="h-5 w-5" />
            <span>Cards</span>
        </a>

        {{-- Transactions --}}
        <a href="{{ route('transactions') }}" @class($item(request()->routeIs('transactions') ||
            request()->is('transactions/*')))>
            @if(request()->routeIs('transactions') || request()->is('transactions/*'))
            <span class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r"></span>
            @endif
            <x-heroicon-o-document-text class="h-5 w-5" />
            <span>Transactions</span>
        </a>

        {{-- Fundings --}}
        <a href="{{ route('fundings') }}" @class($item(request()->routeIs('fundings')))>
            @if(request()->routeIs('fundings'))
            <span class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r"></span>
            @endif
            <x-heroicon-o-banknotes class="h-5 w-5" />
            <span>Funding</span>
        </a>

        {{-- KYC --}}
        <a href="{{ route('kyc') }}" @class($item(request()->routeIs('kyc')))>
            @if(request()->routeIs('kyc'))
            <span class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r"></span>
            @endif
            <x-heroicon-o-document-currency-dollar class="h-5 w-5" />
            <span>KYC</span>
        </a>

        {{-- Settings --}}
        <a href="{{ route('settings') }}" @class($item(request()->routeIs('settings')))>
            @if(request()->routeIs('settings'))
            <span class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r"></span>
            @endif
            <x-heroicon-o-cog-6-tooth class="h-5 w-5" />
            <span>Settings</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-gray-800">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg
                       text-sm font-medium text-red-400
                       hover:bg-red-500/10 transition">
                <x-heroicon-o-arrow-left-on-rectangle class="h-5 w-5" />
                <span>Logout</span>
            </button>
        </form>
        

    </div>



    <div id="drawer_backdrop"></div>


    <div class="container_app  bg-amber-400 w-full">
        {{-- Sidebar (20%) --}}
        <div id="sidebar_id" class="w-full">
            @include('layouts.aside')
        </div>

        <div id="mobile_top_nav"
            class="bg-white shadow-md border-b border-gray-300 z-30 h-[50px] flex items-center justify-between px-2">
            <img id="icon_btn" src="{{ asset('images/menu.png') }}" class="max-w-8" alt="">
            <a href="{{ route('home') }}"><img id="logo_btn" src="{{ asset('images/logo.png') }}" class="h-10"
                    alt=""></a>
        </div>

        {{-- Main Content (80%) --}}
        <main class="bg-white min-h-screen right_side">
            {{ $slot }}
        </main>
    </div>

    <script>
        const iconBtn = document.getElementById('icon_btn');
    const drawer = document.getElementById('mob_sidebar');
    const backdrop = document.getElementById('drawer_backdrop');

    iconBtn.addEventListener('click', () => {
        drawer.classList.add('open');
        backdrop.classList.add('show');
    });

    backdrop.addEventListener('click', () => {
        drawer.classList.remove('open');
        backdrop.classList.remove('show');
    });
    </script>

</body>

</html>