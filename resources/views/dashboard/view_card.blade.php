<x-app-layout>
    <style>
        /* Custom styles that can't be easily replaced with Tailwind */
        .card-3d {
            transform-style: preserve-3d;
        }

        .large-cloud {
            position: absolute;
            top: -20px;
            right: -30px;
            width: 120px;
            height: 80px;
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border-radius: 60px 60px 60px 60px / 40px 40px 40px 40px;
            opacity: 0.8;
        }

        .tap-text {
            background: linear-gradient(90deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    {{-- Cashout Modal --}}
    <div id="cashoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50   hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl h-[270px] bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Cash Out</h3>
                <button id="closeCashoutModal" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('card_cashout') }}" method="post" class="space-y-4">
                @csrf
                <div>
                    <label for="cashout_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Withdrawal Amount
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" id="cashout_amount" name="amount" placeholder="0.00" min="1"
                            max="{{ $card->cardBalance ?? 0 }}" step="0.01" required
                            class="w-full pl-8 pr-3 py-2 border text-gray-600 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Available: ${{ number_format($card->cardBalance ?? 0, 2) }}
                    </p>
                </div>

                <input type="hidden" name="card_id" value="{{ $card->id }}">

                <!-- Modal Footer -->
                <div class="flex space-x-3 pt-4">
                    <button type="button" id="cancelCashout"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Cash Out
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Recharge Modal --}}
    <div id="rechargeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl h-[270px] bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recharge</h3>
                <button id="closeRechargeModal" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('card_recharge') }}" method="post" class="space-y-4">
                @csrf
                <div>
                    <label for="recharge_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Recharge Amount
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" id="recharge_amount" name="amount" placeholder="0.00" min="1" required
                            class="w-full pl-8 pr-3 py-2 border text-gray-600 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Available: ${{ number_format($card->cardBalance ?? 0, 2) }}
                    </p>
                </div>

                <input type="hidden" name="card_id" value="{{ $card->id }}">

                <!-- Modal Footer -->
                <div class="flex space-x-3 pt-4">
                    <button type="button" id="cancelRechargeModal"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Recharge
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-gray-700 ">
        <!-- Header Section -->
        <div class="text-gray-700 px-6 py-4 mb-6">

            <div class="">
                <div class="flex items-center  justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Card Details</h1>
                        <p class="text-gray-400">Manage your virtual card and view transactions</p>
                    </div>
                    <div class="flex space-x-3">

                        <a href="{{ route('cards') }}"
                            class="bg-gray-800 backdrop-blur-sm hover:bg-gray-700/30 text-white px-4 py-2 rounded-lg transition-colors">
                            ← Back to Cards
                        </a>
                    </div>
                </div>



            </div>
        </div>

        <!-- Main Content -->
        <div class=" px-6 ">

            {{-- buttons --}}
            <div class="lg:col-span-2 mb-6 flex flex-col mt-6 justify-end space-y-6">
                {{-- action cards --}}
                <div class=" flex gap-3 max-w-sm justify-evenly">
                    
                    <button id="openRechargeModal" class="p-2 rounded-lg bg-gray-300 hover:bg-amber-300" @if($card->state == 2) disabled
                        @endif>
                        Recharge
                    </button>

                    <button class="p-2 rounded-lg bg-gray-300 hover:bg-amber-300" id="openCashoutModal" @if($card->state == 2) disabled @endif>
                        Cash Out
                    </button>

                    @if($card->state == 2)

                    <form class="p-2 rounded-lg bg-gray-300 border hover:bg-amber-300"
                        action="{{ route('unfreeze_card') }}" method="post">

                        @csrf

                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                        <button type="submit">Unfreeze</button>
                    </form>
                    @else

                    <form class="p-2 rounded-lg bg-gray-300 border hover:bg-amber-300"
                        action="{{ route('freeze_card') }}" method="post">
                        @csrf
                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                        <button type="submit">Freeze</button>
                    </form>
                    @endif

                    <form class="p-2 rounded-lg bg-gray-300 border hover:bg-amber-300"
                        action="{{ route('cancel_card') }}" method="post">

                        @csrf

                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                        <button type="submit" @if($card->state == 2) disabled @endif>Cancel Card</button>
                    </form>

                </div>
            </div>

            {{-- Card Design --}}
            <div class=" ">
                <div
                    class="card-3d w-96 h-56 {{ $card->state == 2 ? 'filter grayscale' : '' }} transition-transform duration-600 hover:rotate-y-1 hover:rotate-x-1">
                    <div class="bg-white rounded-3xl shadow-lg p-8 relative overflow-hidden">
                        <!-- Large Cloud Background -->
                        <div
                            class="large-cloud absolute -top-5 -right-8 w-30 h-20 bg-gradient-to-br from-red-600 to-red-500 opacity-80">
                        </div>

                        <!-- Card Content -->
                        <div class="relative z-10 h-full flex flex-col">
                            <!-- Top Section -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center">
                                    <div class="flex items-center font-bold font-sans">
                                        <img src="{{ asset('images/logo.png') }}" class="w-24" alt="">
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <div class="w-5 h-5 bg-red-600 rounded-full"></div>
                                    <div class="w-5 h-5 bg-orange-500 rounded-full -ml-2"></div>
                                </div>
                            </div>

                            <!-- Middle Section - Card Number -->
                            <div class="flex justify-between flex-1">
                                <div class="text-black font-mono tracking-wider font-normal text-xl whitespace-nowrap">
                                    {{ substr($card->number, 0, 4) }} {{ substr($card->number, 4, 4) }} {{
                                    substr($card->number, 8, 4) }} {{ substr($card->number, 12, 4) }}
                                    <span
                                        class="text-xs cursor-pointer border p-2 rounded-md text-blue-600 hover:text-blue-800 ml-2"
                                        onclick="copyCardNumber('{{ $card->number }}')">Copy</span>
                                </div>
                            </div>

                            <!-- Bottom Section -->
                            <div class="flex justify-between items-end">
                                <div>
                                    <div class="text-lg font-bold text-black my-2">{{ strtoupper(Auth::user()->name)
                                        }}</div>
                                    <div class="text-xs text-gray-600 font-medium mt-1">VALID THRU</div>
                                    <div class="text-lg text-black font-mono font-normal tracking-wide">{{
                                        $card->expiryDate ?? '01/28' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-600 font-medium">CVV</div>
                                    <div
                                        class="text-sm text-black bg-black bg-opacity-5 px-2 py-1 rounded font-mono font-normal tracking-wide">
                                        {{ $card->cvv ?? '789' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" max-w-sm my-3">
                <div class="p-2 flex justify-between">
                    <div class="">Card Balance</div>
                    <div class="flex">${{ number_format($card->cardBalance ?? null, 2) }}
                        <a class=" ml-2" href="{{ route('update_balance', $card->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25"
                                role="img" aria-label="Sync">
                                <g class="spin" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 12a9 9 0 1 1-3.51-7.13" />
                                    <polyline points="21 3 21 9 15 9" />
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="p-2 flex justify-between">
                    <div class="">Card Status</div>
                    <div class="">
                        @php
                        $state = $card->state ?? 1;
                        @endphp
                        {{ $state == 1 ? 'Active' : ($state == 2 ? 'Frozen' : 'Canceled') }}
                    </div>

                </div>

                <div class="p-2 flex justify-between">
                    <div class="">Total Spend</div>
                    <div class="">${{ number_format($card->totalConsume ?? null, 2) }}</div>
                </div>


            </div>

            <!-- Transaction History Table -->
            <div class="bg-white  shadow-lg overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            Recent Card Transactions
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto border border-gray-300">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Merchant</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            {{-- dynamic transactions --}}
                            @if($thisCardTransactions->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-4  whitespace-nowrap text-sm text-gray-500 text-center">
                                    No transactions found.
                                </td>
                            </tr>
                            @else
                            @foreach ($thisCardTransactions as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            <span class="text-orange-600 font-bold text-sm">A</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $transaction->merchantName
                                                }}</div>
                                            <div class="text-sm text-gray-500">{{ $transaction->type }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{
                                    \Carbon\Carbon::parse($transaction->recordTime)->format('Y-m-d h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{
                                    $transaction->amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->status == 'Finish')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{
                                        $transaction->status }}</span>
                                    @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{
                                        $transaction->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{
                                    $transaction->vcc_id }}</td>
                            </tr>
                            @endforeach
                            @endif


                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

    <script>
        function copyCardNumber(cardNumber) {
            navigator.clipboard.writeText(cardNumber).then(function() {
                // Show success message
                const span = event.target;
                const originalText = span.textContent;
                span.textContent = 'Copied!';
                span.classList.add('text-green-600');
                
                setTimeout(function() {
                    span.textContent = originalText;
                    span.classList.remove('text-green-600');
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('Failed to copy card number');
            });
        }

        // Cashout Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('cashoutModal');
            const openButton = document.getElementById('openCashoutModal');
            const closeButton = document.getElementById('closeCashoutModal');
            const cancelButton = document.getElementById('cancelCashout');

            openButton.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            closeButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            cancelButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            // Close modal when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });

        // Recharge Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('rechargeModal');
            const openButton = document.getElementById('openRechargeModal');
            const closeButton = document.getElementById('closeRechargeModal');
            const cancelButton = document.getElementById('cancelRechargeModal');

            openButton.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            closeButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            cancelButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            // Close modal when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });
    </script>
</x-app-layout>