@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

@include('components.sidebar-admin', ['activePage' => 'rekap-semester'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Rekapitulasi Per Semester',
        'breadcrumbs' => [['label' => 'Analitik'], ['label' => 'Rekapitulasi Per Semester']],
    ])

    <main class="admin-main">

        {{-- Heading + Filter --}}
        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Rekapitulasi Per Semester</h2>
                <p class="content-sub">Ringkasan laporan bullying per semester tahun ajaran.</p>
            </div>
            <div class="heading-actions">
                <select class="filter-select" id="filterSemester">
                    <option value="ganjil">Semester Ganjil</option>
                    <option value="genap" selected>Semester Genap</option>
                </select>
                <select class="filter-select" id="filterTahunAjaran">
                    <option value="2023/2024">2023/2024</option>
                    <option value="2024/2025">2024/2025</option>
                    <option value="2025/2026" selected>2025/2026</option>
                </select>
                <button class="btn-export" onclick="exportRekap()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export
                </button>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="animate-fade-in" style="animation-delay:.05s">
            @include('components.rekap-stats-admin', [
                'totalLaporan'        => 184,
                'rataRata'            => '1.2',
                'tingkatPenyelesaian' => '82',
                'periodeLabel'        => 'Semester Genap 2025/2026',
            ])
        </div>

        {{-- Grafik --}}
        <div class="rekap-chart-card animate-fade-in" style="animation-delay:.1s">
            <div class="rekap-chart-header">
                <div>
                    <h3 class="rekap-chart-title">Frekuensi Laporan Masuk</h3>
                    <p class="rekap-chart-sub">Total laporan per bulan — Semester Genap 2025/2026</p>
                </div>
                <div class="rekap-chart-peak">
                    <span class="peak-label">Puncak</span>
                    <span class="peak-val">42 laporan</span>
                    <span class="peak-date">Maret 2026</span>
                </div>
            </div>
            @include('components.rekap-chart-admin', [
                'chartId'     => 'chartSemester',
                'chartLabels' => ['Jan','Feb','Mar','Apr','Mei','Jun'],
                'chartData'   => [24, 31, 42, 38, 29, 20],
                'chartLabel'  => 'Laporan Masuk',
                'chartHeight' => 220,
            ])
        </div>

        {{-- Tabel Rekapitulasi --}}
        <div class="table-card animate-fade-in" style="animation-delay:.15s; margin-top:20px">
            <div class="rekap-table-header">
                <div>
                    <h3 class="rekap-chart-title">Rekapitulasi Detail</h3>
                    <p class="rekap-chart-sub">Per kelas — Semester Genap 2025/2026</p>
                </div>
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchTable" class="search-input" placeholder="Cari kelas...">
                </div>
            </div>
            <div class="table-scroll">
                <table class="data-table" id="rekapTable">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th>Semester / Tahun</th>
                            <th>Kelas</th>
                            <th>Total Laporan</th>
                            <th>Diselesaikan</th>
                            <th>Tingkat Selesai</th>
                            <th class="col-aksi" style="width:110px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="rekapTableBody"></tbody>
                </table>
                <div class="no-results hidden" id="noResultsRekap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Tidak ada data ditemukan</p>
                </div>
            </div>
            <div class="table-footer">
                <p class="table-info" id="tableInfoRekap">—</p>
            </div>
        </div>

    </main>

    <footer class="footer-compact" style="text-align:center;font-size:.72rem;color:#9ca3af;margin-top:28px">
        <strong style="color:#6b7280">SMK Muhammadiyah 3 Kadungora</strong> · Bersama Sekolah Aman. Semua Hak Terlindungi.
    </footer>

    @include('components.toast')
</div>

<style>
html,body{height:100%;overflow:auto;}
.admin-wrapper{min-height:100vh;overflow-y:auto;margin-left:var(--sidebar-width,260px);}
.admin-main{overflow:visible;padding-bottom:40px;}
@media(max-width:768px){.admin-wrapper{margin-left:0!important;}}

