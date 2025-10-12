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
                        <input 
                            type="number" 
                            id="cashout_amount"
                            name="amount" 
                            placeholder="0.00" 
                            min="1" 
                            max="{{ $card->cardBalance ?? 0 }}"
                            step="0.01"
                            required
                            class="w-full pl-8 pr-3 py-2 border text-gray-600 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Available: ${{ number_format($card->cardBalance ?? 0, 2) }}
                    </p>
                </div>
                
                <input type="hidden" name="card_id" value="{{ $card->id }}">
                
                <!-- Modal Footer -->
                <div class="flex space-x-3 pt-4">
                    <button 
                        type="button" 
                        id="cancelCashout"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        Cash Out
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-gray-700">
        <!-- Header Section -->
        <div class="text-gray-700">
            <div class="px-6 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Card Details</h1>
                        <p class="text-gray-400">Manage your virtual card and view transactions</p>
                    </div>
                    <div class="flex space-x-3">

                        <a href="{{ route('cards') }}"
                            class="bg-gray-800 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors">
                            ← Back to Cards
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class=" px-6 py-8">
            <!-- Card and Action Buttons Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 ">
                <!-- Card Display -->
                <div class="lg:col-span-1 flex  ">
                    <div
                        class="card-3d w-96 h-56  relative transition-transform duration-600 hover:rotate-y-1 hover:rotate-x-1">
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
                                    <div
                                        class="text-black font-mono tracking-wider font-normal text-xl whitespace-nowrap">
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

                <!-- Action Buttons -->
                <div class="lg:col-span-2 flex flex-col  space-y-6">

                    <div class="border w-fit p-2 rounded-xl bg-primary-blue/10 text-primary-blue">
                        <a href="{{ route('update_balance', $card->id) }}">Update Balance</a>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1  md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Balance Card -->
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 p-6 border border-gray-100">
                            <div class="flex flex-col">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Available Balance</p>
                                    <p class="text-2xl font-bold text-gray-900">${{ number_format($card->cardBalance ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Spent Card -->
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 p-6 border border-gray-100">
                            <div class="flex flex-col">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Total Spent</p>
                                    <p class="text-2xl font-bold text-gray-900">${{ number_format($card->totalConsume ??
                                        549.46,
                                        2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Status -->
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 p-6 border border-gray-100">
                            <div class="flex flex-col">

                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Card Status</p>
                                    <p class="text-2xl font-bold text-emerald-600">{{ $card->state ?? 'Active' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- action cards --}}
                    <div class=" flex gap-3">
                        <button
                            class="bg-gradient-to-r rounded-[50px] from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3  transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-full">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Recharge
                        </button>

                        <button
                            id="openCashoutModal"
                            class="bg-gradient-to-r rounded-[50px] from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3  transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-full">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                            Cash Out
                        </button>

                        <button
                            class="bg-gradient-to-r rounded-[50px] from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3  transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-full">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636">
                                </path>
                            </svg>
                            Freeze
                        </button>
                        <button
                            class="bg-gradient-to-r rounded-[50px] from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-full">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Cancel Card
                        </button>
                    </div>
                </div>
            </div>



            <!-- Transaction History Table -->
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Transaction History</h2>
                            <p class="mt-1 text-sm text-gray-500">Recent activity on your virtual card</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex space-x-3">
                            <select
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option>All Status</option>
                                <option>Success</option>
                                <option>Pending</option>
                                <option>Failed</option>
                            </select>
                            <select
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option>Last 30 Days</option>
                                <option>Last 7 Days</option>
                                <option>This Month</option>
                                <option>Last Month</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
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
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            <span class="text-orange-600 font-bold text-sm">A</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Amazon</div>
                                            <div class="text-sm text-gray-500">Online Purchase</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Oct 10, 2025 14:32</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">-$89.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Success</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">TXN789123456
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-bold text-sm">T</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Top-up</div>
                                            <div class="text-sm text-gray-500">Card Recharge</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Oct 9, 2025 09:15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">+$500.00</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Success</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">TXN789123455
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <span class="text-red-600 font-bold text-sm">G</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Google Ads</div>
                                            <div class="text-sm text-gray-500">Advertising</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Oct 8, 2025 16:45</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">-$125.50</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Pending</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">TXN789123454
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <span class="text-red-600 font-bold text-sm">N</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Netflix</div>
                                            <div class="text-sm text-gray-500">Subscription</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Oct 7, 2025 12:00</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">-$15.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Success</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">TXN789123453
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <span class="text-purple-600 font-bold text-sm">S</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Shopify</div>
                                            <div class="text-sm text-gray-500">E-commerce</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Oct 6, 2025 18:22</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">-$245.00</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Failed</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">TXN789123452
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-bold text-sm">M</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Microsoft</div>
                                            <div class="text-sm text-gray-500">Office 365</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Oct 5, 2025 10:30</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">-$12.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Success</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">TXN789123451
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                            <span class="text-gray-600 font-bold text-sm">S</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Steam</div>
                                            <div class="text-sm text-gray-500">Gaming</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Oct 4, 2025 20:15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">-$59.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Success</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">TXN789123450
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer with Pagination -->
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">7</span> of <span
                                class="font-medium">23</span> transactions
                        </div>
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50"
                                disabled>
                                Previous
                            </button>
                            <button
                                class="px-3 py-1 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                1
                            </button>
                            <button
                                class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                2
                            </button>
                            <button
                                class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                3
                            </button>
                            <button
                                class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Next
                            </button>
                        </div>
                    </div>
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

        // Modal functionality
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
    </script>
</x-app-layout>