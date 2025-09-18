<x-app-layout>
    <main class="main" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>
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

        <div class="grid grid-2">
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-header">
                    <div class="card-title" style="color: #333;">Card Information</div>
                    <div class="card-subtitle" style="color: #6c757d;">Create your virtual card with selected BIN</div>
                </div>
                <form class="form">
                    <div class="field">
                        <label class="label" for="label" style="color: #6c757d;">Card label</label>
                        <input class="input" id="label" placeholder="e.g., Marketing Team"
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
                    </div>
                    <div class="field">
                        <label class="label" for="email" style="color: #6c757d;">Email <span
                                style="color: #dc3545;">*</span></label>
                        <input class="input" id="email" type="email" placeholder="Enter your email address" required
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
                        <div class="help" style="color: #6c757d;">You can use this email to receive the corresponding
                            transaction verification code</div>
                    </div>
                    <div class="field">
                        <label class="label" for="amount" style="color: #6c757d;">Card Amount <span
                                style="color: #dc3545;">*</span></label>
                        <input class="input" id="amount" type="number" placeholder="10" min="10" step="0.01" required
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
                        <div class="help" style="color: #6c757d;">Minimum amount: $10.00</div>
                    </div>
                    <div class="field">
                        <label class="label" for="bin" style="color: #6c757d;">Card BIN</label>
                        <select class="input" id="bin"
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                            <option value="">Select a BIN</option>
                            <option value="49387519" data-price="25.00">49387519 - $25.00</option>
                            <option value="49387520" data-price="30.00">49387520 - $30.00</option>
                            <option value="537100" data-price="35.00">537100 - $35.00</option>
                            <option value="428852" data-price="40.00">428852 - $40.00</option>
                            <option value="517746" data-price="45.00">517746 - $45.00</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="label" for="currency" style="color: #6c757d;">Currency</label>
                        <select class="input" id="currency"
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                            <option>USD</option>
                            <option>EUR</option>
                            <option>GBP</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="label" for="notes" style="color: #6c757d;">Notes</label>
                        <textarea class="input" id="notes" rows="4" placeholder="Optional notes"
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;"></textarea>
                    </div>
                    <div class="field" id="validation-error" style="display: none;">
                        <div class="card"
                            style="background: rgba(255, 107, 107, 0.1); border: 1px solid var(--danger); padding: 12px;">
                            <div style="color: var(--danger); font-size: 14px;">
                                <span id="error-message">Please enter a valid amount</span>
                            </div>
                        </div>
                    </div>
                    <div class="field" id="price-display" style="display: none;">
                        <div class="card" style="background: #f8f9fa; border: 1px solid #e9ecef; padding: 12px;">
                            <div style="display: grid; gap: 8px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span class="label" style="color: #6c757d;">Card Amount:</span>
                                    <span id="card-amount" style="font-weight: 600; color: #333;">$0.00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span class="label" style="color: #6c757d;">Creation Fee:</span>
                                    <span id="selected-price" style="font-weight: 600; color: #3dd0ff;">$0.00</span>
                                </div>
                                <div
                                    style="border-top: 1px solid #e9ecef; padding-top: 8px; display: flex; justify-content: space-between; align-items: center;">
                                    <span class="label" style="font-weight: 600; color: #333;">Total:</span>
                                    <span id="total-amount"
                                        style="font-weight: 700; color: #2ee6a8; font-size: 16px;">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <a id="create-card" class="btn btn-brand" href="#">Create</a>
                        <a class="btn btn-ghost" href="cards.html">Cancel</a>
                    </div>
                </form>
            </div>
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-title" style="margin-bottom:8px; color: #333;">Preview</div>
                <div class="vcard blue">
                    <div class="brandmark"></div>
                    <div class="number" id="preview-number">5244 ••42 ••65 ••88</div>
                    <div class="meta">
                        <div id="preview-label">Marketing</div>
                        <div>12/29</div>
                    </div>
                </div>
                <div class="help" style="margin-top:10px; color: #6c757d;">
                    <div>BIN: <span id="preview-bin">Not selected</span></div>
                    <div>Fee: <span id="preview-price">$0.00</span></div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>