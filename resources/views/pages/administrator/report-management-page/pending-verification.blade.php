@extends('layouts.app-admin')

@section('content')

@include('components.sidebar-admin', ['activePage' => 'menunggu-verifikasi'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Menunggu Verifikasi',
        'breadcrumbs' => [['label' => 'Pelaporan'], ['label' => 'Menunggu Verifikasi']],
    ])

    <main class="admin-main">
        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Data Laporan Menunggu Verifikasi</h2>
                <p class="content-sub">Laporan yang telah disetujui dan menunggu verifikasi lebih lanjut.</p>
            </div>
            <div class="heading-actions">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari kode / nama...">
                </div>
                <select class="filter-select" id="filterUrgensi">
                    <option value="">Semua Urgensi</option>
                    <option value="tinggi">Tinggi</option>
                    <option value="sedang">Sedang</option>
                    <option value="rendah">Rendah</option>
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
                    <p>Tidak ada laporan ditemukan</p>
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
    let LAPORAN_DATA = {}; 
    let _allRows = [];
    let _filteredRows = [];
    let _currentPage = 1;
    const PER_PAGE = 10;

    // FUNGSI AMBIL DATA DARI DB
    async function loadRealData() {
        const infoEl = document.getElementById('tableInfo');
        if (infoEl) infoEl.textContent = "Memuat data...";

        try {
            const res = await fetchAdminJson('/api/admin/reports?status=menunggu');

            if (res.success) {
                LAPORAN_DATA = res.data;
                _allRows = Object.keys(LAPORAN_DATA);
                _filteredRows = [..._allRows];
                renderTable();
            }
        } catch (error) {
            console.error("Gagal load data:", error);
        }
    }

    const AVATAR_COLORS = [
        {bg:'#fee2e2',color:'#ef4444'},{bg:'#fef9c3',color:'#ca8a04'},
        {bg:'#dbeafe',color:'#3b82f6'},{bg:'#dcfce7',color:'#15803d'},
        {bg:'#f3e8ff',color:'#9333ea'},{bg:'#ffedd5',color:'#ea580c'},
    ];
    function avatarColor(i) { return AVATAR_COLORS[i % AVATAR_COLORS.length]; }

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        const noRes = document.getElementById('noResults');
        const start = (_currentPage - 1) * PER_PAGE;
        const pageRows = _filteredRows.slice(start, start + PER_PAGE);

        if (_filteredRows.length === 0) {
            tbody.innerHTML = ''; noRes.classList.remove('hidden');
        } else {
            noRes.classList.add('hidden');
            tbody.innerHTML = pageRows.map((rowId, idx) => {
                const d = LAPORAN_DATA[rowId], av = avatarColor(idx);
                return `<tr class="table-row animate-fade-in" id="${rowId}">
                    <td class="col-no">${start + idx + 1}</td>
                    <td><span class="kode-badge">${d.kode}</span></td>
                    <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:${av.bg};color:${av.color}">${d.nama.charAt(0)}</div><span>${d.nama}</span></div></td>
                    <td class="text-mono">${d.nis}</td>
                    <td><span class="kelas-tag">${d.kelas}</span></td>
                    <td><span class="urgensi-badge ${d.urgensi}">${ucfirst(d.urgensi)}</span></td>
                    <td><span class="status-badge verifikasi">Menunggu Verifikasi</span></td>
                    <td class="col-aksi">
                        <div class="aksi-wrap" style="display: flex; gap: 8px;">
                            <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('${rowId}','menunggu-verifikasi')" 
                                style="background: #eff6ff; color: #2563eb; border-radius: 12px; padding: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button class="btn-aksi reminder" title="Kirim Reminder" onclick="handleQuickAction('reminder','${rowId}')"
                                style="background: #fffbeb; color: #d97706; border-radius: 12px; padding: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>`;
            }).join('');
        }
        buildTableInfo(document.getElementById('tableInfo'), _currentPage, _filteredRows, PER_PAGE);
        buildPagination(document.getElementById('paginationWrap'), _currentPage, _filteredRows.length, PER_PAGE, goPage);
    }

    function goPage(p) {
        const total = Math.ceil(_filteredRows.length / PER_PAGE);
        if (p < 1 || p > total) return;
        _currentPage = p; renderTable(); window.scrollTo({top:0, behavior:'smooth'});
    }

    function applyFilter() {
        const q = (document.getElementById('searchInput')?.value || '').toLowerCase();
        const u = (document.getElementById('filterUrgensi')?.value || '').toLowerCase();
        _filteredRows = _allRows.filter(id => {
            const d = LAPORAN_DATA[id];
            return (!q || d.kode.toLowerCase().includes(q) || d.nama.toLowerCase().includes(q) || d.nis.includes(q)) && (!u || d.urgensi === u);
        });
        _currentPage = 1; renderTable();
    }

    document.getElementById('searchInput')?.addEventListener('input', applyFilter);
    document.getElementById('filterUrgensi')?.addEventListener('change', applyFilter);

    function showDetail(rowId, type) {
        const d = LAPORAN_DATA[rowId]; if (!d) return;
        _currentRow = document.getElementById(rowId); _currentData = d;
        openDetailModal(d, type, _currentRow);
    }

    function handleQuickAction(action, rowId) {
        const d = LAPORAN_DATA[rowId]; if (!d) return;
        _currentRow = document.getElementById(rowId); _currentData = d;
        document.getElementById('modalDetail').style.display = 'none';
        document.body.style.overflow = '';
        triggerKonfirmasi(action);
    }

    // LOAD DATA SAAT BUKA HALAMAN
    document.addEventListener('DOMContentLoaded', () => loadRealData());
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        const openId = params.get('open');
        
        if (openId) {
            window.history.replaceState({}, '', window.location.pathname);
            
            // Tunggu loadRealData selesai dulu baru buka modal
            const waitAndOpen = setInterval(() => {
                const rowId = 'row-' + openId;
                if (LAPORAN_DATA[rowId]) {
                    clearInterval(waitAndOpen);
                    showDetail(rowId, 'menunggu-verifikasi');// ← pakai showDetail, bukan openDetailModal
                }
            }, 200); // cek setiap 200ms sampai data ready

            // Safety timeout 5 detik
            setTimeout(() => clearInterval(waitAndOpen), 5000);
        }
    });
</script>