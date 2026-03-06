@include('components.toast')

<div class="mk-overlay" id="modalKonfirmasi" style="display:none">
    <div class="mk-panel">

        <div class="mk-topbar" id="mkTopbar">
            <div class="mk-topbar-icon" id="mkTopbarIcon"></div>
            <div class="mk-topbar-text">
                <p class="mk-topbar-sub" id="mkTopbarSub">Konfirmasi Tindakan</p>
                <h3 class="mk-topbar-title" id="mkTopbarTitle">Konfirmasi</h3>
            </div>
        </div>

        <div class="mk-body">

            <div class="mk-alert" id="mkAlert">
                <div class="mk-alert-icon" id="mkAlertIcon"></div>
                <p class="mk-alert-text" id="mkAlertText">Apakah Anda yakin?</p>
            </div>

            <div class="mk-card" id="mkCard">
                <div class="mk-card-row">
                    <div class="mk-card-field">
                        <span class="mk-card-label">Kode Laporan</span>
                        <span class="mk-card-val mono" id="mkCardKode">—</span>
                    </div>
                    <div class="mk-card-field">
                        <span class="mk-card-label">Nama Pelapor</span>
                        <span class="mk-card-val" id="mkCardNama">—</span>
                    </div>
                </div>
                <div class="mk-card-row" id="mkCardRowExtra">
                    <div class="mk-card-field">
                        <span class="mk-card-label">Kelas</span>
                        <span class="mk-card-val" id="mkCardKelas">—</span>
                    </div>
                    <div class="mk-card-field">
                        <span class="mk-card-label">Urgensi</span>
                        <span class="mk-card-val" id="mkCardUrgensi">—</span>
                    </div>
                </div>
            </div>

            <div class="mk-note" id="mkNote">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p id="mkNoteText">—</p>
            </div>

        </div>

        <div class="mk-footer">
            <button class="mk-btn-cancel" onclick="closeKonfirmasi()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batal
            </button>
            <button class="mk-btn-confirm" id="mkBtnConfirm">Konfirmasi</button>
        </div>

    </div>
</div>

<style>
.mk-overlay {
    position: fixed; inset: 0; z-index: 700;
    background: rgba(15,23,42,.65); backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
}
.mk-panel {
    background: white; border-radius: 20px;
    width: 100%; max-width: 420px;
    box-shadow: 0 32px 80px rgba(0,0,0,.24);
    overflow: hidden;
    animation: mkIn .3s cubic-bezier(.16,1,.3,1) both;
}
@keyframes mkIn {
    from { opacity:0; transform:translateY(20px) scale(.96); }
    to   { opacity:1; transform:translateY(0) scale(1); }
}

.mk-topbar {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 20px;
}
.mk-topbar-icon {
    width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
    background: rgba(255,255,255,.2); border: 1.5px solid rgba(255,255,255,.28);
    display: flex; align-items: center; justify-content: center;
}
.mk-topbar-icon svg { width: 22px; height: 22px; color: white; }
.mk-topbar-sub   { font-size:.62rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:rgba(255,255,255,.72); margin-bottom:3px; }
.mk-topbar-title { font-size:1.05rem; font-weight:800; color:white; }

.mk-body { padding: 16px 20px; display:flex; flex-direction:column; gap:10px; }

