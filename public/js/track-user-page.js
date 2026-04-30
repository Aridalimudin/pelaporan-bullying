/**
 * track-user-page.js
 */

const lacakModule = (function () {

    let overlay, input, btnCari, errEl, inputRow, iconBox;

    /* ══════════════════════════════════════════════
       BUKA / TUTUP
    ══════════════════════════════════════════════ */
    function openPopup() {
        if (!overlay) return;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => input?.focus(), 300);
    }

    function closePopup() {
        if (!overlay) return;
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        _clearState();
    }

    /* ══════════════════════════════════════════════
       INPUT STATE
    ══════════════════════════════════════════════ */
    function _showError(msg) {
        if (errEl) {
            errEl.textContent   = msg;
            errEl.style.display = 'block';
        }
        if (inputRow) {
            inputRow.style.borderColor = '#ef4444';
            inputRow.style.animation   = 'none';
            void inputRow.offsetWidth;
            inputRow.style.animation   = 'lacak-shake 0.4s ease';
        }
        if (iconBox) iconBox.style.background = '#ef4444';
        _setBtnDefault();
    }

    function _showSuccess() {
        if (inputRow) inputRow.style.borderColor = '#10b981';
        if (iconBox)  iconBox.style.background   = '#059669';
        if (errEl)    errEl.style.display         = 'none';
    }

    function _clearState() {
        if (errEl)    { errEl.textContent = ''; errEl.style.display = 'none'; }
        if (inputRow) { inputRow.style.borderColor = '#e2e8f0'; inputRow.style.animation = ''; }
        if (iconBox)  iconBox.style.background = '#10b981';
        _setBtnDefault();
    }

    /* ══════════════════════════════════════════════
       STATE TOMBOL — pakai wrapper agar style tidak hilang
    ══════════════════════════════════════════════ */
    const BTN_BASE = `
        width:100%; margin-top:20px; padding:13px 20px;
        border:none; border-radius:12px; font-weight:700; font-size:15px;
        cursor:pointer; display:flex; align-items:center;
        justify-content:center; gap:8px;
        transition: transform 0.15s, box-shadow 0.2s;`;

    function _setBtnDefault() {
        if (!btnCari) return;
        btnCari.disabled      = false;
        btnCari.style.cssText = BTN_BASE + `
            background: linear-gradient(to right, #10b981, #059669);
            color: white; box-shadow: none; transform: scale(1);`;
        btnCari.innerHTML = `
            <span>Lacak Sekarang</span>
            <svg style="width:20px;height:20px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>`;
        btnCari.onmouseover = () => { if (!btnCari.disabled) btnCari.style.transform = 'translateY(-1px)'; };
        btnCari.onmouseout  = () => { if (!btnCari.disabled) btnCari.style.transform = 'scale(1)'; };
    }

    function _setBtnLoading() {
        if (!btnCari) return;
        btnCari.disabled      = true;
        btnCari.onmouseover   = null;
        btnCari.onmouseout    = null;
        btnCari.style.cssText = BTN_BASE + `
            background: #6b7280; color: white;
            cursor: wait; transform: scale(0.98); box-shadow: none;`;
        btnCari.innerHTML = `
            <svg style="width:20px;height:20px;flex-shrink:0;animation:lacak-spin 1s linear infinite;"
                 fill="none" viewBox="0 0 24 24">
                <circle style="opacity:0.25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"/>
                <path style="opacity:0.75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span>Mencari...</span>`;
    }

    function _setBtnSuccess() {
        if (!btnCari) return;
        btnCari.disabled      = true;
        btnCari.onmouseover   = null;
        btnCari.onmouseout    = null;
        btnCari.style.cssText = BTN_BASE + `
            background: linear-gradient(to right, #059669, #047857);
            color: white; transform: scale(1.01);
            box-shadow: 0 4px 16px rgba(5,150,105,0.4); cursor: default;`;
        btnCari.innerHTML = `
            <svg style="width:20px;height:20px;flex-shrink:0;animation:lacak-popin 0.35s cubic-bezier(0.34,1.56,0.64,1);"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Laporan Ditemukan!</span>`;
    }

    /* ══════════════════════════════════════════════
       CORE: LACAK
    ══════════════════════════════════════════════ */
    async function lacakLaporan() {
        const code = input?.value.trim().toUpperCase();
        _clearState();

        if (!code) {
            _showError('Kode tiket wajib diisi.');
            input?.focus();
            return;
        }

        if (!/^KRF-\d{6}-[A-Z0-9]{4}$/.test(code)) {
            _showError('Format tidak valid. Contoh: KRF-140326-AB12');
            return;
        }

        _setBtnLoading();

        try {
            const res  = await fetch(`/api/reports/track?code=${encodeURIComponent(code)}`, {
                headers: { 'Accept': 'application/json' },
            });
            const data = await res.json();

            if (res.ok && data.success) {
                _showSuccess();
                _setBtnSuccess();
                sessionStorage.setItem('lacak_code', code);

                setTimeout(() => {
                    window.location.href = `/progress-laporan?code=${encodeURIComponent(code)}`;
                }, 900);

            } else {
                _showError(data.message || 'Kode tiket tidak ditemukan.');
                _showNotFoundModal(data.message || 'Kode tiket tidak ditemukan. Periksa kembali penulisan kode Anda.');
            }

        } catch (e) {
            console.error(e);
            _showError('Koneksi bermasalah. Periksa internet Anda dan coba lagi.');
        }
    }

    /* ══════════════════════════════════════════════
       MODAL TIDAK DITEMUKAN
    ══════════════════════════════════════════════ */
    function _showNotFoundModal(msg) {
        document.getElementById('modalKodeTidakDitemukan')?.remove();

        const modal = document.createElement('div');
        modal.id = 'modalKodeTidakDitemukan';
        modal.style.cssText = `
            position:fixed; inset:0; background:rgba(0,0,0,0.6);
            z-index:99999; display:flex; align-items:center;
            justify-content:center; padding:20px;
            backdrop-filter:blur(3px); animation:lacak-fadein 0.2s ease;`;

        modal.innerHTML = `
            <div style="
                background:#fff; border-radius:20px; padding:32px 28px;
                max-width:360px; width:100%; text-align:center;
                box-shadow:0 24px 64px rgba(0,0,0,0.22);
                animation:lacak-slideup 0.25s ease;">
                <div style="width:60px;height:60px;background:#fef2f2;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <svg style="width:30px;height:30px;stroke:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732
                                 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h4 style="font-size:18px;font-weight:700;color:#111827;margin-bottom:8px;">
                    Kode Tidak Ditemukan
                </h4>
                <p style="font-size:14px;color:#6b7280;line-height:1.65;margin-bottom:24px;">
                    ${msg.replace(/</g,'&lt;')}
                </p>
                <button
                    onclick="document.getElementById('modalKodeTidakDitemukan').remove()"
                    style="width:100%;padding:12px 24px;background:#059669;color:#fff;border:none;
                        border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;"
                    onmouseover="this.style.background='#047857'"
                    onmouseout="this.style.background='#059669'">
                    Coba Lagi
                </button>
            </div>`;

        modal.addEventListener('click', (e) => { if (e.target === modal) modal.remove(); });
        document.body.appendChild(modal);
    }

    /* ══════════════════════════════════════════════
       BINDING
    ══════════════════════════════════════════════ */
    function _bind() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.getElementById('modalKodeTidakDitemukan')?.remove();
                closePopup();
            }
        });

        overlay?.addEventListener('click', (e) => {
            if (e.target === overlay) closePopup();
        });

        input?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') { e.preventDefault(); lacakLaporan(); }
        });

        input?.addEventListener('input', function () {
            const pos = this.selectionStart;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(pos, pos);
            if (inputRow?.style.borderColor === 'rgb(239, 68, 68)') _clearState();
        });

        btnCari?.addEventListener('click', lacakLaporan);
    }

    /* ══════════════════════════════════════════════
       AUTO-HANDLE ?code= DI URL
    ══════════════════════════════════════════════ */
    async function _checkUrlCode() {
        const params = new URLSearchParams(window.location.search);
        const code   = params.get('code');

        if (code) {
            if (input) input.value = code.toUpperCase();
            openPopup();
            await new Promise(r => setTimeout(r, 450));
            await lacakLaporan();
        } else {
            setTimeout(openPopup, 400);
        }
    }

    /* ══════════════════════════════════════════════
       INJECT KEYFRAMES
    ══════════════════════════════════════════════ */
    function _injectKeyframes() {
        if (document.getElementById('lacakKeyframes')) return;
        const style = document.createElement('style');
        style.id = 'lacakKeyframes';
        style.textContent = `
            @keyframes lacak-shake {
                0%,100% { transform:translateX(0); }
                20%     { transform:translateX(-6px); }
                40%     { transform:translateX(6px); }
                60%     { transform:translateX(-4px); }
                80%     { transform:translateX(4px); }
            }
            @keyframes lacak-spin {
                from { transform:rotate(0deg); }
                to   { transform:rotate(360deg); }
            }
            @keyframes lacak-popin {
                from { transform:scale(0) rotate(-30deg); opacity:0; }
                to   { transform:scale(1) rotate(0deg);   opacity:1; }
            }
            @keyframes lacak-fadein {
                from { opacity:0; } to { opacity:1; }
            }
            @keyframes lacak-slideup {
                from { transform:translateY(16px) scale(0.97); opacity:0; }
                to   { transform:translateY(0) scale(1); opacity:1; }
            }
        `;
        document.head.appendChild(style);
    }

    /* ══════════════════════════════════════════════
       INIT
    ══════════════════════════════════════════════ */
    function init() {
        overlay  = document.getElementById('lacakOverlay');
        input    = document.getElementById('trackingCode');
        btnCari  = document.getElementById('btnCariLaporan');
        errEl    = document.getElementById('trackingCodeError');
        inputRow = document.getElementById('inputRow');
        iconBox  = document.getElementById('inputIconBox');

        _injectKeyframes();
        _bind();
        _setBtnDefault(); // pastikan style tombol benar dari awal
        _checkUrlCode();
    }

    return { init, openPopup, closePopup, lacakLaporan };

})();

window.lacakModule = lacakModule;
document.addEventListener('DOMContentLoaded', () => lacakModule.init());