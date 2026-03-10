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
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/report-admin-page.js') }}"></script>
    <script>
    const LAPORAN_DATA = {
        'row-1': { kode:'KRF-290226-Z1A2', nama:'Tomi Setiawan',  nis:'10789', kelas:'X MM-2',    urgensi:'rendah', tahapTerakhir:'laporan-masuk',       tglDitolak:'04 Mar 2026', alasanTolak:'Laporan tidak memenuhi syarat minimum — deskripsi terlalu singkat.',                                    email:'tomi.s@student.smkm3.sch.id',  deskripsi:'Ada yang nakal sama saya.' },
        'row-2': { kode:'KRF-280226-B3C4', nama:'Putri Lestari',  nis:'11901', kelas:'XI AKL-1',  urgensi:'sedang', tahapTerakhir:'laporan-masuk',       tglDitolak:'03 Mar 2026', alasanTolak:'Laporan duplikat — kasus yang sama sudah pernah dilaporkan sebelumnya.',                              email:'putri.l@student.smkm3.sch.id', deskripsi:'Teman saya sering mengejek penampilan saya di depan teman-teman.' },
        'row-3': { kode:'KRF-270226-D5E6', nama:'Agus Hermawan',  nis:'12012', kelas:'XII RPL-1', urgensi:'tinggi', tahapTerakhir:'menunggu-verifikasi', tglDitolak:'02 Mar 2026', alasanTolak:'Laporan tidak dapat diverifikasi kebenarannya. Saksi menyatakan tidak menyaksikan kejadian.',         email:'agus.h@student.smkm3.sch.id',  tanggal:'27 Feb 2026', tempat:'Belakang Lapangan', pelaku:'Siswa Kelas XII (anonim)', korban:'Agus Hermawan', saksi:'Penjaga Sekolah', deskripsi:'Saya dipukul oleh kakak kelas di belakang lapangan.' },
        'row-4': { kode:'KRF-260226-F7G8', nama:'Rina Oktavia',   nis:'10123', kelas:'X TKJ-2',   urgensi:'sedang', tahapTerakhir:'menunggu-verifikasi', tglDitolak:'01 Mar 2026', alasanTolak:'Pelapor mencabut laporannya secara sukarela setelah mediasi informal oleh wali kelas.',              email:'rina.o@student.smkm3.sch.id',  tanggal:'26 Feb 2026', tempat:'Grup WhatsApp Kelas', pelaku:'3 teman sekelas', korban:'Rina Oktavia', saksi:'2 teman lain', deskripsi:'Saya terus-menerus dikirim pesan tidak menyenangkan di grup WhatsApp.' },
        'row-5': { kode:'KRF-250226-H9I0', nama:'Danu Prakoso',   nis:'11234', kelas:'XI MM-3',   urgensi:'rendah', tahapTerakhir:'menunggu-verifikasi', tglDitolak:'28 Feb 2026', alasanTolak:'Bukti tidak cukup kuat. Tidak ada saksi dan foto/video pendukung.',                                   email:'danu.p@student.smkm3.sch.id',  tanggal:'25 Feb 2026', tempat:'Kelas XI MM-3', pelaku:'Teman sebangku', korban:'Danu Prakoso', saksi:'Tidak ada', deskripsi:'Teman sebangku saya sering mengambil alat tulis saya tanpa izin.' },
        'row-6': { kode:'KRF-200226-J1K2', nama:'Hendra Saputra', nis:'12456', kelas:'XII AKL-1', urgensi:'tinggi', tahapTerakhir:'proses-laporan',      tglDitolak:'27 Feb 2026', alasanTolak:'Proses dihentikan karena pelaku sudah pindah sekolah sehingga tidak dapat dilanjutkan ke tahap sanksi.', email:'hendra.s@student.smkm3.sch.id', tanggal:'20 Feb 2026', tempat:'Kantin Sekolah', pelaku:'Siswa Kelas XII (sudah pindah)', korban:'Hendra Saputra', saksi:'Penjaga Kantin', deskripsi:'Saya dipaksa memberikan uang jajan setiap hari.', jenisTindakan:'Pemanggilan Orang Tua', tanggalTindak:'24 Feb 2026', deskripsiTindakan:'Orang tua pelaku telah dipanggil, namun pelaku sudah pindah sekolah.' },
        'row-7': { kode:'KRF-180226-L3M4', nama:'Sinta Dewi',     nis:'10567', kelas:'X RPL-1',   urgensi:'sedang', tahapTerakhir:'proses-laporan',      tglDitolak:'26 Feb 2026', alasanTolak:'Mediasi berhasil dilakukan secara informal. Semua pihak setuju menutup kasus.',                        email:'sinta.d@student.smkm3.sch.id', tanggal:'18 Feb 2026', tempat:'Kelas X RPL-1', pelaku:'Teman Sekelas', korban:'Sinta Dewi', saksi:'Wali Kelas', deskripsi:'Beberapa teman sering meminjam barang milik saya tanpa izin.', jenisTindakan:'Mediasi', tanggalTindak:'22 Feb 2026', deskripsiTindakan:'Mediasi informal berhasil. Semua barang dikembalikan.' },
    };

    const AVATAR_COLORS = [
        {bg:'#fee2e2',color:'#ef4444'},{bg:'#fef9c3',color:'#ca8a04'},
        {bg:'#dbeafe',color:'#3b82f6'},{bg:'#dcfce7',color:'#15803d'},
        {bg:'#f3e8ff',color:'#9333ea'},{bg:'#ffedd5',color:'#ea580c'},
    ];
    function avatarColor(i) { return AVATAR_COLORS[i % AVATAR_COLORS.length]; }

    const TAHAP_META = {
        'laporan-masuk':       { label:'Laporan Masuk', cls:'dari-masuk' },
        'menunggu-verifikasi': { label:'Verifikasi',    cls:'dari-verifikasi' },
        'proses-laporan':      { label:'Proses Laporan',cls:'dari-proses' },
    };

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
                const tm = TAHAP_META[d.tahapTerakhir] || { label: d.tahapTerakhir, cls: '' };
                return `<tr class="table-row" id="${rowId}" data-tahap="${d.tahapTerakhir}" data-urgensi="${d.urgensi}">
                    <td class="col-no">${start + idx + 1}</td>
                    <td><span class="kode-badge">${d.kode}</span></td>
                    <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:${av.bg};color:${av.color}">${d.nama.charAt(0)}</div><span>${d.nama}</span></div></td>
                    <td class="text-mono">${d.nis}</td>
                    <td><span class="kelas-tag">${d.kelas}</span></td>
                    <td><span class="urgensi-badge ${d.urgensi}">${ucfirst(d.urgensi)}</span></td>
                    <td><span class="tahap-badge ${tm.cls}">${tm.label}</span></td>
                    <td class="tgl-selesai">${d.tglDitolak}</td>
                    <td><span class="status-badge ditolak">Ditolak</span></td>
                    <td class="col-aksi"><div class="aksi-wrap">
                        <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('${rowId}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        <button class="btn-aksi restore" title="Pulihkan Laporan" onclick="handleQuickAction('pulihkan','${rowId}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
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
        const t = (document.getElementById('filterTahap')?.value || '').toLowerCase();
        _filteredRows = _allRows.filter(id => {
            const d = LAPORAN_DATA[id];
            return (!q || d.kode.toLowerCase().includes(q) || d.nama.toLowerCase().includes(q) || d.nis.includes(q)) && (!t || d.tahapTerakhir === t);
        });
        _currentPage = 1; renderTable();
    }

    document.getElementById('searchInput')?.addEventListener('input', applyFilter);
    document.getElementById('filterTahap')?.addEventListener('change', applyFilter);

    function showDetail(rowId) {
        const d = LAPORAN_DATA[rowId]; if (!d) return;
        _currentRow = document.getElementById(rowId); _currentData = d;
        openDetailModal(d, 'laporan-ditolak', _currentRow);
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