<div id="detailDrawer" class="drawer-overlay" onclick="closeDrawer(event)">
    <div class="drawer-panel" id="drawerPanel">

        {{-- Header --}}
        <div class="drawer-header">
            <div>
                <h3 class="drawer-title" id="drawerTitle">Detail Kelas</h3>
                <p class="drawer-sub" id="drawerSub">—</p>
            </div>
            <button class="drawer-close" onclick="closeDrawerDirect()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <button class="drawer-download" id="drawerDownloadBtn" onclick="downloadFromDrawer()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download PDF
            </button>
        </div>

        {{-- Loading --}}
        <div id="drawerLoading" class="drawer-loading">
            <div class="drawer-spinner"></div>
            <p>Memuat data...</p>
        </div>

        {{-- Content --}}
        <div id="drawerContent" class="drawer-content hidden">

            {{-- 1. Stats utama --}}
            <div class="dk-section">
                <p class="dk-section-title">Ringkasan Laporan</p>
                <div class="dk-stats-grid">
                    <div class="dk-stat-card dk-blue">
                        <span class="dk-stat-val" id="dkTotal">0</span>
                        <span class="dk-stat-lbl">Total Laporan</span>
                    </div>
                    <div class="dk-stat-card dk-green">
                        <span class="dk-stat-val" id="dkSelesai">0</span>
                        <span class="dk-stat-lbl">Diselesaikan</span>
                    </div>
                    <div class="dk-stat-card dk-red">
                        <span class="dk-stat-val" id="dkDitolak">0</span>
                        <span class="dk-stat-lbl">Ditolak</span>
                    </div>
                </div>

                {{-- Progress penyelesaian --}}
                <div class="dk-progress-wrap">
                    <div class="dk-progress-header">
                        <span>Tingkat Penyelesaian</span>
                        <span id="dkPct" class="dk-pct-val">0%</span>
                    </div>
                    <div class="dk-progress-track">
                        <div class="dk-progress-bar" id="dkProgressBar" style="width:0%"></div>
                    </div>
                </div>
            </div>

            {{-- 2. Distribusi Urgensi --}}
            <div class="dk-section">
                <p class="dk-section-title">Distribusi Urgensi</p>
                <div class="dk-urgensi-grid">
                    <div class="dk-urgensi-card dk-urg-tinggi">
                        <div class="dk-urg-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="dk-urg-val" id="dkUrgTinggi">0</span>
                            <span class="dk-urg-lbl">Tinggi</span>
                        </div>
                    </div>
                    <div class="dk-urgensi-card dk-urg-sedang">
                        <div class="dk-urg-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="dk-urg-val" id="dkUrgSedang">0</span>
                            <span class="dk-urg-lbl">Sedang</span>
                        </div>
                    </div>
                    <div class="dk-urgensi-card dk-urg-rendah">
                        <div class="dk-urg-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="dk-urg-val" id="dkUrgRendah">0</span>
                            <span class="dk-urg-lbl">Rendah</span>
                        </div>
                    </div>
                </div>

                {{-- Bar urgensi visual --}}
                <div class="dk-urg-bars" id="dkUrgBars"></div>
            </div>

            {{-- 3. Tabel laporan terminal --}}
            <div class="dk-section">
                <p class="dk-section-title">Riwayat Laporan Selesai & Ditolak</p>
                <div class="dk-table-scroll">
                    <table class="dk-table">
                        <thead>
                            <tr>
                                <th>Kode Tiket</th>
                                <th>Pelapor</th>
                                <th>Urgensi</th>
                                <th>Status</th>
                                <th>Tgl Selesai</th>
                            </tr>
                        </thead>
                        <tbody id="dkTableBody"></tbody>
                    </table>
                    <div id="dkEmpty" class="dk-empty hidden">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>Belum ada laporan selesai atau ditolak pada periode ini</p>
                    </div>
                </div>
            </div>

            {{-- Placeholder kategori --}}
            <div class="dk-section dk-coming-soon">
                <p class="dk-section-title">Kategori Bullying</p>
                <div class="dk-placeholder">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <p>Fitur kategori bullying akan tersedia setelah algoritma klasifikasi diimplementasikan.</p>
                </div>
            </div>

        </div>{{-- /drawerContent --}}
    </div>
</div>

