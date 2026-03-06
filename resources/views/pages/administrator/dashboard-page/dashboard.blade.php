@extends('layouts.app')

@section('content')

@include('components.sidebar-admin', ['activePage' => 'dashboard'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Dashboard',
        'breadcrumbs' => [['label' => 'Dashboard']],
    ])

    <main class="admin-main">

        {{-- Welcome Banner --}}
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

        {{-- Status Laporan Hari Ini --}}
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

        {{-- Urgensi + Jenis Kasus --}}
        <div class="dash-mid-grid animate-fade-in" style="animation-delay:.13s">

            {{-- Urgensi --}}
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

            {{-- Jenis Kasus --}}
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

    <footer class="footer-compact">
        <strong>SMK Muhammadiyah 3 Kadungora</strong> · Bersama Sekolah Aman. Semua Hak Terlindungi.
    </footer>

    @include('components.toast')
</div>

{{-- ===================== STYLE ===================== --}}
<style>
/* ─── Reset & Base ─── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; overflow: auto; font-family: 'Plus Jakarta Sans', sans-serif; background: #f9fafb; color: #111827; }

/* ─── Variabel ─── */
:root {
    --green:         #10b981;
    --green-dark:    #059669;
    --green-deeper:  #047857;
    --green-light:   #d1fae5;
    --green-faint:   #f0fdf4;
    --sidebar-w:     260px;
    --topbar-h:      64px;
    --gray-50:       #f9fafb;
    --gray-100:      #f3f4f6;
    --gray-200:      #e5e7eb;
    --gray-300:      #d1d5db;
    --gray-400:      #9ca3af;
    --gray-500:      #6b7280;
    --gray-700:      #374151;
    --gray-900:      #111827;
    --radius:        12px;
    --shadow-sm:     0 1px 3px rgba(0,0,0,.08);
    --shadow-lg:     0 12px 40px rgba(0,0,0,.12);
}

/* ─── Animasi ─── */
@keyframes fadeIn { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
.animate-fade-in { animation: fadeIn .5s cubic-bezier(.16,1,.3,1) both; }
.hidden { display: none !important; }

/* ─────────────────────────────────────
   SIDEBAR
───────────────────────────────────── */
.admin-sidebar {
    width: var(--sidebar-w); height: 100vh;
    background: #fff; display: flex; flex-direction: column;
    border-right: 1px solid var(--gray-200);
    box-shadow: 0 4px 24px rgba(0,0,0,.08);
    overflow: hidden; position: fixed; left: 0; top: 0;
    z-index: 1000; transition: transform .3s cubic-bezier(.16,1,.3,1);
}
.sidebar-brand {
    display: flex; align-items: center; gap: 12px;
    padding: 20px 18px 18px; border-bottom: 1px solid var(--gray-100); flex-shrink: 0;
}
.sidebar-brand-icon {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--green), var(--green-deeper));
    display: flex; align-items: center; justify-content: center;
}
.sidebar-brand-icon svg { width: 22px; height: 22px; color: white; }
.sidebar-brand-text { display: flex; flex-direction: column; gap: 3px; flex: 1; min-width: 0; }
.brand-name { font-size: 15px; font-weight: 700; color: var(--gray-900); letter-spacing: -.2px; }
.brand-sub  { font-size: 11px; font-weight: 600; color: var(--green-dark); text-transform: uppercase; letter-spacing: .8px; }
.sidebar-close-btn {
    display: none; margin-left: auto; background: none; border: none;
    cursor: pointer; padding: 4px; color: var(--gray-500); border-radius: 6px;
}
.sidebar-close-btn svg { width: 18px; height: 18px; }

/* Nav */
.sidebar-nav {
    flex: 1; overflow-y: auto; padding: 14px 12px;
    display: flex; flex-direction: column; gap: 2px;
    scrollbar-width: thin; scrollbar-color: var(--gray-200) transparent;
}
.sidebar-nav::-webkit-scrollbar { width: 4px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 4px; }

