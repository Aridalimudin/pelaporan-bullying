<div id="lacakOverlay" class="popup-overlay">
    <div class="popup-card">
        <div class="popup-header">
            <button class="popup-close" onclick="lacakModule.closePopup()" style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.2); border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; color: white;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            
            <div class="popup-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #10b981;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <h2 class="text-white">Lacak Laporan</h2>
            <p class="text-emerald-50 text-xs">Masukkan kode unik laporan Anda</p>
        </div>

        <div class="popup-body" style="padding: 24px;">
            <form id="formLacak" action="{{ route('lapor.lacak') }}" method="GET">
                <label class="text-sm font-bold text-gray-700 mb-2 block">Kode Laporan</label>
                <div class="popup-input-row" style="border: 2px solid #e2e8f0; border-radius: 12px; display: flex; overflow: hidden; background: #f8fafc;">
                    <div class="bg-emerald-500 px-3 flex items-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    </div>
                    <input type="text" name="code" id="trackingCode" class="popup-input" placeholder="Contoh: KRF-240524-ABCD" style="width: 100%; padding: 12px; outline: none; background: transparent; color: #1e293b; font-weight: 500;">
                </div>
                <button type="submit" class="popup-btn-submit" style="width: 100%; margin-top: 20px; padding: 12px; background: linear-gradient(to r, #10b981, #059669); color: white; border-radius: 12px; font-weight: 700; transition: transform 0.2s;">
                    Lacak Sekarang
                </button>
            </form>
        </div>
    </div>
</div>