@extends('layouts.app-admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
<link rel="stylesheet" href="{{ asset('css/recapitulation-admin-page.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

@include('components.sidebar-admin', ['activePage' => 'rekap-bulan'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Rekapitulasi Per Bulan',
        'breadcrumbs' => [['label' => 'Analitik'], ['label' => 'Rekapitulasi Per Bulan']],
    ])

    <main class="admin-main">

        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Rekapitulasi Per Bulan</h2>
                <p class="content-sub">Ringkasan laporan bullying berdasarkan bulan yang dipilih.</p>
            </div>
            <div class="heading-actions">
                <select class="filter-select" id="filterBulan">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3" selected>Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                <select class="filter-select" id="filterTahun">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026" selected>2026</option>
                </select>
                <button class="btn-export" onclick="exportRekap()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export
                </button>
            </div>
        </div>

        <div class="animate-fade-in" style="animation-delay:.05s" id="statsWrap">
        @include('components.rekap-stats-admin', [
            'idPrefix'            => 'bulan',
            'totalLaporan'        => 0,
            'rataRata'            => '0.0',
            'tingkatPenyelesaian' => '0',
            'periodeLabel'        => '—',
            'pelaporSiswa'        => 0,
            'pelaporOrtu'         => 0,
        ])
        </div>

        <div class="rekap-chart-card animate-fade-in" style="animation-delay:.1s">
            <div class="rekap-chart-header">
                <div>
                    <h3 class="rekap-chart-title">Frekuensi Laporan Masuk</h3>
                    <p class="rekap-chart-sub" id="chartSubLabel">Total laporan per hari — Maret 2026</p>
                </div>
                <div class="rekap-chart-peak">
                    <span class="peak-label">Puncak</span>
                    <span class="peak-val">— laporan</span>
                    <span class="peak-date">—</span>
                </div>
            </div>
            @include('components.rekap-chart-admin', [
                'chartId'     => 'chartBulan',
                'chartLabels' => [],
                'chartData'   => [],
                'chartLabel'  => 'Laporan Masuk',
                'chartHeight' => 220,
            ])
        </div>

        <div class="table-card animate-fade-in" style="animation-delay:.15s; margin-top:20px">
            <div class="rekap-table-header">
                <div>
                    <h3 class="rekap-chart-title">Rekapitulasi Detail</h3>
                    <p class="rekap-chart-sub" id="tableSubLabel">Per kelas — Maret 2026</p>
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
                            <th>Bulan / Tahun</th>
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
// ── State ────────────────────────────────────────────────
let _allData  = [];
let _filtered = [];
let _chart    = null;

// ── Ambil data dari API ──────────────────────────────────
async function loadRekap() {
    const bulan = document.getElementById('filterBulan').value;
    const tahun = document.getElementById('filterTahun').value;

    // Tampilkan loading di tabel
    document.getElementById('rekapTableBody').innerHTML =
        `<tr><td colspan="7" style="text-align:center;padding:24px;color:#9ca3af">Memuat data...</td></tr>`;

    try {
        const res  = await fetch(`/api/admin/rekap/bulan?bulan=${bulan}&tahun=${tahun}`);
        const json = await res.json();
        if (!json.success) throw new Error('Gagal memuat data');

        const { stats, chart, tabel } = json.data;

        updateStats(stats);
        updateChart(chart);

        _allData  = tabel;
        _filtered = [...tabel];
        renderTable();

    } catch (e) {
        document.getElementById('rekapTableBody').innerHTML =
            `<tr><td colspan="7" style="text-align:center;padding:24px;color:#ef4444">Gagal memuat data. Coba lagi.</td></tr>`;
    }
}

// ── Update stats card ────────────────────────────────────
function updateStats(stats) {
    document.getElementById('bulan-totalLaporan').textContent = stats.totalLaporan;
    document.getElementById('bulan-rataRata').textContent     = stats.rataRata;
    document.getElementById('bulan-periode').textContent      = stats.periodeLabel;
    document.getElementById('bulan-pct').innerHTML            = stats.tingkatPenyelesaian + '<small>%</small>';

    // Badge warna
    const badge = document.getElementById('bulan-pctBadge');
    const bar   = document.getElementById('bulan-progressBar');
    const pct   = stats.tingkatPenyelesaian;
    const cls   = pct >= 75 ? 'rs-pct-good' : pct >= 50 ? 'rs-pct-mid' : 'rs-pct-low';
    const lbl   = pct >= 75 ? 'Baik' : pct >= 50 ? 'Sedang' : 'Rendah';

    badge.className = `rs-pct-badge ${cls}`;
    badge.textContent = lbl;
    bar.className   = `rs-progress-bar ${cls}`;
    bar.style.width = Math.min(100, pct) + '%';

    // Tambahan 2 baris update pelapor
    document.getElementById('bulan-pelaporSiswa').textContent = stats.pelaporSiswa ?? 0;
    document.getElementById('bulan-pelaporOrtu').textContent  = stats.pelaporOrtu  ?? 0;
}

// ── Update chart ─────────────────────────────────────────
function updateChart(chart) {
    // Update teks peak
    document.querySelector('.peak-val').textContent  = chart.peakVal + ' laporan';
    document.querySelector('.peak-date').textContent = chart.peakHari ? 'tgl ' + chart.peakHari : '-';

    const bulan = document.getElementById('filterBulan').value;
    const tahun = document.getElementById('filterTahun').value;
    const namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('chartSubLabel').textContent = `Total laporan per hari — ${namaBulan[bulan]} ${tahun}`;
    document.getElementById('tableSubLabel').textContent = `Per kelas — ${namaBulan[bulan]} ${tahun}`;

    // Destroy & rebuild chart
    const canvas = document.getElementById('chartBulan');
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
                borderColor: '#10b981',
                borderWidth: 2.5,
                backgroundColor: grad,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#10b981',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2,
                tension: 0.55,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#f1f5f9',
                    bodyColor: '#94a3b8',
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: { label: ctx => ' ' + ctx.parsed.y + ' laporan' }
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 11, weight: '600' }, color: '#9ca3af', maxRotation: 0 } },
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false, dash: [4,4] }, ticks: { font: { size: 11 }, color: '#9ca3af', stepSize: 1, padding: 6 } }
            }
        }
    });
}

// ── Render tabel ─────────────────────────────────────────
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
    const bulan = document.getElementById('filterBulan').value;
    const tahun = document.getElementById('filterTahun').value;
    openDrawer(kelas, { bulan, tahun });
}

function downloadKelas(kelas) {
    const bulan = document.getElementById('filterBulan').value;
    const tahun = document.getElementById('filterTahun').value;
    window.open(`/api/admin/rekap/download-kelas?kelas=${encodeURIComponent(kelas)}&bulan=${bulan}&tahun=${tahun}`, '_blank');
}

// ── Export semua ─────────────────────────────────────────
function exportRekap() {
    const bulan = document.getElementById('filterBulan').value;
    const tahun = document.getElementById('filterTahun').value;
    window.open(`/api/admin/rekap/bulan/export?bulan=${bulan}&tahun=${tahun}`, '_blank');
}

// ── Search ───────────────────────────────────────────────
document.getElementById('searchTable')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    _filtered = _allData.filter(d =>
        d.kelas.toLowerCase().includes(q) || d.periode.toLowerCase().includes(q)
    );
    renderTable();
});

// ── Filter change ────────────────────────────────────────
document.getElementById('filterBulan').addEventListener('change', loadRekap);
document.getElementById('filterTahun').addEventListener('change', loadRekap);

// ── Init ─────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', loadRekap);
</script>
@endsection