.nav-section-label {
    font-size: 9.5px; font-weight: 800; color: var(--gray-400);
    text-transform: uppercase; letter-spacing: 1.1px; padding: 12px 12px 5px; margin-top: 2px;
}
.nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: var(--radius);
    color: var(--gray-500); text-decoration: none;
    font-size: 13.5px; font-weight: 500;
    transition: all .18s ease; position: relative;
}
.nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
.nav-item:hover { background: var(--green-faint); color: var(--green-dark); }
.nav-item.active { background: var(--green-faint); color: var(--green-dark); font-weight: 600; }
.nav-item.active::before {
    content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
    width: 3px; height: 22px; background: var(--green-dark); border-radius: 0 3px 3px 0;
}

.nav-group { display: flex; flex-direction: column; }
.nav-group-trigger {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 12px; border-radius: var(--radius); background: none; border: none;
    cursor: pointer; color: var(--gray-500); font-family: inherit;
    font-size: 13.5px; font-weight: 500; width: 100%; transition: all .18s ease;
}
.nav-group-trigger:hover { background: var(--green-faint); color: var(--green-dark); }
.nav-group.open .nav-group-trigger { background: var(--green-faint); color: var(--green-dark); font-weight: 600; }
.nav-group-left { display: flex; align-items: center; gap: 10px; }
.nav-group-left svg { width: 18px; height: 18px; flex-shrink: 0; }
.nav-chevron { width: 15px; height: 15px; flex-shrink: 0; transition: transform .25s ease; }
.nav-group.open .nav-chevron { transform: rotate(180deg); }
.nav-group-children {
    overflow: hidden; max-height: 0;
    transition: max-height .35s cubic-bezier(.4,0,.2,1);
    padding-left: 8px; display: flex; flex-direction: column; gap: 1px; margin-top: 2px;
}
.nav-group.open .nav-group-children { max-height: 500px; }

