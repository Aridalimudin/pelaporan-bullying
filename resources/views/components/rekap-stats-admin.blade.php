@php
    $totalLaporan        = $totalLaporan        ?? 0;
    $rataRata            = $rataRata            ?? '0';
    $tingkatPenyelesaian = $tingkatPenyelesaian ?? '0';
    $periodeLabel        = $periodeLabel        ?? '—';
    $pct                 = (int) $tingkatPenyelesaian;

    if ($pct >= 75) {
        $pctClass   = 'rs-pct-good';
        $pctLabel   = 'Baik';
    } elseif ($pct >= 50) {
        $pctClass   = 'rs-pct-mid';
        $pctLabel   = 'Sedang';
    } else {
        $pctClass   = 'rs-pct-low';
        $pctLabel   = 'Rendah';
    }

    $pctWidth = min(100, max(0, $pct));
@endphp

<div class="rs-grid">

    <div class="rs-card rs-blue">
        <div class="rs-icon-wrap">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div class="rs-body">
            <span class="rs-val">{{ $totalLaporan }}</span>
            <span class="rs-lbl">Total Laporan</span>
            <span class="rs-period">{{ $periodeLabel }}</span>
        </div>
    </div>

    <div class="rs-card rs-amber">
        <div class="rs-icon-wrap">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <div class="rs-body">
            <span class="rs-val">{{ $rataRata }}</span>
            <span class="rs-lbl">Rata-rata Laporan</span>
            <span class="rs-period">per hari</span>
        </div>
    </div>

    <div class="rs-card rs-green">
        <div class="rs-icon-wrap">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="rs-body">
            <div class="rs-pct-row">
                <span class="rs-val">{{ $pct }}<small>%</small></span>
                <span class="rs-pct-badge {{ $pctClass }}">{{ $pctLabel }}</span>
            </div>
            <span class="rs-lbl">Tingkat Penyelesaian</span>
            <div class="rs-progress-wrap">
                <div class="rs-progress-bar {{ $pctClass }}" data-width="{{ $pctWidth }}"></div>
            </div>
        </div>
    </div>

</div>

<style>
.rs-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}
@media (max-width: 700px) { .rs-grid { grid-template-columns: 1fr; } }

.rs-card {
    background: white;
    border-radius: 16px;
    border: 1.5px solid #f3f4f6;
    padding: 18px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
    transition: transform .2s, box-shadow .2s;
}
.rs-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.07); }

.rs-icon-wrap {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.rs-icon-wrap svg { width: 21px; height: 21px; }
.rs-blue .rs-icon-wrap { background: #eff6ff; color: #3b82f6; }
.rs-amber .rs-icon-wrap { background: #fffbeb; color: #d97706; }
.rs-green .rs-icon-wrap { background: #ecfdf5; color: #10b981; }

.rs-body { display: flex; flex-direction: column; gap: 3px; flex: 1; min-width: 0; }
.rs-val { font-size: 1.7rem; font-weight: 800; color: #111827; line-height: 1; }
.rs-val small { font-size: 1rem; font-weight: 700; }
.rs-lbl { font-size: .75rem; font-weight: 600; color: #6b7280; }
.rs-period { font-size: .68rem; color: #9ca3af; }

.rs-pct-row { display: flex; align-items: center; gap: 8px; }
.rs-pct-badge { font-size: .65rem; font-weight: 800; padding: 2px 8px; border-radius: 99px; }

.rs-pct-good { background: #ecfdf5; color: #059669; }
.rs-pct-mid  { background: #fffbeb; color: #d97706; }
.rs-pct-low  { background: #fef2f2; color: #dc2626; }

.rs-progress-wrap {
    height: 5px; background: #f3f4f6; border-radius: 99px; overflow: hidden; margin-top: 5px;
}
.rs-progress-bar { height: 100%; border-radius: 99px; transition: width 1s cubic-bezier(.16,1,.3,1); }
.rs-progress-bar.rs-pct-good { background: #10b981; }
.rs-progress-bar.rs-pct-mid { background: #f59e0b; }
.rs-progress-bar.rs-pct-low { background: #ef4444; }
</style>

<script>
document.querySelectorAll('.rs-progress-bar[data-width]').forEach(bar => {
    const width = Math.min(100, Math.max(0, parseInt(bar.dataset.width) || 0));
    bar.style.width = width + '%';
});
</script>