@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

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
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
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
                    <thead><tr>
                        <th class="col-no">No</th><th>Kode Laporan</th><th>Nama Pelapor</th>
                        <th>NIS</th><th>Kelas</th><th>Urgensi</th><th>Status</th><th class="col-aksi">Aksi</th>
                    </tr></thead>
                    <tbody id="tableBody">
                        <tr class="table-row" id="row-1" data-urgensi="tinggi">
                            <td class="col-no">1</td>
                            <td><span class="kode-badge">KRF-280226-T1U2</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#fee2e2;color:#ef4444">S</div><span>Siti Nurhaliza</span></div></td>
                            <td class="text-mono">10234</td><td><span class="kelas-tag">X AKL-1</span></td>
                            <td><span class="urgensi-badge tinggi">Tinggi</span></td>
                            <td><span class="status-badge verifikasi">Menunggu Verifikasi</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-1','menunggu-verifikasi')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button class="btn-aksi verify" title="Verifikasi" onclick="quickConfirm('proses','row-1')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </button>
                            </div></td>
                        </tr>
                        <tr class="table-row" id="row-2" data-urgensi="sedang">
                            <td class="col-no">2</td>
                            <td><span class="kode-badge">KRF-270226-V3W4</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#fef9c3;color:#ca8a04">B</div><span>Budi Santoso</span></div></td>
                            <td class="text-mono">11456</td><td><span class="kelas-tag">XI TKJ-1</span></td>
                            <td><span class="urgensi-badge sedang">Sedang</span></td>
                            <td><span class="status-badge verifikasi">Menunggu Verifikasi</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-2','menunggu-verifikasi')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button class="btn-aksi verify" title="Verifikasi" onclick="quickConfirm('proses','row-2')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </button>
                            </div></td>
                        </tr>
                        <tr class="table-row" id="row-3" data-urgensi="rendah">
                            <td class="col-no">3</td>
                            <td><span class="kode-badge">KRF-260226-X5Y6</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#dbeafe;color:#3b82f6">D</div><span>Dewi Rahayu</span></div></td>
                            <td class="text-mono">12678</td><td><span class="kelas-tag">XII MM-2</span></td>
                            <td><span class="urgensi-badge rendah">Rendah</span></td>
                            <td><span class="status-badge verifikasi">Menunggu Verifikasi</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-3','menunggu-verifikasi')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button class="btn-aksi verify" title="Verifikasi" onclick="quickConfirm('proses','row-3')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </button>
                            </div></td>
                        </tr>
                        <tr class="table-row empty-row"><td class="col-no">4</td><td colspan="7"><span class="empty-cell">—</span></td></tr>
                        <tr class="table-row empty-row"><td class="col-no">5</td><td colspan="7"><span class="empty-cell">—</span></td></tr>
                    </tbody>
                </table>
                <div class="no-results hidden" id="noResults">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Tidak ada laporan ditemukan</p>
                </div>
            </div>
            <div class="table-footer">
                <p class="table-info" id="tableInfo">Menampilkan 3 dari 3 laporan</p>
                <div class="pagination">
                    <button class="page-btn active">1</button><button class="page-btn">2</button>
                    <button class="page-btn">3</button><span class="page-ellipsis">...</span>
                </div>
            </div>
        </div>
    </main>

@include('components.toast')
</div>

@include('components.details-modal-admin')
@include('components.confirm-modal-admin')

<style>.status-badge.ditolak{background:#fef2f2;color:#dc2626}</style>
<script src="{{ asset('js/report-admin-pagejs') }}"></script>
<script>
const LAPORAN_DATA = {
    'row-1': { kode:'KRF-280226-T1U2', nama:'Siti Nurhaliza', nis:'10234', kelas:'X AKL-1', email:'siti.n@student.smkm3.sch.id', tanggal:'28 Feb 2026', tempat:'Belakang Lapangan', pelaku:'Siswa Kelas XI (anonim)', korban:'Siti Nurhaliza', saksi:'Tidak ada', deskripsi:'Saya mendapat perlakuan tidak menyenangkan dari sekelompok siswa kelas XI yang sering menghalangi jalan saya dan mengancam secara fisik setiap pulang sekolah.' },
    'row-2': { kode:'KRF-270226-V3W4', nama:'Budi Santoso', nis:'11456', kelas:'XI TKJ-1', email:'budi.s@student.smkm3.sch.id', tanggal:'27 Feb 2026', tempat:'Kelas XI TKJ-1', pelaku:'Rekan Sekelas', korban:'Budi Santoso', saksi:'3 teman sekelas', deskripsi:'Ada teman sekelas yang sering menyebarkan rumor tidak benar tentang saya kepada teman-teman lain sehingga membuat saya dikucilkan dari pergaulan.' },
    'row-3': { kode:'KRF-260226-X5Y6', nama:'Dewi Rahayu', nis:'12678', kelas:'XII MM-2', email:'dewi.r@student.smkm3.sch.id', tanggal:'26 Feb 2026', tempat:'Ruang Kelas', pelaku:'Teman Sekelas', korban:'Dewi Rahayu', saksi:'Tidak ada', deskripsi:'Beberapa teman sering mencoret-coret buku dan peralatan sekolah milik saya tanpa izin.' },
};
function showDetail(rowId, type) {
    const d = LAPORAN_DATA[rowId]; if (!d) return;
    openDetailModal(d, type, document.getElementById(rowId));
}
function quickConfirm(action, rowId) {
    const d = LAPORAN_DATA[rowId] || {};
    _currentRow = document.getElementById(rowId); _currentData = d;
    triggerKonfirmasi(action);
}
</script>
@endsection