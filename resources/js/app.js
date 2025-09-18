import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Simple front-end store using localStorage
const CardStore = (() => {
    const STORAGE_KEY = 'tappayz.cards';
    const load = () => {
        try { return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]'); } catch { return []; }
    };
    const save = (cards) => localStorage.setItem(STORAGE_KEY, JSON.stringify(cards));
    const add = (card) => { const cards = load(); cards.unshift({ id: Date.now(), ...card }); save(cards); return cards[0]; };
    const remove = (id) => { const cards = load().filter(c => c.id !== id); save(cards); return cards; };
    const list = () => load();
    return { add, remove, list };
})();

// Utility: create element from HTML
function el(html) { const t = document.createElement('template'); t.innerHTML = html.trim(); return t.content.firstChild; }

// Render cards grid on cards.html
function renderCardsPage() {
    const grid = document.getElementById('cards-grid');
    if (!grid) return;
    grid.innerHTML = '';
    const cards = CardStore.list();
    const createCardUrl = grid.dataset.createCardUrl; // 👈 Blade route injected here
    if (!cards.length) {
        grid.appendChild(el(`
            <div class="card" style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-title" style="margin-bottom:8px; color: #333;">No cards yet</div>
                <div class="help" style="color: #6c757d;">Create your first virtual card to get started.</div>
                <a class="btn btn-brand" style="margin-top:10px;" href="${createCardUrl}">Create card</a>
            </div>
        `));
        return;
    }
    cards.forEach(c => {
        const gradient = c.theme === 'purple' ? 'linear-gradient(160deg,#c1b7ff,#9b8cff 60%,#6ee7ff)' : c.theme === 'green' ? 'linear-gradient(160deg,#8cf0cc,#2ee6a8 60%,#a9b8ff)' : '';
        const statusColor = c.frozen ? '#ffc107' : '#2ee6a8';
        const statusText = c.frozen ? 'Frozen' : 'Active';

        const row = el(`
      <div class="card-row" style="background: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; margin-bottom: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 20px;">
        <div class="left" style="display: flex; align-items: center; gap: 20px; flex: 1;">
          <div class="vcard mini blue" style="background: ${gradient || 'linear-gradient(160deg,#a9b8ff,#3dd0ff 60%,#6ee7ff)'}; border-radius: 12px; padding: 16px; min-width: 200px; height: 120px; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
            <div class="brandmark" style="width:24px;height:24px;border-radius:8px; background: rgba(255,255,255,0.2); position: absolute; top: 12px; right: 12px;"></div>
            <div class="number" style="color: white; font-size: 18px; font-weight: 600; margin-top: 20px;">${c.masked || '5244 ••42 ••65 ••88'}</div>
            <div class="meta" style="color: white; display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
              <div style="font-size: 14px; font-weight: 500;">${c.label || 'Card'}</div>
              <div style="font-size: 12px;">${c.exp || '12/29'}</div>
            </div>
          </div>
          <div class="details" style="flex: 1;">
            <div class="title" style="font-size: 18px; font-weight: 600; color: #333; margin-bottom: 8px;">${c.label || 'Untitled card'}</div>
            <div class="muted" style="color: #6c757d; font-size: 14px; margin-bottom: 12px;">Limit: ${c.currency || 'USD'} ${c.amount ? c.amount.toFixed(2) : '0.00'}</div>
            <div class="meta-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
              <div class="meta-item" style="text-align: center; padding: 8px; background: #f8f9fa; border-radius: 8px;">
                <div class="k" style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">Amount</div>
                <div class="v" style="font-weight: 600; color: #333;">$${c.amount ? c.amount.toFixed(2) : '0.00'}</div>
              </div>
              <div class="meta-item" style="text-align: center; padding: 8px; background: #f8f9fa; border-radius: 8px;">
                <div class="k" style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">Currency</div>
                <div class="v" style="font-weight: 600; color: #333;">${c.currency || 'USD'}</div>
              </div>
              <div class="meta-item" style="text-align: center; padding: 8px; background: #f8f9fa; border-radius: 8px;">
                <div class="k" style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">Status</div>
                <div class="v" style="color: ${statusColor}; font-weight: 600;">${statusText}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="actions" style="display: flex; flex-direction: column; gap: 8px;">
          <a class="btn btn-ghost" href="#" data-action="freeze" data-id="${c.id}" style="background: #f8f9fa; color: #333; border: 1px solid #e9ecef; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 14px; min-width: 100px; justify-content: center;">
            <span>❄️</span>
            <span>${c.frozen ? 'Unfreeze' : 'Freeze'}</span>
          </a>
          <a class="btn btn-ghost" href="#" data-action="reveal" data-id="${c.id}" style="background: #f8f9fa; color: #333; border: 1px solid #e9ecef; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 14px; min-width: 100px; justify-content: center;">
            <span>👁️</span>
            <span>Reveal</span>
          </a>
          <a class="btn btn-danger" href="#" data-action="terminate" data-id="${c.id}" style="background: #dc3545; color: white; border: 1px solid #dc3545; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 14px; min-width: 100px; justify-content: center;">
            <span>🗑️</span>
            <span>Terminate</span>
          </a>
        </div>
      </div>
    `);
        grid.appendChild(row);
    });

    // Bind action buttons
    grid.querySelectorAll('[data-action]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const action = btn.getAttribute('data-action');
            const id = Number(btn.getAttribute('data-id'));

            if (action === 'terminate') {
                if (confirm('Are you sure you want to terminate this card? This action cannot be undone.')) {
                    CardStore.remove(id);
                    renderCardsPage();
                }
            } else if (action === 'freeze') {
                // Toggle freeze status
                const cards = CardStore.list();
                const card = cards.find(c => c.id === id);
                if (card) {
                    card.frozen = !card.frozen;
                    CardStore.save(cards);
                    renderCardsPage();
                }
            } else if (action === 'reveal') {
                // Show card details (in a real app, this would reveal sensitive info)
                const cards = CardStore.list();
                const card = cards.find(c => c.id === id);
                if (card) {
                    alert(`Card Details:\nNumber: ${card.masked}\nBIN: ${card.bin || 'N/A'}\nExpiry: ${card.exp}\nAmount: $${card.amount || '0.00'}`);
                }
            }
        });
    });
}

