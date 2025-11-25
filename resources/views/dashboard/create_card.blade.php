<x-app-layout>
    <main class="main" style="background: white; color: #333;">

        <!-- Modal -->
        <div id="binModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full  max-w-lg p-6 relative overflow-y-auto"
                style="max-height: 90vh;">
                <button onclick="closeBinModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">✖</button>

                <h2 class="text-xl font-bold mb-4 text-gray-800">Create Virtual Card</h2>

                <form id="binForm" method="POST" action="{{ route('open_card') }}">
                    @csrf
                    <input type="hidden" name="bin_id" id="modal-bin-id">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <div class="mb-3 field">
                        <label class="block text-gray-600">Email <span class="text-red-600">*</span></label>
                        <span class="text-sm ">You can use this email to receive the corresponding transaction
                            verification code.</span>
                        <input type="email" id="modal-email" name="email" required
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"
                            class="w-full border rounded p-2 text-gray-800">
                    </div>

                    <div class="mb-3 field">
                        <label class="block text-gray-600">BIN</label>
                        <input type="text" id="modal-bin" name="bin" readonly
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"
                            class="w-full input border rounded p-2 bg-gray-100 text-gray-800">
                    </div>

                    <div class="mb-3 field">
                        <label class="block text-gray-600">Organization</label>
                        <input type="text" id="modal-organization" name="organization" readonly
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"
                            class="w-full border rounded p-2 bg-gray-100 text-gray-800">
                    </div>

                    <input type="hidden" id="modal-area" name="area" readonly>

                    <div class="mb-3 field">
                        <label class="block text-gray-600">Price / Rate</label>
                        <input type="text" id="modal-price" name="price" readonly
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"
                            class="w-full border rounded p-2 bg-gray-100 text-gray-800">
                    </div>

                    <div class="mb-3 field">
                        <label class="block text-gray-600">Amount<span class="text-red-600">*</span> (Min : 10$)</label>
                        <input type="text" name="amount" min="10" value="" required id="amount"
                            oninput="updateTotal()" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"
                            class="w-full border rounded p-2 bg-gray-100 text-gray-800">
                        <p class="text-red-600 text-sm ">
                            Total: <span id="total_amount">$0.00</span>
                        </p>
                    </div>

                    <div class="mb-3 field">
                        <label class="block text-gray-600">Card Holder Name <span class="text-red-600">*</span> </label>
                        <input type="text" name="card_holder" required
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"
                            class="w-full input border rounded p-2 bg-gray-100 text-gray-800">
                    </div>

                    <div class="mb-3 field">
                        <label class="block text-gray-600">Remark</label>
                        <textarea id="modal-notes" name="remark"
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"
                            class="w-full border rounded p-2 text-gray-800"></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Create Card
                    </button>
                </form>

            </div>
        </div>
        {{-- end of modal --}}

        <div class="topbar">
            <div class="brand" style="gap:8px;">

                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Create Card</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Create a new virtual card with your preferred
                        settings</p>
                </div>
            </div>
        </div>

        <!-- Card BIN Information & Terms - Collapsible -->
        <div class="card info-card"
            style="margin-bottom: 20px; background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            
            <div class="card-header" id="info-toggle">
                <div>
                    <div class="card-title" style="color: #333;">Card BIN Information & Terms</div>
                    <div class="card-subtitle" style="color: #6c757d;">Important details about your virtual card</div>
                </div>
                <div class="toggle-icon" id="toggle-icon">▶</div>
            </div>

            <div class="info-content" id="info-content">
                <div class="info-grid">
                    <!-- Supported Platforms -->
                    <div class="info-section">
                        <div class="info-title">
                            <div class="info-icon">🌐</div>
                            <span style="color: #333; font-weight: 600;">Supported Platforms</span>
                        </div>
                        <div class="platforms">
                            <span class="platform-tag">Google Pay</span>
                            <span class="platform-tag">Facebook</span>
                            <span class="platform-tag">Amazon</span>
                            <span class="platform-tag">GoDaddy</span>
                            <span class="platform-tag">TikTok</span>
                            <span class="platform-tag">+ More</span>
                        </div>
                    </div>

                    <!-- Card Specifications -->
                    <div class="info-section">
                        <div class="info-title">
                            <div class="info-icon">⚡</div>
                            <span style="color: #333; font-weight: 600;">Card Specifications</span>
                        </div>
                        <div class="specs-grid">
                            <div class="spec-item">
                                <div class="spec-label" style="color: #333; font-weight: 500;">Daily Limit</div>
                                <div class="spec-value" style="color: #333; font-weight: 600;">$800,000</div>
                            </div>
                            <div class="spec-item">
                                <div class="spec-label" style="color: #333; font-weight: 500;">Validity</div>
                                <div class="spec-value" style="color: #333; font-weight: 600;">3 Years</div>
                            </div>
                            <div class="spec-item">
                                <div class="spec-label" style="color: #333; font-weight: 500;">Rechargeable</div>
                                <div class="spec-value" style="color: #333; font-weight: 600;">Multiple Times</div>
                            </div>
                            <div class="spec-item">
                                <div class="spec-label" style="color: #333; font-weight: 500;">Use Case</div>
                                <div class="spec-value" style="color: #333; font-weight: 600;">Formal Use Only</div>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Structure -->
                    <div class="info-section">
                        <div class="info-title">
                            <div class="info-icon">💰</div>
                            <span style="color: #333; font-weight: 600;">Fee Structure</span>
                        </div>
                        <div class="fee-list">
                            <div class="fee-item">
                                <div class="fee-name" style="color: #333; font-weight: 600;">Non-payment Fee</div>
                                <div class="fee-desc" style="color: #333;">First 3 failed transactions free, then $0.30
                                    per chargeback</div>
                            </div>
                            <div class="fee-item">
                                <div class="fee-name" style="color: #333; font-weight: 600;">Cancellation Fee</div>
                                <div class="fee-desc" style="color: #333;">$1.00 per authorization cancellation</div>
                            </div>
                            <div class="fee-item">
                                <div class="fee-name" style="color: #333; font-weight: 600;">Refund Fee</div>
                                <div class="fee-desc" style="color: #333;">2% of purchase amount per refund</div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="info-section warning">
                        <div class="info-title">
                            <div class="info-icon">⚠️</div>
                            <span style="color: #333; font-weight: 600;">Important Notes</span>
                        </div>
                        <div class="warning-content">
                            <div class="warning-item" style="color: #333;">
                                <strong style="color: #333;">Chargeback Control:</strong> Card BIN prohibits malicious
                                chargebacks. Multiple chargebacks or payment failures will trigger risk control and may
                                result in card cancellation.
                            </div>
                            <div class="warning-item" style="color: #333;">
                                <strong style="color: #333;">Payment Habits:</strong> Please develop good payment
                                habits. For subscription services, log into merchant interface to complete unbinding or
                                cancellation.
                            </div>
                            <div class="warning-item" style="color: #333;">
                                <strong style="color: #333;">Hong Kong BIN:</strong> Hong Kong card BINs require 1 hour
                                wait time after card creation before normal use.
                            </div>
                            <div class="warning-item" style="color: #333;">
                                <strong style="color: #333;">Overdraft Protection:</strong> If card balance is overdrawn
                                due to non-payment, the system will automatically delete the card.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- card area --}}
        <div class="flex flex-wrap w-full ">

            <!-- Left Side -->
            <div class="card bg-sky-300 p-2 flex-1 min-w-[280px]">
                <div class="card-header mb-3">
                    <div class="card-title text-lg font-semibold text-[#333]">Card Information</div>
                    <div class="card-subtitle text-sm text-[#6c757d]">Create your virtual card with selected BIN</div>
                </div>

                <div class="cards flex flex-wrap gap-4 justify-center">
                    @foreach ($bins as $bin)
                    <div class="border  p-3 rounded-lg shadow-md min-w-[220px] flex-1 hover:cursor-pointer hover:bg-gray-200"
                    
                        onclick="openBinModal('{{ $bin->id }}', '{{ $bin->bin }}', '{{ $bin->organization }}', '{{ $bin->cr }}', '{{ $bin->actualOpenCardPrice }}/{{ $bin->actualRechargeFeeRate }}')">
                        <div class="flex justify-between items-center py-3">
                            <h3>
                                <span class="font-bold text-lg">
                                    @if($bin->bin == "428852" || $bin->bin == "517746") PREMIUM @endif
                                </span>
                                {{ $bin->bin }}
                            </h3>
                            <img class="w-16"
                                src="{{ $bin->organization == 'VISA' ? asset('images/visa-a.png') : asset('images/mastercard.png') }}"
                                alt="logo">
                        </div>
                        <p class="py-2">Price/Rate :
                            <span>@if ($bin->bin == 517746 || $bin->bin == 428852)
                                {{ $bin->actualOpenCardPrice + 8 }}$/5.00%
                                @else
                                {{ $bin->actualOpenCardPrice + 3 }}$/6.00%
                                @endif</span>
                        </p>
                        <p class="flex justify-between items-center">Area : <span>{{ __($bin->cr) }}</span> <button
                                class="border p-2 bg-green-400 rounded-md">Issue Card</button></p>
                    </div>
                    @endforeach
                </div>
            </div>



        </div>


    </main>

    <script>
        function openBinModal(id, bin, organization, area, price) {
            document.getElementById('modal-bin-id').value = id;
            let requested_bin = document.getElementById('modal-bin').value = bin;
            document.getElementById('modal-organization').value = organization;
            document.getElementById('modal-area').value = area;

            if(requested_bin == "517746" || requested_bin == "428852") {
                let price_modal_value = document.getElementById('modal-price').value = "10$ / 5.00%";
            } else {
                let price_modal_value = document.getElementById('modal-price').value = "5$ / 6.00%";
            }

            // Show modal
            document.getElementById('binModal').classList.remove('hidden');
            document.getElementById('binModal').classList.add('flex');
        }

         function updateTotal() {
            let amountInput = document.getElementById('amount');
            let requested_bin = document.getElementById('modal-bin').value; // READ ONLY

            let amount = parseFloat(amountInput.value) || 0;
            let total_amount = 0;

            if (requested_bin == "517746" || requested_bin == "428852") {
                let fee_percent = amount * 0.05;
                total_amount = amount + 10 + fee_percent;
            } else {
                let fee_percent = amount * 0.06;
                total_amount = amount + 5 + fee_percent;
            }

            document.getElementById('total_amount').innerText = "$" + total_amount.toFixed(2);
        }

        function closeBinModal() {
            document.getElementById('binModal').classList.add('hidden');
            document.getElementById('binModal').classList.remove('flex');
        }
    </script>


</x-app-layout>