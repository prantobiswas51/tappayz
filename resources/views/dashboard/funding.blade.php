<x-app-layout>
    <main class="main" style="background: white; color: #333;">


        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>
                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Funding</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Manage your account funding and payments</p>
                </div>
            </div>
        </div>
        <!-- Manual Payment Methods and Transaction Form -->
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
                    <form action="{{ route('deposit') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" value="{{ Auth::id() }}" name="user_id">

                        {{-- currency --}}
                        <div class="field" style="margin-top:10px;">
                            <label class="label" style="color: #6c757d;">Select Cryptocurrency</label>
                            <select class="input" id="crypto-select" name="currency"
                                style="background: white; border: 1px solid #e9ecef; color: #333;">
                                <option value="USDT">USDT (Tether)</option>
                                <option value="USDC">USDC (USD Coin)</option>
                                <option value="TRX">TRX (TRON)</option>
                                <option value="BTC">BTC (Bitcoin)</option>
                            </select>
                        </div>

                        {{-- amount field --}}
                        <div class="field">
                            <label class="label" style="color: #6c757d;">Deposit Amount</label>
                            <input class="input" id="crypto-amount" type="number" value="10" min="1" name="amount"
                                style="background: white; border: 1px solid #e9ecef; color: #333;" />
                        </div>

                        <div class="field">
                            <label class="label" style="color: #6c757d;">Tappayz Deposit Address</label>
                            <div style="display: flex; gap: 8px;">
                                <input class="input" id="deposit-address" value="{{ Auth::user()->trx_address }}"
                                    readonly
                                    style="background: white; border: 1px solid #e9ecef; color: #333; flex: 1;" />
                                <button class="btn btn-ghost copy-btn"
                                    data-address="{{ Auth::user()->trx_address }}">Copy</button>
                            </div>
                        </div>

                        <div class="field">
                            <div class="help" style="color: #6c757d; font-size: 12px;">
                                <strong>How it works:</strong><br>
                                1. Send crypto to our address above<br>
                                2. Our TronScan API monitors the transaction<br>
                                3. Funds are instantly added to your balance<br>
                                4. Minimum deposit: $10 equivalent. <br>
                                5. Wait 1 minute before clicking "💰 Payment Sent!" button after sending the payment!
                            </div>
                        </div>


                        <button type="submit" class="btn btn-brand" id="open_deposit"
                            style="width: 100%; margin-top: 10px;">
                            💰 Payment Sent!
                        </button>
                    </form>

                    <!-- Status indicator -->
                    <div id="crypto-status"
                        style="display: none; margin-top: 10px; padding: 12px; background: #e3f2fd; border: 1px solid #2196f3; border-radius: 8px; text-align: center;">
                        <div style="color: #1976d2; font-weight: 600; margin-bottom: 8px;">
                            ⏳ Monitoring Transaction...
                        </div>
                        <div style="color: #666; font-size: 14px;">
                            Please wait while we verify your transaction on the blockchain
                        </div>
                        <div style="margin-top: 8px;">
                            <div
                                style="display: inline-block; width: 20px; height: 20px; border: 2px solid #2196f3; border-top: 2px solid transparent; border-radius: 50%; animation: spin 1s linear infinite;">
                            </div>
                        </div>
                    </div>

                    <style>
                        @keyframes spin {
                            0% {
                                transform: rotate(0deg);
                            }

                            100% {
                                transform: rotate(360deg);
                            }
                        }
                    </style>
                </div>
            </div>

            <!-- Transaction Submission Form -->
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-header">
                    <div class="card-title" style="color: #333;">Manual Payment</div>
                </div>

                <form class="form transaction-form" id="transaction-form">
                    <div class="form-grid">
                        <div class="field">
                            <label class="label" for="payment-method" style="color: #6c757d;">Payment Method <span
                                    style="color: #dc3545;">*</span></label>
                            <select class="input" id="payment-method" required
                                style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                                <option value="">Select Payment Method</option>
                                <option value="payoneer">Payoneer</option>
                            </select>
                        </div>

                        <div class="field">
                            <label class="label" for="amount" style="color: #6c757d;">Amount <span
                                    style="color: #dc3545;">*</span></label>
                            <input class="input" id="amount" type="number" step="0.01" min="1" placeholder="0.00"
                                required style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
                        </div>

                        <div class="field">
                            <label class="label" for="currency" style="color: #6c757d;">Currency <span
                                    style="color: #dc3545;">*</span></label>
                            <select class="input" id="currency" required
                                style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                                <option value="">Select Currency</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                                <option value="BDT">BDT</option>
                            </select>
                        </div>

                        <div class="field">
                            <label class="label" for="transaction-id" style="color: #6c757d;">Transaction ID/Reference
                                <span style="color: #dc3545;">*</span></label>
                            <input class="input" id="transaction-id" type="text"
                                placeholder="Enter transaction ID or reference" required
                                style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
                        </div>

                        <div class="field" style="grid-column: 1 / -1;">
                            <label class="label" for="screenshot" style="color: #6c757d;">Payment
                                Screenshot/Proof</label>
                            <div class="file-input">
                                <input class="input" id="screenshot" type="file" accept="image/*" />
                                <span>Choose File</span>
                            </div>
                            <div class="help" style="color: #6c757d;">Upload screenshot or proof of payment (optional
                                but recommended)</div>
                        </div>

                        <div class="field" style="grid-column: 1 / -1;">
                            <label class="label" for="notes" style="color: #6c757d;">Additional Notes</label>
                            <textarea class="input" id="notes" rows="3"
                                placeholder="Any additional information about the payment..."
                                style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"></textarea>
                        </div>
                    </div>

                    <div class="field" id="submission-status" style="display: none;">
                        <div class="card"
                            style="background: rgba(46, 230, 168, 0.1); border: 1px solid var(--success); padding: 12px;">
                            <div style="color: var(--success); font-size: 14px;">
                                <span id="status-message">Transaction submitted successfully!</span>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; gap:10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-brand">Submit Transaction</button>
                        <button type="reset" class="btn btn-ghost">Clear Form</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="card"
            style="margin-top: 20px; background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div class="card-header">
                <div class="card-title" style="color: #333;">Recent Submissions</div>
                <div class="card-subtitle" style="color: #6c757d;">Your recent transaction submissions</div>
            </div>

            <div id="transaction-history">
                <div class="help" style="text-align: center; padding: 20px; color: #6c757d;">No transactions submitted
                    yet</div>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', () => {
            const text = btn.getAttribute('data-address');
            navigator.clipboard.writeText(text)
                .then(() => alert('Copied: ' + text))
                .catch(err => console.error(err));
            });
        });
    </script>

</x-app-layout>