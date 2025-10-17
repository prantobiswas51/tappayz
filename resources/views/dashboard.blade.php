<x-app-layout>

    <main class="main min-h-screen" style="background: white; color: #333;">
        
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>
                <div>Overview | {{ Auth::user()->name }} </div>
            </div>
            <input class="input search" placeholder="Search…"
                style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
        </div>
        <section class="grid grid-4" style="max-width: 800px; margin: 0;">
            <div class="widget kpi" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333; padding: 16px;">
                <div class="label" style="color: #6c757d; font-size: 12px;">Total Balance</div>
                <div class="value" style="color: #28a745; font-weight: 700; font-size: 18px;">${{ Auth::user()->balance }} </div>
            </div>
            <div class="widget kpi" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333; padding: 16px;">
                <div class="label" style="color: #6c757d; font-size: 12px;">Active Cards</div>
                <div class="value" style="color: #007bff; font-weight: 700; font-size: 18px;">{{ $activeCardsCount }}</div>
            </div>
            <div class="widget kpi" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333; padding: 16px;">
                <div class="label" style="color: #6c757d; font-size: 12px;">Spending (30d)</div>
                <div class="value" style="color: #fd7e14; font-weight: 700; font-size: 18px;">$4,902.55</div>
            </div>
            <div class="widget kpi" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333; padding: 16px;">
                <div class="label" style="color: #6c757d; font-size: 12px;">Pending Authorizations</div>
                <div class="value" style="color: #ffc107; font-weight: 700; font-size: 18px;">3</div>
            </div>
        </section>

        <section class="grid grid-1" style="margin-top:16px;">
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-header">
                    <div class="card-title" style="color: #333;">Recent Transactions</div>
                    <a class="btn" href="transactions.html">View all</a>
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

                            {{-- dynamic transactions --}}
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
    </main>

</x-app-layout>