<style>
    .drawer-download {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px;
    border: 1.5px solid #10b981;
    background: #ecfdf5; color: #10b981;
    font-size: .75rem; font-weight: 700;
    cursor: pointer; transition: background .15s;
    white-space: nowrap; flex-shrink: 0;
}
.drawer-download:hover { background: #d1fae5; }
.drawer-download svg { width: 14px; height: 14px; }

.drawer-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.4);
    z-index: 1000;
    opacity: 0; pointer-events: none;
    transition: opacity .25s;
}
.drawer-overlay.open { opacity: 1; pointer-events: all; }

.drawer-panel {
    position: absolute; top: 0; right: 0; bottom: 0;
    width: min(500px, 100vw);
    background: #fff;
    display: flex; flex-direction: column;
    transform: translateX(100%);
    transition: transform .3s cubic-bezier(.16,1,.3,1);
    overflow: hidden;
    box-shadow: -8px 0 40px rgba(0,0,0,.12);
}
.drawer-overlay.open .drawer-panel { transform: translateX(0); }

/* Header */
.drawer-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 12px;
    padding: 20px 20px 16px;
    border-bottom: 1.5px solid #f3f4f6;
    flex-shrink: 0;
    background: #fff;
}
.drawer-title { font-size: 1.05rem; font-weight: 800; color: #111827; margin: 0; }
.drawer-sub   { font-size: .75rem; color: #9ca3af; margin: 4px 0 0; }
.drawer-close {
    width: 32px; height: 32px; border-radius: 8px;
    border: none; background: #f9fafb; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: background .15s;
}
.drawer-close:hover { background: #f3f4f6; }
.drawer-close svg { width: 16px; height: 16px; color: #6b7280; }

/* Loading */
.drawer-loading {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 12px;
    color: #9ca3af; font-size: .85rem;
}
.drawer-spinner {
    width: 32px; height: 32px; border-radius: 50%;
    border: 3px solid #f3f4f6; border-top-color: #10b981;
    animation: dkSpin .7s linear infinite;
}
@keyframes dkSpin { to { transform: rotate(360deg); } }

/* Content */
.drawer-content {
    flex: 1; overflow-y: auto; padding: 0;
    display: flex; flex-direction: column;
}
.drawer-content.hidden { display: none; }
.drawer-loading.hidden { display: none; }

/* Section */
.dk-section {
    padding: 18px 20px;
    border-bottom: 1.5px solid #f9fafb;
}
.dk-section:last-child { border-bottom: none; }
.dk-section-title {
    font-size: .72rem; font-weight: 700;
    color: #9ca3af; text-transform: uppercase;
    letter-spacing: .06em; margin: 0 0 12px;
}

/* Stats grid */
.dk-stats-grid {
    display: grid; grid-template-columns: repeat(3,1fr); gap: 10px;
    margin-bottom: 14px;
}
.dk-stat-card {
    border-radius: 12px; padding: 14px 12px;
    display: flex; flex-direction: column; align-items: center;
    gap: 4px; border: 1.5px solid transparent; text-align: center;
}
.dk-stat-val { font-size: 1.6rem; font-weight: 800; line-height: 1; }
.dk-stat-lbl { font-size: .65rem; font-weight: 600; opacity: .8; }
.dk-blue  { background:#eff6ff; border-color:#dbeafe; color:#3b82f6; }
.dk-green { background:#ecfdf5; border-color:#d1fae5; color:#10b981; }
.dk-red   { background:#fef2f2; border-color:#fecaca; color:#ef4444; }

/* Progress */
.dk-progress-wrap { display: flex; flex-direction: column; gap: 6px; }
.dk-progress-header {
    display: flex; justify-content: space-between;
    font-size: .75rem; font-weight: 600; color: #6b7280;
}
.dk-pct-val { color: #111827; font-weight: 800; }
.dk-progress-track {
    height: 8px; background: #f3f4f6; border-radius: 99px; overflow: hidden;
}
.dk-progress-bar {
    height: 100%; border-radius: 99px; background: #10b981;
    transition: width 1s cubic-bezier(.16,1,.3,1);
}

/* Urgensi */
.dk-urgensi-grid {
    display: grid; grid-template-columns: repeat(3,1fr); gap: 10px;
    margin-bottom: 14px;
}
.dk-urgensi-card {
    border-radius: 12px; padding: 12px;
    display: flex; align-items: center; gap: 10px;
    border: 1.5px solid transparent;
}
.dk-urg-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.dk-urg-icon svg { width: 16px; height: 16px; }
.dk-urg-val { display: block; font-size: 1.3rem; font-weight: 800; line-height: 1; }
.dk-urg-lbl { display: block; font-size: .62rem; font-weight: 600; opacity: .75; }

.dk-urg-tinggi { background:#fef2f2; border-color:#fecaca; color:#ef4444; }
.dk-urg-tinggi .dk-urg-icon { background:#fee2e2; }
.dk-urg-sedang { background:#fffbeb; border-color:#fde68a; color:#d97706; }
.dk-urg-sedang .dk-urg-icon { background:#fef3c7; }
.dk-urg-rendah { background:#ecfdf5; border-color:#d1fae5; color:#10b981; }
.dk-urg-rendah .dk-urg-icon { background:#d1fae5; }

/* Bar urgensi */
.dk-urg-bars { display: flex; flex-direction: column; gap: 7px; }
.dk-urg-bar-row { display: flex; align-items: center; gap: 10px; font-size: .73rem; }
.dk-urg-bar-label { width: 52px; font-weight: 600; color: #6b7280; flex-shrink: 0; }
.dk-urg-bar-track { flex: 1; height: 8px; background: #f3f4f6; border-radius: 99px; overflow: hidden; }
.dk-urg-bar-fill  { height: 100%; border-radius: 99px; transition: width .9s cubic-bezier(.16,1,.3,1); }
.dk-urg-bar-count { width: 24px; text-align: right; font-weight: 700; color: #374151; }

/* Tabel */
.dk-table-scroll { overflow-x: auto; border-radius: 10px; border: 1.5px solid #f3f4f6; }
.dk-table { width: 100%; border-collapse: collapse; font-size: .77rem; }
.dk-table thead th {
    background: #f9fafb; padding: 9px 12px;
    text-align: left; font-weight: 700; color: #6b7280;
    border-bottom: 1.5px solid #f3f4f6; white-space: nowrap;
}
.dk-table tbody td {
    padding: 9px 12px; border-bottom: 1px solid #f9fafb;
    color: #374151; vertical-align: middle;
}
.dk-table tbody tr:last-child td { border-bottom: none; }
.dk-table tbody tr:hover td { background: #fafafa; }

.dk-badge {
    display: inline-block; padding: 2px 8px; border-radius: 99px;
    font-size: .65rem; font-weight: 700; white-space: nowrap;
}
.dk-badge-selesai { background:#ecfdf5; color:#10b981; }
.dk-badge-ditolak { background:#fef2f2; color:#ef4444; }
.dk-badge-tinggi  { background:#fef2f2; color:#ef4444; }
.dk-badge-sedang  { background:#fffbeb; color:#d97706; }
.dk-badge-rendah  { background:#ecfdf5; color:#10b981; }

.dk-ticket { font-family:monospace; font-size:.71rem; color:#6b7280; font-weight:600; }

.dk-empty {
    padding: 28px; text-align: center;
    color: #9ca3af; font-size: .8rem;
}
.dk-empty svg { width:36px; height:36px; margin:0 auto 8px; display:block; }

/* Placeholder kategori */
.dk-coming-soon { background: #fafafa; }
.dk-placeholder {
    border: 1.5px dashed #e5e7eb; border-radius: 12px;
    padding: 20px; text-align: center;
    color: #9ca3af; font-size: .78rem; line-height: 1.5;
}
.dk-placeholder svg { width:32px; height:32px; margin:0 auto 8px; display:block; color:#d1d5db; }
</style>

<script>
    let _drawerParams = {};

function openDrawer(kelas, periodeParams) {
    const overlay = document.getElementById('detailDrawer');
    const content = document.getElementById('drawerContent');
    const loading = document.getElementById('drawerLoading');

    content.classList.add('hidden');
    loading.classList.remove('hidden');
    loading.innerHTML = '<div class="drawer-spinner"></div><p>Memuat data...</p>';
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';

    _drawerParams = { kelas, ...periodeParams };

    document.getElementById('drawerTitle').textContent = 'Kelas ' + kelas;
    document.getElementById('drawerSub').textContent   = 'Memuat...';

    const params = new URLSearchParams({ kelas, ...periodeParams });
    fetch(`/api/admin/rekap/detail-kelas?${params}`)
        .then(r => r.json())
        .then(json => {
            if (!json.success) throw new Error(json.message);
            renderDrawer(json.data);
        })
        .catch(err => {
            loading.innerHTML = `<p style="color:#ef4444;font-size:.85rem">Gagal memuat data.<br><small>${err.message}</small></p>`;
        });
}

function closeDrawer(e) {
    if (e.target === document.getElementById('detailDrawer')) closeDrawerDirect();
}
function closeDrawerDirect() {
    document.getElementById('detailDrawer').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDrawerDirect();
});

function renderDrawer(data) {
    document.getElementById('drawerTitle').textContent = 'Kelas ' + data.kelas;
    document.getElementById('drawerSub').textContent   = data.periodeLabel;

    // ── Stats ──────────────────────────────────────────────
    document.getElementById('dkTotal').textContent   = data.stats.total;
    document.getElementById('dkSelesai').textContent = data.stats.selesai;
    document.getElementById('dkDitolak').textContent = data.stats.ditolak;

    // Progress
    const pct      = data.stats.pct;
    const pctColor = pct >= 75 ? '#10b981' : pct >= 50 ? '#f59e0b' : '#ef4444';
    document.getElementById('dkPct').textContent = pct + '%';
    const bar = document.getElementById('dkProgressBar');
    bar.style.background = pctColor;
    bar.style.width = '0%';
    setTimeout(() => { bar.style.width = pct + '%'; }, 60);

    // ── Urgensi ────────────────────────────────────────────
    document.getElementById('dkUrgTinggi').textContent = data.urgensi.tinggi;
    document.getElementById('dkUrgSedang').textContent = data.urgensi.sedang;
    document.getElementById('dkUrgRendah').textContent = data.urgensi.rendah;

    const maxUrg = Math.max(data.urgensi.tinggi, data.urgensi.sedang, data.urgensi.rendah, 1);
    const urgCfg = [
        { key:'tinggi', label:'Tinggi', color:'#ef4444' },
        { key:'sedang', label:'Sedang', color:'#f59e0b' },
        { key:'rendah', label:'Rendah', color:'#10b981' },
    ];
    document.getElementById('dkUrgBars').innerHTML = urgCfg.map(u => {
        const count = data.urgensi[u.key] || 0;
        const w     = Math.round((count / maxUrg) * 100);
        return `<div class="dk-urg-bar-row">
            <span class="dk-urg-bar-label">${u.label}</span>
            <div class="dk-urg-bar-track">
                <div class="dk-urg-bar-fill" style="width:0%;background:${u.color}" data-target="${w}"></div>
            </div>
            <span class="dk-urg-bar-count">${count}</span>
        </div>`;
    }).join('');
    setTimeout(() => {
        document.querySelectorAll('.dk-urg-bar-fill[data-target]').forEach(el => {
            el.style.width = el.dataset.target + '%';
        });
    }, 60);

    // ── Tabel ──────────────────────────────────────────────
    const tbody = document.getElementById('dkTableBody');
    const empty = document.getElementById('dkEmpty');

    if (!data.laporan.length) {
        tbody.innerHTML = '';
        empty.classList.remove('hidden');
    } else {
        empty.classList.add('hidden');
        tbody.innerHTML = data.laporan.map(r => `
            <tr>
                <td><span class="dk-ticket">${r.ticket_code}</span></td>
                <td>${r.student_name ?? '—'}</td>
                <td><span class="dk-badge dk-badge-${r.urgency}">${
                    r.urgency === 'tinggi' ? 'Tinggi' :
                    r.urgency === 'sedang' ? 'Sedang' : 'Rendah'
                }</span></td>
                <td><span class="dk-badge dk-badge-${r.status}">${
                    r.status === 'selesai' ? 'Selesai' : 'Ditolak'
                }</span></td>
                <td style="white-space:nowrap;color:#9ca3af">${r.handled_at ?? '-'}</td>
            </tr>
        `).join('');
    }

    // Show content
    document.getElementById('drawerLoading').classList.add('hidden');
    document.getElementById('drawerContent').classList.remove('hidden');
}

function downloadFromDrawer() {
    const params = new URLSearchParams(_drawerParams);
    window.open(`/api/admin/rekap/download-kelas?${params}`, '_blank');
}
</script>