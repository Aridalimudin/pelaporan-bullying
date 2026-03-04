@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

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
                        <th>NIS</th><th>Kelas</th><th>Urgensi</th><th>Tgl Selesai</th><th>Status</th><th class="col-aksi">Aksi</th>
                    </tr></thead>
                    <tbody id="tableBody">
                        <tr class="table-row" id="row-1" data-urgensi="tinggi">
                            <td class="col-no">1</td>
                            <td><span class="kode-badge">KRF-200226-A1B2</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#fee2e2;color:#ef4444">H</div><span>Hendra Kusuma</span></div></td>
                            <td class="text-mono">10111</td><td><span class="kelas-tag">X TKJ-1</span></td>
                            <td><span class="urgensi-badge tinggi">Tinggi</span></td>
                            <td style="font-size:.78rem;color:#6b7280;font-family:monospace">03 Mar 2026</td>
                            <td><span class="status-badge selesai">Selesai</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-1','laporan-selesai')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div></td>
                        </tr>
                        <tr class="table-row" id="row-2" data-urgensi="sedang">
                            <td class="col-no">2</td>
                            <td><span class="kode-badge">KRF-180226-C3D4</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#fef9c3;color:#ca8a04">N</div><span>Nadia Sari</span></div></td>
                            <td class="text-mono">11222</td><td><span class="kelas-tag">XI MM-1</span></td>
                            <td><span class="urgensi-badge sedang">Sedang</span></td>
                            <td style="font-size:.78rem;color:#6b7280;font-family:monospace">01 Mar 2026</td>
                            <td><span class="status-badge selesai">Selesai</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-2','laporan-selesai')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div></td>
                        </tr>
                        <tr class="table-row" id="row-3" data-urgensi="rendah">
                            <td class="col-no">3</td>
                            <td><span class="kode-badge">KRF-150226-E5F6</span></td>
                            <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:#dbeafe;color:#3b82f6">I</div><span>Irfan Hakim</span></div></td>
                            <td class="text-mono">12333</td><td><span class="kelas-tag">XII TKJ-2</span></td>
                            <td><span class="urgensi-badge rendah">Rendah</span></td>
                            <td style="font-size:.78rem;color:#6b7280;font-family:monospace">28 Feb 2026</td>
                            <td><span class="status-badge selesai">Selesai</span></td>
                            <td class="col-aksi"><div class="aksi-wrap">
                                <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('row-3','laporan-selesai')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div></td>
                        </tr>
                        <tr class="table-row empty-row"><td class="col-no">4</td><td colspan="8"><span class="empty-cell">—</span></td></tr>
                        <tr class="table-row empty-row"><td class="col-no">5</td><td colspan="8"><span class="empty-cell">—</span></td></tr>
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

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
const LAPORAN_DATA = {
    'row-1': { kode:'KRF-200226-A1B2', nama:'Hendra Kusuma', nis:'10111', kelas:'X TKJ-1', email:'hendra.k@student.smkm3.sch.id', tanggal:'20 Feb 2026', tempat:'Belakang Lapangan', pelaku:'Siswa Kelas XII (3 orang)', korban:'Hendra Kusuma', saksi:'Penjaga Sekolah', deskripsi:'Saya mendapat perlakuan kekerasan fisik dari kakak kelas di belakang lapangan. Sudah terjadi 3 kali dalam seminggu terakhir.', jenisTindakan:'Pemanggilan Orang Tua', tanggalTindak:'28 Feb 2026', deskripsiTindakan:'Pelaku telah dipanggil bersama orang tua, diberikan surat peringatan, dan diwajibkan mengikuti sesi konseling sebanyak 3 kali.' },
    'row-2': { kode:'KRF-180226-C3D4', nama:'Nadia Sari', nis:'11222', kelas:'XI MM-1', email:'nadia.s@student.smkm3.sch.id', tanggal:'18 Feb 2026', tempat:'Grup WhatsApp Kelas', pelaku:'3 teman sekelas', korban:'Nadia Sari', saksi:'Anggota grup lain', deskripsi:'Saya terus-menerus dikirim pesan menyakitkan melalui grup WhatsApp kelas oleh beberapa teman.', jenisTindakan:'Mediasi', tanggalTindak:'25 Feb 2026', deskripsiTindakan:'Dilakukan mediasi antara korban dan pelaku dengan pendampingan guru BK. Semua pihak sepakat untuk tidak mengulangi dan meminta maaf.' },
    'row-3': { kode:'KRF-150226-E5F6', nama:'Irfan Hakim', nis:'12333', kelas:'XII TKJ-2', email:'irfan.h@student.smkm3.sch.id', tanggal:'15 Feb 2026', tempat:'Kelas XII TKJ-2', pelaku:'Teman Sekelas', korban:'Irfan Hakim', saksi:'Wali Kelas', deskripsi:'Teman-teman sering tidak mengajak saya dalam kegiatan kelompok dan mengabaikan saya di kelas.', jenisTindakan:'Konseling', tanggalTindak:'22 Feb 2026', deskripsiTindakan:'Seluruh siswa kelas mendapatkan sesi konseling kelompok tentang pentingnya inklusivitas dan persahabatan yang sehat.' },
};
function showDetail(rowId, type) {
    const d = LAPORAN_DATA[rowId]; if (!d) return;
    openDetailModal(d, type, document.getElementById(rowId));
}
</script>
@endsection