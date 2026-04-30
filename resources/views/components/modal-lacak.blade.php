<div id="lacakOverlay" class="popup-overlay">
    <div class="popup-card">

        {{-- ── Header ── --}}
        <div class="popup-header">
            <button
                class="popup-close"
                type="button"
                onclick="lacakModule.closePopup()"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="popup-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h2 class="text-white">Lacak Laporan</h2>
            <p class="text-emerald-50 text-xs">Masukkan kode unik laporan Anda</p>
        </div>

        {{-- ── Body ── --}}
        <div class="popup-body">

            {{-- Label --}}
            <label for="trackingCode" class="text-sm font-bold text-gray-700 mb-2 block">
                Kode Laporan
            </label>

            {{-- Input row --}}
            <div class="popup-input-row" id="inputRow">
                <div class="popup-input-icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010
                                 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013
                                 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    id="trackingCode"
                    class="popup-input"
                    placeholder="Contoh: KRF-140326-AB12"
                    maxlength="15"
                    autocomplete="off"
                    spellcheck="false"
                    inputmode="text"
                >
            </div>

            {{-- Pesan error inline --}}
            <p id="trackingCodeError" class="lacak-error-msg hidden"></p>

            {{-- Tombol — BUKAN <form> submit, pakai type="button" --}}
            <button
                type="button"
                id="btnCariLaporan"
                class="btn-lacak-submit"
            >
                <span>Lacak Sekarang</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

        </div>{{-- /popup-body --}}
    </div>{{-- /popup-card --}}
</div>{{-- /lacakOverlay --}}