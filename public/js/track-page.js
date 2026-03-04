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

    function _autoOpen() {
        setTimeout(openPopup, 400); 
    }

    function _bind() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closePopup();
        });
    }

    return {
        init: function() {
            _bind();
            _autoOpen();
        },
        openPopup: openPopup,
        closePopup: closePopup
    };
})();

window.lacakModule = lacakModule;

document.addEventListener('DOMContentLoaded', () => {
    lacakModule.init();
});