{{-- Modal Alert & Confirm Custom --}}
<div id="customAlertModal"
     class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm px-4 transition-all duration-300">
    <div id="customAlertContent"
         class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-90 opacity-0 transition-all duration-300 relative border border-gray-100">

        <div class="relative pt-7 pb-4 text-center px-6">
            {{-- Icon Container --}}
            <div id="customAlertIconBg" class="mx-auto flex items-center justify-center w-16 h-16 bg-amber-100 rounded-full mb-3 shadow-md">
                <svg id="customAlertIconWarning" class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <svg id="customAlertIconError" class="w-8 h-8 text-red-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <svg id="customAlertIconQuestion" class="w-8 h-8 text-red-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>

            <h3 id="customAlertTitle" class="text-lg font-bold text-gray-900 mb-1">
                Pemberitahuan
            </h3>
            <p id="customAlertMessage" class="text-sm text-gray-600 leading-relaxed">
                Pesan peringatan...
            </p>
        </div>

        {{-- Single button container (Alert mode) --}}
        <div id="alertSingleButtonContainer" class="px-6 pb-6 pt-2">
            <button type="button"
                    onclick="closeCustomAlert()"
                    class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-emerald-500/25 active:scale-95 transition-all duration-200">
                Mengerti
            </button>
        </div>

        {{-- Dual button container (Confirm mode) --}}
        <div id="confirmDualButtonContainer" class="px-6 pb-6 pt-2 hidden flex items-center gap-3">
            <button type="button"
                    onclick="closeCustomAlert()"
                    class="flex-1 py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl transition-all duration-200">
                Batal
            </button>
            <button type="button"
                    id="btnConfirmAction"
                    class="flex-1 py-2.5 px-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-red-500/25 active:scale-95 transition-all duration-200">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
let _confirmCallback = null;

function showCustomAlert(title, message, type = 'warning') {
    const modal = document.getElementById('customAlertModal');
    const content = document.getElementById('customAlertContent');
    const titleEl = document.getElementById('customAlertTitle');
    const msgEl = document.getElementById('customAlertMessage');
    const iconBg = document.getElementById('customAlertIconBg');
    const iconWarning = document.getElementById('customAlertIconWarning');
    const iconError = document.getElementById('customAlertIconError');
    const iconQuestion = document.getElementById('customAlertIconQuestion');
    const singleBtn = document.getElementById('alertSingleButtonContainer');
    const dualBtn = document.getElementById('confirmDualButtonContainer');

    if (!modal || !content) {
        alert(message);
        return;
    }

    titleEl.textContent = title || (type === 'error' ? 'Terjadi Kesalahan' : 'Pemberitahuan');
    msgEl.textContent = message;

    singleBtn.classList.remove('hidden');
    dualBtn.classList.add('hidden');
    dualBtn.classList.remove('flex');

    if (type === 'error') {
        iconBg.className = 'mx-auto flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-3 shadow-md';
        iconWarning.classList.add('hidden');
        iconError.classList.remove('hidden');
        iconQuestion.classList.add('hidden');
    } else {
        iconBg.className = 'mx-auto flex items-center justify-center w-16 h-16 bg-amber-100 rounded-full mb-3 shadow-md';
        iconWarning.classList.remove('hidden');
        iconError.classList.add('hidden');
        iconQuestion.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-90', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 20);
}

function showCustomConfirm(title, message, onConfirm, confirmText = 'Ya, Keluar', type = 'danger') {
    const modal = document.getElementById('customAlertModal');
    const content = document.getElementById('customAlertContent');
    const titleEl = document.getElementById('customAlertTitle');
    const msgEl = document.getElementById('customAlertMessage');
    const iconBg = document.getElementById('customAlertIconBg');
    const iconWarning = document.getElementById('customAlertIconWarning');
    const iconError = document.getElementById('customAlertIconError');
    const iconQuestion = document.getElementById('customAlertIconQuestion');
    const singleBtn = document.getElementById('alertSingleButtonContainer');
    const dualBtn = document.getElementById('confirmDualButtonContainer');
    const btnAction = document.getElementById('btnConfirmAction');

    if (!modal || !content) {
        if (confirm(message)) onConfirm();
        return;
    }

    titleEl.textContent = title || 'Konfirmasi';
    msgEl.textContent = message;
    _confirmCallback = onConfirm;

    if (btnAction) {
        btnAction.textContent = confirmText;
        if (type === 'danger') {
            btnAction.className = 'flex-1 py-2.5 px-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-red-500/25 active:scale-95 transition-all duration-200';
            iconBg.className = 'mx-auto flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-3 shadow-md';
        } else {
            btnAction.className = 'flex-1 py-2.5 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-emerald-500/25 active:scale-95 transition-all duration-200';
            iconBg.className = 'mx-auto flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-3 shadow-md';
        }
    }

    iconWarning.classList.add('hidden');
    iconError.classList.add('hidden');
    iconQuestion.classList.remove('hidden');

    singleBtn.classList.add('hidden');
    dualBtn.classList.remove('hidden');
    dualBtn.classList.add('flex');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-90', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 20);
}

document.getElementById('btnConfirmAction')?.addEventListener('click', function() {
    closeCustomAlert();
    if (typeof _confirmCallback === 'function') {
        const cb = _confirmCallback;
        _confirmCallback = null;
        cb();
    }
});

function closeCustomAlert() {
    const modal = document.getElementById('customAlertModal');
    const content = document.getElementById('customAlertContent');

    if (!modal || !content) return;

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-90', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 200);
}

// Close on background click
document.getElementById('customAlertModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeCustomAlert();
});
</script>
