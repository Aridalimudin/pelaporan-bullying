@extends('layouts.app-admin')

@section('content')

@include('components.sidebar-admin', ['activePage' => 'laporan-ditolak'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Laporan Ditolak',
        'breadcrumbs' => [['label' => 'Pelaporan'], ['label' => 'Laporan Ditolak']],
    ])

    <main class="admin-main">
        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Data Laporan Ditolak</h2>
                <p class="content-sub">Laporan yang telah ditolak beserta informasi tahap terakhir sebelum penolakan.</p>
            </div>
            <div class="heading-actions">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari kode / nama...">
                </div>
                <select class="filter-select" id="filterTahap">
                    <option value="">Semua Tahap</option>
                    <option value="laporan-masuk">Dari: Laporan Masuk</option>
                    <option value="menunggu-verifikasi">Dari: Verifikasi</option>
                    <option value="proses-laporan">Dari: Proses Laporan</option>
                </select>
            </div>
        </div>

        <div class="table-card animate-fade-in" style="animation-delay:.1s">
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th>Kode Laporan</th>
                            <th>Nama Pelapor</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Urgensi</th>
                            <th>Ditolak Dari</th>
                            <th>Tgl Ditolak</th>
                            <th>Status</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
                <div class="no-results hidden" id="noResults">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Tidak ada laporan ditolak ditemukan</p>
                </div>
            </div>
            <div class="table-footer">
                <p class="table-info" id="tableInfo">Memuat data...</p>
                <div class="pagination" id="paginationWrap"></div>
            </div>
        </div>
    </main>

    @include('components.footer', ['type' => 'admin'])
    @include('components.toast')
</div>

@include('components.details-modal-admin')
@include('components.confirm-modal-admin')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/master-admin-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/report-admin-page.js') }}"></script>
    <script>
 /* ══════════════════════════════════════════
   STATE
══════════════════════════════════════════ */
let LAPORAN_DATA  = {};
let _allRows      = [];
let _filteredRows = [];
let _currentPage  = 1;
const PER_PAGE    = 10;

const AVATAR_COLORS = [
    { bg:'#fee2e2', color:'#ef4444' }, { bg:'#fef9c3', color:'#ca8a04' },
    { bg:'#dbeafe', color:'#3b82f6' }, { bg:'#dcfce7', color:'#15803d' },
    { bg:'#f3e8ff', color:'#9333ea' }, { bg:'#ffedd5', color:'#ea580c' },
];

const TAHAP_META = {
    'laporan-masuk'       : { label:'Laporan Masuk',  cls:'dari-masuk'      },
    'menunggu-verifikasi' : { label:'Verifikasi',     cls:'dari-verifikasi' },
    'proses-laporan'      : { label:'Proses Laporan', cls:'dari-proses'     },
};

/* ══════════════════════════════════════════
   INIT
══════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    loadRealData();
    document.getElementById('searchInput')?.addEventListener('input', applyFilter);
    document.getElementById('filterTahap')?.addEventListener('change', applyFilter);
});

/* ══════════════════════════════════════════
   FETCH DATA API
══════════════════════════════════════════ */
async function loadRealData() {
    setTableLoading(true);
    try {
        const res = await fetchAdminJson('/api/admin/reports?status=ditolak');
        if (!res.success) { showAdminToast(res.message || 'Gagal memuat data.', 'error'); return; }

        LAPORAN_DATA  = res.data || {};
        _allRows      = Object.keys(LAPORAN_DATA);
        _filteredRows = [..._allRows];
        _currentPage  = 1;
        renderTable();
    } catch (e) {
        console.error(e);
        showAdminToast('Koneksi bermasalah. Coba refresh.', 'error');
    } finally {
        setTableLoading(false);
    }
}

