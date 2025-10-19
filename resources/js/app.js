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


document.addEventListener('DOMContentLoaded', () => {
    renderCardsPage();
    initCreateCardPage();
    initCollapsibleInfo();
    initFundingPage();
    initCryptoDeposit();
});


