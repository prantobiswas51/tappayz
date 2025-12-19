<div class="sidebar bg-gray-300 text-gray-700">
    <div class="brand flex flex-col">
        <a href="{{ route('home') }}">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Tappayz">
            </div>
        </a>
    </div>

    <nav class="nav flex flex-col">
        <a href="{{ route('dashboard') }}"
            @class([ 'py-4 border-gray-400/50 border px-2 rounded-md flex items-center gap-2', 'text-green-600 bg-gray-500/60'=> request()->routeIs('dashboard'),
            'hover:text-green-600 hover:bg-gray-300/30' => !request()->routeIs('dashboard'),
            ])>
            <x-heroicon-o-queue-list class="h-6 w-6 mr-2" /> Dashboard
        </a>

        <a href="{{ route('cards') }}" @class([ 'py-4 flex items-center gap-2' , 'text-green-600 bg-gray-500/60'=>
            request()->routeIs('cards') || request()->is('cards/*'),
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

        <a href="{{ route('fundings') }}" @class([ 'py-4 flex items-center gap-2' , 'text-green-600 bg-gray-500/60'=>
            request()->routeIs('fundings'),
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

        <a href="{{ route('settings') }}" @class([ 'py-4 flex items-center gap-2' , 'text-green-600 bg-gray-500/60'=>
            request()->routeIs('settings'),
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
</div>