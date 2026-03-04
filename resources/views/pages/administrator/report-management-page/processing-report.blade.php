@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

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
                            <td><span class="kode-badge">KRF-250226-P1Q2</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#fce7f3;color:#db2777">A</div><span>Anisa Putri</span></div></td>
                            <td class="text-mono">10567</td><td><span class="kelas-tag">X MM-3</span></td>
                            <td><span class="urgensi-badge tinggi">Tinggi</span></td>
                            <td><span class="status-badge proses">Sedang Diproses</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-1','proses-laporan')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button class="btn-aksi done" title="Tandai Selesai" onclick="quickConfirm('selesai','row-1')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </button>
                            </div></td>
                        </tr>
                        <tr class="table-row" id="row-2" data-urgensi="sedang">
                            <td class="col-no">2</td>
                            <td><span class="kode-badge">KRF-240226-R3S4</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#e0e7ff;color:#4338ca">M</div><span>Muhammad Rizki</span></div></td>
                            <td class="text-mono">11789</td><td><span class="kelas-tag">XI RPL-2</span></td>
                            <td><span class="urgensi-badge sedang">Sedang</span></td>
                            <td><span class="status-badge proses">Sedang Diproses</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-2','proses-laporan')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button class="btn-aksi done" title="Tandai Selesai" onclick="quickConfirm('selesai','row-2')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </button>
                            </div></td>
                        </tr>
                        <tr class="table-row" id="row-3" data-urgensi="rendah">
                            <td class="col-no">3</td>
                            <td><span class="kode-badge">KRF-230226-T5U6</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#d1fae5;color:#065f46">Y</div><span>Yoga Pratama</span></div></td>
                            <td class="text-mono">12345</td><td><span class="kelas-tag">XII AKL-2</span></td>
                            <td><span class="urgensi-badge rendah">Rendah</span></td>
                            <td><span class="status-badge proses">Sedang Diproses</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-3','proses-laporan')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button class="btn-aksi done" title="Tandai Selesai" onclick="quickConfirm('selesai','row-3')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
const LAPORAN_DATA = {
    'row-1': { kode:'KRF-250226-P1Q2', nama:'Anisa Putri', nis:'10567', kelas:'X MM-3', email:'anisa.p@student.smkm3.sch.id', tanggal:'25 Feb 2026', tempat:'Kantin Sekolah', pelaku:'Siswa Kelas XII', korban:'Anisa Putri', saksi:'Penjaga Kantin', deskripsi:'Saya dipaksa memberikan uang jajan saya setiap hari oleh kakak kelas. Jika tidak diberikan saya diancam akan dipukul di tempat sepi.' },
    'row-2': { kode:'KRF-240226-R3S4', nama:'Muhammad Rizki', nis:'11789', kelas:'XI RPL-2', email:'m.rizki@student.smkm3.sch.id', tanggal:'24 Feb 2026', tempat:'Kelas XI RPL-2', pelaku:'Beberapa teman sekelas', korban:'Muhammad Rizki', saksi:'2 teman sekelas', deskripsi:'Saya sering diejek dan dipermalukan di depan teman-teman ketika pelajaran berlangsung oleh beberapa orang teman sekelas.' },
    'row-3': { kode:'KRF-230226-T5U6', nama:'Yoga Pratama', nis:'12345', kelas:'XII AKL-2', email:'yoga.p@student.smkm3.sch.id', tanggal:'23 Feb 2026', tempat:'Lorong Kelas', pelaku:'Teman Sekelas', korban:'Yoga Pratama', saksi:'Tidak ada', deskripsi:'Teman saya sering menggunakan nama saya untuk hal-hal yang tidak baik dan membuat nama saya jelek di lingkungan sekolah.' },
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