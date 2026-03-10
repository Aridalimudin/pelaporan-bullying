@extends('layouts.app-admin')

@section('content')

@include('components.sidebar-admin', ['activePage' => 'dashboard'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Dashboard',
        'breadcrumbs' => [['label' => 'Dashboard']],
    ])

    <main class="admin-main">

        <div class="dash-welcome animate-fade-in">
            <div class="dash-welcome-text">
                <p class="dash-eyebrow">Selamat Datang Kembali 👋</p>
                <h2 class="dash-welcome-name">Adi Nuryadi</h2>
                <p class="dash-welcome-sub">Berikut ringkasan laporan bullying hari ini. Pastikan semua laporan masuk ditangani tepat waktu.</p>
            </div>
            <div class="dash-welcome-badge">
                <div class="dash-date-card">
                    <span class="dash-date-day" id="dashDay"></span>
                    <span class="dash-date-full" id="dashDate"></span>
                    <span class="dash-date-time" id="dashTime"></span>
                </div>
            </div>
        </div>

        <div class="dash-section-label animate-fade-in" style="animation-delay:.05s">Status Laporan Hari Ini</div>
        <div class="dash-stats-grid animate-fade-in" style="animation-delay:.08s">
            <div class="dash-stat-card dash-stat-blue">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">6</span>
                    <span class="dash-stat-lbl">Laporan Masuk</span>
                    <span class="dash-stat-trend up">↑ 3 dari kemarin</span>
                </div>
            </div>
            <div class="dash-stat-card dash-stat-amber">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">2</span>
                    <span class="dash-stat-lbl">Sedang Diproses</span>
                    <span class="dash-stat-trend neutral">= sama dengan kemarin</span>
                </div>
            </div>
            <div class="dash-stat-card dash-stat-purple">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">1</span>
                    <span class="dash-stat-lbl">Menunggu Verifikasi</span>
                    <span class="dash-stat-trend down">↓ 2 dari kemarin</span>
                </div>
            </div>
            <div class="dash-stat-card dash-stat-green">
                <div class="dash-stat-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="dash-stat-body">
                    <span class="dash-stat-val">3</span>
                    <span class="dash-stat-lbl">Selesai</span>
                    <span class="dash-stat-trend up">↑ 1 dari kemarin</span>
                </div>
            </div>
        </div>

        <div class="dash-mid-grid animate-fade-in" style="animation-delay:.13s">

            <div class="dash-panel">
                <div class="dash-panel-header">
                    <h3 class="dash-card-title">Tingkat Urgensi</h3>
                    <p class="dash-card-sub">Laporan aktif hari ini</p>
                </div>
                <div class="dash-urgensi-list">
                    <div class="dash-urg-row dash-urg-tinggi">
                        <div class="dash-urg-label-wrap">
                            <span class="dash-urg-dot"></span>
                            <span class="dash-urg-lbl">Tinggi</span>
                        </div>
                        <div class="dash-urg-bar-wrap">
                            <div class="dash-urg-bar" style="width:58%"></div>
                        </div>
                        <div class="dash-urg-right">
                            <span class="dash-urg-val">4</span>
                            <span class="dash-urg-pct">58%</span>
                        </div>
                    </div>
                    <div class="dash-urg-row dash-urg-sedang">
                        <div class="dash-urg-label-wrap">
                            <span class="dash-urg-dot"></span>
                            <span class="dash-urg-lbl">Sedang</span>
                        </div>
                        <div class="dash-urg-bar-wrap">
                            <div class="dash-urg-bar" style="width:29%"></div>
                        </div>
                        <div class="dash-urg-right">
                            <span class="dash-urg-val">2</span>
                            <span class="dash-urg-pct">29%</span>
                        </div>
                    </div>
                    <div class="dash-urg-row dash-urg-rendah">
                        <div class="dash-urg-label-wrap">
                            <span class="dash-urg-dot"></span>
                            <span class="dash-urg-lbl">Rendah</span>
                        </div>
                        <div class="dash-urg-bar-wrap">
                            <div class="dash-urg-bar" style="width:13%"></div>
                        </div>
                        <div class="dash-urg-right">
                            <span class="dash-urg-val">1</span>
                            <span class="dash-urg-pct">13%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dash-panel">
                <div class="dash-panel-header">
                    <h3 class="dash-card-title">Jenis Kasus</h3>
                    <p class="dash-card-sub">Laporan masuk hari ini</p>
                </div>
                <div class="dash-jenis-cards">
                    <div class="dash-jenis-big dash-jenis-verbal">
                        <div class="dash-jenis-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <div class="dash-jenis-info">
                            <span class="dash-jenis-num">4</span>
                            <span class="dash-jenis-name">Verbal</span>
                        </div>
                        <div class="dash-jenis-bar-vert">
                            <div class="dash-jenis-fill" style="height:67%"></div>
                        </div>
                        <span class="dash-jenis-pct-tag">67%</span>
                    </div>
                    <div class="dash-jenis-big dash-jenis-nonverbal">
                        <div class="dash-jenis-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        </div>
                        <div class="dash-jenis-info">
                            <span class="dash-jenis-num">2</span>
                            <span class="dash-jenis-name">Non-Verbal</span>
                        </div>
                        <div class="dash-jenis-bar-vert">
                            <div class="dash-jenis-fill" style="height:33%"></div>
                        </div>
                        <span class="dash-jenis-pct-tag">33%</span>
                    </div>
                </div>
                <div class="dash-jenis-total-row">
                    <span class="dash-jenis-total-lbl">Total Hari Ini</span>
                    <span class="dash-jenis-total-val">6 laporan</span>
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