/* ══════════════════════════════════════════
   RENDER TABEL
══════════════════════════════════════════ */
function renderTable() {
    const tbody    = document.getElementById('tableBody');
    const noRes    = document.getElementById('noResults');
    const start    = (_currentPage - 1) * PER_PAGE;
    const pageRows = _filteredRows.slice(start, start + PER_PAGE);

    if (_filteredRows.length === 0) {
        tbody.innerHTML = '';
        noRes.classList.remove('hidden');
    } else {
        noRes.classList.add('hidden');
        tbody.innerHTML = pageRows.map((rowId, idx) => {
            const d  = LAPORAN_DATA[rowId];
            const av = AVATAR_COLORS[(start + idx) % AVATAR_COLORS.length];
            const tm = TAHAP_META[d.tahapTerakhir] || { label: d.tahapTerakhir || '-', cls: '' };
            return `
                <tr class="table-row" id="${rowId}"
                    data-tahap="${d.tahapTerakhir || ''}"
                    data-urgensi="${d.urgensi || ''}">
                    <td class="col-no">${start + idx + 1}</td>
                    <td><span class="kode-badge">${d.kode}</span></td>
                    <td>
                        <div class="pelapor-cell">
                            <div class="pelapor-avatar" style="background:${av.bg};color:${av.color}">
                                ${(d.nama || '?').charAt(0).toUpperCase()}
                            </div>
                            <span>${d.nama || '-'}</span>
                        </div>
                    </td>
                    <td class="text-mono">${d.nis || '-'}</td>
                    <td><span class="kelas-tag">${d.kelas || '-'}</span></td>
                    <td><span class="urgensi-badge ${d.urgensi}">${ucfirst(d.urgensi || '')}</span></td>
                    <td><span class="tahap-badge ${tm.cls}">${tm.label}</span></td>
                    <td class="tgl-selesai">${d.tglDitolak || '-'}</td>
                    <td><span class="status-badge ditolak">Ditolak</span></td>
                    <td class="col-aksi">
                        <div class="aksi-wrap">
                            <button class="btn-aksi view" title="Lihat Detail"
                                onclick="showDetail('${rowId}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <button class="btn-aksi restore" title="Pulihkan Laporan"
                                onclick="handleQuickAction('pulihkan','${rowId}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>`;
        }).join('');
    }

    buildTableInfo(document.getElementById('tableInfo'), _currentPage, _filteredRows, PER_PAGE);
    buildPagination(document.getElementById('paginationWrap'), _currentPage, _filteredRows.length, PER_PAGE, goPage);
}

/* ══════════════════════════════════════════
   FILTER & PAGINATION
══════════════════════════════════════════ */
function applyFilter() {
    const q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    const t = (document.getElementById('filterTahap')?.value || '').toLowerCase();
    _filteredRows = _allRows.filter(id => {
        const d = LAPORAN_DATA[id];
        const matchQ = !q || (d.kode||'').toLowerCase().includes(q)
                          || (d.nama||'').toLowerCase().includes(q)
                          || (d.nis||'').includes(q);
        const matchT = !t || d.tahapTerakhir === t;
        return matchQ && matchT;
    });
    _currentPage = 1;
    renderTable();
}

function goPage(p) {
    const total = Math.ceil(_filteredRows.length / PER_PAGE);
    if (p < 1 || p > total) return;
    _currentPage = p;
    renderTable();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ══════════════════════════════════════════
   SHOW DETAIL — buka modal dengan data lengkap
   sesuai tahap penolakan
══════════════════════════════════════════ */
function showDetail(rowId) {
    const d = LAPORAN_DATA[rowId];
    if (!d) return;
    _currentRow  = document.getElementById(rowId);
    _currentData = d;
    openDetailModal(d, 'laporan-ditolak', _currentRow);
}

/* ══════════════════════════════════════════
   QUICK ACTION (dari tombol di baris tabel)
══════════════════════════════════════════ */
function handleQuickAction(action, rowId) {
    const d = LAPORAN_DATA[rowId];
    if (!d) return;
    _currentRow  = document.getElementById(rowId);
    _currentData = d;
    document.getElementById('modalDetail').style.display = 'none';
    document.body.style.overflow = '';
    triggerKonfirmasi(action);
}

/* ══════════════════════════════════════════
   LOADING STATE TABEL
══════════════════════════════════════════ */
function setTableLoading(on) {
    const tbody = document.getElementById('tableBody');
    if (!tbody) return;
    if (on) {
        tbody.innerHTML = `
            <tr>
                <td colspan="10" style="text-align:center;padding:40px;color:#9ca3af;font-size:.85rem;">
                    <div style="display:flex;align-items:center;justify-content:center;gap:10px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            style="animation:spin 1s linear infinite;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581
                                m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Memuat data laporan ditolak...
                    </div>
                </td>
            </tr>`;
    }
}

/* ══════════════════════════════════════════
   HELPER
══════════════════════════════════════════ */
function ucfirst(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}
    </script>
@endpush