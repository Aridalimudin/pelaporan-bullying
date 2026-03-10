@extends('layouts.app-admin')

@section('content')

@include('components.sidebar-admin', ['activePage' => 'proses-laporan'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Proses Laporan',
        'breadcrumbs' => [['label' => 'Pelaporan'], ['label' => 'Proses Laporan']],
    ])

    <main class="admin-main">
        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Data Laporan Dalam Proses</h2>
                <p class="content-sub">Laporan yang sedang dalam penanganan oleh pihak sekolah.</p>
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
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/report-admin-page.js') }}"></script>
    <script>
    const LAPORAN_DATA = {
        'row-1': { kode:'KRF-250226-P1Q2', nama:'Anisa Putri',    nis:'10567', kelas:'X MM-3',   urgensi:'tinggi', email:'anisa.p@student.smkm3.sch.id',  tanggal:'25 Feb 2026', tempat:'Kantin Sekolah',   pelaku:'Siswa Kelas XII',        korban:'Anisa Putri',    saksi:'Penjaga Kantin',  deskripsi:'Saya dipaksa memberikan uang jajan saya setiap hari oleh kakak kelas.' },
        'row-2': { kode:'KRF-240226-R3S4', nama:'Muhammad Rizki', nis:'11789', kelas:'XI RPL-2',  urgensi:'sedang', email:'m.rizki@student.smkm3.sch.id',   tanggal:'24 Feb 2026', tempat:'Kelas XI RPL-2',  pelaku:'Beberapa teman sekelas', korban:'Muhammad Rizki', saksi:'2 teman sekelas', deskripsi:'Saya sering diejek dan dipermalukan di depan teman-teman ketika pelajaran berlangsung.' },
        'row-3': { kode:'KRF-230226-T5U6', nama:'Yoga Pratama',   nis:'12345', kelas:'XII AKL-2', urgensi:'rendah', email:'yoga.p@student.smkm3.sch.id',    tanggal:'23 Feb 2026', tempat:'Lorong Kelas',    pelaku:'Teman Sekelas',          korban:'Yoga Pratama',   saksi:'Tidak ada',       deskripsi:'Teman saya sering menggunakan nama saya untuk hal-hal yang tidak baik.' },
        'row-4': { kode:'KRF-220226-U7V8', nama:'Hani Pertiwi',   nis:'10678', kelas:'X AKL-2',   urgensi:'tinggi', email:'hani.p@student.smkm3.sch.id',    tanggal:'22 Feb 2026', tempat:'Ruang Kelas',     pelaku:'Teman Sebangku',         korban:'Hani Pertiwi',   saksi:'Guru Mapel',      deskripsi:'Saya dipaksa memberikan jawaban ujian secara berulang kali dengan ancaman.' },
        'row-5': { kode:'KRF-210226-W9X0', nama:'Fajar Setiawan', nis:'11890', kelas:'XI TKJ-2',  urgensi:'sedang', email:'fajar.s@student.smkm3.sch.id',   tanggal:'21 Feb 2026', tempat:'Parkiran Sekolah',pelaku:'Siswa Kelas XII',        korban:'Fajar Setiawan', saksi:'Tidak ada',       deskripsi:'Motor saya sering diganggu dan kunci helm hilang beberapa kali.' },
        'row-6': { kode:'KRF-200226-Y1Z2', nama:'Novi Anggraini', nis:'12890', kelas:'XII RPL-2', urgensi:'rendah', email:'novi.a@student.smkm3.sch.id',    tanggal:'20 Feb 2026', tempat:'Perpustakaan',    pelaku:'Teman Sekelas',          korban:'Novi Anggraini', saksi:'Petugas Pustaka', deskripsi:'Buku-buku perpustakaan yang saya pinjam sering diambil paksa.' },
    };

    const AVATAR_COLORS = [
        {bg:'#fce7f3',color:'#db2777'},{bg:'#e0e7ff',color:'#4338ca'},
        {bg:'#d1fae5',color:'#065f46'},{bg:'#fee2e2',color:'#ef4444'},
        {bg:'#fef9c3',color:'#ca8a04'},{bg:'#dbeafe',color:'#3b82f6'},
    ];
    function avatarColor(i) { return AVATAR_COLORS[i % AVATAR_COLORS.length]; }

    const PER_PAGE = 10;
    let _allRows      = Object.keys(LAPORAN_DATA);
    let _filteredRows = [..._allRows];
    let _currentPage  = 1;

    function renderTable() {
        const tbody    = document.getElementById('tableBody');
        const noRes    = document.getElementById('noResults');
        const start    = (_currentPage - 1) * PER_PAGE;
        const pageRows = _filteredRows.slice(start, start + PER_PAGE);

        if (_filteredRows.length === 0) {
            tbody.innerHTML = ''; noRes.classList.remove('hidden');
        } else {
            noRes.classList.add('hidden');
            tbody.innerHTML = pageRows.map((rowId, idx) => {
                const d = LAPORAN_DATA[rowId], av = avatarColor(idx);
                return `<tr class="table-row" id="${rowId}" data-urgensi="${d.urgensi}">
                    <td class="col-no">${start + idx + 1}</td>
                    <td><span class="kode-badge">${d.kode}</span></td>
                    <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:${av.bg};color:${av.color}">${d.nama.charAt(0)}</div><span>${d.nama}</span></div></td>
                    <td class="text-mono">${d.nis}</td>
                    <td><span class="kelas-tag">${d.kelas}</span></td>
                    <td><span class="urgensi-badge ${d.urgensi}">${ucfirst(d.urgensi)}</span></td>
                    <td><span class="status-badge proses">Sedang Diproses</span></td>
                    <td class="col-aksi"><div class="aksi-wrap">
                        <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('${rowId}','proses-laporan')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        <button class="btn-aksi done" title="Tandai Selesai" onclick="handleQuickAction('selesai','${rowId}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </button>
                    </div></td>
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

    document.addEventListener('DOMContentLoaded', () => renderTable());
    </script>
@endpush