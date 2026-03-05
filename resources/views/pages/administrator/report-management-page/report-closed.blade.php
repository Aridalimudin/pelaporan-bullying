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
.tgl-selesai { font-size:.78rem; color:#6b7280; font-family:monospace; }
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
const LAPORAN_DATA = {
    'row-1': { kode:'KRF-200226-A1B2', nama:'Hendra Kusuma',  nis:'10111', kelas:'X TKJ-1',  urgensi:'tinggi', tglSelesai:'03 Mar 2026', email:'hendra.k@student.smkm3.sch.id', tanggal:'20 Feb 2026', tempat:'Belakang Lapangan',  pelaku:'Siswa Kelas XII (3 orang)', korban:'Hendra Kusuma',  saksi:'Penjaga Sekolah',  deskripsi:'Saya mendapat perlakuan kekerasan fisik dari kakak kelas di belakang lapangan. Sudah terjadi 3 kali dalam seminggu terakhir.',                              jenisTindakan:'Pemanggilan Orang Tua', tanggalTindak:'28 Feb 2026', deskripsiTindakan:'Pelaku telah dipanggil bersama orang tua, diberikan surat peringatan, dan diwajibkan mengikuti sesi konseling sebanyak 3 kali.' },
    'row-2': { kode:'KRF-180226-C3D4', nama:'Nadia Sari',      nis:'11222', kelas:'XI MM-1',   urgensi:'sedang', tglSelesai:'01 Mar 2026', email:'nadia.s@student.smkm3.sch.id',  tanggal:'18 Feb 2026', tempat:'Grup WhatsApp Kelas', pelaku:'3 teman sekelas',           korban:'Nadia Sari',     saksi:'Anggota grup lain', deskripsi:'Saya terus-menerus dikirim pesan menyakitkan melalui grup WhatsApp kelas oleh beberapa teman.',                                                     jenisTindakan:'Mediasi',              tanggalTindak:'25 Feb 2026', deskripsiTindakan:'Dilakukan mediasi antara korban dan pelaku dengan pendampingan guru BK. Semua pihak sepakat untuk tidak mengulangi.' },
    'row-3': { kode:'KRF-150226-E5F6', nama:'Irfan Hakim',     nis:'12333', kelas:'XII TKJ-2', urgensi:'rendah', tglSelesai:'28 Feb 2026', email:'irfan.h@student.smkm3.sch.id',  tanggal:'15 Feb 2026', tempat:'Kelas XII TKJ-2',    pelaku:'Teman Sekelas',             korban:'Irfan Hakim',    saksi:'Wali Kelas',        deskripsi:'Teman-teman sering tidak mengajak saya dalam kegiatan kelompok dan mengabaikan saya di kelas.',                                                        jenisTindakan:'Konseling',            tanggalTindak:'22 Feb 2026', deskripsiTindakan:'Seluruh siswa kelas mendapatkan sesi konseling kelompok tentang inklusivitas dan persahabatan yang sehat.' },
    'row-4': { kode:'KRF-120226-G7H8', nama:'Putri Amalia',    nis:'10222', kelas:'X RPL-2',   urgensi:'tinggi', tglSelesai:'25 Feb 2026', email:'putri.a@student.smkm3.sch.id',  tanggal:'12 Feb 2026', tempat:'Toilet Putri',       pelaku:'Siswi Kelas XI',            korban:'Putri Amalia',   saksi:'2 siswi',           deskripsi:'Saya dipaksa memberikan uang dan diancam secara verbal oleh kakak kelas setiap kali masuk toilet sekolah.',                                            jenisTindakan:'Skorsing',             tanggalTindak:'19 Feb 2026', deskripsiTindakan:'Pelaku mendapatkan skorsing 3 hari dan surat peringatan pertama. Orang tua dipanggil dan diberikan pengarahan.' },
    'row-5': { kode:'KRF-100226-I9J0', nama:'Bayu Nugroho',    nis:'11333', kelas:'XI AKL-2',  urgensi:'sedang', tglSelesai:'22 Feb 2026', email:'bayu.n@student.smkm3.sch.id',   tanggal:'10 Feb 2026', tempat:'Kelas XI AKL-2',     pelaku:'Ketua Kelas',               korban:'Bayu Nugroho',   saksi:'3 teman',           deskripsi:'Ketua kelas sering memaksa saya mengerjakan tugas piket orang lain dengan ancaman tidak diajak dalam kelompok.',                                        jenisTindakan:'Pembinaan',            tanggalTindak:'17 Feb 2026', deskripsiTindakan:'Pelaku mendapatkan pembinaan dari wali kelas dan BK. Ketua kelas diganti dan dibuat aturan piket baru.' },
    'row-6': { kode:'KRF-080226-K1L2', nama:'Sari Wulandari',  nis:'12444', kelas:'XII MM-1',  urgensi:'rendah', tglSelesai:'18 Feb 2026', email:'sari.w@student.smkm3.sch.id',   tanggal:'08 Feb 2026', tempat:'Media Sosial',       pelaku:'Teman Sekelas',             korban:'Sari Wulandari', saksi:'Tidak ada',         deskripsi:'Foto-foto saya diedit secara tidak pantas dan disebarkan di media sosial oleh teman sekelas.',                                                         jenisTindakan:'Mediasi',              tanggalTindak:'15 Feb 2026', deskripsiTindakan:'Pelaku meminta maaf secara terbuka, menghapus konten, dan bersepakat tidak mengulangi perbuatan.' },
};

const AVATAR_COLORS=[
    {bg:'#fee2e2',color:'#ef4444'},{bg:'#fef9c3',color:'#ca8a04'},
    {bg:'#dbeafe',color:'#3b82f6'},{bg:'#dcfce7',color:'#15803d'},
    {bg:'#f3e8ff',color:'#9333ea'},{bg:'#ffedd5',color:'#ea580c'},
];
function avatarColor(i){return AVATAR_COLORS[i%AVATAR_COLORS.length];}

const PER_PAGE=10;
let _allRows=Object.keys(LAPORAN_DATA);
let _filteredRows=[..._allRows];
let _currentPage=1;

function renderTable(){
    const tbody=document.getElementById('tableBody'),noRes=document.getElementById('noResults');
    const start=(_currentPage-1)*PER_PAGE,pageRows=_filteredRows.slice(start,start+PER_PAGE);
    if(_filteredRows.length===0){tbody.innerHTML='';noRes.classList.remove('hidden');}
    else{
        noRes.classList.add('hidden');
        tbody.innerHTML=pageRows.map((rowId,idx)=>{
            const d=LAPORAN_DATA[rowId],av=avatarColor(idx);
            return `<tr class="table-row" id="${rowId}" data-urgensi="${d.urgensi}">
                <td class="col-no">${start+idx+1}</td>
                <td><span class="kode-badge">${d.kode}</span></td>
                <td><div class="pelapor-cell"><div class="pelapor-avatar" style="background:${av.bg};color:${av.color}">${d.nama.charAt(0)}</div><span>${d.nama}</span></div></td>
                <td class="text-mono">${d.nis}</td>
                <td><span class="kelas-tag">${d.kelas}</span></td>
                <td><span class="urgensi-badge ${d.urgensi}">${d.urgensi.charAt(0).toUpperCase()+d.urgensi.slice(1)}</span></td>
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
    updateTableInfo();renderPagination();
}

function updateTableInfo(){const el=document.getElementById('tableInfo');const s=(_currentPage-1)*PER_PAGE+1,e=Math.min(_currentPage*PER_PAGE,_filteredRows.length);if(el)el.textContent=_filteredRows.length===0?'Tidak ada laporan ditemukan':`Menampilkan ${s}–${e} dari ${_filteredRows.length} laporan`;}
function renderPagination(){const wrap=document.getElementById('paginationWrap');if(!wrap)return;const total=Math.ceil(_filteredRows.length/PER_PAGE);wrap.innerHTML='';if(total<=1)return;wrap.appendChild(makePagBtn('‹',_currentPage===1,()=>goPage(_currentPage-1)));getPageNumbers(total).forEach(p=>{if(p==='...'){const s=document.createElement('span');s.className='page-ellipsis';s.textContent='...';wrap.appendChild(s);}else{const b=makePagBtn(p,false,()=>goPage(p));if(p===_currentPage)b.classList.add('active');wrap.appendChild(b);}});wrap.appendChild(makePagBtn('›',_currentPage===total,()=>goPage(_currentPage+1)));}
function makePagBtn(label,disabled,fn){const b=document.createElement('button');b.className='page-btn';b.textContent=label;b.disabled=disabled;if(disabled)b.style.opacity='.4';b.addEventListener('click',fn);return b;}
function getPageNumbers(total){if(total<=7)return Array.from({length:total},(_,i)=>i+1);const p=[];if(_currentPage<=4){for(let i=1;i<=5;i++)p.push(i);p.push('...');p.push(total);}else if(_currentPage>=total-3){p.push(1);p.push('...');for(let i=total-4;i<=total;i++)p.push(i);}else{p.push(1);p.push('...');for(let i=_currentPage-1;i<=_currentPage+1;i++)p.push(i);p.push('...');p.push(total);}return p;}
function goPage(p){const total=Math.ceil(_filteredRows.length/PER_PAGE);if(p<1||p>total)return;_currentPage=p;renderTable();window.scrollTo({top:0,behavior:'smooth'});}
function applyFilter(){const q=(document.getElementById('searchInput')?.value||'').toLowerCase();const u=(document.getElementById('filterUrgensi')?.value||'').toLowerCase();_filteredRows=_allRows.filter(id=>{const d=LAPORAN_DATA[id];return(!q||d.kode.toLowerCase().includes(q)||d.nama.toLowerCase().includes(q)||d.nis.includes(q))&&(!u||d.urgensi===u);});_currentPage=1;renderTable();}
document.getElementById('searchInput')?.addEventListener('input',applyFilter);
document.getElementById('filterUrgensi')?.addEventListener('change',applyFilter);
function showDetail(rowId,type){const d=LAPORAN_DATA[rowId];if(!d)return;_currentRow=document.getElementById(rowId);_currentData=d;openDetailModal(d,type,_currentRow);}
document.addEventListener('DOMContentLoaded',()=>renderTable());
</script>
@endsection