.mk-alert {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 14px; border-radius: 11px;
    border: 1.5px solid transparent;
}
.mk-alert-icon { width: 22px; height: 22px; flex-shrink: 0; margin-top: 1px; }
.mk-alert-icon svg { width: 22px; height: 22px; }
.mk-alert-text { font-size: .83rem; color: #374151; line-height: 1.55; }

.mk-alert.success { background: #f0fdf4; border-color: #bbf7d0; }
.mk-alert.success .mk-alert-icon { color: #16a34a; }
.mk-alert.danger  { background: #fef2f2; border-color: #fecaca; }
.mk-alert.danger  .mk-alert-icon { color: #dc2626; }
.mk-alert.warning { background: #fffbeb; border-color: #fde68a; }
.mk-alert.warning .mk-alert-icon { color: #d97706; }
.mk-alert.info    { background: #eff6ff; border-color: #bfdbfe; }
.mk-alert.info    .mk-alert-icon { color: #2563eb; }

.mk-card {
    background: #f9fafb; border: 1.5px solid #e5e7eb;
    border-radius: 12px; padding: 12px 14px;
    display: flex; flex-direction: column; gap: 10px;
}
.mk-card-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.mk-card-field { display: flex; flex-direction: column; gap: 3px; }
.mk-card-label { font-size: .6rem; font-weight: 700; letter-spacing: .08em; color: #9ca3af; text-transform: uppercase; }
.mk-card-val   { font-size: .83rem; font-weight: 600; color: #111827; }
.mk-card-val.mono { font-family: 'Courier New', monospace; font-size: .78rem; }

.mk-note {
    display: flex; align-items: flex-start; gap: 8px;
    padding: 10px 12px; background: #f8fafc;
    border: 1px solid #e2e8f0; border-radius: 9px;
}
.mk-note svg { width: 16px; height: 16px; color: #64748b; flex-shrink: 0; margin-top: 1px; }
.mk-note p   { font-size: .76rem; color: #64748b; line-height: 1.5; margin: 0; }

.mk-footer {
    display: flex; gap: 8px; padding: 12px 20px 16px;
    border-top: 1px solid #f0f0f0; background: #fafafa;
}
.mk-btn-cancel {
    flex: 0 0 auto; padding: 11px 16px; border-radius: 10px;
    border: 1.5px solid #d1d5db; background: white;
    font-family: inherit; font-size: .83rem; font-weight: 600; color: #374151;
    cursor: pointer; display: flex; align-items: center; gap: 6px;
    transition: background .15s;
}
.mk-btn-cancel svg { width: 14px; height: 14px; }
.mk-btn-cancel:hover { background: #f9fafb; }

.mk-btn-confirm {
    flex: 1; padding: 11px 14px; border-radius: 10px; border: none;
    font-family: inherit; font-size: .84rem; font-weight: 700; color: white;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: filter .15s, transform .1s;
}
.mk-btn-confirm svg { width: 15px; height: 15px; }
.mk-btn-confirm:hover  { filter: brightness(.9); transform: translateY(-1px); }
.mk-btn-confirm:active { transform: scale(.98) translateY(0); }
.mk-btn-confirm.green  { background: #10b981; box-shadow: 0 4px 14px rgba(16,185,129,.3); }
.mk-btn-confirm.red    { background: #ef4444; box-shadow: 0 4px 14px rgba(239,68,68,.3); }
.mk-btn-confirm.yellow { background: #f59e0b; box-shadow: 0 4px 14px rgba(245,158,11,.3); }
.mk-btn-confirm.blue   { background: #3b82f6; box-shadow: 0 4px 14px rgba(59,130,246,.3); }

.mk-urgensi-tinggi { color: #dc2626; }
.mk-urgensi-sedang { color: #d97706; }
.mk-urgensi-rendah { color: #059669; }

.status-badge.ditolak { background: #fef2f2; color: #dc2626; }
</style>

<script>
/* =========================================================
   KONFIRMASI CONFIG
   ========================================================= */
const _KFG = {
    terima: {
        topbarBg    : 'linear-gradient(135deg,#10b981,#047857)',
        topbarIcon  : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`,
        topbarSub   : 'Konfirmasi Penerimaan',
        topbarTitle : 'Terima Laporan Ini?',
        alertType   : 'success',
        alertIcon   : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        alertText   : 'Dengan menerima laporan ini, laporan akan dipindahkan ke tahap <strong>Menunggu Verifikasi</strong> dan dapat ditindaklanjuti oleh petugas.',
        note        : 'Pastikan Anda telah membaca isi laporan sebelum menerimanya. Laporan yang diterima akan tercatat dalam sistem.',
        btnClass    : 'green',
        btnLabel    : 'Ya, Terima Laporan',
        btnIcon     : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`,
        toastType   : 'success', toastTitle: 'Laporan Diterima', toastMsg: 'Laporan berhasil dipindahkan ke Menunggu Verifikasi.',
        newStatus   : 'Menunggu Verifikasi', newClass: 'verifikasi',
    },
    tolak: {
        topbarBg    : 'linear-gradient(135deg,#ef4444,#b91c1c)',
        topbarIcon  : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`,
        topbarSub   : 'Konfirmasi Penolakan',
        topbarTitle : 'Tolak Laporan Ini?',
        alertType   : 'danger',
        alertIcon   : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
        alertText   : 'Laporan ini akan <strong>ditolak dan tidak dapat dikembalikan</strong>. Pelapor tidak akan mendapat tindak lanjut atas laporan ini.',
        note        : '⚠️ Harap pastikan alasan penolakan sudah tepat. Tindakan ini bersifat permanen dan tidak dapat dibatalkan.',
        btnClass    : 'red',
        btnLabel    : 'Ya, Tolak Laporan',
        btnIcon     : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>`,
        toastType   : 'error', toastTitle: 'Laporan Ditolak', toastMsg: 'Laporan telah ditolak dari sistem.',
        newStatus   : 'Ditolak', newClass: 'ditolak',
    },
    proses: {
        topbarBg    : 'linear-gradient(135deg,#7c3aed,#5b21b6)',
        topbarIcon  : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>`,
        topbarSub   : 'Konfirmasi Proses',
        topbarTitle : 'Proses Laporan Ini?',
        alertType   : 'info',
        alertIcon   : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>`,
        alertText   : 'Laporan ini telah diverifikasi dan siap untuk diproses. Status akan berubah menjadi <strong>Sedang Diproses</strong>.',
        note        : 'Pastikan seluruh informasi laporan sudah diverifikasi kebenarannya sebelum melanjutkan ke tahap penanganan.',
        btnClass    : 'yellow',
        btnLabel    : 'Ya, Proses Laporan',
        btnIcon     : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>`,
        toastType   : 'warning', toastTitle: 'Laporan Diproses', toastMsg: 'Laporan dipindahkan ke tahap Proses Laporan.',
        newStatus   : 'Sedang Diproses', newClass: 'proses',
    },
    selesai: {
        topbarBg    : 'linear-gradient(135deg,#10b981,#047857)',
        topbarIcon  : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        topbarSub   : 'Konfirmasi Penyelesaian',
        topbarTitle : 'Tandai Laporan Selesai?',
        alertType   : 'success',
        alertIcon   : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        alertText   : 'Laporan ini akan ditandai sebagai <strong>Selesai</strong> dan diarsipkan. Proses penanganan dianggap telah tuntas.',
        note        : 'Pastikan semua tindak lanjut sudah dilaksanakan dan terdokumentasi dengan baik sebelum menyelesaikan laporan ini.',
        btnClass    : 'green',
        btnLabel    : 'Ya, Selesaikan',
        btnIcon     : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        toastType   : 'success', toastTitle: 'Laporan Selesai!', toastMsg: 'Laporan berhasil diselesaikan dan diarsipkan.',
        newStatus   : 'Selesai', newClass: 'selesai',
    },
    pulihkan: {
        topbarBg    : 'linear-gradient(135deg,#3b82f6,#1d4ed8)',
        topbarIcon  : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>`,
        topbarSub   : 'Konfirmasi Pemulihan',
        topbarTitle : 'Pulihkan Laporan Ini?',
        alertType   : 'info',
        alertIcon   : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>`,
        alertText   : 'Laporan ini akan <strong>dipulihkan</strong> dan dikembalikan ke tahap terakhirnya sebelum ditolak.',
        note        : 'Laporan akan dikembalikan ke antrian sesuai progress terakhirnya. Pastikan Anda memiliki alasan yang valid untuk memulihkan laporan ini.',
        btnClass    : 'blue',
        btnLabel    : 'Ya, Pulihkan Laporan',
        btnIcon     : `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>`,
        toastType   : 'success', toastTitle: 'Laporan Dipulihkan!', toastMsg: 'Laporan berhasil dipulihkan ke tahap sebelumnya.',
        newStatus   : 'Dipulihkan', newClass: 'verifikasi',
    },
};

/* =========================================================
   STATE (shared dengan detail modal)
   ========================================================= */
/* _currentRow & _currentData di-declare di details-modal-admin */

let _mkActiveCfg = null;

/* =========================================================
   TRIGGER KONFIRMASI
   Dipanggil dari:
     1. Tombol quick approve di tabel         → handleQuickApprove()
     2. Tombol aksi di footer detail modal    → triggerKonfirmasi('tolak'/'terima'/dll)
   ========================================================= */
function triggerKonfirmasi(action) {
    const cfg = _KFG[action];
    if (!cfg) return;
    _mkActiveCfg = cfg;

    /* Tutup detail modal dulu (jika terbuka) */
    const detailOverlay = document.getElementById('modalDetail');
    if (detailOverlay) {
        detailOverlay.style.display = 'none';
    }
    document.body.style.overflow = 'hidden';

    /* Isi topbar */
    document.getElementById('mkTopbar').style.background    = cfg.topbarBg;
    document.getElementById('mkTopbarIcon').innerHTML       = cfg.topbarIcon;
    document.getElementById('mkTopbarSub').textContent      = cfg.topbarSub;
    document.getElementById('mkTopbarTitle').textContent    = cfg.topbarTitle;

    /* Isi alert */
    const alertEl = document.getElementById('mkAlert');
    alertEl.className = 'mk-alert ' + cfg.alertType;
    document.getElementById('mkAlertIcon').innerHTML        = cfg.alertIcon;
    document.getElementById('mkAlertText').innerHTML        = cfg.alertText;

    /* Isi card data laporan */
    const d = _currentData || {};
    document.getElementById('mkCardKode').textContent   = d.kode  || '—';
    document.getElementById('mkCardNama').textContent   = d.nama  || '—';
    document.getElementById('mkCardKelas').textContent  = d.kelas || '—';

    const urgensi = d.urgensi || '—';
    const urEl = document.getElementById('mkCardUrgensi');
    urEl.textContent = urgensi.charAt(0).toUpperCase() + urgensi.slice(1);
    urEl.className   = 'mk-card-val mk-urgensi-' + urgensi.toLowerCase();

    /* Isi note */
    document.getElementById('mkNoteText').textContent = cfg.note;

    /* Tombol konfirmasi */
    const btn = document.getElementById('mkBtnConfirm');
    btn.className = 'mk-btn-confirm ' + cfg.btnClass;
    btn.innerHTML = cfg.btnIcon + ' ' + cfg.btnLabel;
    btn.onclick   = () => _doConfirm(cfg);

    /* Tampilkan modal */
    document.getElementById('modalKonfirmasi').style.display = 'flex';
}

/* =========================================================
   EKSEKUSI KONFIRMASI
   ========================================================= */
function _doConfirm(cfg) {
    closeKonfirmasi();

    if (_currentRow) {
        /* Update badge status di baris tabel */
        const badge = _currentRow.querySelector('.status-badge');
        if (badge) {
            badge.textContent = cfg.newStatus;
            badge.className   = 'status-badge ' + cfg.newClass;
        }

        /* Disable tombol aksi non-view */
        _currentRow.querySelectorAll('.btn-aksi:not(.view)').forEach(b => {
            b.disabled     = true;
            b.style.opacity = '.35';
        });

        /* Highlight baris sebentar */
        const hiColor = cfg.toastType === 'success' ? '#f0fdf4'
                      : cfg.toastType === 'error'   ? '#fef2f2' : '#fffbeb';
        _currentRow.style.transition  = 'background .5s';
        _currentRow.style.background  = hiColor;
        setTimeout(() => { if (_currentRow) _currentRow.style.background = ''; }, 1600);
    }

    /* Toast notifikasi */
    setTimeout(() => Toast.show(cfg.toastType, cfg.toastTitle, cfg.toastMsg), 200);
}

/* =========================================================
   TUTUP MODAL KONFIRMASI
   ========================================================= */
function closeKonfirmasi() {
    document.getElementById('modalKonfirmasi').style.display = 'none';
    document.body.style.overflow = '';
}

/* Klik overlay untuk tutup */
document.getElementById('modalKonfirmasi').addEventListener('click', function(e) {
    if (e.target === this) closeKonfirmasi();
});
</script>