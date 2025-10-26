<x-app-layout>

    <main class="main" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Funding</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Manage your account funding and payments</p>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="gap: 20px; margin-bottom: 20px;">

            <!-- Crypto Instant Deposit -->
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-header">
                    <div class="card-title" style="color: #333;">Instant Method</div>
                </div>

                <div class="card payment-method-card"
                    style="margin-top: 10px; background: #f8f9fa; border: 1px solid #e9ecef;">
                    <div class="card-title" style="color: #ff6b35;">₿ Crypto Deposit</div>
                    <div class="help" style="color: #6c757d;">Instant crypto deposit to your wallet</div>

                    <form id="crypto-form" method="POST" action="{{ route('check_deposit') }}">

                        @csrf
                        <input type="hidden" value="{{ Auth::id() }}" name="user_id">

                        <div class="field" style="margin-top:10px;">
                            <label class="label" style="color: #6c757d;">Select Cryptocurrency</label>
                            <select id="crypto-select" name="currency" class="rounded-lg border-gray-300 border">
                                <option value="TRX">TRX (TRON, TRC-20)</option>
                            </select>
                        </div>

                        <div class="field" style="margin-top:10px;">
                            <label class="label" style="color: #6c757d;">Deposit Address</label>
                            <div style="display: flex; gap: 8px;">
                                <input id="deposit_address" readonly value="TXKeZZxtnpdMw7zup2wCJ6wSxzrNFaevNc"
                                    class="rounded-lg border-gray-300 border w-full text-gray-700" />
                                <button type="button" class="btn btn-ghost copy-btn" data-copy="address">Copy</button>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label mt-2" style="color: #6c757d;">Scan here if needed</label>
                            <div id="qr-code" class="items-center flex justify-center" style="margin-top:10px;">
                                {!! QrCode::size(150)->generate('TXKeZZxtnpdMw7zup2wCJ6wSxzrNFaevNc'); !!}
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
    </script>


</x-app-layout>