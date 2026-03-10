@extends('layouts.app-admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
<link rel="stylesheet" href="{{ asset('css/recapitulation-admin-page.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

@include('components.sidebar-admin', ['activePage' => 'rekap-semester'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Rekapitulasi Per Semester',
        'breadcrumbs' => [['label' => 'Analitik'], ['label' => 'Rekapitulasi Per Semester']],
    ])

    <main class="admin-main">

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

        <div class="animate-fade-in" style="animation-delay:.05s">
            @include('components.rekap-stats-admin', [
                'totalLaporan'        => 184,
                'rataRata'            => '1.2',
                'tingkatPenyelesaian' => '82',
                'periodeLabel'        => 'Semester Genap 2025/2026',
            ])
        </div>

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

    @include('components.footer', ['type' => 'admin'])
    @include('components.toast')
</div>

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

function pctColor(p) { return p >= 75 ? '#10b981' : p >= 50 ? '#f59e0b' : '#ef4444'; }

function renderTable() {
    const body  = document.getElementById('rekapTableBody');
    const noRes = document.getElementById('noResultsRekap');
    const info  = document.getElementById('tableInfoRekap');
    if (!_filtered.length) {
        body.innerHTML = '';
        noRes.classList.remove('hidden');
        info.textContent = 'Tidak ada data';
        return;
    }
    noRes.classList.add('hidden');
    body.innerHTML = _filtered.map((d, i) => {
        const pct = Math.round(d.selesai / d.total * 100);
        const c   = pctColor(pct);
        return `<tr class="table-row">
            <td class="col-no">${i + 1}</td>
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

document.getElementById('searchTable')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    _filtered = REKAP_SEMESTER.filter(d => d.kelas.toLowerCase().includes(q) || d.periode.toLowerCase().includes(q));
    renderTable();
});

function exportRekap() { alert('Fitur export akan tersambung ke backend.'); }

document.addEventListener('DOMContentLoaded', renderTable);
</script>
@endsection