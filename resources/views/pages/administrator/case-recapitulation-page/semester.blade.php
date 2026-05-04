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
            'idPrefix'            => 'semester',
            'totalLaporan'        => 0,
            'rataRata'            => '0.0',
            'tingkatPenyelesaian' => '0',
            'periodeLabel'        => '—',
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

    @include('components.rekap-detail-drawer')
    @include('components.footer', ['type' => 'admin'])
    @include('components.toast')
</div>

<script>
let _allData  = [];
let _filtered = [];
let _chart    = null;

async function loadRekap() {
    const semester    = document.getElementById('filterSemester').value;
    const tahunAjaran = document.getElementById('filterTahunAjaran').value;

    document.getElementById('rekapTableBody').innerHTML =
        `<tr><td colspan="7" style="text-align:center;padding:24px;color:#9ca3af">Memuat data...</td></tr>`;

    try {
        const res  = await fetch(`/api/admin/rekap/semester?semester=${semester}&tahun_ajaran=${encodeURIComponent(tahunAjaran)}`);
        const json = await res.json();
        if (!json.success) throw new Error();

        const { stats, chart, tabel } = json.data;
        // Stats
        document.getElementById('semester-totalLaporan').textContent = stats.totalLaporan;
        document.getElementById('semester-rataRata').textContent     = stats.rataRata;
        document.getElementById('semester-periode').textContent      = stats.periodeLabel;
        document.getElementById('semester-pct').innerHTML            = stats.tingkatPenyelesaian + '<small>%</small>';

        const badge = document.getElementById('semester-pctBadge');
        const bar   = document.getElementById('semester-progressBar');
        const pct   = stats.tingkatPenyelesaian;
        const cls   = pct >= 75 ? 'rs-pct-good' : pct >= 50 ? 'rs-pct-mid' : 'rs-pct-low';
        const lbl   = pct >= 75 ? 'Baik'        : pct >= 50 ? 'Sedang'      : 'Rendah';

        badge.className   = `rs-pct-badge ${cls}`;
        badge.textContent = lbl;
        bar.className     = `rs-progress-bar ${cls}`;
        bar.style.width   = Math.min(100, pct) + '%';


        const allSubs = document.querySelectorAll('.rekap-chart-sub');
        if (allSubs[0]) allSubs[0].textContent = `Total laporan per bulan — ${stats.periodeLabel}`;
        if (allSubs[1]) allSubs[1].textContent = `Per kelas — ${stats.periodeLabel}`;
        document.querySelector('.peak-val').textContent  = chart.peakVal + ' laporan';
        document.querySelector('.peak-date').textContent = chart.peakLabel ?? '-';

        // Rebuild chart
        const canvas = document.getElementById('chartSemester');
        if (_chart) { _chart.destroy(); _chart = null; }
        const ctx  = canvas.getContext('2d');
        const grad = ctx.createLinearGradient(0, 0, 0, 220);
        grad.addColorStop(0,   'rgba(16,185,129,0.28)');
        grad.addColorStop(0.6, 'rgba(16,185,129,0.06)');
        grad.addColorStop(1,   'rgba(16,185,129,0)');

        _chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chart.labels,
                datasets: [{
                    label: 'Laporan Masuk',
                    data: chart.data,
                    borderColor: '#10b981', borderWidth: 2.5,
                    backgroundColor: grad,
                    pointRadius: 0, pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#10b981',
                    pointHoverBorderColor: '#fff', pointHoverBorderWidth: 2,
                    tension: 0.55, fill: true,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b', titleColor: '#f1f5f9',
                        bodyColor: '#94a3b8', padding: 12, cornerRadius: 10,
                        displayColors: false,
                        callbacks: { label: c => ' ' + c.parsed.y + ' laporan' }
                    }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 11, weight: '600' }, color: '#9ca3af' } },
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { font: { size: 11 }, color: '#9ca3af', stepSize: 5, padding: 6 } }
                }
            }
        });

        // Tabel
        _allData  = tabel;
        _filtered = [...tabel];
        renderTable();

        } catch (e) {
                console.error('loadRekap error:', e);
                document.getElementById('rekapTableBody').innerHTML =
                    `<tr><td colspan="7" style="text-align:center;padding:24px;color:#ef4444">Gagal memuat data.</td></tr>`;
            }
}

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
        const pct = d.total > 0 ? Math.round(d.selesai / d.total * 100) : 0;
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
                    <button class="btn-aksi view" title="Lihat Detail" onclick="lihatDetail('${d.kelas}')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                    <button class="btn-aksi done" title="Download" onclick="downloadKelas('${d.kelas}')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
    info.textContent = `Menampilkan ${_filtered.length} dari ${_allData.length} kelas`;
}

function lihatDetail(kelas) {
    const semester    = document.getElementById('filterSemester').value;
    const tahunAjaran = document.getElementById('filterTahunAjaran').value;
    openDrawer(kelas, { semester, tahun_ajaran: tahunAjaran });
}

function downloadKelas(kelas) {
    const semester    = document.getElementById('filterSemester').value;
    const tahunAjaran = document.getElementById('filterTahunAjaran').value;
    window.open(`/api/admin/rekap/download-kelas?kelas=${encodeURIComponent(kelas)}&semester=${semester}&tahun_ajaran=${encodeURIComponent(tahunAjaran)}`, '_blank');
}

function exportRekap() {
    const semester    = document.getElementById('filterSemester').value;
    const tahunAjaran = document.getElementById('filterTahunAjaran').value;
    window.open(`/api/admin/rekap/semester/export?semester=${semester}&tahun_ajaran=${encodeURIComponent(tahunAjaran)}`, '_blank');
}

document.getElementById('searchTable')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    _filtered = _allData.filter(d =>
        d.kelas.toLowerCase().includes(q) || d.periode.toLowerCase().includes(q)
    );
    renderTable();
});

document.getElementById('filterSemester').addEventListener('change', loadRekap);
document.getElementById('filterTahunAjaran').addEventListener('change', loadRekap);

document.addEventListener('DOMContentLoaded', loadRekap);
</script>
@endsection