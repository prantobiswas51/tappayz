import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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
    initCollapsibleInfo();
});


