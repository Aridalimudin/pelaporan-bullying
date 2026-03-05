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

    @include('components.toast')
</div>

@include('components.details-modal-admin')
@include('components.confirm-modal-admin')

<style>
.status-badge.ditolak { background:#fef2f2; color:#dc2626; }
html, body { height:100%; overflow:auto; }
.admin-wrapper { min-height:100vh; overflow-y:auto; }
.admin-main { overflow:visible; padding-bottom:40px; }
.table-card { overflow:visible; }
.table-scroll { overflow-x:auto; overflow-y:visible; }
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
const LAPORAN_DATA = {
    'row-1': { kode:'KRF-280226-T1U2', nama:'Siti Nurhaliza',  nis:'10234', kelas:'X AKL-1',  urgensi:'tinggi', email:'siti.n@student.smkm3.sch.id',  tanggal:'28 Feb 2026', tempat:'Belakang Lapangan', pelaku:'Siswa Kelas XI (anonim)', korban:'Siti Nurhaliza',  saksi:'Tidak ada',       deskripsi:'Saya mendapat perlakuan tidak menyenangkan dari sekelompok siswa kelas XI yang sering menghalangi jalan saya dan mengancam secara fisik setiap pulang sekolah.' },
    'row-2': { kode:'KRF-270226-V3W4', nama:'Budi Santoso',    nis:'11456', kelas:'XI TKJ-1', urgensi:'sedang', email:'budi.s@student.smkm3.sch.id',   tanggal:'27 Feb 2026', tempat:'Kelas XI TKJ-1',   pelaku:'Rekan Sekelas',           korban:'Budi Santoso',   saksi:'3 teman sekelas', deskripsi:'Ada teman sekelas yang sering menyebarkan rumor tidak benar tentang saya kepada teman-teman lain sehingga membuat saya dikucilkan dari pergaulan.' },
    'row-3': { kode:'KRF-260226-X5Y6', nama:'Dewi Rahayu',     nis:'12678', kelas:'XII MM-2', urgensi:'rendah', email:'dewi.r@student.smkm3.sch.id',   tanggal:'26 Feb 2026', tempat:'Ruang Kelas',       pelaku:'Teman Sekelas',           korban:'Dewi Rahayu',    saksi:'Tidak ada',       deskripsi:'Beberapa teman sering mencoret-coret buku dan peralatan sekolah milik saya tanpa izin.' },
    'row-4': { kode:'KRF-250226-Y7Z8', nama:'Andi Saputra',    nis:'10345', kelas:'X RPL-1',  urgensi:'tinggi', email:'andi.s@student.smkm3.sch.id',   tanggal:'25 Feb 2026', tempat:'Kantin',            pelaku:'Kakak Kelas',             korban:'Andi Saputra',   saksi:'Penjaga Kantin',  deskripsi:'Saya dipaksa memberikan sebagian uang jajan setiap hari dengan ancaman kekerasan.' },
    'row-5': { kode:'KRF-240226-A2B3', nama:'Fitri Handayani', nis:'11567', kelas:'XI MM-2',  urgensi:'sedang', email:'fitri.h@student.smkm3.sch.id',  tanggal:'24 Feb 2026', tempat:'Lorong Kelas',      pelaku:'Teman Sekelas',           korban:'Fitri Handayani',saksi:'2 teman',         deskripsi:'Saya sering dijahili dengan cara menyembunyikan tas dan buku saya sebelum jam pelajaran.' },
    'row-6': { kode:'KRF-230226-C4D5', nama:'Reza Firmansyah', nis:'12789', kelas:'XII TKJ-1',urgensi:'rendah', email:'reza.f@student.smkm3.sch.id',   tanggal:'23 Feb 2026', tempat:'Ruang Komputer',    pelaku:'Teman Sekelas',           korban:'Reza Firmansyah',saksi:'Guru Piket',      deskripsi:'Hasil tugas saya diklaim sebagai milik teman lain dan diserahkan ke guru tanpa izin saya.' },
    'row-7': { kode:'KRF-220226-E6F7', nama:'Lina Marlina',    nis:'10456', kelas:'X MM-1',   urgensi:'tinggi', email:'lina.m@student.smkm3.sch.id',   tanggal:'22 Feb 2026', tempat:'Toilet Sekolah',    pelaku:'Siswa Kelas XI',          korban:'Lina Marlina',   saksi:'Tidak ada',       deskripsi:'Saya diancam dan dipaksa mengerjakan PR teman di toilet sekolah saat jam istirahat.' },
    'row-8': { kode:'KRF-210226-G8H9', nama:'Doni Pratama',    nis:'11678', kelas:'XI AKL-1', urgensi:'sedang', email:'doni.p@student.smkm3.sch.id',   tanggal:'21 Feb 2026', tempat:'Kelas XI AKL-1',   pelaku:'Beberapa teman',          korban:'Doni Pratama',   saksi:'Wali Kelas',      deskripsi:'Nama saya sering dijadikan bahan lelucon di depan kelas secara berulang-ulang.' },
};

const AVATAR_COLORS = [
    {bg:'#fee2e2',color:'#ef4444'},{bg:'#fef9c3',color:'#ca8a04'},
    {bg:'#dbeafe',color:'#3b82f6'},{bg:'#dcfce7',color:'#15803d'},
    {bg:'#f3e8ff',color:'#9333ea'},{bg:'#ffedd5',color:'#ea580c'},
];
function avatarColor(i) { return AVATAR_COLORS[i % AVATAR_COLORS.length]; }

const PER_PAGE    = 10;
let _allRows      = Object.keys(LAPORAN_DATA);
let _filteredRows = [..._allRows];
let _currentPage  = 1;

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
            const d = LAPORAN_DATA[rowId];
            const av = avatarColor(idx);
            return `
            <tr class="table-row" id="${rowId}" data-urgensi="${d.urgensi}">
                <td class="col-no">${start + idx + 1}</td>
                <td><span class="kode-badge">${d.kode}</span></td>
                <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:${av.bg};color:${av.color}">${d.nama.charAt(0)}</div><span>${d.nama}</span></div></td>
                <td class="text-mono">${d.nis}</td>
                <td><span class="kelas-tag">${d.kelas}</span></td>
                <td><span class="urgensi-badge ${d.urgensi}">${d.urgensi.charAt(0).toUpperCase()+d.urgensi.slice(1)}</span></td>
                <td><span class="status-badge verifikasi">Menunggu Verifikasi</span></td>
                <td class="col-aksi"><div class="aksi-wrap">
                    <button class="btn-aksi view" title="Lihat Detail" onclick="showDetail('${rowId}','menunggu-verifikasi')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                    <button class="btn-aksi verify" title="Proses Laporan" onclick="handleQuickAction('proses','${rowId}')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </button>
                </div></td>
            </tr>`;
        }).join('');
    }
    updateTableInfo(); renderPagination();
}

