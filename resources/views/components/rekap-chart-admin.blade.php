@php
    $chartId     = $chartId     ?? 'rekapChart';
    $chartLabel  = $chartLabel  ?? 'Laporan Masuk';
    $chartHeight = $chartHeight ?? 220;
    $chartLabels = $chartLabels ?? ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    $chartData   = $chartData   ?? [4,7,5,9,12,10,14,11,8,13,9,6];

    $labelsJson  = json_encode($chartLabels);
    $dataJson    = json_encode($chartData);
    $labelEsc    = e($chartLabel);
    $idEsc       = e($chartId);
    $heightPx    = (int) $chartHeight;
@endphp

<div class="rc-wrap">
    <canvas id="{{ $idEsc }}" 
            data-height="{{ $heightPx }}"
            data-config="{{ base64_encode(json_encode(['labels' => $chartLabels, 'data' => $chartData, 'label' => $chartLabel])) }}">
    </canvas>
</div>

<script>
(function() {
    function initChart() {
        if (typeof Chart === 'undefined') {
            setTimeout(initChart, 120);
            return;
        }

        var canvas = document.querySelector('canvas[data-config]');
        if (!canvas) return;

        var config = JSON.parse(atob(canvas.dataset.config));
        var CHART_ID = canvas.id;
        var CHART_LABELS = config.labels;
        var CHART_DATA = config.data;
        var CHART_LABEL = config.label;
        var CHART_HEIGHT = parseInt(canvas.dataset.height) || 220;

        if (typeof Chart !== 'undefined') {
            var existing = Chart.getChart(CHART_ID);
            if (existing) existing.destroy();

            var ctx = canvas.getContext('2d');

            var grad = ctx.createLinearGradient(0, 0, 0, CHART_HEIGHT);
            grad.addColorStop(0,   'rgba(16,185,129,0.28)');
            grad.addColorStop(0.6, 'rgba(16,185,129,0.06)');
            grad.addColorStop(1,   'rgba(16,185,129,0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: CHART_LABELS,
                    datasets: [{
                        label: CHART_LABEL,
                        data: CHART_DATA,
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
                            callbacks: {
                                label: function(ctx) { return ' ' + ctx.parsed.y + ' laporan'; }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                font: { size: 11, weight: '600' },
                                color: '#9ca3af',
                                maxRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            border: { display: false, dash: [4,4] },
                            ticks: {
                                font: { size: 11 },
                                color: '#9ca3af',
                                stepSize: 3,
                                padding: 6
                            }
                        }
                    }
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChart);
    } else {
        initChart();
    }
})();
</script>

<style>
.rc-wrap { position: relative; width: 100%; }
.rc-wrap canvas { width: 100% !important; display: block; }
</style>

<script>
document.querySelectorAll('[data-height]').forEach(canvas => {
    canvas.style.height = parseInt(canvas.dataset.height) + 'px';
});
</script>