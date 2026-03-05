@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

@include('components.sidebar-admin', ['activePage' => 'laporan-masuk'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Kelola Laporan Baru',
        'breadcrumbs' => [['label' => 'Pelaporan'], ['label' => 'Laporan Masuk']],
    ])

    <main class="admin-main">
        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Data Laporan Baru</h2>
                <p class="content-sub">Daftar laporan bullying yang baru masuk dan belum diproses.</p>
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
                    <tbody id="tableBody">
                        {{-- Data dirender oleh JS dari LAPORAN_DATA --}}
                    </tbody>
                </table>
                <div class="no-results hidden" id="noResults">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Tidak ada laporan ditemukan</p>
                </div>
            </div>

            {{-- Pagination Component --}}
            @include('components.pagination', ['tableInfoId' => 'tableInfo', 'paginationId' => 'paginationWrap'])
        </div>
    </main>

    @include('components.toast')
</div>

@include('components.details-modal-admin')
@include('components.confirm-modal-admin')

<style>
.status-badge.ditolak { background: #fef2f2; color: #dc2626; }

/* ---- Scroll Fix ---- */
html, body {
    height: 100%;
    overflow: auto;
}
.admin-wrapper {
    min-height: 100vh;
    overflow-y: auto;
}
.admin-main {
    overflow: visible;
    padding-bottom: 40px;
}
.table-card {
    overflow: visible;
}
.table-scroll {
    overflow-x: auto;
    overflow-y: visible;
}
.data-table {
    overflow: visible;
}
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
/* =========================================================
   DATA LAPORAN
   ========================================================= */
const LAPORAN_DATA = {
    'row-1':  { kode:'KRF-040326-X9A1', nama:'Keonho',         nis:'12345', kelas:'XI MM-1',   urgensi:'sedang', email:'keonho@student.smkm3.sch.id',   deskripsi:'Saya mengalami perundungan secara verbal oleh beberapa teman sekelas. Mereka sering mengejek nama saya dan membuat saya merasa tidak nyaman saat berada di kelas maupun di kantin.' },
    'row-2':  { kode:'KRF-030326-B2C4', nama:'Rina Marlina',   nis:'11089', kelas:'X TKJ-2',   urgensi:'tinggi', email:'rina.m@student.smkm3.sch.id',    deskripsi:'Saya menerima pesan ancaman melalui media sosial dari kakak kelas. Pesan tersebut berisi ancaman fisik jika saya tidak memberikan uang jajan saya kepada mereka setiap hari.' },
    'row-3':  { kode:'KRF-020326-D5E7', nama:'Fahri Ramadan',  nis:'12901', kelas:'XII RPL-1', urgensi:'rendah', email:'fahri.r@student.smkm3.sch.id',   deskripsi:'Ada beberapa teman yang sering mengambil alat tulis saya tanpa izin dan tidak pernah mengembalikannya. Sudah terjadi berkali-kali dalam satu bulan terakhir.' },
    'row-4':  { kode:'KRF-010326-G8H2', nama:'Siti Rahayu',    nis:'13201', kelas:'X AKL-1',   urgensi:'tinggi', email:'siti.r@student.smkm3.sch.id',    deskripsi:'Saya dipaksa memberikan jawaban ulangan oleh teman sebangku dan diancam jika tidak mau.' },
    'row-5':  { kode:'KRF-280226-K1L9', nama:'Bagas Pratama',  nis:'11450', kelas:'XI TKJ-1',  urgensi:'sedang', email:'bagas.p@student.smkm3.sch.id',   deskripsi:'Sering diejek karena penampilan fisik saya oleh sekelompok siswa dari kelas lain.' },
    'row-6':  { kode:'KRF-270226-M3N7', nama:'Dewi Kusuma',    nis:'12670', kelas:'XII MM-2',  urgensi:'rendah', email:'dewi.k@student.smkm3.sch.id',    deskripsi:'Teman saya menyebarkan foto saya tanpa izin ke grup kelas dan membuatnya jadi bahan candaan.' },
    'row-7':  { kode:'KRF-260226-P5Q3', nama:'Arif Hidayat',   nis:'11980', kelas:'X RPL-2',   urgensi:'tinggi', email:'arif.h@student.smkm3.sch.id',    deskripsi:'Saya dipukul oleh kakak kelas saat jam istirahat di depan kantin tanpa alasan yang jelas.' },
    'row-8':  { kode:'KRF-250226-R2S6', nama:'Nurul Aini',     nis:'13450', kelas:'XI AKL-2',  urgensi:'sedang', email:'nurul.a@student.smkm3.sch.id',   deskripsi:'Ada teman yang terus menerus menggangu saya ketika sedang belajar dan mengambil barang saya.' },
    'row-9':  { kode:'KRF-240226-T8U1', nama:'Rizky Firmansyah',nis:'12100',kelas:'XII TKJ-1', urgensi:'rendah', email:'rizky.f@student.smkm3.sch.id',   deskripsi:'Saya dikucilkan dari kelompok teman karena menolak ikut membolos bersama mereka.' },
    'row-10': { kode:'KRF-230226-V4W9', nama:'Anggi Permata',  nis:'11230', kelas:'X MM-2',    urgensi:'sedang', email:'anggi.p@student.smkm3.sch.id',   deskripsi:'Seseorang memposting status berisi hinaan tentang saya di media sosial dan banyak yang me-like.' },
    'row-11': { kode:'KRF-220226-X6Y2', nama:'Dimas Saputra',  nis:'13670', kelas:'XI RPL-1',  urgensi:'tinggi', email:'dimas.s@student.smkm3.sch.id',   deskripsi:'Saya mendapat ancaman dari sekelompok siswa yang meminta uang setiap minggu.' },
    'row-12': { kode:'KRF-210226-Z0A5', nama:'Putri Handayani', nis:'12340', kelas:'XII AKL-1',urgensi:'rendah', email:'putri.h@student.smkm3.sch.id',   deskripsi:'Tas saya sering disembunyikan oleh teman sekelas sehingga saya sering terlambat masuk kelas.' },
};

/* =========================================================
   AVATAR COLORS
   ========================================================= */
const AVATAR_COLORS = [
    { bg:'#dcfce7', color:'#15803d' },
    { bg:'#fee2e2', color:'#ef4444' },
    { bg:'#dbeafe', color:'#3b82f6' },
    { bg:'#fef9c3', color:'#ca8a04' },
    { bg:'#f3e8ff', color:'#9333ea' },
    { bg:'#ffedd5', color:'#ea580c' },
];
function avatarColor(i) { return AVATAR_COLORS[i % AVATAR_COLORS.length]; }

/* =========================================================
   PAGINATION STATE
   ========================================================= */
const PER_PAGE       = 10;
let   _allRows       = Object.keys(LAPORAN_DATA);   // semua key
let   _filteredRows  = [..._allRows];
let   _currentPage   = 1;

/* =========================================================
   RENDER TABLE
   ========================================================= */
function renderTable() {
    const tbody   = document.getElementById('tableBody');
    const noRes   = document.getElementById('noResults');
    const start   = (_currentPage - 1) * PER_PAGE;
    const end     = start + PER_PAGE;
    const pageRows = _filteredRows.slice(start, end);

    if (_filteredRows.length === 0) {
        tbody.innerHTML = '';
        noRes.classList.remove('hidden');
    } else {
        noRes.classList.add('hidden');
        tbody.innerHTML = pageRows.map((rowId, idx) => {
            const d  = LAPORAN_DATA[rowId];
            const no = start + idx + 1;
            const av = avatarColor(idx);
            return `
            <tr class="table-row" id="${rowId}" data-urgensi="${d.urgensi}">
                <td class="col-no">${no}</td>
                <td><span class="kode-badge">${d.kode}</span></td>
                <td>
                    <div class="pelapor-cell">
                        <div class="pelapor-avatar" style="background:${av.bg};color:${av.color}">${d.nama.charAt(0)}</div>
                        <span>${d.nama}</span>
                    </div>
                </td>
                <td class="text-mono">${d.nis}</td>
                <td><span class="kelas-tag">${d.kelas}</span></td>
                <td><span class="urgensi-badge ${d.urgensi}">${ucfirst(d.urgensi)}</span></td>
                <td><span class="status-badge menunggu">Menunggu Approval</span></td>
                <td class="col-aksi">
                    <div class="aksi-wrap">
                        <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('${rowId}','laporan-masuk')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button class="btn-aksi approve" title="Terima Laporan" onclick="handleQuickApprove('${rowId}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    updateTableInfo();
    renderPagination();
}

function ucfirst(str) { return str.charAt(0).toUpperCase() + str.slice(1); }

/* =========================================================
   TABLE INFO
   ========================================================= */
function updateTableInfo() {
    const el    = document.getElementById('tableInfo');
    const start = (_currentPage - 1) * PER_PAGE + 1;
    const end   = Math.min(_currentPage * PER_PAGE, _filteredRows.length);
    if (el) el.textContent = _filteredRows.length === 0
        ? 'Tidak ada laporan ditemukan'
        : `Menampilkan ${start}–${end} dari ${_filteredRows.length} laporan`;
}

/* =========================================================
   PAGINATION RENDER (mengisi component)
   ========================================================= */
function renderPagination() {
    const wrap      = document.getElementById('paginationWrap');
    if (!wrap) return;
    const totalPages = Math.ceil(_filteredRows.length / PER_PAGE);
    wrap.innerHTML  = '';

    if (totalPages <= 1) return;

    /* Prev */
    const prev = makePagBtn('‹', _currentPage === 1, () => goPage(_currentPage - 1));
    prev.title = 'Sebelumnya';
    wrap.appendChild(prev);

    /* Pages */
    const pages = getPageNumbers(totalPages);
    pages.forEach(p => {
        if (p === '...') {
            const el = document.createElement('span');
            el.className = 'page-ellipsis';
            el.textContent = '...';
            wrap.appendChild(el);
        } else {
            const btn = makePagBtn(p, false, () => goPage(p));
            if (p === _currentPage) btn.classList.add('active');
            wrap.appendChild(btn);
        }
    });

    /* Next */
    const next = makePagBtn('›', _currentPage === totalPages, () => goPage(_currentPage + 1));
    next.title = 'Berikutnya';
    wrap.appendChild(next);
}

function makePagBtn(label, disabled, fn) {
    const btn = document.createElement('button');
    btn.className   = 'page-btn';
    btn.textContent = label;
    btn.disabled    = disabled;
    if (disabled) btn.style.opacity = '.4';
    btn.addEventListener('click', fn);
    return btn;
}

function getPageNumbers(total) {
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    const pages = [];
    if (_currentPage <= 4) {
        for (let i = 1; i <= 5; i++) pages.push(i);
        pages.push('...'); pages.push(total);
    } else if (_currentPage >= total - 3) {
        pages.push(1); pages.push('...');
        for (let i = total - 4; i <= total; i++) pages.push(i);
    } else {
        pages.push(1); pages.push('...');
        for (let i = _currentPage - 1; i <= _currentPage + 1; i++) pages.push(i);
        pages.push('...'); pages.push(total);
    }
    return pages;
}

function goPage(p) {
    const total = Math.ceil(_filteredRows.length / PER_PAGE);
    if (p < 1 || p > total) return;
    _currentPage = p;
    renderTable();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* =========================================================
   SEARCH & FILTER
   ========================================================= */
function applyFilter() {
    const q       = (document.getElementById('searchInput')?.value || '').toLowerCase();
    const urgensi = (document.getElementById('filterUrgensi')?.value || '').toLowerCase();
    _filteredRows = _allRows.filter(id => {
        const d = LAPORAN_DATA[id];
        const matchQ = !q || d.kode.toLowerCase().includes(q) || d.nama.toLowerCase().includes(q) || d.nis.includes(q);
        const matchU = !urgensi || d.urgensi === urgensi;
        return matchQ && matchU;
    });
    _currentPage = 1;
    renderTable();
}

document.getElementById('searchInput')?.addEventListener('input',  applyFilter);
document.getElementById('filterUrgensi')?.addEventListener('change', applyFilter);

/* =========================================================
   DETAIL MODAL
   ========================================================= */
function showDetail(rowId, type) {
    const d = LAPORAN_DATA[rowId];
    if (!d) return;
    _currentRow  = document.getElementById(rowId);
    _currentData = d;
    openDetailModal(d, type, _currentRow);
}

/* =========================================================
   QUICK APPROVE — langsung buka confirm tanpa modal detail
   ========================================================= */
function handleQuickApprove(rowId) {
    const d = LAPORAN_DATA[rowId];
    if (!d) return;
    _currentRow  = document.getElementById(rowId);
    _currentData = d;
    /* Pastikan detail modal tertutup dulu */
    document.getElementById('modalDetail').style.display = 'none';
    document.body.style.overflow = '';
    /* Langsung buka konfirmasi */
    triggerKonfirmasi('terima');
}

/* =========================================================
   INIT
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => renderTable());
</script>
@endsection