function updateTableInfo() {
    const el = document.getElementById('tableInfo');
    const s  = (_currentPage-1)*PER_PAGE+1;
    const e  = Math.min(_currentPage*PER_PAGE, _filteredRows.length);
    if (el) el.textContent = _filteredRows.length === 0 ? 'Tidak ada laporan ditemukan' : `Menampilkan ${s}–${e} dari ${_filteredRows.length} laporan`;
}

function renderPagination() {
    const wrap = document.getElementById('paginationWrap');
    if (!wrap) return;
    const total = Math.ceil(_filteredRows.length / PER_PAGE);
    wrap.innerHTML = '';
    if (total <= 1) return;
    wrap.appendChild(makePagBtn('‹', _currentPage===1, ()=>goPage(_currentPage-1)));
    getPageNumbers(total).forEach(p => {
        if (p==='...') { const s=document.createElement('span'); s.className='page-ellipsis'; s.textContent='...'; wrap.appendChild(s); }
        else { const b=makePagBtn(p,false,()=>goPage(p)); if(p===_currentPage) b.classList.add('active'); wrap.appendChild(b); }
    });
    wrap.appendChild(makePagBtn('›', _currentPage===total, ()=>goPage(_currentPage+1)));
}

function makePagBtn(label, disabled, fn) {
    const b=document.createElement('button'); b.className='page-btn'; b.textContent=label; b.disabled=disabled;
    if(disabled) b.style.opacity='.4'; b.addEventListener('click',fn); return b;
}

function getPageNumbers(total) {
    if(total<=7) return Array.from({length:total},(_,i)=>i+1);
    const p=[];
    if(_currentPage<=4){for(let i=1;i<=5;i++)p.push(i);p.push('...');p.push(total);}
    else if(_currentPage>=total-3){p.push(1);p.push('...');for(let i=total-4;i<=total;i++)p.push(i);}
    else{p.push(1);p.push('...');for(let i=_currentPage-1;i<=_currentPage+1;i++)p.push(i);p.push('...');p.push(total);}
    return p;
}

function goPage(p) {
    const total=Math.ceil(_filteredRows.length/PER_PAGE);
    if(p<1||p>total) return;
    _currentPage=p; renderTable(); window.scrollTo({top:0,behavior:'smooth'});
}

function applyFilter() {
    const q=(document.getElementById('searchInput')?.value||'').toLowerCase();
    const u=(document.getElementById('filterUrgensi')?.value||'').toLowerCase();
    _filteredRows=_allRows.filter(id=>{
        const d=LAPORAN_DATA[id];
        return (!q||d.kode.toLowerCase().includes(q)||d.nama.toLowerCase().includes(q)||d.nis.includes(q))&&(!u||d.urgensi===u);
    });
    _currentPage=1; renderTable();
}

document.getElementById('searchInput')?.addEventListener('input', applyFilter);
document.getElementById('filterUrgensi')?.addEventListener('change', applyFilter);

function showDetail(rowId, type) {
    const d=LAPORAN_DATA[rowId]; if(!d) return;
    _currentRow=document.getElementById(rowId); _currentData=d;
    openDetailModal(d, type, _currentRow);
}

function handleQuickAction(action, rowId) {
    const d=LAPORAN_DATA[rowId]; if(!d) return;
    _currentRow=document.getElementById(rowId); _currentData=d;
    document.getElementById('modalDetail').style.display='none';
    document.body.style.overflow='';
    triggerKonfirmasi(action);
}

document.addEventListener('DOMContentLoaded', ()=>renderTable());
</script>
@endsection