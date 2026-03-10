<aside class="admin-sidebar" id="adminSidebar">

    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <div class="sidebar-brand-text">
            <span class="brand-name">SIP Bullying</span>
            <span class="brand-sub">Kesiswaan</span>
        </div>
        <button class="sidebar-close-btn" id="sidebarClose" onclick="closeSidebar()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="sidebar-nav">

        <div class="nav-section-label">Dashboard</div>
        <a href="dashboard" class="nav-item {{ ($activePage ?? '') === 'dashboard' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Beranda</span>
        </a>

        <div class="nav-section-label">Pelaporan</div>
        <div class="nav-group {{ in_array($activePage ?? '', ['laporan-masuk','menunggu-verifikasi','proses-laporan','laporan-selesai','laporan-ditolak']) ? 'open' : '' }}" id="groupPelaporan">
            <button class="nav-group-trigger" onclick="toggleNavGroup('groupPelaporan')">
                <div class="nav-group-left">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Manajemen Laporan</span>
                </div>
                <svg class="nav-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="nav-group-children">
                <a href="/laporan-masuk" class="nav-child {{ ($activePage ?? '') === 'laporan-masuk' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <span>Laporan Masuk</span>
                    @php
                        $__badgeLM = $countLaporanMasuk ?? 12;
                    @endphp
                    @if($__badgeLM > 0)
                        <span class="nav-badge">{{ $__badgeLM }}</span>
                    @endif
                </a>
                <a href="/menunggu-verifikasi" class="nav-child {{ ($activePage ?? '') === 'menunggu-verifikasi' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Menunggu Verifikasi</span>
                    @php $__badgeMV = $countMenungguVerifikasi ?? 0; @endphp
                    @if($__badgeMV > 0)
                        <span class="nav-badge">{{ $__badgeMV }}</span>
                    @endif
                </a>
                <a href="/proses-laporan" class="nav-child {{ ($activePage ?? '') === 'proses-laporan' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Proses Laporan</span>
                    @php $__badgePL = $countProsesLaporan ?? 0; @endphp
                    @if($__badgePL > 0)
                        <span class="nav-badge">{{ $__badgePL }}</span>
                    @endif
                </a>
                <a href="/laporan-selesai" class="nav-child {{ ($activePage ?? '') === 'laporan-selesai' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Laporan Selesai</span>
                    @php $__badgeLS = $countLaporanSelesai ?? 0; @endphp
                    @if($__badgeLS > 0)
                        <span class="nav-badge">{{ $__badgeLS }}</span>
                    @endif
                </a>
                <a href="/laporan-ditolak" class="nav-child {{ ($activePage ?? '') === 'laporan-ditolak' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Laporan Ditolak</span>
                    @php $__badgeDT = $countLaporanDitolak ?? 0; @endphp
                    @if($__badgeDT > 0)
                        <span class="nav-badge" style="background:#ef4444">{{ $__badgeDT }}</span>
                    @endif
                </a>
            </div>
        </div>

        <div class="nav-section-label">Administrasi</div>

       <div class="nav-group {{ in_array($activePage ?? '', ['data-siswa','jenis-pelanggaran','tindakan-disiplin']) ? 'open' : '' }}" id="groupMasterData">
            <button class="nav-group-trigger" onclick="toggleNavGroup('groupMasterData')">
                <div class="nav-group-left">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    <span>Master Data</span>
                </div>
                <svg class="nav-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="nav-group-children">
                <a href="/data-siswa" class="nav-child {{ ($activePage ?? '') === 'data-siswa' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Data Siswa</span>
                </a>
                <a href="/jenis-pelanggaran" class="nav-child {{ ($activePage ?? '') === 'jenis-pelanggaran' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Jenis Pelanggaran</span>
                </a>
                <a href="/tindakan-disiplin" class="nav-child {{ ($activePage ?? '') === 'tindakan-disiplin' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span>Tindakan Disiplin</span>
                </a>
            </div>
        </div>

        <div class="nav-group {{ in_array($activePage ?? '', ['daftar-users','daftar-roles','daftar-permissions']) ? 'open' : '' }}" id="groupUser">
            <button class="nav-group-trigger" onclick="toggleNavGroup('groupUser')">
                <div class="nav-group-left">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Manajemen User</span>
                </div>
                <svg class="nav-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="nav-group-children">
                <a href="/daftar-users" class="nav-child {{ ($activePage ?? '') === 'daftar-users' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>User</span>
                </a>
                <a href="/daftar-roles" class="nav-child {{ ($activePage ?? '') === 'daftar-roles' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Role</span>
                </a>
                <a href="/daftar-permissions" class="nav-child {{ ($activePage ?? '') === 'daftar-permissions' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    <span>Permission</span>
                </a>
            </div>
        </div>

        <div class="nav-section-label">Analitik</div>
        <div class="nav-group {{ in_array($activePage ?? '', ['rekap-bulan','rekap-semester']) ? 'open' : '' }}" id="groupAnalitik">
            <button class="nav-group-trigger" onclick="toggleNavGroup('groupAnalitik')">
                <div class="nav-group-left">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Rekapitulasi Kasus</span>
                </div>
                <svg class="nav-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="nav-group-children">
                <a href="/rekapitulasi-PerBulan" class="nav-child {{ ($activePage ?? '') === 'rekap-bulan' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Per Bulan</span>
                </a>
                <a href="/rekapitulasi-PerSemester" class="nav-child {{ ($activePage ?? '') === 'rekap-semester' ? 'active' : '' }}">
                    <svg class="child-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Per Semester</span>
                </a>
            </div>
        </div>

    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-profile">
            <div class="sidebar-profile-avatar">A</div>
            <div class="sidebar-profile-info">
                <span class="sidebar-profile-name">Admin</span>
                <span class="sidebar-profile-role">Kesiswaan</span>
            </div>
        </div>

        <form method="POST" action="#">
            @csrf
            <button type="submit" class="btn-logout">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<style>
    :root {
        --sidebar-bg: #ffffff;
        --sidebar-width: 260px;
        --green-primary: #16a34a;
        --green-light: #dcfce7;
        --green-medium: #bbf7d0;
        --green-dark: #15803d;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --text-muted: #9ca3af;
        --border-color: #f3f4f6;
        --hover-bg: #f0fdf4;
        --active-bg: #dcfce7;
        --radius: 10px;
        --radius-sm: 6px;
        --shadow: 0 4px 24px rgba(0,0,0,0.08);
    }

    .admin-sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        background: var(--sidebar-bg);
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--border-color);
        box-shadow: var(--shadow);
        overflow: hidden;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        transition: transform 0.3s ease;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 18px 18px;
        border-bottom: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .sidebar-brand-icon {
        width: 42px;
        height: 42px;
        background: var(--green-primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sidebar-brand-icon svg {
        width: 22px;
        height: 22px;
        color: white;
    }

    .sidebar-brand-text {
        display: flex;
        flex-direction: column;
        line-height: 1;
        gap: 3px;
    }

    .brand-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.2px;
    }

    .brand-sub {
        font-size: 11px;
        font-weight: 600;
        color: var(--green-primary);
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .sidebar-close-btn {
        display: none;
        margin-left: auto;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        color: var(--text-secondary);
        border-radius: var(--radius-sm);
    }

    .sidebar-close-btn svg { width: 18px; height: 18px; }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: 14px 12px;
        display: flex;
        flex-direction: column;
        gap: 2px;
        scrollbar-width: thin;
        scrollbar-color: #e5e7eb transparent;
    }

    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }

    .nav-section-label {
        font-size: 9.5px;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1.1px;
        padding: 12px 12px 5px;
        margin-top: 2px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius);
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 500;
        transition: all 0.18s ease;
        position: relative;
    }

    .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

    .nav-item:hover {
        background: var(--hover-bg);
        color: var(--green-dark);
    }

    .nav-item.active {
        background: var(--active-bg);
        color: var(--green-primary);
        font-weight: 600;
    }

    .nav-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 22px;
        background: var(--green-primary);
        border-radius: 0 3px 3px 0;
    }

    .nav-group {
        display: flex;
        flex-direction: column;
    }

    .nav-group-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        border-radius: var(--radius);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-secondary);
        font-size: 13.5px;
        font-weight: 500;
        width: 100%;
        transition: all 0.18s ease;
    }

    .nav-group-trigger:hover {
        background: var(--hover-bg);
        color: var(--green-dark);
    }

    .nav-group.open .nav-group-trigger {
        background: var(--active-bg);
        color: var(--green-primary);
        font-weight: 600;
    }

    .nav-group-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-group-left svg { width: 18px; height: 18px; flex-shrink: 0; }

    .nav-chevron {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
        transition: transform 0.25s ease;
    }

    .nav-group.open .nav-chevron { transform: rotate(180deg); }

    .nav-group-children {
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.35s cubic-bezier(0.4,0,0.2,1);
        padding-left: 8px;
        padding-right: 0;
        display: flex;
        flex-direction: column;
        gap: 1px;
        margin-top: 2px;
    }

    .nav-group.open .nav-group-children { max-height: 500px; }

    .nav-child {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 7px 10px;
        border-radius: 8px;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 13px;
        font-weight: 400;
        transition: all 0.15s ease;
        position: relative;
    }

    .nav-child span:not(.nav-badge) {
        flex: 1;
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .nav-child:hover {
        background: var(--hover-bg);
        color: var(--green-dark);
    }

    .nav-child.active {
        background: var(--active-bg);
        color: var(--green-primary);
        font-weight: 600;
    }

    .child-icon {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
        color: #b0b8c4;
        transition: color 0.15s;
    }

    .nav-child:hover .child-icon { color: var(--green-primary); }
    .nav-child.active .child-icon { color: var(--green-primary); }

    .nav-badge {
        margin-left: auto;
        flex-shrink: 0;
        background: #ef4444;
        color: white;
        font-size: 9.5px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 20px;
        min-width: 18px;
        text-align: center;
        line-height: 1.6;
    }

    .sidebar-footer {
        border-top: 1px solid var(--border-color);
        padding: 14px 12px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .sidebar-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: var(--active-bg);
        border-radius: var(--radius);
    }

    .sidebar-profile-avatar {
        width: 36px;
        height: 36px;
        background: var(--green-primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .sidebar-profile-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
        overflow: hidden;
    }

    .sidebar-profile-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-profile-role {
        font-size: 11px;
        color: var(--green-primary);
        font-weight: 500;
    }

    .btn-logout {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius);
        border: 1.5px solid #fecaca;
        background: #fff5f5;
        color: #ef4444;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: all 0.18s ease;
    }

    .btn-logout svg { width: 17px; height: 17px; flex-shrink: 0; }

    .btn-logout:hover {
        background: #fee2e2;
        border-color: #f87171;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 999;
    }

    @media (max-width: 768px) {
        .admin-sidebar { transform: translateX(-100%); }
        .admin-sidebar.open { transform: translateX(0); }
        .sidebar-close-btn { display: flex; }
        .sidebar-overlay.active { display: block; }
    }
</style>