// Hook up create flow on card-create.html
function initCreateCardPage() {
    const createBtn = document.getElementById('create-card');
    if (!createBtn) return;

    // BIN selection handler
    const binSelect = document.getElementById('bin');
    const amountInput = document.getElementById('amount');
    const priceDisplay = document.getElementById('price-display');
    const validationError = document.getElementById('validation-error');
    const errorMessage = document.getElementById('error-message');
    const selectedPrice = document.getElementById('selected-price');
    const cardAmount = document.getElementById('card-amount');
    const totalAmount = document.getElementById('total-amount');
    const previewBin = document.getElementById('preview-bin');
    const previewPrice = document.getElementById('preview-price');
    const previewNumber = document.getElementById('preview-number');

    // Amount validation function
    function validateAmount() {
        const amount = parseFloat(amountInput.value);
        if (isNaN(amount) || amount < 10) {
            validationError.style.display = 'block';
            errorMessage.textContent = amount < 10 ? 'Minimum amount is $10.00' : 'Please enter a valid amount';
            return false;
        } else {
            validationError.style.display = 'none';
            return true;
        }
    }

    // Update price calculation
    function updatePriceCalculation() {
        const amount = parseFloat(amountInput.value) || 0;
        const binPrice = parseFloat(selectedPrice.textContent.replace('$', '')) || 0;
        const total = amount + binPrice;

        cardAmount.textContent = `$${amount.toFixed(2)}`;
        totalAmount.textContent = `$${total.toFixed(2)}`;
    }

    // Amount input handler
    if (amountInput) {
        amountInput.addEventListener('input', function () {
            validateAmount();
            updatePriceCalculation();
        });
    }

    if (binSelect) {
        binSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const bin = selectedOption.value;
            const price = selectedOption.getAttribute('data-price');

            if (bin) {
                // Show price display
                priceDisplay.style.display = 'block';
                selectedPrice.textContent = `$${price}`;

                // Update preview
                previewBin.textContent = bin;
                previewPrice.textContent = `$${price}`;

                // Update card number preview with BIN
                const randomDigits = `${Math.floor(10 + Math.random() * 89)} ••${Math.floor(10 + Math.random() * 89)} ••${Math.floor(10 + Math.random() * 89)}`;
                previewNumber.textContent = `${bin.substring(0, 4)} ••${randomDigits}`;

                // Update price calculation
                updatePriceCalculation();
            } else {
                // Hide price display
                priceDisplay.style.display = 'none';
                selectedPrice.textContent = '$0.00';

                // Reset preview
                previewBin.textContent = 'Not selected';
                previewPrice.textContent = '$0.00';
                previewNumber.textContent = '5244 ••42 ••65 ••88';
            }
        });
    }

    createBtn.addEventListener('click', function (e) {
        e.preventDefault();

        // Validate amount first
        if (!validateAmount()) {
            return;
        }

        const label = document.getElementById('label')?.value?.trim() || 'New Card';
        const email = document.getElementById('email')?.value?.trim() || '';
        const amount = parseFloat(document.getElementById('amount')?.value) || 0;
        const currency = document.getElementById('currency')?.value || 'USD';
        const bin = document.getElementById('bin')?.value || '';
        const binPrice = document.getElementById('bin')?.selectedOptions[0]?.getAttribute('data-price') || '0.00';
        const totalAmount = amount + parseFloat(binPrice);

        // Validate email
        if (!email) {
            alert('Please enter your email address for 3D Secure verification.');
            return;
        }

        // Basic email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return;
        }

        const themes = ['blue', 'purple', 'green'];
        const theme = themes[Math.floor(Math.random() * themes.length)];
        const masked = bin ? `${bin.substring(0, 4)} ••${Math.floor(10 + Math.random() * 89)} ••${Math.floor(10 + Math.random() * 89)} ••${Math.floor(10 + Math.random() * 89)}` : `${Math.floor(4000 + Math.random() * 4999)} ••${Math.floor(10 + Math.random() * 89)} ••${Math.floor(10 + Math.random() * 89)} ••${Math.floor(10 + Math.random() * 89)}`;
        const exp = `${String(Math.floor(1 + Math.random() * 12)).padStart(2, '0')}/${String(27 + Math.floor(Math.random() * 5))}`;

        CardStore.add({
            label,
            email,
            amount,
            currency,
            theme,
            masked,
            exp,
            bin,
            binPrice,
            totalAmount
        });

        window.location.href = 'cards.html';
    });
}

