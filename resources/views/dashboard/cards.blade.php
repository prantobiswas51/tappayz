<x-app-layout>
    <main class="main" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" >

                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Cards</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Manage your virtual cards</p>
                </div>
            </div>

            <div class="toolbar ">

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
            <div class="flex flex-col md:flex-row md:items-center gap-4 border my-2 rounded-md p-4 shadow-sm">

                <!-- Card Icon -->
                <div class="bg-white rounded-sm flex items-center justify-center md:w-auto w-full">
                    @php
                    if($card->organization == 'VISA'){
                    echo '<img src="/images/visa-a.png" alt="VISA" class="h-10 mx-auto">';
                    } else if($card->organization == 'MASTERCARD'){
                    echo '<img src="/images/mastercard.png" alt="MasterCard" class="h-10 mx-auto">';
                    } else {
                    echo '<div class="h-10 w-[55px] mx-auto"></div>';
                    }
                    @endphp
                </div>

                <!-- Card Details -->
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-4">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Card Organization</div>
                        <div class="text-sm font-medium text-gray-800">{{ $card->organization }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 mb-1">Email</div>
                        <div class="text-sm font-medium text-gray-800 break-all">
                            {{ $card->email }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 mb-1">Card Number</div>
                        <div class="text-sm font-medium text-gray-800 font-mono">
                            {{ $card->hiddenNum }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 mb-1">Expire</div>
                        <div class="text-sm font-medium text-gray-800">
                            {{ $card->hiddenDate }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 mb-1">CVV</div>
                        <div class="text-sm font-medium text-gray-800">
                            {{ $card->hiddenCvv }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 mb-1">Name on Card</div>
                        <div class="text-sm font-medium text-gray-800">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex md:justify-end justify-start mt-2 md:mt-0">
                    @if($card->state == 4)
                    <div
                        class="bg-yellow-600 text-white text-sm font-medium border border-yellow-600 px-3 py-1 rounded-lg flex items-center space-x-2 cursor-not-allowed">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Processing</span>
                    </div>
                    @else
                    <a href="{{ route('view_card', $card->id) }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium border border-blue-600 px-3 py-1 rounded-lg hover:bg-blue-50">
                        See Details
                    </a>
                    @endif
                </div>

            </div>

            @endforeach

            @endif
        </div>

    </main>
</x-app-layout>