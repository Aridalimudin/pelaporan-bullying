/* Update pada lacak-page.js */

const lacakModule = (function () {
    const overlay = document.getElementById('lacakOverlay');
    const input = document.getElementById('trackingCode');

    function openPopup() {
        if (!overlay) return;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => { if (input) input.focus(); }, 300);
    }

    function closePopup() {
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Fungsi otomatis buka saat masuk ke halaman Lacak
    function _autoOpen() {
        // Logika: Langsung buka popup saat script dimuat di page Lacak
        setTimeout(openPopup, 400); 
    }

    function _bind() {
        // ... kode event listener yang sudah ada sebelumnya ...
        // Tambahkan fungsi ESC untuk menutup
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closePopup();
        });
    }

    return {
        init: function() {
            _bind();
            _autoOpen(); // Jalankan otomatisasi
        },
        openPopup: openPopup,
        closePopup: closePopup
    };
})();

window.lacakModule = lacakModule;

document.addEventListener('DOMContentLoaded', () => {
    lacakModule.init();
});