.btn-export{display:flex;align-items:center;gap:7px;padding:9px 16px;background:#10b981;color:white;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .15s;flex-shrink:0;}
.btn-export svg{width:15px;height:15px;}
.btn-export:hover{background:#059669;}

.rekap-chart-card{background:white;border-radius:16px;border:1.5px solid #f3f4f6;padding:22px 24px;box-shadow:0 1px 4px rgba(0,0,0,.04);}
.rekap-chart-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap;}
.rekap-chart-title{font-size:.9rem;font-weight:800;color:#111827;}
.rekap-chart-sub{font-size:.72rem;color:#9ca3af;margin-top:2px;}
.rekap-chart-peak{text-align:right;flex-shrink:0;}
.peak-label{display:block;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#9ca3af;}
.peak-val{display:block;font-size:1.1rem;font-weight:800;color:#10b981;line-height:1.1;}
.peak-date{display:block;font-size:.68rem;color:#9ca3af;}

.rekap-table-header{display:flex;align-items:center;justify-content:space-between;padding:18px 20px 14px;gap:14px;flex-wrap:wrap;}

.selesai-cell{display:flex;align-items:center;gap:8px;}
.selesai-bar-wrap{width:60px;height:6px;background:#f3f4f6;border-radius:99px;overflow:hidden;flex-shrink:0;}
.selesai-bar{height:100%;border-radius:99px;}
.selesai-pct{font-size:.75rem;font-weight:700;min-width:34px;}
</style>

<script>
const REKAP_SEMESTER = [
    { periode:'Genap 2025/2026', kelas:'X AKL-1',   total:28, selesai:24 },
    { periode:'Genap 2025/2026', kelas:'X RPL-1',   total:22, selesai:20 },
    { periode:'Genap 2025/2026', kelas:'X MM-1',    total:18, selesai:16 },
    { periode:'Genap 2025/2026', kelas:'XI TKJ-1',  total:31, selesai:27 },
    { periode:'Genap 2025/2026', kelas:'XI MM-2',   total:25, selesai:19 },
    { periode:'Genap 2025/2026', kelas:'XI AKL-1',  total:20, selesai:15 },
    { periode:'Genap 2025/2026', kelas:'XII AKL-1', total:19, selesai:18 },
    { periode:'Genap 2025/2026', kelas:'XII TKJ-1', total:21, selesai:12 },
];

let _filtered = [...REKAP_SEMESTER];

function pctColor(p){ return p>=75?'#10b981':p>=50?'#f59e0b':'#ef4444'; }

function renderTable(){
    const body  = document.getElementById('rekapTableBody');
    const noRes = document.getElementById('noResultsRekap');
    const info  = document.getElementById('tableInfoRekap');
    if(!_filtered.length){
        body.innerHTML='';
        noRes.classList.remove('hidden');
        info.textContent='Tidak ada data';
        return;
    }
    noRes.classList.add('hidden');
    body.innerHTML = _filtered.map((d,i)=>{
        const pct = Math.round(d.selesai/d.total*100);
        const c   = pctColor(pct);
        return `<tr class="table-row">
            <td class="col-no">${i+1}</td>
            <td>${d.periode}</td>
            <td><span class="kelas-tag">${d.kelas}</span></td>
            <td><strong>${d.total}</strong></td>
            <td>${d.selesai} / ${d.total}</td>
            <td>
                <div class="selesai-cell">
                    <div class="selesai-bar-wrap"><div class="selesai-bar" style="width:${pct}%;background:${c}"></div></div>
                    <span class="selesai-pct" style="color:${c}">${pct}%</span>
                </div>
            </td>
            <td class="col-aksi">
                <div class="aksi-wrap">
                    <button class="btn-aksi view" title="Lihat Detail">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                    <button class="btn-aksi done" title="Download">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
    info.textContent = `Menampilkan ${_filtered.length} dari ${REKAP_SEMESTER.length} kelas`;
}

document.getElementById('searchTable')?.addEventListener('input', function(){
    const q = this.value.toLowerCase();
    _filtered = REKAP_SEMESTER.filter(d => d.kelas.toLowerCase().includes(q) || d.periode.toLowerCase().includes(q));
    renderTable();
});

function exportRekap(){ alert('Fitur export akan tersambung ke backend.'); }

document.addEventListener('DOMContentLoaded', renderTable);
</script>
@endsection