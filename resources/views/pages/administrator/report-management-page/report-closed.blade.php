@extends('layouts.app-admin')

@section('content')

@include('components.sidebar-admin', ['activePage' => 'laporan-selesai'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Laporan Selesai',
        'breadcrumbs' => [['label' => 'Pelaporan'], ['label' => 'Laporan Selesai']],
    ])

    <main class="admin-main">
        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Data Laporan Selesai</h2>
                <p class="content-sub">Laporan yang telah berhasil ditangani dan diselesaikan.</p>
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
                            <th>Tgl Selesai</th>
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
        'row-1': { kode:'KRF-200226-A1B2', nama:'Hendra Kusuma', nis:'10111', kelas:'X TKJ-1',   urgensi:'tinggi', tglSelesai:'03 Mar 2026', email:'hendra.k@student.smkm3.sch.id', tanggal:'20 Feb 2026', tempat:'Belakang Lapangan',  pelaku:'Siswa Kelas XII (3 orang)', korban:'Hendra Kusuma',  saksi:'Penjaga Sekolah',   deskripsi:'Saya mendapat perlakuan kekerasan fisik dari kakak kelas.',           jenisTindakan:'Pemanggilan Orang Tua', tanggalTindak:'28 Feb 2026', deskripsiTindakan:'Pelaku telah dipanggil bersama orang tua dan diberikan surat peringatan.' },
        'row-2': { kode:'KRF-180226-C3D4', nama:'Nadia Sari',    nis:'11222', kelas:'XI MM-1',   urgensi:'sedang', tglSelesai:'01 Mar 2026', email:'nadia.s@student.smkm3.sch.id',  tanggal:'18 Feb 2026', tempat:'Grup WhatsApp Kelas', pelaku:'3 teman sekelas',           korban:'Nadia Sari',     saksi:'Anggota grup lain', deskripsi:'Saya terus-menerus dikirim pesan menyakitkan melalui grup WhatsApp kelas.', jenisTindakan:'Mediasi',              tanggalTindak:'25 Feb 2026', deskripsiTindakan:'Dilakukan mediasi antara korban dan pelaku. Semua pihak sepakat.' },
        'row-3': { kode:'KRF-150226-E5F6', nama:'Irfan Hakim',   nis:'12333', kelas:'XII TKJ-2', urgensi:'rendah', tglSelesai:'28 Feb 2026', email:'irfan.h@student.smkm3.sch.id',  tanggal:'15 Feb 2026', tempat:'Kelas XII TKJ-2',    pelaku:'Teman Sekelas',             korban:'Irfan Hakim',    saksi:'Wali Kelas',        deskripsi:'Teman-teman sering tidak mengajak saya dalam kegiatan kelompok.',         jenisTindakan:'Konseling',            tanggalTindak:'22 Feb 2026', deskripsiTindakan:'Seluruh siswa mendapatkan sesi konseling kelompok.' },
        'row-4': { kode:'KRF-120226-G7H8', nama:'Putri Amalia',  nis:'10222', kelas:'X RPL-2',   urgensi:'tinggi', tglSelesai:'25 Feb 2026', email:'putri.a@student.smkm3.sch.id',  tanggal:'12 Feb 2026', tempat:'Toilet Putri',       pelaku:'Siswi Kelas XI',            korban:'Putri Amalia',   saksi:'2 siswi',           deskripsi:'Saya dipaksa memberikan uang dan diancam secara verbal oleh kakak kelas.',  jenisTindakan:'Skorsing',             tanggalTindak:'19 Feb 2026', deskripsiTindakan:'Pelaku mendapatkan skorsing 3 hari dan surat peringatan.' },
        'row-5': { kode:'KRF-100226-I9J0', nama:'Bayu Nugroho',  nis:'11333', kelas:'XI AKL-2',  urgensi:'sedang', tglSelesai:'22 Feb 2026', email:'bayu.n@student.smkm3.sch.id',   tanggal:'10 Feb 2026', tempat:'Kelas XI AKL-2',     pelaku:'Ketua Kelas',               korban:'Bayu Nugroho',   saksi:'3 teman',           deskripsi:'Ketua kelas memaksa saya mengerjakan tugas piket orang lain.',            jenisTindakan:'Pembinaan',            tanggalTindak:'17 Feb 2026', deskripsiTindakan:'Pelaku mendapatkan pembinaan dari wali kelas dan BK.' },
        'row-6': { kode:'KRF-080226-K1L2', nama:'Sari Wulandari',nis:'12444', kelas:'XII MM-1',  urgensi:'rendah', tglSelesai:'18 Feb 2026', email:'sari.w@student.smkm3.sch.id',   tanggal:'08 Feb 2026', tempat:'Media Sosial',       pelaku:'Teman Sekelas',             korban:'Sari Wulandari', saksi:'Tidak ada',         deskripsi:'Foto-foto saya diedit secara tidak pantas dan disebarkan di media sosial.',  jenisTindakan:'Mediasi',              tanggalTindak:'15 Feb 2026', deskripsiTindakan:'Pelaku meminta maaf secara terbuka dan menghapus konten.' },
    };

    const AVATAR_COLORS = [
        {bg:'#fee2e2',color:'#ef4444'},{bg:'#fef9c3',color:'#ca8a04'},
        {bg:'#dbeafe',color:'#3b82f6'},{bg:'#dcfce7',color:'#15803d'},
        {bg:'#f3e8ff',color:'#9333ea'},{bg:'#ffedd5',color:'#ea580c'},
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
                    <td class="tgl-selesai">${d.tglSelesai}</td>
                    <td><span class="status-badge selesai">Selesai</span></td>
                    <td class="col-aksi"><div class="aksi-wrap">
                        <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('${rowId}','laporan-selesai')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
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

    document.addEventListener('DOMContentLoaded', () => renderTable());
    </script>
@endpush