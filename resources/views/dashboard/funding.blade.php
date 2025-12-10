<x-app-layout>

    <main class="main bg-sky-400 p-2" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Funding</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Manage your account funding and payments</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2  p-2" style="gap: 20px; margin-bottom: 20px;">

            <!-- Crypto Instant Deposit -->
            <div class="card p-6">
                <div class="card-header">
                    <div class="card-title" style="color: #333;">Instant Method</div>
                </div>

                <div class="">
                    <div class="card-title" style="color: #ff6b35;">₿ Crypto Deposit</div>
                    <div class="help" style="color: #6c757d;">Instant crypto deposit to your wallet</div>

                    <form id="crypto-form" method="POST" action="{{ route('check_deposit') }}">

                        @csrf
                        <input type="hidden" value="{{ Auth::id() }}" name="user_id">

                        <div class="field" style="margin-top:10px;">
                            <label class="label" style="color: #6c757d;">Select Cryptocurrency</label>
                            <select id="crypto-select" name="currency" class="rounded-lg border-gray-300 p-2 border">
                                <option value="TRX">USDT (TRC-20)</option>
                            </select>
                        </div>

                        <div class="field" style="margin-top:10px;">
                            <label class="label" style="color: #6c757d;">Deposit Address</label>
                            <div style="display: flex; gap: 8px;">
                                <input id="deposit_address" readonly value="{{ $trx_address ?? "" }}"
                                    class="rounded-lg border-gray-300 border w-full text-gray-700" />
                                <button type="button" class="btn btn-ghost copy-btn" data-copy="address">Copy</button>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label mt-2" style="color: #6c757d;">Scan here if needed</label>
                            <div id="qr-code" class="items-center flex justify-center" style="margin-top:10px;">
                                @if($trx_address)
                                    {!! QrCode::size(150)->generate($trx_address); !!}
                                @endif
                            </div>
                        </div>

                        <div class="field" style="margin-top:10px;">
                            <label class="label" style="color: #6c757d;">Enter Your Transaction ID</label>
                            <input type="text" name="tx_id" required placeholder="Ex. Transaction hash or id"
                                class="rounded-lg border-gray-300 border" />
                        </div>

                        <div class="field" style="margin-top:10px;">
                            <div class="help" style="color: #6c757d; font-size: 12px;">
                                <strong>How it works:</strong><br>
                                1. Minimum deposit: $10<br>
                                2. Sent to this address then enter the tx id to check the deposit. <br>
                                3. Put the transaction ID immediately after sending. <br>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-brand mt-4">💰 Check Payment</button>
                    </form>

                </div>
            </div>

            {{-- Manual Payment --}}
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-header">
                    <div class="card-title" style="color: #333;">Manual Payment</div>
                </div>

                <form class="form transaction-form" method="POST" enctype="multipart/form-data"
                    action="{{ route('manual_payment') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="field">
                            <label class="label" for="payment-method" style="color: #6c757d;">Payment Method
                                <span style="color: #dc3545;">*</span>
                            </label>
                            <select class="rounded-lg border-gray-300 p-2 border" id="payment-method" required
                                name="payment_method">
                                <option value="">Select Payment Method</option>
                                <option value="payoneer">Payoneer</option>
                                <option value="paypal">Paypal</option>
                                <option value="skrill">Skrill</option>
                            </select>
                        </div>

                        <div class="field my-3"
                            style="margin-top:10px; color:#6c757d; display: flex; align-items: center; gap: 8px;">
                            Sent to : <div id="show_msg" style="flex: 1;"></div>
                            <span id="copy_btn" style="cursor:pointer; color:#007bff; display:none;">Copy</span>
                        </div>


                        <div class="field">
                            <label class="label" for="amount" style="color: #6c757d;">Amount <span
                                    style="color: #dc3545;">*</span></label>
                            <input class="rounded-lg border-gray-300 border" id="amount" type="number" step="0.01"
                                min="1" placeholder="0.00" name="amount" />
                        </div>

                        <div class="field">
                            <label class="label" for="transaction-id" style="color: #6c757d;">Transaction ID/Reference
                                <span style="color: #dc3545;">*</span></label>
                            <input class="rounded-lg border-gray-300 border" id="transaction-id" type="text"
                                name="tx_id" placeholder="Enter transaction ID or reference" required />
                        </div>

                        <div class="field" style="grid-column: 1 / -1;">
                            <label class="label" for="screenshot" style="color: #6c757d;">Payment
                                Screenshot/Proof</label>
                            <div class="file-input">
                                <span>Choose File</span>
                                <input class="rounded-lg border-gray-300 border w-full hover:cursor-pointer p-2"
                                    required id="screenshot" type="file" accept="image/*" name="screenshot" />

                            </div>
                            <div class="help" style="color: #6c757d;">Upload screenshot or proof of payment (optional
                                but recommended)</div>
                        </div>

                        <div class="field mt-2">
                            <label class="label" for="notes" style="color: #6c757d;">Additional Notes</label>
                            <textarea class="rounded-lg border-gray-300 border" id="notes" rows="3" name="notes"
                                placeholder="Any additional information about the payment..."></textarea>
                        </div>
                    </div>

                    <div style="display:flex; gap:10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-brand">Submit Transaction</button>
                        <button type="reset" class="btn btn-ghost">Clear Form</button>
                    </div>
                </form>
            </div>


        </div>

        <div class="card" style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div class="card-header">
                <div class="card-title" style="color: #333;">Recent Transactions</div>
                <a class="btn" href="{{ route('transactions') }}">View all</a>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Merchant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Transaction ID</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                        {{-- dynamic transactions --}}
                        @if($deposits->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No transactions found.
                            </td>
                        </tr>
                        @else
                        @foreach ($deposits as $deposit)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                        <span class="text-orange-600 font-bold text-sm">A</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $deposit->merchantName
                                            }}</div>
                                        <div class="text-sm text-gray-500">{{ $deposit->type }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{
                                \Carbon\Carbon::parse($deposit->recordTime)->format('Y-m-d h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{
                                $deposit->amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($deposit->status == 'Finish')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{
                                    $deposit->status }}</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $deposit->status == 'Approved' ? 'bg-green-100 text-green-800' : 
                                    ($deposit->status == 'Rejected' ? 'bg-red-100 text-red-800' : 
                                    ($deposit->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ $deposit->status }}
                                </span>

                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{
                                $deposit->tx_id }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const copyBtn = document.querySelector(".copy-btn");
            const depositInput = document.getElementById("deposit_address");

            copyBtn.addEventListener("click", function () {
                navigator.clipboard.writeText(depositInput.value)
                    .then(() => {
                        copyBtn.textContent = "Copied!";
                        setTimeout(() => copyBtn.textContent = "Copy", 1500);
                    })
                    .catch(() => alert("Failed to copy"));
            });
        });

        const paymentSelect = document.getElementById('payment-method');
        const msgDiv = document.getElementById('show_msg');
        const copyBtn = document.getElementById('copy_btn');

        paymentSelect.addEventListener('change', function() {
            let message = '';

            @php

            $payoneer_email = \App\Models\Setting::value('payoneer_email');
            $paypal_email = \App\Models\Setting::value('paypal_email');
            $skrill_email = \App\Models\Setting::value('skrill_email');

            @endphp

            switch (this.value) {
            case 'payoneer':
                message = '{{ $payoneer_email }}';
                break;
            case 'paypal':
                message = '{{ $paypal_email }}';
                break;
            case 'skrill':
                message = '{{ $skrill_email }}';
                break;
            default:
                message = '';
            }

            msgDiv.textContent = message;
            copyBtn.style.display = message ? 'inline' : 'none';
        });

        copyBtn.addEventListener('click', () => {
            if (msgDiv.textContent.trim() !== '') {
            navigator.clipboard.writeText(msgDiv.textContent.trim());
            copyBtn.textContent = 'Copied!';
            setTimeout(() => copyBtn.textContent = 'Copy', 1500);
            }
        });
    </script>


</x-app-layout>