// Initialize collapsible info section
function initCollapsibleInfo() {
    const toggleButton = document.getElementById('info-toggle');
    const infoContent = document.getElementById('info-content');
    const toggleIcon = document.getElementById('toggle-icon');

    if (toggleButton && infoContent && toggleIcon) {
        // Start with content collapsed
        infoContent.classList.add('collapsed');
        toggleIcon.textContent = '▶';

        toggleButton.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Toggle the collapsed state
            infoContent.classList.toggle('collapsed');

            // Update the arrow direction
            if (infoContent.classList.contains('collapsed')) {
                toggleIcon.textContent = '▶';
            } else {
                toggleIcon.textContent = '▼';
            }
        });
    }
}

// Initialize crypto deposit functionality
function initCryptoDeposit() {
    const cryptoSelect = document.getElementById('crypto-select');
    const cryptoAmount = document.getElementById('crypto-amount');
    const walletAddress = document.getElementById('wallet-address');

    // Update deposit address based on selected crypto
    if (cryptoSelect) {
        cryptoSelect.addEventListener('change', function () {
            const crypto = this.value;
            const depositAddress = document.getElementById('deposit-address');

            // Different addresses for different cryptocurrencies
            const addresses = {
                'USDT': 'TQn9Y2khEsLJW1ChVWFMSMeRDow5KcbLSE',
                'USDC': 'TQn9Y2khEsLJW1ChVWFMSMeRDow5KcbLSE',
                'TRX': 'TQn9Y2khEsLJW1ChVWFMSMeRDow5KcbLSE',
                'BTC': '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'
            };

            if (depositAddress) {
                depositAddress.value = addresses[crypto] || addresses['USDT'];
            }
        });
    }
}

// Initiate crypto deposit process
function initiateCryptoDeposit() {
    const crypto = document.getElementById('crypto-select')?.value;
    const amount = document.getElementById('crypto-amount')?.value;
    const walletAddress = document.getElementById('wallet-address')?.value;
    const depositAddress = document.getElementById('deposit-address')?.value;

    // Validation
    if (!crypto || !amount || !walletAddress) {
        alert('Please fill in all required fields.');
        return;
    }

    if (parseFloat(amount) < 10) {
        alert('Minimum deposit amount is $10 equivalent.');
        return;
    }

    // Validate TRON address format
    if (crypto !== 'BTC' && !isValidTronAddress(walletAddress)) {
        alert('Please enter a valid TRON wallet address.');
        return;
    }

    // Show confirmation dialog
    const confirmed = confirm(
        `Confirm Crypto Deposit:\n\n` +
        `Cryptocurrency: ${crypto}\n` +
        `Amount: ${amount}\n` +
        `Your Wallet: ${walletAddress}\n` +
        `Deposit to: ${depositAddress}\n\n` +
        `Send the crypto to the deposit address and our TronScan API will monitor the transaction.`
    );

    if (confirmed) {
        // Simulate API call to TronScan
        monitorCryptoTransaction(crypto, amount, walletAddress, depositAddress);
    }
}

