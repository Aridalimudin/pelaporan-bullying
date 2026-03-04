<header class="admin-topbar">
    <div class="topbar-left">
        <button class="hamburger-btn" onclick="openSidebar()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div>
            <h1 class="topbar-title">{{ $pageTitle ?? 'Dashboard' }}</h1>
            @if(isset($breadcrumbs))
            <nav class="topbar-breadcrumb">
                @foreach($breadcrumbs as $i => $crumb)
                    @if($i > 0) <span class="bc-sep">/</span> @endif
                    @if(isset($crumb['url']))
                        <a href="{{ $crumb['url'] }}" class="bc-link">{{ $crumb['label'] }}</a>
                    @else
                        <span class="bc-current">{{ $crumb['label'] }}</span>
                    @endif
                @endforeach
            </nav>
            @endif
        </div>
    </div>

    <div class="topbar-right">
        {{-- Notification --}}
        <div class="notif-wrap" id="notifWrap">
            <button class="topbar-icon-btn" onclick="toggleNotif()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="notif-dot">3</span>
            </button>
            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-header">
                    <span class="notif-header-title">Notifikasi</span>
                    <span class="notif-count-badge">3 baru</span>
                </div>
                <div class="notif-list">
                    <div class="notif-item unread">
                        <div class="notif-item-icon green">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                        </div>
                        <div class="notif-item-body">
                            <p class="notif-item-text">Laporan baru masuk dari <strong>Keonho</strong></p>
                            <span class="notif-item-time">2 menit lalu</span>
                        </div>
                    </div>
                    <div class="notif-item unread">
                        <div class="notif-item-icon yellow">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="notif-item-body">
                            <p class="notif-item-text">Laporan <strong>KRF-010126-A3B2</strong> perlu verifikasi</p>
                            <span class="notif-item-time">1 jam lalu</span>
                        </div>
                    </div>
                    <div class="notif-item unread">
                        <div class="notif-item-icon blue">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="notif-item-body">
                            <p class="notif-item-text">Laporan <strong>KRF-291225-X9Y1</strong> selesai ditangani</p>
                            <span class="notif-item-time">3 jam lalu</span>
                        </div>
                    </div>
                </div>
                <div class="notif-footer">
                    <a href="#">Lihat semua notifikasi</a>
                </div>
            </div>
        </div>

        <div class="avatar-wrap" id="avatarWrap">
            <button class="avatar-btn" onclick="toggleAvatar()">
                <div class="avatar-circle">A</div>
                <div class="avatar-info">
                    <span class="avatar-name">Admin</span>
                    <span class="avatar-role">Kesiswaan</span>
                </div>
                <svg class="avatar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="avatar-dropdown" id="avatarDropdown">
                <div class="avatar-dropdown-header">
                    <div class="avatar-circle lg">A</div>
                    <div>
                        <p class="avatar-dropdown-name">Administrator</p>
                        <p class="avatar-dropdown-email">admin@smkm3.sch.id</p>
                    </div>
                </div>
                <div class="avatar-dropdown-divider"></div>
                <a href="#" class="avatar-dropdown-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil Saya
                </a>
                <a href="#" class="avatar-dropdown-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan
                </a>
                <div class="avatar-dropdown-divider"></div>
                <form method="POST" action="#">
                    @csrf
                    <button type="submit" class="avatar-dropdown-item danger">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>