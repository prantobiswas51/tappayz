<x-app-layout>

    <div class="">

        <div class="flex text-gray-800 pl-3 py-3">
            <div class="brand gap-3">
                <div>Overview | {{ Auth::user()->name }}</div>
            </div>
        </div>

        <section class="grid grid-cols-1 text-gray-800 gap-4 sm:grid-cols-2 lg:grid-cols-4 p-4 rounded-lg">
            <div class="border bg-gray-50 p-4 rounded-md shadow-lg">
                <div class="label font-bold" >Total Balance</div>
                <div class="value" style="color: #28a745; font-weight: 700; font-size: 18px;">${{ Auth::user()->balance
                    }}</div>
            </div>

            <div class="border bg-gray-50 p-4 rounded-md shadow-lg">
                <div class="label font-bold" >Active Cards</div>
                <div class="value" style="color: #007bff; font-weight: 700; font-size: 18px;">{{ $activeCardsCount }}
                </div>
            </div>

            <div class="border bg-gray-50 p-4 rounded-md shadow-lg">
                <div class="label font-bold" >Pending Cards</div>
                <div class="value" style="color: #fd7e14; font-weight: 700; font-size: 18px;">{{ $pendingCardsCount }}
                </div>
            </div>

            <div class="border bg-gray-50 p-4 rounded-md shadow-lg">
                <div class="label font-bold" >Frozen Cards</div>
                <div class="value" style="color: #ffc107; font-weight: 700; font-size: 18px;">{{ $freezedCardsCount }}
                </div>
            </div>
        </section>

        <section class="overflow-hidden  p-4">
            <div class="rounded-lg p-2 bg-gray-50 shadow-lg text-gray-800 border">
                
                <div class="flex items-center justify-between mb-4">
                    <div class="card-title">Recent Transactions</div>
                    <a class="btn" href="{{ route('transactions') }}">View all</a>
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


                            @if($transactions->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No transactions found.
                                </td>
                            </tr>
                            @else
                            @foreach ($transactions as $transaction)
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
        </section>
    </div>

</x-app-layout>