// Validate TRON address format
function isValidTronAddress(address) {
    // Basic TRON address validation (starts with T and is 34 characters)
    return /^T[A-Za-z1-9]{33}$/.test(address);
}

// Monitor crypto transaction using TronScan API
function monitorCryptoTransaction(crypto, amount, walletAddress, depositAddress) {
    // Show loading state
    const button = document.getElementById('crypto-deposit-btn');
    const statusDiv = document.getElementById('crypto-status');
    const originalText = button.textContent;

    // Hide button and show status
    button.style.display = 'none';
    statusDiv.style.display = 'block';

    // TronScan API configuration
    const TRONSCAN_API_KEY = '7889c19c-430b-4550-910b-a530e74f3d37';
    const TRONSCAN_BASE_URL = 'https://apilist.tronscanapi.com/api';

    // Start monitoring transaction
    const monitoringInterval = setInterval(async () => {
        try {
            // Check for recent transactions to the deposit address
            const response = await fetch(`${TRONSCAN_BASE_URL}/transaction?address=${depositAddress}&limit=10`, {
                method: 'GET',
                headers: {
                    'TRON-PRO-API-KEY': TRONSCAN_API_KEY,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`API Error: ${response.status}`);
            }

            const data = await response.json();

            // Look for recent transactions matching our criteria
            const recentTransactions = data.data || [];
            const matchingTransaction = recentTransactions.find(tx => {
                // Check if transaction is recent (within last 5 minutes)
                const txTime = new Date(tx.timestamp);
                const now = new Date();
                const timeDiff = (now - txTime) / 1000 / 60; // minutes

                return timeDiff <= 5 &&
                    tx.to === depositAddress &&
                    tx.from === walletAddress &&
                    tx.contractRet === 'SUCCESS';
            });

            if (matchingTransaction) {
                // Transaction found!
                clearInterval(monitoringInterval);

                const transactionData = {
                    id: Date.now().toString(),
                    method: `CRYPTO-${crypto}`,
                    amount: amount,
                    currency: crypto,
                    transactionId: matchingTransaction.hash,
                    notes: `Crypto deposit via TronScan API - Confirmed on blockchain`,
                    timestamp: new Date().toLocaleString(),
                    status: 'APPROVED',
                    blockNumber: matchingTransaction.blockNumber,
                    gasUsed: matchingTransaction.gasUsed
                };

                // Store in localStorage
                let transactions = JSON.parse(localStorage.getItem('fundingTransactions') || '[]');
                transactions.unshift(transactionData);
                localStorage.setItem('fundingTransactions', JSON.stringify(transactions));

                // Update UI
                alert(`✅ Crypto deposit successful!\n\nTransaction ID: ${matchingTransaction.hash}\nAmount: ${amount} ${crypto}\nBlock: ${matchingTransaction.blockNumber}\n\nFunds have been added to your balance.`);

                // Refresh transaction history
                if (typeof renderTransactionHistory === 'function') {
                    renderTransactionHistory();
                }

                // Reset form
                document.getElementById('crypto-amount').value = '';
                document.getElementById('wallet-address').value = '';

                // Reset UI
                button.style.display = 'block';
                statusDiv.style.display = 'none';

            } else {
                // Check if we've been monitoring for too long (5 minutes)
                const startTime = Date.now();
                const elapsed = (Date.now() - startTime) / 1000 / 60; // minutes

                if (elapsed >= 5) {
                    clearInterval(monitoringInterval);
                    alert('⏰ Transaction monitoring timeout. Please check your wallet and try again if the transaction was sent.');

                    // Reset UI
                    button.style.display = 'block';
                    statusDiv.style.display = 'none';
                }
            }

        } catch (error) {
            console.error('TronScan API Error:', error);

            // If API fails, fall back to simulation for demo purposes
            if (error.message.includes('API Error')) {
                clearInterval(monitoringInterval);

                // Simulate successful transaction for demo
                setTimeout(() => {
                    const transactionData = {
                        id: Date.now().toString(),
                        method: `CRYPTO-${crypto}`,
                        amount: amount,
                        currency: crypto,
                        transactionId: `TXN_${Math.random().toString(36).substr(2, 9).toUpperCase()}`,
                        notes: `Crypto deposit via TronScan API (Demo Mode)`,
                        timestamp: new Date().toLocaleString(),
                        status: 'APPROVED'
                    };

                    // Store in localStorage
                    let transactions = JSON.parse(localStorage.getItem('fundingTransactions') || '[]');
                    transactions.unshift(transactionData);
                    localStorage.setItem('fundingTransactions', JSON.stringify(transactions));

                    // Update UI
                    alert(`✅ Crypto deposit successful! (Demo Mode)\n\nTransaction ID: ${transactionData.transactionId}\nAmount: ${amount} ${crypto}\n\nFunds have been added to your balance.`);

                    // Refresh transaction history
                    if (typeof renderTransactionHistory === 'function') {
                        renderTransactionHistory();
                    }

                    // Reset form
                    document.getElementById('crypto-amount').value = '';
                    document.getElementById('wallet-address').value = '';

                    // Reset UI
                    button.style.display = 'block';
                    statusDiv.style.display = 'none';
                }, 2000);
            }
        }
    }, 10000); // Check every 10 seconds

    // Stop monitoring after 5 minutes
    setTimeout(() => {
        clearInterval(monitoringInterval);
        if (statusDiv.style.display === 'block') {
            button.style.display = 'block';
            statusDiv.style.display = 'none';
        }
    }, 300000); // 5 minutes
}

// Initialize funding page
function initFundingPage() {
    const form = document.getElementById('transaction-form');
    const submissionStatus = document.getElementById('submission-status');
    const statusMessage = document.getElementById('status-message');
    const transactionHistory = document.getElementById('transaction-history');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const transactionData = {
                id: Date.now().toString(),
                method: formData.get('payment-method') || document.getElementById('payment-method').value,
                amount: formData.get('amount') || document.getElementById('amount').value,
                currency: formData.get('currency') || document.getElementById('currency').value,
                transactionId: formData.get('transaction-id') || document.getElementById('transaction-id').value,
                notes: formData.get('notes') || document.getElementById('notes').value,
                screenshot: formData.get('screenshot') || document.getElementById('screenshot').files[0],
                status: 'pending',
                date: new Date().toLocaleString(),
                timestamp: Date.now()
            };

            // Store transaction in localStorage
            const transactions = JSON.parse(localStorage.getItem('fundingTransactions') || '[]');
            transactions.unshift(transactionData);
            localStorage.setItem('fundingTransactions', JSON.stringify(transactions));

            // Show success message
            statusMessage.textContent = 'Transaction submitted successfully! We will review and approve it manually.';
            submissionStatus.style.display = 'block';

            // Reset form
            form.reset();

            // Update transaction history
            renderTransactionHistory();

            // Hide success message after 5 seconds
            setTimeout(() => {
                submissionStatus.style.display = 'none';
            }, 5000);
        });
    }

    // Render transaction history
    function renderTransactionHistory() {
        if (!transactionHistory) return;

        const transactions = JSON.parse(localStorage.getItem('fundingTransactions') || '[]');

        if (transactions.length === 0) {
            transactionHistory.innerHTML = '<div class="help" style="text-align: center; padding: 20px;">No transactions submitted yet</div>';
            return;
        }

        const historyHTML = transactions.map(transaction => {
            const statusClass = transaction.status === 'approved' ? 'approved' :
                transaction.status === 'rejected' ? 'rejected' : 'pending';
            const statusText = transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1);

            return `
        <div class="card-row" style="margin-bottom: 10px;">
          <div class="left">
            <div class="details">
              <div class="title">${transaction.method.toUpperCase()} - ${transaction.currency} ${transaction.amount}</div>
              <div class="muted">Transaction ID: ${transaction.transactionId}</div>
              <div class="muted">Submitted: ${transaction.date}</div>
              ${transaction.notes ? `<div class="muted">Notes: ${transaction.notes}</div>` : ''}
            </div>
          </div>
          <div class="actions">
            <div class="status-badge ${statusClass}">${statusText}</div>
          </div>
        </div>
      `;
        }).join('');

        transactionHistory.innerHTML = historyHTML;
    }

    // Initial render
    renderTransactionHistory();
}

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show temporary success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.style.background = 'var(--success)';
        button.style.color = 'white';

        setTimeout(() => {
            button.textContent = originalText;
            button.style.background = '';
            button.style.color = '';
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
        alert('Failed to copy to clipboard');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    renderCardsPage();
    initCreateCardPage();
    initCollapsibleInfo();
    initFundingPage();
    initCryptoDeposit();
});