.nav-child {
    display: flex; align-items: center; gap: 9px;
    padding: 7px 10px; border-radius: 8px;
    color: var(--gray-500); text-decoration: none;
    font-size: 13px; font-weight: 400; transition: all .15s ease; position: relative;
}
.nav-child span:not(.nav-badge) { flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.nav-child:hover  { background: var(--green-faint); color: var(--green-dark); }
.nav-child.active { background: var(--green-faint); color: var(--green-dark); font-weight: 600; }
.child-icon { width: 15px; height: 15px; flex-shrink: 0; color: var(--gray-300); transition: color .15s; }
.nav-child:hover .child-icon, .nav-child.active .child-icon { color: var(--green-dark); }
.nav-badge {
    margin-left: auto; flex-shrink: 0; background: #ef4444; color: white;
    font-size: 9.5px; font-weight: 700; padding: 2px 6px; border-radius: 20px;
    min-width: 18px; text-align: center; line-height: 1.6;
}

/* Sidebar Footer */
.sidebar-footer { border-top: 1px solid var(--gray-100); padding: 14px 12px; flex-shrink: 0; display: flex; flex-direction: column; gap: 8px; }
.sidebar-profile { display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: var(--green-faint); border-radius: var(--radius); }
.sidebar-profile-avatar {
    width: 36px; height: 36px; background: var(--green-dark); color: white;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; flex-shrink: 0;
}
.sidebar-profile-info { display: flex; flex-direction: column; gap: 2px; overflow: hidden; }
.sidebar-profile-name { font-size: 13px; font-weight: 600; color: var(--gray-900); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sidebar-profile-role { font-size: 11px; color: var(--green-dark); font-weight: 500; }
.btn-logout {
    display: flex; align-items: center; gap: 10px; padding: 10px 12px;
    border-radius: var(--radius); border: 1.5px solid #fecaca; background: #fff5f5;
    color: #ef4444; font-size: 13.5px; font-weight: 600; font-family: inherit;
    cursor: pointer; width: 100%; transition: all .18s ease;
}
.btn-logout svg { width: 17px; height: 17px; flex-shrink: 0; }
.btn-logout:hover { background: #fee2e2; border-color: #f87171; }

/* Overlay */
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 999; backdrop-filter: blur(2px); }

/* ─────────────────────────────────────
   LAYOUT WRAPPER & TOPBAR
───────────────────────────────────── */
.admin-wrapper {
    margin-left: var(--sidebar-w); min-height: 100vh;
    display: flex; flex-direction: column;
    transition: margin-left .3s cubic-bezier(.16,1,.3,1); overflow-y: auto;
}
.admin-main { flex: 1; padding: 28px 28px 40px; overflow: visible; }

.admin-topbar {
    position: sticky; top: 0; z-index: 100; height: var(--topbar-h);
    background: rgba(255,255,255,.92); backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--gray-200);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 24px; gap: 16px;
}
.topbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
.hamburger-btn {
    display: none; background: none; border: none; cursor: pointer;
    padding: 8px; border-radius: 8px; color: var(--gray-700); transition: background .15s;
}
.hamburger-btn:hover { background: var(--gray-100); }
.hamburger-btn svg { width: 20px; height: 20px; }
.topbar-title { font-size: 1rem; font-weight: 700; color: var(--gray-900); white-space: nowrap; }
.topbar-breadcrumb { display: flex; align-items: center; gap: 4px; margin-top: 1px; }
.bc-sep     { font-size: .7rem; color: var(--gray-300); }
.bc-link    { font-size: .72rem; color: var(--gray-500); text-decoration: none; }
.bc-link:hover  { color: var(--green); }
.bc-current { font-size: .72rem; color: var(--green-dark); font-weight: 600; }
.topbar-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
.topbar-icon-btn {
    position: relative; background: none; border: none; cursor: pointer;
    padding: 8px; border-radius: 10px; color: var(--gray-500); transition: background .15s;
}
.topbar-icon-btn:hover { background: var(--gray-100); }
.topbar-icon-btn svg { width: 20px; height: 20px; display: block; }
.notif-dot {
    position: absolute; top: 4px; right: 4px; width: 16px; height: 16px;
    border-radius: 50%; background: #ef4444; color: white;
    font-size: .55rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center; border: 2px solid white;
}
.notif-wrap { position: relative; }
.notif-dropdown {
    position: absolute; top: calc(100% + 8px); right: 0; width: 300px;
    background: white; border: 1px solid var(--gray-200); border-radius: 14px;
    box-shadow: var(--shadow-lg); opacity: 0; pointer-events: none;
    transform: translateY(-8px); transition: opacity .2s, transform .2s; z-index: 300;
}
.notif-dropdown.open { opacity: 1; pointer-events: auto; transform: translateY(0); }
.notif-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px 10px; border-bottom: 1px solid var(--gray-100); }
.notif-header-title { font-weight: 700; font-size: .85rem; }
.notif-count-badge { background: var(--green-faint); color: var(--green-dark); font-size: .68rem; font-weight: 700; padding: 2px 8px; border-radius: 99px; }
.notif-list { max-height: 240px; overflow-y: auto; }
.notif-item { display: flex; gap: 10px; padding: 12px 16px; transition: background .15s; cursor: pointer; }
.notif-item:hover { background: var(--gray-50); }
.notif-item.unread { background: var(--green-faint); }
.notif-item-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.notif-item-icon.green  { background: var(--green-light); color: var(--green-dark); }
.notif-item-icon.yellow { background: #fef9c3; color: #ca8a04; }
.notif-item-icon.blue   { background: #dbeafe; color: #2563eb; }
.notif-item-icon svg { width: 15px; height: 15px; }
.notif-item-body { min-width: 0; }
.notif-item-text { font-size: .78rem; color: var(--gray-700); line-height: 1.4; }
.notif-item-time { font-size: .68rem; color: var(--gray-500); margin-top: 2px; display: block; }
.notif-footer { padding: 10px 16px; border-top: 1px solid var(--gray-100); text-align: center; }
.notif-footer a { font-size: .75rem; color: var(--green-dark); font-weight: 600; text-decoration: none; }
.avatar-wrap { position: relative; }
.avatar-btn { display: flex; align-items: center; gap: 8px; background: none; border: none; cursor: pointer; border-radius: 10px; padding: 5px 8px; transition: background .15s; }
.avatar-btn:hover { background: var(--gray-100); }
.avatar-circle {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, var(--green), var(--green-deeper));
    color: white; font-weight: 700; font-size: .85rem;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.avatar-circle.lg { width: 40px; height: 40px; font-size: 1rem; }
.avatar-info { text-align: left; display: none; }
.avatar-name { display: block; font-size: .8rem; font-weight: 700; color: var(--gray-900); line-height: 1.1; }
.avatar-role { display: block; font-size: .68rem; color: var(--gray-500); }
.avatar-chevron { width: 14px; height: 14px; color: var(--gray-400); }
.avatar-dropdown {
    position: absolute; top: calc(100% + 8px); right: 0; width: 220px;
    background: white; border: 1px solid var(--gray-200); border-radius: 14px;
    box-shadow: var(--shadow-lg); opacity: 0; pointer-events: none;
    transform: translateY(-8px); transition: opacity .2s, transform .2s; z-index: 300; overflow: hidden;
}
.avatar-dropdown.open { opacity: 1; pointer-events: auto; transform: translateY(0); }
.avatar-dropdown-header { display: flex; align-items: center; gap: 10px; padding: 14px; background: var(--green-faint); }
.avatar-dropdown-name  { font-size: .83rem; font-weight: 700; color: var(--gray-900); }
.avatar-dropdown-email { font-size: .7rem; color: var(--gray-500); }
.avatar-dropdown-divider { height: 1px; background: var(--gray-100); }
.avatar-dropdown-item {
    display: flex; align-items: center; gap: 10px; padding: 10px 14px;
    font-size: .8rem; font-weight: 500; color: var(--gray-700);
    text-decoration: none; transition: background .15s; cursor: pointer;
    background: none; border: none; width: 100%; font-family: inherit;
}
.avatar-dropdown-item svg { width: 16px; height: 16px; flex-shrink: 0; }
.avatar-dropdown-item:hover { background: var(--gray-50); }
.avatar-dropdown-item.danger { color: #ef4444; }
.avatar-dropdown-item.danger:hover { background: #fef2f2; }

/* ─────────────────────────────────────
   DASHBOARD — Welcome Banner
───────────────────────────────────── */
.dash-welcome {
    display: flex; align-items: center; justify-content: space-between;
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    border-radius: 18px; padding: 24px 28px; margin-bottom: 24px;
    gap: 20px; overflow: hidden; position: relative;
}
.dash-welcome::before {
    content: ''; position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='20' cy='20' r='1' fill='%23ffffff12'/%3E%3C/svg%3E");
    background-size: 20px 20px;
}
.dash-welcome-text { position: relative; z-index: 1; }
.dash-eyebrow      { font-size: .78rem; font-weight: 600; color: rgba(255,255,255,.75); margin-bottom: 4px; }
.dash-welcome-name { font-size: 1.4rem; font-weight: 800; color: white; margin-bottom: 6px; line-height: 1.2; }
.dash-welcome-sub  { font-size: .78rem; color: rgba(255,255,255,.7); max-width: 380px; line-height: 1.6; }
.dash-welcome-badge { position: relative; z-index: 1; flex-shrink: 0; }
.dash-date-card {
    background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.25);
    border-radius: 14px; padding: 14px 20px; text-align: center;
    backdrop-filter: blur(6px); min-width: 130px;
}
.dash-date-day  { display: block; font-size: 2rem; font-weight: 800; color: white; line-height: 1; }
.dash-date-full { display: block; font-size: .72rem; color: rgba(255,255,255,.8); margin-top: 4px; }
.dash-date-time { display: block; font-size: .8rem; font-weight: 700; color: rgba(255,255,255,.9); margin-top: 6px; font-variant-numeric: tabular-nums; }

/* ─────────────────────────────────────
   DASHBOARD — Section Label
───────────────────────────────────── */
.dash-section-label {
    font-size: .68rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: .1em; color: var(--gray-400); margin-bottom: 10px;
}

/* ─────────────────────────────────────
   DASHBOARD — Stat Cards
───────────────────────────────────── */
.dash-stats-grid {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 24px;
}
.dash-stat-card {
    background: white; border-radius: 16px; border: 1.5px solid var(--gray-100);
    padding: 18px; display: flex; align-items: center; gap: 14px;
    box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s;
}
.dash-stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.07); }
.dash-stat-icon-wrap { width: 46px; height: 46px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.dash-stat-icon-wrap svg { width: 22px; height: 22px; }
.dash-stat-blue   .dash-stat-icon-wrap { background: #eff6ff; color: #3b82f6; }
.dash-stat-amber  .dash-stat-icon-wrap { background: #fffbeb; color: #d97706; }
.dash-stat-purple .dash-stat-icon-wrap { background: #f5f3ff; color: #7c3aed; }
.dash-stat-green  .dash-stat-icon-wrap { background: #ecfdf5; color: #10b981; }
.dash-stat-body { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.dash-stat-val   { font-size: 1.6rem; font-weight: 800; color: var(--gray-900); line-height: 1; }
.dash-stat-lbl   { font-size: .75rem; font-weight: 600; color: var(--gray-500); }
.dash-stat-trend { font-size: .68rem; font-weight: 600; margin-top: 2px; }
.dash-stat-trend.up      { color: #10b981; }
.dash-stat-trend.down    { color: #ef4444; }
.dash-stat-trend.neutral { color: var(--gray-400); }

/* ─────────────────────────────────────
   DASHBOARD — Mid Grid
───────────────────────────────────── */
.dash-mid-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 16px; margin-bottom: 8px;
}
.dash-panel {
    background: white; border-radius: 16px;
    border: 1.5px solid var(--gray-100); padding: 20px;
    box-shadow: var(--shadow-sm);
}
.dash-panel-header { margin-bottom: 18px; }
.dash-card-title { font-size: .9rem; font-weight: 800; color: var(--gray-900); }
.dash-card-sub   { font-size: .72rem; color: var(--gray-400); margin-top: 2px; }

/* Urgensi */
.dash-urgensi-list { display: flex; flex-direction: column; gap: 16px; }
.dash-urg-row { display: flex; align-items: center; gap: 12px; }
.dash-urg-label-wrap { display: flex; align-items: center; gap: 8px; width: 68px; flex-shrink: 0; }
.dash-urg-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.dash-urg-tinggi .dash-urg-dot { background: #ef4444; }
.dash-urg-sedang .dash-urg-dot { background: #f59e0b; }
.dash-urg-rendah .dash-urg-dot { background: #10b981; }
.dash-urg-lbl { font-size: .78rem; font-weight: 600; color: var(--gray-700); }
.dash-urg-bar-wrap { flex: 1; height: 10px; background: var(--gray-100); border-radius: 99px; overflow: hidden; }
.dash-urg-bar { height: 100%; border-radius: 99px; transition: width .9s cubic-bezier(.16,1,.3,1); }
.dash-urg-tinggi .dash-urg-bar { background: linear-gradient(90deg, #fca5a5, #ef4444); }
.dash-urg-sedang .dash-urg-bar { background: linear-gradient(90deg, #fcd34d, #f59e0b); }
.dash-urg-rendah .dash-urg-bar { background: linear-gradient(90deg, #6ee7b7, #10b981); }
.dash-urg-right { display: flex; flex-direction: column; align-items: flex-end; flex-shrink: 0; width: 46px; }
.dash-urg-val   { font-size: .9rem; font-weight: 800; color: var(--gray-900); line-height: 1; }
.dash-urg-pct   { font-size: .65rem; color: var(--gray-400); font-weight: 600; }

/* Jenis Kasus */
.dash-jenis-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px; }
.dash-jenis-big {
    border-radius: 14px; padding: 16px;
    display: flex; flex-direction: column; gap: 8px;
    position: relative; overflow: hidden; min-height: 130px;
}
.dash-jenis-verbal    { background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1.5px solid #a7f3d0; }
.dash-jenis-nonverbal { background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1.5px solid #bfdbfe; }
.dash-jenis-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
.dash-jenis-verbal    .dash-jenis-icon { background: rgba(16,185,129,.15); color: #059669; }
.dash-jenis-nonverbal .dash-jenis-icon { background: rgba(59,130,246,.15); color: #3b82f6; }
.dash-jenis-icon svg { width: 18px; height: 18px; }
.dash-jenis-info { display: flex; flex-direction: column; }
.dash-jenis-num  { font-size: 1.8rem; font-weight: 800; color: var(--gray-900); line-height: 1; }
.dash-jenis-name { font-size: .72rem; font-weight: 700; color: var(--gray-500); margin-top: 2px; }
.dash-jenis-bar-vert {
    position: absolute; bottom: 0; right: 16px; width: 6px;
    background: rgba(0,0,0,.06); border-radius: 99px 99px 0 0;
    height: 60px; display: flex; flex-direction: column; justify-content: flex-end;
}
.dash-jenis-fill { border-radius: 99px 99px 0 0; transition: height .9s cubic-bezier(.16,1,.3,1); }
.dash-jenis-verbal    .dash-jenis-fill { background: #10b981; }
.dash-jenis-nonverbal .dash-jenis-fill { background: #3b82f6; }
.dash-jenis-pct-tag {
    position: absolute; top: 12px; right: 12px;
    font-size: .65rem; font-weight: 800; padding: 2px 7px; border-radius: 99px;
}
.dash-jenis-verbal    .dash-jenis-pct-tag { background: rgba(16,185,129,.15); color: #059669; }
.dash-jenis-nonverbal .dash-jenis-pct-tag { background: rgba(59,130,246,.15); color: #3b82f6; }
.dash-jenis-total-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px; background: var(--gray-50);
    border-radius: 10px; border: 1px solid var(--gray-100);
}
.dash-jenis-total-lbl { font-size: .75rem; font-weight: 600; color: var(--gray-400); }
.dash-jenis-total-val { font-size: .8rem; font-weight: 800; color: var(--gray-900); }

/* ─────────────────────────────────────
   FOOTER
───────────────────────────────────── */
.footer-compact {
    margin-top: 28px; padding: 16px; border-top: 1px solid var(--gray-200);
    background: white; text-align: center; font-size: .72rem; color: var(--gray-400);
}
.footer-compact strong { color: var(--gray-500); }

/* ─────────────────────────────────────
   RESPONSIVE
───────────────────────────────────── */
@media (max-width: 900px) { .dash-stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 700px) { .dash-mid-grid { grid-template-columns: 1fr; } }
@media (max-width: 480px) {
    .dash-stats-grid { grid-template-columns: 1fr; }
    .dash-welcome { flex-direction: column; }
    .dash-date-card { min-width: unset; width: 100%; }
}
@media (max-width: 768px) {
    .admin-sidebar { transform: translateX(-100%); }
    .admin-sidebar.open { transform: translateX(0); }
    .sidebar-overlay.open { display: block; }
    .sidebar-close-btn { display: flex; }
    .admin-wrapper { margin-left: 0 !important; }
    .hamburger-btn { display: flex; }
    .avatar-info, .avatar-chevron { display: none; }
    .admin-main { padding: 20px 16px 40px; }
}
@media (min-width: 1024px) { .avatar-info { display: block; } }
</style>

{{-- ===================== SCRIPT ===================== --}}
<script>
/* ── Sidebar ── */
function openSidebar() {
    document.getElementById('adminSidebar').classList.add('open');
    document.getElementById('sidebarOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    document.getElementById('adminSidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
function toggleNavGroup(id) {
    const group  = document.getElementById(id);
    const isOpen = group.classList.contains('open');
    document.querySelectorAll('.nav-group.open').forEach(g => g.classList.remove('open'));
    if (!isOpen) group.classList.add('open');
}

/* ── Topbar Dropdown ── */
function toggleNotif() {
    document.getElementById('notifDropdown').classList.toggle('open');
    document.getElementById('avatarDropdown').classList.remove('open');
}
function toggleAvatar() {
    document.getElementById('avatarDropdown').classList.toggle('open');
    document.getElementById('notifDropdown').classList.remove('open');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('#notifWrap'))  document.getElementById('notifDropdown')?.classList.remove('open');
    if (!e.target.closest('#avatarWrap')) document.getElementById('avatarDropdown')?.classList.remove('open');
});

/* ── Jam & Tanggal ── */
function updateClock() {
    const now    = new Date();
    const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    document.getElementById('dashDay').textContent  = now.getDate().toString().padStart(2,'0');
    document.getElementById('dashDate').textContent = `${days[now.getDay()]}, ${months[now.getMonth()]} ${now.getFullYear()}`;
    const hh = now.getHours().toString().padStart(2,'0');
    const mm = now.getMinutes().toString().padStart(2,'0');
    const ss = now.getSeconds().toString().padStart(2,'0');
    document.getElementById('dashTime').textContent = `${hh}:${mm}:${ss}`;
}
updateClock();
setInterval(updateClock, 1000);
</script>

@endsection