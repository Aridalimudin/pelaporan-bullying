@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report-progress-user-page.css') }}">
@endpush

@section('content')

{{-- Dekorasi latar --}}
<div class="decorative-circle" style="top:-60px;left:-80px;width:320px;height:320px;background:var(--green);"></div>
<div class="decorative-circle" style="bottom:-80px;right:-60px;width:380px;height:380px;background:var(--green-dark);"></div>

@include('components.navbar')

<!-- ══════════════════════════════════════
     MAIN WRAPPER
══════════════════════════════════════ -->
<main class="main-wrap">
    <datalist id="listKelas">
    </datalist>

    <!-- SKELETON LOADING -->
    <div id="skeletonWrap">
        <div class="skeleton-header">
            <div class="sk sk-title"></div>
            <div class="sk sk-sub" style="margin-top:10px;"></div>
        </div>
        <div class="skeleton-stepper">
            <div class="sk sk-circle"></div>
            <div class="sk sk-line"></div>
            <div class="sk sk-circle"></div>
            <div class="sk sk-line"></div>
            <div class="sk sk-circle"></div>
            <div class="sk sk-line"></div>
            <div class="sk sk-circle"></div>
        </div>
        <div class="skeleton-cards">
            <div class="sk sk-card"></div>
            <div class="sk sk-card" style="height:140px;"></div>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="content-wrap hidden" id="contentWrap">

        <!-- Tombol Kembali -->
        <a href="#" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>

        <!-- ══════════════════════
             PAGE HEADER
        ══════════════════════ -->
        <div class="page-header">
            <div class="page-header-left">
                <h1 class="page-title">Status Laporan</h1>
                <p class="page-meta">
                    <span class="mono" id="displayKode">—</span>
                    <span class="sep">·</span>
                    <span id="displayTanggal">—</span>
                </p>
            </div>
            <div class="page-header-right">
                <span class="status-pill" id="statusPill">MEMUAT…</span>

                {{-- Reminder button + counter badge --}}
                <div class="reminder-btn-wrap hidden" id="reminderBtnWrap">
                    <span class="reminder-counter ok" id="reminderCounter" title="Sisa reminder hari ini">2</span>
                    <button class="btn-reminder" id="btnReminder" onclick="openReminderModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Kirim Reminder
                    </button>
                </div>
            </div>
        </div>

        {{-- Demo Switcher – dihapus otomatis JS di production --}}
        <div class="demo-switcher">
            <span class="demo-label">Demo Status:</span>
            <button class="demo-btn active" onclick="demoStatus('terkirim')">Terkirim</button>
            <button class="demo-btn" onclick="demoStatus('verifikasi')">Verifikasi</button>
            <button class="demo-btn" onclick="demoStatus('diproses')">Diproses</button>
            <button class="demo-btn" onclick="demoStatus('selesai')">Selesai</button>
            <button class="demo-btn" onclick="demoStatus('ditolak')">Ditolak</button>
        </div>

        <!-- ══════════════════════
             PROGRESS STEPPER
        ══════════════════════ -->
        <div class="stepper-card">
            <div class="stepper-track" id="stepperTrack">
                {{-- Diisi JS --}}
            </div>
        </div>

        <div id="globalActionBanner" class="global-action-banner hidden" onclick="bannerScrollToForm()">
            <div class="gab-left">
                <div class="gab-pulse-dot"></div>
                <div class="gab-icon">📋</div>
                <div class="gab-text">
                    <span class="gab-title">Tindakan Diperlukan</span>  
                    <span class="gab-desc">Lengkapi detail kejadian agar laporan segera ditindaklanjuti</span>
                </div>
            </div>
            <div class="gab-right">
                <span class="gab-cta">Isi Sekarang</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>

        <div class="body-grid">

            <!-- ── KOLOM KIRI ── -->
            <div class="main-col">

                <!-- Aktivitas Timeline -->
                <div class="activity-card">
                    <div class="activity-header">
                        <div class="activity-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="activity-title">Aktivitas Terbaru</h2>
                    </div>
                    <div id="activityList">
                        {{-- Diisi JS --}}
                    </div>
                </div>

                {{-- Konten utama per tahap (diisi JS) --}}
                <div id="mainContent"></div>

            </div>{{-- /main-col --}}

            <!-- ── KOLOM KANAN: SIDEBAR ── -->
            <div class="side-col">

                <!-- Informasi Laporan -->
                <div class="info-card">
                    <h3 class="info-card-title">Informasi Laporan</h3>
                    <div class="info-row">
                        <span class="info-key">Kode</span>
                        <span class="info-val mono" id="sideKode">—</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Pelapor</span>
                        <span class="info-val" id="sideNama">—</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">NIS</span>
                        <span class="info-val mono" id="sideNis">—</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Kelas</span>
                        <span class="info-val" id="sideKelas">—</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Urgensi</span>
                        <span class="info-val" id="sideUrgensi">—</span>
                    </div>
                    <div class="info-row">
                        <span class="info-key">Tanggal</span>
                        <span class="info-val" id="sideTanggal">—</span>
                    </div>
                </div>

                <!-- Butuh Bantuan -->
                <div class="help-card">
                    <h3 class="help-title">Butuh Bantuan?</h3>
                    <a href="#" class="help-item">
                        <div class="help-item-icon green">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="help-item-label">Hotline BK</div>
                            <div class="help-item-sub">Senin–Jumat, 07.00–15.00</div>
                        </div>
                    </a>
                    <a href="#" class="help-item">
                        <div class="help-item-icon blue">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="help-item-label">WhatsApp</div>
                            <div class="help-item-sub">Respon dalam 1×24 jam</div>
                        </div>
                    </a>
                </div>

                <!-- Kerahasiaan -->
                <div class="privacy-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <p>Laporan Anda bersifat <strong>rahasia</strong> dan ditangani secara profesional oleh pihak sekolah.</p>
                </div>

            </div>{{-- /side-col --}}
        </div>{{-- /body-grid --}}

    </div>{{-- /contentWrap --}}
</main>

<!-- Footer -->
<footer class="site-footer">
    <strong>SMK Muhammadiyah 3 Kadungora</strong> &nbsp;·&nbsp; Bersama Sekolah Aman. Semua Hak Terlindungi.
</footer>

<!-- ══════════════════════════════════════
     MODAL REMINDER (fleksibel)
══════════════════════════════════════ -->
<div class="modal-overlay hidden" id="reminderModal" onclick="closeModal(event)">
    <div class="modal-box" id="modalBox">
        <div class="modal-icon amber">
            {{-- Diisi JS --}}
        </div>
        <h3 class="modal-title">—</h3>
        <p class="modal-desc">—</p>
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeModal()">Tutup</button>
            <button class="btn-modal-confirm" id="modalConfirmBtn" onclick="confirmModal()">Ya, Kirim Sekarang</button>
        </div>
    </div>
</div>

<!-- Toast Container (pojok kanan atas) -->
<div class="toast-container" id="toastContainer"></div>

@include('components.footer')

<script src="{{ asset('js/report-progress-user-page.js') }}"></script>

@endsection
