@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

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

    @include('components.toast')
</div>

@include('components.details-modal-admin')
@include('components.confirm-modal-admin')

<style>
html, body { height:100%; overflow:auto; }
.admin-wrapper { min-height:100vh; overflow-y:auto; }
.admin-main { overflow:visible; padding-bottom:40px; }
.table-card { overflow:visible; }
.table-scroll { overflow-x:auto; overflow-y:visible; }

/* Tahap badge */
.tahap-badge {
    display:inline-flex; align-items:center; gap:5px;
    font-size:.7rem; font-weight:700; padding:3px 9px;
    border-radius:6px; white-space:nowrap;
}
.tahap-badge.dari-masuk       { background:#dbeafe; color:#1d4ed8; }
.tahap-badge.dari-verifikasi  { background:#ede9fe; color:#5b21b6; }
.tahap-badge.dari-proses      { background:#fef9c3; color:#b45309; }

.btn-aksi.restore {
    background:#eff6ff; color:#3b82f6; border:1.5px solid #bfdbfe;
}
.btn-aksi.restore:hover { background:#dbeafe; }
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
/* =========================================================
   DATA — masing-masing entry menyimpan seluruh data
   sesuai tahap terakhirnya sebelum ditolak
   ========================================================= */
const LAPORAN_DATA = {

    /* ---- Ditolak dari LAPORAN MASUK (data minimal, belum ada pelaku/korban) ---- */
    'row-1': {
        kode:'KRF-290226-Z1A2', nama:'Tomi Setiawan',    nis:'10789', kelas:'X MM-2',
        urgensi:'rendah',
        /* Info penolakan */
        tahapTerakhir:'laporan-masuk', tglDitolak:'04 Mar 2026',
        alasanTolak:'Laporan tidak memenuhi syarat minimum — deskripsi terlalu singkat dan tidak ada bukti pendukung. Pelapor diminta melengkapi laporan.',
        /* Data pelapor */
        email:'tomi.s@student.smkm3.sch.id',
        /* Tidak ada data waktu/pihak karena ditolak di tahap masuk */
        deskripsi:'Ada yang nakal sama saya.',
    },
    'row-2': {
        kode:'KRF-280226-B3C4', nama:'Putri Lestari',    nis:'11901', kelas:'XI AKL-1',
        urgensi:'sedang',
        tahapTerakhir:'laporan-masuk', tglDitolak:'03 Mar 2026',
        alasanTolak:'Laporan duplikat — kasus yang sama sudah pernah dilaporkan sebelumnya dengan kode KRF-200226 dan sedang dalam penanganan.',
        email:'putri.l@student.smkm3.sch.id',
        deskripsi:'Teman saya sering mengejek penampilan saya di depan teman-teman.',
    },

    /* ---- Ditolak dari MENUNGGU VERIFIKASI (ada data waktu & pihak) ---- */
    'row-3': {
        kode:'KRF-270226-D5E6', nama:'Agus Hermawan',    nis:'12012', kelas:'XII RPL-1',
        urgensi:'tinggi',
        tahapTerakhir:'menunggu-verifikasi', tglDitolak:'02 Mar 2026',
        alasanTolak:'Setelah dilakukan investigasi awal, laporan tidak dapat diverifikasi kebenarannya. Saksi yang disebutkan menyatakan tidak menyaksikan kejadian tersebut.',
        email:'agus.h@student.smkm3.sch.id',
        tanggal:'27 Feb 2026', tempat:'Belakang Lapangan',
        pelaku:'Siswa Kelas XII (anonim)', korban:'Agus Hermawan', saksi:'Penjaga Sekolah',
        deskripsi:'Saya dipukul oleh kakak kelas di belakang lapangan saat jam istirahat berlangsung.',
    },
    'row-4': {
        kode:'KRF-260226-F7G8', nama:'Rina Oktavia',     nis:'10123', kelas:'X TKJ-2',
        urgensi:'sedang',
        tahapTerakhir:'menunggu-verifikasi', tglDitolak:'01 Mar 2026',
        alasanTolak:'Laporan tidak dapat dilanjutkan karena pelapor mencabut laporannya secara sukarela setelah dilakukan mediasi informal oleh wali kelas.',
        email:'rina.o@student.smkm3.sch.id',
        tanggal:'26 Feb 2026', tempat:'Grup WhatsApp Kelas',
        pelaku:'3 teman sekelas', korban:'Rina Oktavia', saksi:'2 teman lain',
        deskripsi:'Saya terus-menerus dikirim pesan tidak menyenangkan di grup WhatsApp kelas oleh beberapa teman.',
    },
    'row-5': {
        kode:'KRF-250226-H9I0', nama:'Danu Prakoso',     nis:'11234', kelas:'XI MM-3',
        urgensi:'rendah',
        tahapTerakhir:'menunggu-verifikasi', tglDitolak:'28 Feb 2026',
        alasanTolak:'Bukti yang diajukan tidak cukup kuat untuk melanjutkan proses. Tidak ada saksi dan foto/video pendukung yang dapat diverifikasi.',
        email:'danu.p@student.smkm3.sch.id',
        tanggal:'25 Feb 2026', tempat:'Kelas XI MM-3',
        pelaku:'Teman sebangku', korban:'Danu Prakoso', saksi:'Tidak ada',
        deskripsi:'Teman sebangku saya sering mengambil alat tulis saya tanpa izin.',
    },

    /* ---- Ditolak dari PROSES LAPORAN (ada data tindak lanjut parsial) ---- */
    'row-6': {
        kode:'KRF-200226-J1K2', nama:'Hendra Saputra',   nis:'12456', kelas:'XII AKL-1',
        urgensi:'tinggi',
        tahapTerakhir:'proses-laporan', tglDitolak:'27 Feb 2026',
        alasanTolak:'Proses tindak lanjut dihentikan karena pelaku yang teridentifikasi ternyata sudah pindah sekolah sehingga kasus tidak dapat dilanjutkan ke tahap sanksi.',
        email:'hendra.s@student.smkm3.sch.id',
        tanggal:'20 Feb 2026', tempat:'Kantin Sekolah',
        pelaku:'Siswa Kelas XII (sudah pindah)', korban:'Hendra Saputra', saksi:'Penjaga Kantin',
        deskripsi:'Saya dipaksa memberikan uang jajan setiap hari dengan ancaman kekerasan oleh kakak kelas.',
        /* Data tindak lanjut parsial sebelum ditolak */
        jenisTindakan:'Pemanggilan Orang Tua',
        tanggalTindak:'24 Feb 2026',
        deskripsiTindakan:'Orang tua pelaku telah dipanggil, namun diketahui pelaku sudah pindah sekolah sejak 25 Feb 2026. Proses tidak dapat dilanjutkan.',
    },
    'row-7': {
        kode:'KRF-180226-L3M4', nama:'Sinta Dewi',       nis:'10567', kelas:'X RPL-1',
        urgensi:'sedang',
        tahapTerakhir:'proses-laporan', tglDitolak:'26 Feb 2026',
        alasanTolak:'Mediasi sudah berhasil dilakukan secara informal antara pihak-pihak yang terlibat sebelum proses formal diselesaikan. Semua pihak setuju untuk menutup kasus.',
        email:'sinta.d@student.smkm3.sch.id',
        tanggal:'18 Feb 2026', tempat:'Kelas X RPL-1',
        pelaku:'Teman Sekelas', korban:'Sinta Dewi', saksi:'Wali Kelas',
        deskripsi:'Beberapa teman sering meminjam barang milik saya tanpa izin dan tidak mengembalikannya tepat waktu.',
        jenisTindakan:'Mediasi',
        tanggalTindak:'22 Feb 2026',
        deskripsiTindakan:'Mediasi informal telah berhasil di luar sistem. Semua barang dikembalikan dan pelaku meminta maaf. Pelapor meminta kasus ditutup.',
    },
};

const AVATAR_COLORS = [
    {bg:'#fee2e2',color:'#ef4444'},{bg:'#fef9c3',color:'#ca8a04'},
    {bg:'#dbeafe',color:'#3b82f6'},{bg:'#dcfce7',color:'#15803d'},
    {bg:'#f3e8ff',color:'#9333ea'},{bg:'#ffedd5',color:'#ea580c'},
    {bg:'#fce7f3',color:'#db2777'},{bg:'#e0e7ff',color:'#4338ca'},
];
function avatarColor(i){return AVATAR_COLORS[i%AVATAR_COLORS.length];}

/* Label & class untuk kolom "Ditolak Dari" */
const TAHAP_META = {
    'laporan-masuk':       { label:'Laporan Masuk',  cls:'dari-masuk' },
    'menunggu-verifikasi': { label:'Verifikasi',      cls:'dari-verifikasi' },
    'proses-laporan':      { label:'Proses Laporan',  cls:'dari-proses' },
};

const PER_PAGE    = 10;
let _allRows      = Object.keys(LAPORAN_DATA);
let _filteredRows = [..._allRows];
let _currentPage  = 1;

/* =========================================================
   RENDER TABLE
   ========================================================= */
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
            const d   = LAPORAN_DATA[rowId];
            const av  = avatarColor(idx);
            const tm  = TAHAP_META[d.tahapTerakhir] || {label:d.tahapTerakhir, cls:''};
            return `
            <tr class="table-row" id="${rowId}" data-tahap="${d.tahapTerakhir}" data-urgensi="${d.urgensi}">
                <td class="col-no">${start + idx + 1}</td>
                <td><span class="kode-badge">${d.kode}</span></td>
                <td>
                    <div class="pelapor-cell">
                        <div class="pelapor-avatar" style="background:${av.bg};color:${av.color}">${d.nama.charAt(0)}</div>
                        <span>${d.nama}</span>
                    </div>
                </td>
                <td class="text-mono">${d.nis}</td>
                <td><span class="kelas-tag">${d.kelas}</span></td>
                <td><span class="urgensi-badge ${d.urgensi}">${d.urgensi.charAt(0).toUpperCase()+d.urgensi.slice(1)}</span></td>
                <td><span class="tahap-badge ${tm.cls}">${tm.label}</span></td>
                <td style="font-size:.78rem;color:#6b7280;font-family:monospace">${d.tglDitolak}</td>
                <td><span class="status-badge ditolak">Ditolak</span></td>
                <td class="col-aksi">
                    <div class="aksi-wrap">
                        <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('${rowId}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button class="btn-aksi restore" title="Pulihkan Laporan" onclick="handlePulihkan('${rowId}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }
    updateTableInfo(); renderPagination();
}

function updateTableInfo() {
    const el = document.getElementById('tableInfo');
    const s  = (_currentPage-1)*PER_PAGE+1;
    const e  = Math.min(_currentPage*PER_PAGE, _filteredRows.length);
    if (el) el.textContent = _filteredRows.length === 0
        ? 'Tidak ada laporan ditemukan'
        : `Menampilkan ${s}–${e} dari ${_filteredRows.length} laporan`;
}

/* =========================================================
   PAGINATION
   ========================================================= */
function renderPagination() {
    const wrap  = document.getElementById('paginationWrap'); if (!wrap) return;
    const total = Math.ceil(_filteredRows.length / PER_PAGE);
    wrap.innerHTML = ''; if (total <= 1) return;
    wrap.appendChild(makePagBtn('‹', _currentPage===1, ()=>goPage(_currentPage-1)));
    getPageNumbers(total).forEach(p => {
        if (p==='...') { const s=document.createElement('span');s.className='page-ellipsis';s.textContent='...';wrap.appendChild(s); }
        else { const b=makePagBtn(p,false,()=>goPage(p)); if(p===_currentPage)b.classList.add('active'); wrap.appendChild(b); }
    });
    wrap.appendChild(makePagBtn('›', _currentPage===total, ()=>goPage(_currentPage+1)));
}
function makePagBtn(label,disabled,fn){const b=document.createElement('button');b.className='page-btn';b.textContent=label;b.disabled=disabled;if(disabled)b.style.opacity='.4';b.addEventListener('click',fn);return b;}
function getPageNumbers(total){if(total<=7)return Array.from({length:total},(_,i)=>i+1);const p=[];if(_currentPage<=4){for(let i=1;i<=5;i++)p.push(i);p.push('...');p.push(total);}else if(_currentPage>=total-3){p.push(1);p.push('...');for(let i=total-4;i<=total;i++)p.push(i);}else{p.push(1);p.push('...');for(let i=_currentPage-1;i<=_currentPage+1;i++)p.push(i);p.push('...');p.push(total);}return p;}
function goPage(p){const total=Math.ceil(_filteredRows.length/PER_PAGE);if(p<1||p>total)return;_currentPage=p;renderTable();window.scrollTo({top:0,behavior:'smooth'});}

/* =========================================================
   FILTER
   ========================================================= */
function applyFilter() {
    const q = (document.getElementById('searchInput')?.value||'').toLowerCase();
    const t = (document.getElementById('filterTahap')?.value||'').toLowerCase();
    _filteredRows = _allRows.filter(id => {
        const d = LAPORAN_DATA[id];
        const matchQ = !q || d.kode.toLowerCase().includes(q) || d.nama.toLowerCase().includes(q) || d.nis.includes(q);
        const matchT = !t || d.tahapTerakhir === t;
        return matchQ && matchT;
    });
    _currentPage = 1; renderTable();
}
document.getElementById('searchInput')?.addEventListener('input', applyFilter);
document.getElementById('filterTahap')?.addEventListener('change', applyFilter);

/* =========================================================
   SHOW DETAIL — kirim type 'laporan-ditolak'
   Modal akan render data sesuai tahapTerakhir
   ========================================================= */
function showDetail(rowId) {
    const d = LAPORAN_DATA[rowId]; if (!d) return;
    _currentRow  = document.getElementById(rowId);
    _currentData = d;
    openDetailModal(d, 'laporan-ditolak', _currentRow);
}

/* =========================================================
   PULIHKAN — buka confirm modal langsung dari tombol tabel
   ========================================================= */
function handlePulihkan(rowId) {
    const d = LAPORAN_DATA[rowId]; if (!d) return;
    _currentRow  = document.getElementById(rowId);
    _currentData = d;
    document.getElementById('modalDetail').style.display = 'none';
    document.body.style.overflow = '';
    triggerKonfirmasi('pulihkan');
}

document.addEventListener('DOMContentLoaded', () => renderTable());
</script>
@endsection