@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome-page.css') }}">
    <style>
        /* ═══════════════════════════════════════════════
           STUDENT DASHBOARD PAGE DESIGN SYSTEM
        ═══════════════════════════════════════════════ */
        body {
            background-color: #f8fafc;
        }

        .sd-wrap {
            max-width: 1040px;
            margin: 0 auto;
            padding: 88px 20px 60px;
        }

        /* ── Profile Hero Card ── */
        .sd-hero {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #0d9488 100%);
            border-radius: 24px;
            padding: 32px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
            box-shadow: 0 12px 36px rgba(16, 185, 129, 0.22);
            position: relative;
            overflow: hidden;
        }
        .sd-hero::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 220px; height: 220px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }
        .sd-hero::after {
            content: '';
            position: absolute;
            bottom: -70px; left: 35%;
            width: 260px; height: 260px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .sd-hero-left {
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            z-index: 1;
        }

        .sd-avatar {
            width: 76px;
            height: 76px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255, 255, 255, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }

        .sd-hero-info { position: relative; z-index: 1; }
        .sd-hero-greeting {
            font-size: 12px;
            font-weight: 700;
            opacity: 0.85;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sd-hero-name {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 8px;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .sd-hero-chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .sd-hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .sd-hero-chip svg { width: 13px; height: 13px; }

        .sd-hero-action {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .sd-btn-lapor {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: #059669;
            border: none;
            border-radius: 14px;
            padding: 12px 20px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            white-space: nowrap;
        }
        .sd-btn-lapor:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
            background: #f0fdf4;
            color: #047857;
        }
        .sd-btn-lapor svg { width: 17px; height: 17px; }

        .sd-btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: white;
            border-radius: 14px;
            padding: 12px 16px;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .sd-btn-logout:hover {
            background: rgba(239, 68, 68, 0.9);
            border-color: #ef4444;
            color: white;
            transform: translateY(-2px);
        }

        /* ── Metric Cards ── */
        .sd-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        @media (max-width: 768px) {
            .sd-stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        .sd-stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        .sd-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            border-color: #cbd5e1;
        }
        .sd-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .sd-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sd-stat-icon svg { width: 22px; height: 22px; }
        .sd-stat-val {
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 4px;
        }
        .sd-stat-lbl {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
        }

        /* ── Grid Layouts for Sections ── */
        .sd-two-col {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            margin-bottom: 28px;
        }
        @media (max-width: 900px) {
            .sd-two-col { grid-template-columns: 1fr; }
        }

        /* ── Standard Card ── */
        .sd-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
        }
        .sd-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .sd-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
        }
        .sd-card-title-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #dcfce7;
            color: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sd-card-title-icon svg { width: 17px; height: 17px; }

        /* ── Filter Tabs ── */
        .sd-filter-tabs {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 3px;
        }
        .sd-filter-btn {
            padding: 5px 12px;
            border-radius: 9px;
            border: none;
            background: transparent;
            color: #64748b;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .sd-filter-btn.active {
            background: #ffffff;
            color: #059669;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        /* ── Recent Reports List ── */
        .sd-report-empty {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }
        .sd-report-empty svg { width: 52px; height: 52px; margin: 0 auto 14px; display: block; opacity: 0.4; }
        .sd-report-empty p { font-size: 14px; font-weight: 500; color: #64748b; margin-bottom: 12px; }

        .sd-report-item {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            margin-bottom: 10px;
            transition: all 0.2s ease;
        }
        .sd-report-item:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        }
        .sd-report-item:last-child { margin-bottom: 0; }

        .sd-report-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .sd-report-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }
        .sd-report-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .sd-report-code {
            font-size: 12px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 700;
            color: #059669;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sd-report-desc {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sd-report-meta {
            font-size: 11.5px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .sd-status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .sd-status-badge.pending     { background: #fef3c7; color: #b45309; }
        .sd-status-badge.submitted   { background: #dbeafe; color: #1d4ed8; }
        .sd-status-badge.verified    { background: #dcfce7; color: #15803d; }
        .sd-status-badge.in_progress { background: #f3e8ff; color: #6b21a8; }
        .sd-status-badge.closed,
        .sd-status-badge.done,
        .sd-status-badge.resolved    { background: #dcfce7; color: #15803d; }
        .sd-status-badge.rejected    { background: #fee2e2; color: #b91c1c; }

        .sd-btn-track {
            padding: 6px 12px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            color: #334155;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
            white-space: nowrap;
        }
        .sd-btn-track:hover {
            background: #059669;
            border-color: #059669;
            color: white;
        }

        /* ── Quick Actions ── */
        .sd-quick-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        @media (max-width: 768px) {
            .sd-quick-actions { grid-template-columns: 1fr; }
        }

        .sd-action-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
            color: #0f172a;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .sd-action-card:hover {
            transform: translateY(-3px);
            border-color: #10b981;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.12);
        }
        .sd-action-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sd-action-card-icon svg { width: 22px; height: 22px; }
        .sd-action-card-title { font-size: 14px; font-weight: 800; margin-bottom: 3px; color: #0f172a; }
        .sd-action-card-desc { font-size: 12px; color: #64748b; font-weight: 500; line-height: 1.3; }

        /* ── Timeline / Steps Info Card ── */
        .sd-steps-card {
            background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
            border: 1px solid #bbf7d0;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 28px;
        }
        .sd-steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 16px;
        }
        @media (max-width: 768px) {
            .sd-steps-grid { grid-template-columns: repeat(2, 1fr); }
        }
        .sd-step-item {
            background: #ffffff;
            border: 1px solid #dcfce7;
            border-radius: 16px;
            padding: 16px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .sd-step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #10b981;
            color: white;
            font-size: 12px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
        }
        .sd-step-title { font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 3px; }
        .sd-step-desc { font-size: 11px; color: #64748b; }

        /* ── BK Operational Info Card ── */
        .sd-bk-info-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        @media (max-width: 640px) {
            .sd-bk-info-card { flex-direction: column; align-items: flex-start; }
        }

        /* ── Emergency Help Contact Card ── */
        .sd-help-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            border-radius: 20px;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        }
        @media (max-width: 640px) {
            .sd-help-card { flex-direction: column; align-items: flex-start; }
        }
        .sd-help-title { font-size: 16px; font-weight: 800; margin-bottom: 6px; }
        .sd-help-desc { font-size: 12.5px; color: #94a3b8; line-height: 1.5; }
        .sd-help-btn {
            padding: 10px 18px;
            background: #10b981;
            color: white;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .sd-help-btn:hover { background: #059669; }

        @media (max-width: 640px) {
            .sd-hero { flex-direction: column; align-items: flex-start; padding: 24px; }
            .sd-hero-left { flex-direction: column; align-items: flex-start; }
            .sd-hero-action { width: 100%; flex-direction: column; }
            .sd-btn-lapor, .sd-btn-logout { width: 100%; justify-content: center; }
        }
    </style>
@endpush

@section('title', 'Dashboard Siswa — SIP Bullying')
@section('meta_description', 'Dashboard resmi siswa SIP Bullying SMK Muhammadiyah 3. Pantau status laporan dan statistik Anda secara realtime.')

@section('content')

{{-- Top Navigation Bar --}}
@include('components.navbar')

<div class="sd-wrap">

    {{-- ── 1. HERO BANNER ── --}}
    <div class="sd-hero">
        <div class="sd-hero-left">
            <div class="sd-avatar">
                {{ strtoupper(substr($student->fullname, 0, 1)) }}
            </div>
            <div class="sd-hero-info">
                <div class="sd-hero-greeting">
                    <svg class="w-4 h-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Akun Siswa Terverifikasi
                </div>
                <div class="sd-hero-name">{{ $student->fullname }}</div>
                <div class="sd-hero-chips">
                    <span class="sd-hero-chip">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h3"/></svg>
                        NIS: {{ $student->nis }}
                    </span>
                    <span class="sd-hero-chip">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Kelas {{ $student->grade }} {{ $student->major }}
                    </span>
                </div>
            </div>
        </div>
        <div class="sd-hero-action">
            <a href="{{ route('lapor.index') }}" class="sd-btn-lapor">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Buat Laporan Baru
            </a>
            <button type="button" onclick="confirmLogoutSiswa()" class="sd-btn-logout" title="Keluar dari akun siswa">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </div>
    </div>

    {{-- ── 2. METRIC STATS ── --}}
    <div class="sd-stats-grid">
        <div class="sd-stat-card">
            <div class="sd-stat-top">
                <div class="sd-stat-icon" style="background:#f1f5f9; color:#475569;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-400">Total</span>
            </div>
            <div class="sd-stat-val">{{ $stats['total'] }}</div>
            <div class="sd-stat-lbl">Laporan Dibuat</div>
        </div>

        <div class="sd-stat-card">
            <div class="sd-stat-top">
                <div class="sd-stat-icon" style="background:#fef3c7; color:#d97706;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-amber-500">Pending</span>
            </div>
            <div class="sd-stat-val">{{ $stats['pending'] }}</div>
            <div class="sd-stat-lbl">Menunggu Verifikasi</div>
        </div>

        <div class="sd-stat-card">
            <div class="sd-stat-top">
                <div class="sd-stat-icon" style="background:#f3e8ff; color:#7c3aed;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <span class="text-xs font-bold text-purple-600">Proses</span>
            </div>
            <div class="sd-stat-val">{{ $stats['proses'] }}</div>
            <div class="sd-stat-lbl">Sedang Ditangani</div>
        </div>

        <div class="sd-stat-card">
            <div class="sd-stat-top">
                <div class="sd-stat-icon" style="background:#dcfce7; color:#16a34a;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-emerald-600">Selesai</span>
            </div>
            <div class="sd-stat-val">{{ $stats['selesai'] }}</div>
            <div class="sd-stat-lbl">Selesai Ditangani</div>
        </div>
    </div>

    {{-- ── 3. QUICK ACTIONS ── --}}
    <div class="sd-quick-actions">
        <a href="{{ route('lapor.index') }}" class="sd-action-card">
            <div class="sd-action-card-icon" style="background: #dcfce7; color: #059669;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <div class="sd-action-card-title">Buat Laporan Baru</div>
                <div class="sd-action-card-desc">Laporkan tindakan perundungan dengan aman & rahasia</div>
            </div>
        </a>

        <a href="{{ route('lapor.lacak') }}" class="sd-action-card">
            <div class="sd-action-card-icon" style="background: #dbeafe; color: #2563eb;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <div>
                <div class="sd-action-card-title">Lacak Status Laporan</div>
                <div class="sd-action-card-desc">Cek perkembangan laporan menggunakan Kode Tiket</div>
            </div>
        </a>

        <a href="{{ route('lapor.contact') }}" class="sd-action-card">
            <div class="sd-action-card-icon" style="background: #fef3c7; color: #d97706;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <div>
                <div class="sd-action-card-title">Kontak Layanan Bantuan</div>
                <div class="sd-action-card-desc">Konsultasi langsung dengan Tim Guru BK Sekolah</div>
            </div>
        </a>
    </div>

    {{-- ── 4. TWO COLUMN: RECENT REPORTS & CHART STATISTIK ── --}}
    <div class="sd-two-col">

        {{-- Left Column: Riwayat Laporan Terbaru --}}
        <div class="sd-card">
            <div class="sd-card-header">
                <div class="sd-card-title">
                    <div class="sd-card-title-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 022 2h2a2 2 0 022-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    Riwayat Laporan Saya
                </div>

                {{-- Status Filter Tabs --}}
                <div class="sd-filter-tabs">
                    <button type="button" class="sd-filter-btn active" onclick="filterDashboardReports('all', this)">Semua</button>
                    <button type="button" class="sd-filter-btn" onclick="filterDashboardReports('pending', this)">Menunggu</button>
                    <button type="button" class="sd-filter-btn" onclick="filterDashboardReports('proses', this)">Diproses</button>
                    <button type="button" class="sd-filter-btn" onclick="filterDashboardReports('selesai', this)">Selesai</button>
                </div>
            </div>

            @if($reports->isEmpty())
                <div class="sd-report-empty">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p>Anda belum pernah mengirim laporan bullying.</p>
                    <a href="{{ route('lapor.index') }}" class="sd-btn-lapor" style="display:inline-flex; padding:8px 16px; font-size:13px;">
                        + Buat Laporan Pertama
                    </a>
                </div>
            @else
                <div id="sdReportListContainer">
                    @foreach($reports as $report)
                        @php
                            $statusMap = [
                                'masuk'       => ['label' => 'Menunggu',     'class' => 'pending',     'category' => 'pending', 'icon' => '⏳', 'bg' => '#fef3c7', 'color' => '#d97706'],
                                'menunggu'    => ['label' => 'Menunggu',     'class' => 'pending',     'category' => 'pending', 'icon' => '⏳', 'bg' => '#fef3c7', 'color' => '#d97706'],
                                'pending'     => ['label' => 'Menunggu',     'class' => 'pending',     'category' => 'pending', 'icon' => '⏳', 'bg' => '#fef3c7', 'color' => '#d97706'],
                                'submitted'   => ['label' => 'Terkirim',     'class' => 'submitted',   'category' => 'pending', 'icon' => '📤', 'bg' => '#dbeafe', 'color' => '#2563eb'],
                                'terverifikasi'=> ['label' => 'Terverifikasi', 'class' => 'verified',    'category' => 'proses',  'icon' => '✅', 'bg' => '#dcfce7', 'color' => '#16a34a'],
                                'verified'    => ['label' => 'Terverifikasi', 'class' => 'verified',    'category' => 'proses',  'icon' => '✅', 'bg' => '#dcfce7', 'color' => '#16a34a'],
                                'diproses'    => ['label' => 'Diproses',     'class' => 'in_progress', 'category' => 'proses',  'icon' => '🔄', 'bg' => '#f3e8ff', 'color' => '#7c3aed'],
                                'in_progress' => ['label' => 'Diproses',     'class' => 'in_progress', 'category' => 'proses',  'icon' => '🔄', 'bg' => '#f3e8ff', 'color' => '#7c3aed'],
                                'selesai'     => ['label' => 'Selesai',      'class' => 'closed',      'category' => 'selesai', 'icon' => '🏁', 'bg' => '#dcfce7', 'color' => '#16a34a'],
                                'closed'      => ['label' => 'Selesai',      'class' => 'closed',      'category' => 'selesai', 'icon' => '🏁', 'bg' => '#dcfce7', 'color' => '#16a34a'],
                                'done'        => ['label' => 'Selesai',      'class' => 'done',        'category' => 'selesai', 'icon' => '✔️', 'bg' => '#dcfce7', 'color' => '#16a34a'],
                                'resolved'    => ['label' => 'Selesai',      'class' => 'resolved',    'category' => 'selesai', 'icon' => '✔️', 'bg' => '#dcfce7', 'color' => '#16a34a'],
                                'ditolak'     => ['label' => 'Ditolak',      'class' => 'rejected',    'category' => 'ditolak', 'icon' => '❌', 'bg' => '#fee2e2', 'color' => '#dc2626'],
                                'rejected'    => ['label' => 'Ditolak',      'class' => 'rejected',    'category' => 'ditolak', 'icon' => '❌', 'bg' => '#fee2e2', 'color' => '#dc2626'],
                            ];
                            $st = $statusMap[$report->status ?? 'pending'] ?? $statusMap['pending'];
                        @endphp
                        <div class="sd-report-item" data-category="{{ $st['category'] }}">
                            <div class="sd-report-row">
                                <div class="sd-report-left">
                                    <div class="sd-report-icon" style="background: {{ $st['bg'] }}; color: {{ $st['color'] }};">
                                        {{ $st['icon'] }}
                                    </div>
                                    <div style="min-width:0;">
                                        <div class="sd-report-code">
                                            <span>{{ $report->ticket_code ?? 'TKT-PENDING' }}</span>
                                            @if($report->ticket_code)
                                                <button type="button" onclick="copyReportCode('{{ $report->ticket_code }}', this)" class="text-slate-400 hover:text-emerald-600 transition-colors" title="Salin Kode Tiket">
                                                    <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="sd-report-desc">{{ Str::limit($report->deskripsi ?? 'Laporan Bullying #'.$report->id, 48) }}</div>
                                        <div class="sd-report-meta">
                                            <span>📅 {{ $report->created_at ? $report->created_at->format('d M Y') : '—' }}</span>
                                            <span>•</span>
                                            <span>Urgensi: <strong style="color: #0f172a;">{{ ucfirst($report->urgency ?? 'Sedang') }}</strong></span>
                                            @if(($report->reporter_type ?? 'siswa') === 'ortu')
                                                <span>•</span>
                                                <span class="inline-flex items-center gap-1 text-[10.5px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">👨‍👩‍👧 Laporan Ortu</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="sd-status-badge {{ $st['class'] }}">{{ $st['label'] }}</span>
                                    @if($report->ticket_code)
                                        <a href="{{ route('lapor.progress', ['code' => $report->ticket_code]) }}" class="sd-btn-track" title="Pantau Laporan">
                                            Pantau →
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Catatan / Feedback dari Admin BK (jika ada) --}}
                            @if(!empty($report->catatan_admin))
                                <div class="mt-1.5 p-2.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl text-xs text-emerald-900 flex items-start gap-2">
                                    <span class="font-bold shrink-0">💬 Respon Tim BK:</span>
                                    <span class="font-medium leading-relaxed">{{ $report->catatan_admin }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Right Column: Interactive Chart Status Laporan --}}
        <div class="sd-card">
            <div class="sd-card-header">
                <div class="sd-card-title">
                    <div class="sd-card-title-icon" style="background:#dbeafe; color:#2563eb;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 30a1 1 0 000 2h2a1 1 0 000-2h-2zM4 11a1 1 0 011-1h14a1 1 0 110 2H5a1 1 0 01-1-1zm5 4a1 1 0 011-1h4a1 1 0 110 2H10a1 1 0 01-1-1z"/></svg>
                    </div>
                    Statistik Laporan
                </div>
            </div>

            <div style="position: relative; height: 210px; display: flex; align-items: center; justify-content: center;">
                <canvas id="studentReportChart"></canvas>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-500 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Menunggu</span>
                    <strong class="text-slate-800">{{ $chartData['pending'] }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Sedang Diproses</span>
                    <strong class="text-slate-800">{{ $chartData['proses'] }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Selesai Ditangani</span>
                    <strong class="text-slate-800">{{ $chartData['selesai'] }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Ditolak / Dibatalkan</span>
                    <strong class="text-slate-800">{{ $chartData['ditolak'] }}</strong>
                </div>
            </div>
        </div>

    </div>

    {{-- ── 5. INFORMASI OPERASIONAL BK & LOKASI ── --}}
    <div class="sd-bk-info-card">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                🏫
            </div>
            <div>
                <div class="text-sm font-bold text-slate-900">Ruang Bimbingan & Konseling (BK) Sekolah</div>
                <div class="text-xs text-slate-500 mt-0.5">Gedung Utama Lantai 1 &bull; Jam Layanan: <strong>Senin - Jumat (07.00 - 15.30 WIB)</strong></div>
            </div>
        </div>
        <div class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200">
            🔒 Pendampingan Rahasia
        </div>
    </div>

    {{-- ── 6. ALUR PENANGANAN LAPORAN (STEPS) ── --}}
    <div class="sd-steps-card">
        <div class="sd-card-title">
            <div class="sd-card-title-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            Alur & Tahapan Penanganan Laporan di Sekolah
        </div>
        <p class="text-xs text-slate-500 mt-1">Setiap laporan yang masuk akan ditangani secara profesional, rahasia, dan tanpa intimidasi.</p>

        <div class="sd-steps-grid">
            <div class="sd-step-item">
                <div class="sd-step-num">1</div>
                <div class="sd-step-title">Laporan Diterima</div>
                <div class="sd-step-desc">Kode tiket unik langsung terbit secara otomatis.</div>
            </div>
            <div class="sd-step-item">
                <div class="sd-step-num">2</div>
                <div class="sd-step-title">Verifikasi BK</div>
                <div class="sd-step-desc">Tim Satgas & BK memeriksa validitas & urgensi laporan.</div>
            </div>
            <div class="sd-step-item">
                <div class="sd-step-num">3</div>
                <div class="sd-step-title">Tindakan Khusus</div>
                <div class="sd-step-desc">Penanganan korban & tindakan disiplin pada pelaku.</div>
            </div>
            <div class="sd-step-item">
                <div class="sd-step-num">4</div>
                <div class="sd-step-title">Selesai & Evaluasi</div>
                <div class="sd-step-desc">Kasus ditutup dengan pendampingan berkelanjutan.</div>
            </div>
        </div>
    </div>

    {{-- ── 7. EMERGENCY HELP CARD ── --}}
    <div class="sd-help-card">
        <div>
            <div class="sd-help-title">Butuh Bantuan Darurat atau Ingin Curhat?</div>
            <div class="sd-help-desc">
                Identitas Anda **100% terlindungi**. Jangan ragu untuk menghubungi Tim Bimbingan Konseling (BK) jika membutuhkan perlindungan atau pendampingan psikologis secepatnya.
            </div>
        </div>
        <a href="{{ route('lapor.contact') }}" class="sd-help-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            Hubungi Guru BK
        </a>
    </div>

</div>

{{-- Modal Alert / Confirm Component --}}
@include('components.modal-alert')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function confirmLogoutSiswa() {
        showCustomConfirm(
            'Konfirmasi Keluar',
            'Apakah Anda yakin ingin keluar dari akun siswa?',
            function () {
                fetch('{{ route("api.siswa.logout") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    window.location.href = "{{ route('lapor.index') }}";
                })
                .catch(err => {
                    window.location.href = "{{ route('lapor.index') }}";
                });
            },
            'Ya, Keluar',
            'danger'
        );
    }

    function filterDashboardReports(category, btnEl) {
        document.querySelectorAll('.sd-filter-btn').forEach(b => b.classList.remove('active'));
        if (btnEl) btnEl.classList.add('active');

        const items = document.querySelectorAll('#sdReportListContainer .sd-report-item');
        items.forEach(item => {
            const cat = item.getAttribute('data-category');
            if (category === 'all' || cat === category) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function copyReportCode(code, btnEl) {
        navigator.clipboard.writeText(code).then(() => {
            if (btnEl) {
                const orig = btnEl.innerHTML;
                btnEl.innerHTML = '<span style="font-size:10px; color:#10b981; font-weight:700;">Disalin! ✓</span>';
                setTimeout(() => btnEl.innerHTML = orig, 1500);
            }
        });
    }

    function initStudentChart() {
        const ctx = document.getElementById('studentReportChart');
        if (!ctx) return;

        const totalReports = {{ $stats['total'] }};
        const pendingCount = {{ $chartData['pending'] }};
        const prosesCount  = {{ $chartData['proses'] }};
        const selesaiCount = {{ $chartData['selesai'] }};
        const ditolakCount = {{ $chartData['ditolak'] }};

        const chartConfigData = totalReports > 0 ? {
            labels: ['Menunggu', 'Sedang Diproses', 'Selesai', 'Ditolak'],
            datasets: [{
                data: [pendingCount, prosesCount, selesaiCount, ditolakCount],
                backgroundColor: [
                    '#fbbf24', // Pending (Amber)
                    '#a855f7', // Proses (Purple)
                    '#10b981', // Selesai (Emerald)
                    '#f43f5e'  // Ditolak (Rose)
                ],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        } : {
            labels: ['Belum Ada Laporan'],
            datasets: [{
                data: [1],
                backgroundColor: ['#e2e8f0'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 0
            }]
        };

        if (window._studentChartInstance) {
            window._studentChartInstance.destroy();
        }

        window._studentChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: chartConfigData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (totalReports === 0) return ' Belum ada laporan yang dibuat';
                                return ' ' + context.label + ': ' + context.raw + ' Laporan';
                            }
                        }
                    }
                },
                cutout: '72%'
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStudentChart);
    } else {
        initStudentChart();
    }
</script>
@endpush
@endsection
