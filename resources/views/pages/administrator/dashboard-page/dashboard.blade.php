@extends('layouts.app-admin')

@section('content')

@include('components.sidebar-admin', ['activePage' => 'dashboard'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Dashboard',
        'breadcrumbs' => [['label' => 'Dashboard']],
    ])

    <main class="admin-main">

        {{-- ── Welcome Banner ── --}}
        <div class="dash-welcome animate-fade-in">
            <div class="dash-welcome-text">
                <p class="dash-eyebrow">Selamat Datang Kembali 👋</p>
                <h2 class="dash-welcome-name">{{ $user->nama }}</h2>
                <p class="dash-welcome-sub">Berikut ringkasan antrian aktif dan aktivitas laporan bullying hari&nbsp;ini.</p>
            </div>
            <div class="dash-welcome-badge">
                <div class="dash-date-card">
                    <span class="dash-date-day" id="dashDay"></span>
                    <span class="dash-date-full" id="dashDate"></span>
                    <span class="dash-date-time" id="dashTime"></span>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════ --}}
        {{-- BARIS 1 — Antrian Aktif                                 --}}
        {{-- ════════════════════════════════════════════════════════ --}}
        <div class="dash-section-label animate-fade-in" style="animation-delay:.05s">
            🗂️ Antrian Aktif — Beban Kerja Saat Ini
        </div>
        <p class="dash-section-desc animate-fade-in" style="animation-delay:.06s">
            Laporan yang belum selesai dari semua waktu dan perlu segera ditangani.
        </p>
        <div class="dash-stats-grid animate-fade-in" style="animation-delay:.08s">

            <div class="dash-stat-card dash-stat-purple">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">{{ $antrian['belum'] }}</span>
                    <span class="dash-stat-lbl">Butuh Persetujuan</span>
                    @php $d = $antrian['belum'] - $antrianKemarin['belum']; @endphp
                    <span class="dash-stat-trend {{ $d > 0 ? 'up' : ($d < 0 ? 'down' : 'neutral') }}">
                        {{ $d > 0 ? '↑' : ($d < 0 ? '↓' : '=') }}
                        {{ $d != 0 ? abs($d).' dari kemarin' : 'sama dengan kemarin' }}
                    </span>
                </div>
            </div>

            <div class="dash-stat-card dash-stat-amber">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">{{ $antrian['menunggu'] }}</span>
                    <span class="dash-stat-lbl">Menunggu Detail</span>
                    @php $d = $antrian['menunggu'] - $antrianKemarin['menunggu']; @endphp
                    <span class="dash-stat-trend {{ $d > 0 ? 'up' : ($d < 0 ? 'down' : 'neutral') }}">
                        {{ $d > 0 ? '↑' : ($d < 0 ? '↓' : '=') }}
                        {{ $d != 0 ? abs($d).' dari kemarin' : 'sama dengan kemarin' }}
                    </span>
                </div>
            </div>

            <div class="dash-stat-card dash-stat-blue">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">{{ $antrian['diproses'] }}</span>
                    <span class="dash-stat-lbl">Sedang Ditangani</span>
                    @php $d = $antrian['diproses'] - $antrianKemarin['diproses']; @endphp
                    <span class="dash-stat-trend {{ $d > 0 ? 'up' : ($d < 0 ? 'down' : 'neutral') }}">
                        {{ $d > 0 ? '↑' : ($d < 0 ? '↓' : '=') }}
                        {{ $d != 0 ? abs($d).' dari kemarin' : 'sama dengan kemarin' }}
                    </span>
                </div>
            </div>

            <div class="dash-stat-card dash-stat-red">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">{{ $antrian['total'] }}</span>
                    <span class="dash-stat-lbl">Total Antrian Aktif</span>
                    @php $d = $antrian['total'] - $antrianKemarin['total']; @endphp
                    <span class="dash-stat-trend {{ $d > 0 ? 'up' : ($d < 0 ? 'down' : 'neutral') }}">
                        {{ $d > 0 ? '↑' : ($d < 0 ? '↓' : '=') }}
                        {{ $d != 0 ? abs($d).' dari kemarin' : 'sama dengan kemarin' }}
                    </span>
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════════════════════════ --}}
        {{-- BARIS 2 — Aktivitas Hari Ini (3 kartu)                  --}}
        {{-- ════════════════════════════════════════════════════════ --}}
        <div class="dash-section-label animate-fade-in" style="animation-delay:.10s">
            📅 Aktivitas Hari Ini
        </div>
        <p class="dash-section-desc animate-fade-in" style="animation-delay:.11s">
            Laporan yang masuk atau berubah status hari ini.
        </p>
        <div class="dash-stats-grid dash-stats-grid--3 animate-fade-in" style="animation-delay:.13s">

            <div class="dash-stat-card dash-stat-blue">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">{{ $hariIni['masuk'] }}</span>
                    <span class="dash-stat-lbl">Laporan Masuk</span>
                    @php $d = $hariIni['masuk'] - $hariIniKemarin['masuk']; @endphp
                    <span class="dash-stat-trend {{ $d > 0 ? 'up' : ($d < 0 ? 'down' : 'neutral') }}">
                        {{ $d > 0 ? '↑' : ($d < 0 ? '↓' : '=') }}
                        {{ $d != 0 ? abs($d).' dari kemarin' : 'sama dengan kemarin' }}
                    </span>
                </div>
            </div>

            <div class="dash-stat-card dash-stat-green">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">{{ $hariIni['selesai'] }}</span>
                    <span class="dash-stat-lbl">Diselesaikan</span>
                    @php $d = $hariIni['selesai'] - $hariIniKemarin['selesai']; @endphp
                    <span class="dash-stat-trend {{ $d > 0 ? 'up' : ($d < 0 ? 'down' : 'neutral') }}">
                        {{ $d > 0 ? '↑' : ($d < 0 ? '↓' : '=') }}
                        {{ $d != 0 ? abs($d).' dari kemarin' : 'sama dengan kemarin' }}
                    </span>
                </div>
            </div>

            <div class="dash-stat-card dash-stat-red">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">{{ $hariIni['ditolak'] }}</span>
                    <span class="dash-stat-lbl">Ditolak</span>
                    @php $d = $hariIni['ditolak'] - $hariIniKemarin['ditolak']; @endphp
                    <span class="dash-stat-trend {{ $d > 0 ? 'up' : ($d < 0 ? 'down' : 'neutral') }}">
                        {{ $d > 0 ? '↑' : ($d < 0 ? '↓' : '=') }}
                        {{ $d != 0 ? abs($d).' dari kemarin' : 'sama dengan kemarin' }}
                    </span>
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════════════════════════ --}}
        {{-- Panel Bawah — Urgensi & Jenis Kasus                     --}}
        {{-- Pelapor hari ini disisipkan di dalam panel Urgensi      --}}
        {{-- ════════════════════════════════════════════════════════ --}}
        <div class="dash-mid-grid animate-fade-in" style="animation-delay:.16s">

            {{-- Tingkat Urgensi + Pelapor Hari Ini --}}
            <div class="dash-panel">
                <div class="dash-panel-header">
                    <h3 class="dash-card-title">Tingkat Urgensi</h3>
                    <p class="dash-card-sub">Dari seluruh antrian aktif</p>
                </div>
                <div class="dash-urgensi-list">

                    @php $pct = $totalUrgensi > 0 ? round($urgensi['tinggi'] / $totalUrgensi * 100) : 0; @endphp
                    <div class="dash-urg-row dash-urg-tinggi">
                        <div class="dash-urg-label-wrap">
                            <span class="dash-urg-dot"></span>
                            <span class="dash-urg-lbl">Tinggi</span>
                        </div>
                        <div class="dash-urg-bar-wrap">
                            <div class="dash-urg-bar" style="width:{{ $pct }}%"></div>
                        </div>
                        <div class="dash-urg-right">
                            <span class="dash-urg-val">{{ $urgensi['tinggi'] }}</span>
                            <span class="dash-urg-pct">{{ $pct }}%</span>
                        </div>
                    </div>

                    @php $pct = $totalUrgensi > 0 ? round($urgensi['sedang'] / $totalUrgensi * 100) : 0; @endphp
                    <div class="dash-urg-row dash-urg-sedang">
                        <div class="dash-urg-label-wrap">
                            <span class="dash-urg-dot"></span>
                            <span class="dash-urg-lbl">Sedang</span>
                        </div>
                        <div class="dash-urg-bar-wrap">
                            <div class="dash-urg-bar" style="width:{{ $pct }}%"></div>
                        </div>
                        <div class="dash-urg-right">
                            <span class="dash-urg-val">{{ $urgensi['sedang'] }}</span>
                            <span class="dash-urg-pct">{{ $pct }}%</span>
                        </div>
                    </div>

                    @php $pct = $totalUrgensi > 0 ? round($urgensi['rendah'] / $totalUrgensi * 100) : 0; @endphp
                    <div class="dash-urg-row dash-urg-rendah">
                        <div class="dash-urg-label-wrap">
                            <span class="dash-urg-dot"></span>
                            <span class="dash-urg-lbl">Rendah</span>
                        </div>
                        <div class="dash-urg-bar-wrap">
                            <div class="dash-urg-bar" style="width:{{ $pct }}%"></div>
                        </div>
                        <div class="dash-urg-right">
                            <span class="dash-urg-val">{{ $urgensi['rendah'] }}</span>
                            <span class="dash-urg-pct">{{ $pct }}%</span>
                        </div>
                    </div>

                </div>

                {{-- Pelapor Hari Ini — disisipkan di bawah urgensi --}}
                <div style="border-top:1.5px dashed #e5e7eb;margin:14px 0 12px;"></div>
                <p style="font-size:.65rem;font-weight:700;color:#9ca3af;letter-spacing:.08em;margin-bottom:10px;">
                    👤 PELAPOR HARI INI
                </p>
                <div style="display:flex;gap:10px;">
                    <div style="flex:1;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:10px;padding:10px 12px;display:flex;align-items:center;gap:8px;">
                        <svg fill="none" stroke="#3b82f6" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        </svg>
                        <div>
                            <div style="font-size:1.2rem;font-weight:800;color:#1d4ed8;line-height:1;">{{ $pelapor['siswa'] }}</div>
                            <div style="font-size:.65rem;font-weight:600;color:#3b82f6;margin-top:2px;">Siswa</div>
                        </div>
                    </div>
                    <div style="flex:1;background:#f5f3ff;border:1.5px solid #ddd6fe;border-radius:10px;padding:10px 12px;display:flex;align-items:center;gap:8px;">
                        <svg fill="none" stroke="#7c3aed" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <div style="font-size:1.2rem;font-weight:800;color:#5b21b6;line-height:1;">{{ $pelapor['ortu'] }}</div>
                            <div style="font-size:.65rem;font-weight:600;color:#7c3aed;margin-top:2px;">Orang Tua</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jenis Kasus --}}
            <div class="dash-panel">
                <div class="dash-panel-header">
                    <h3 class="dash-card-title">Jenis Kasus</h3>
                    <p class="dash-card-sub">Dari seluruh antrian aktif</p>
                </div>
                <div class="dash-jenis-cards">
                    @php
                        $pctFisik  = $totalJenis > 0 ? round($jenis['fisik']  / $totalJenis * 100) : 0;
                        $pctVerbal = $totalJenis > 0 ? round($jenis['verbal'] / $totalJenis * 100) : 0;
                    @endphp

                    <div class="dash-jenis-big dash-jenis-nonverbal">
                        <div class="dash-jenis-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div class="dash-jenis-info">
                            <span class="dash-jenis-num">{{ $jenis['fisik'] ?: '-' }}</span>
                            <span class="dash-jenis-name">Fisik</span>
                        </div>
                        <div class="dash-jenis-bar-vert">
                            <div class="dash-jenis-fill" style="height:{{ $pctFisik }}%"></div>
                        </div>
                        <span class="dash-jenis-pct-tag">{{ $pctFisik }}%</span>
                    </div>

                    <div class="dash-jenis-big dash-jenis-verbal">
                        <div class="dash-jenis-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div class="dash-jenis-info">
                            <span class="dash-jenis-num">{{ $jenis['verbal'] ?: '-' }}</span>
                            <span class="dash-jenis-name">Verbal</span>
                        </div>
                        <div class="dash-jenis-bar-vert">
                            <div class="dash-jenis-fill" style="height:{{ $pctVerbal }}%"></div>
                        </div>
                        <span class="dash-jenis-pct-tag">{{ $pctVerbal }}%</span>
                    </div>
                </div>

                <div class="dash-jenis-total-row">
                    <span class="dash-jenis-total-lbl">Total Antrian Aktif</span>
                    <span class="dash-jenis-total-val">{{ $antrian['total'] }} laporan</span>
                </div>
            </div>

        </div>
    </main>

    @include('components.footer', ['type' => 'admin'])
    @include('components.toast')
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard-page.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/dashboard-page.js') }}"></script>
@endpush