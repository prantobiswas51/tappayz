<x-app-layout>
    <main class="main" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>
                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Cards</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Manage your virtual cards</p>
                </div>
            </div>
            <div class="toolbar ">
                <div class="filters">
                    <div class="search-container">
                        <input class="input search-input" placeholder="Search label or last 4"
                            style="width:280px; padding-left:40px; background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
                        <div class="search-icon" style="color: #6c757d;">🔍</div>
                    </div>
                    <select class="input filter-select"
                        style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Frozen</option>
                        <option>Terminated</option>
                    </select>
                    <select class="input filter-select"
                        style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                        <option>Any Currency</option>
                        <option>USD</option>
                        <option>EUR</option>
                        <option>GBP</option>
                    </select>
                </div>
                <a class="btn btn-brand create-btn" href="{{ route('show_bins') }}">
                    <span>+</span>
                    <span>Create Card</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl  border-gray-200 shadow-sm">

            @if($mycards->isEmpty())

            <p class="text-gray-500 p-4 px-6">No cards available. Please create a card.</p>

            @else

            @foreach ($mycards as $card)
            <div class="flex items-center space-x-6 border my-2 rounded-md p-4 shadow-sm">
                <!-- Card Icon -->

                <div class=" bg-white rounded-sm flex items-center justify-center">
                    @php
                    if($card->organization == 'VISA'){
                    echo '<img src="/images/visa-a.png" alt="VISA" class="h-10">';
                    } else if($card->organization == 'MASTERCARD'){
                    echo '<img src="/images/mastercard.png" alt="MasterCard" class="h-10">';
                    } else {
                    echo '<img src="/images/card.png" alt="Card" class="h-10">';
                    }
                    @endphp
                </div>

                <!-- Card Details -->
                <div class="flex-1 grid grid-cols-2 md:grid-cols-6 gap-6">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Card Type:</div>
                        <div class="text-sm font-medium text-gray-800">{{ $card->organization }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Email</div>
                        <div class="text-sm font-medium text-gray-800">{{ $card->email }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Card Number:</div>
                        <div class="text-sm font-medium text-gray-800 font-mono">{{ $card->hiddenNum }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Expire:</div>
                        <div class="text-sm font-medium text-gray-800">{{ $card->hiddenDate }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">CVV:</div>
                        <div class="text-sm font-medium text-gray-800">{{ $card->hiddenCvv }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Name in Card:</div>
                        <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('view_card', $card->id) }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors border border-blue-600 px-3 py-1 rounded-lg hover:bg-blue-50">
                        See Details
                    </a>
                </div>
            </div>
            @endforeach

            @endif
        </div>

    </main>
</x-app-layout>