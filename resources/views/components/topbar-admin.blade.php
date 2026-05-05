        <header class="admin-topbar">
            <style>
                .admin-topbar {
                    --avatar-bg: {{ auth('web')->user()->avatar_bg ?? '#d1fae5' }};
                    --avatar-color: {{ auth('web')->user()->avatar_color ?? '#065f46' }};
                }
                .admin-topbar .avatar-circle {
                    background: var(--avatar-bg);
                    color: var(--avatar-color);
                }
            </style>
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
                <div class="notif-wrap" id="notifWrap">
                    <button class="topbar-icon-btn" onclick="toggleNotif()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="notif-dot" id="notifBadge">
                            {{ auth('web')->user()->unreadNotifications()->count() }}
                        </span>
                    </button>
                    <div class="notif-dropdown" id="notifDropdown">
                        <div class="notif-header">
                            <span class="notif-header-title">Notifikasi</span>
                            <button class="notif-mark-all" onclick="markAllRead()">Tandai semua dibaca</button>
                        </div>
                        <div class="notif-list" id="notifList">
                            <div class="notif-empty">Memuat...</div>
                        </div>
                        <div class="notif-footer">
                            <a href="/admin/notifications">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </div>

                <div class="avatar-wrap" id="avatarWrap">
                    <button class="avatar-btn" onclick="toggleAvatar()">
                        <div class="avatar-circle">
                            {{ strtoupper(substr(auth('web')->user()->nama ?? 'A', 0, 1)) }}
                        </div>
                        <div class="avatar-info">
                            <span class="avatar-name">{{ auth('web')->user()->nama ?? 'Admin' }}</span>
                            <span class="avatar-role">{{ auth('web')->user()->getPrimaryRole()?->nama ?? '-' }}</span>
                        </div>
                        <svg class="avatar-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="avatar-dropdown" id="avatarDropdown">
                        <div class="avatar-dropdown-header">
                            <div class="avatar-circle lg">
                                {{ strtoupper(substr(auth('web')->user()->nama ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="avatar-dropdown-name">{{ auth('web')->user()->nama ?? 'Administrator' }}</p>
                                <p class="avatar-dropdown-email">{{ auth('web')->user()->email ?? '-' }}</p>
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
                        <button type="button" class="avatar-dropdown-item danger" onclick="doLogout()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <script>
        async function doLogout() {
            const logoutUrl = '{{ route("api.admin.logout") }}';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            if (!csrfToken) {
                console.error('CSRF token not found for logout.');
                window.location.href = '/login';
                return;
            }

            const response = await fetch(logoutUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                console.error('Logout failed with status', response.status);
            }

            window.location.href = '/login';
        }
        </script>

        <script src="{{ asset('js/topbar.js') }}"></script>

<style>
    
    .notif-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 360px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.1);
    z-index: 1000;
    overflow: hidden;
    display: none;
}
.notif-dropdown.open { display: block; }

.notif-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px 10px;
    border-bottom: 1px solid #f0f0f0;
}
.notif-header-title {
    font-weight: 600;
    font-size: 14px;
    color: #111;
}
.notif-mark-all {
    font-size: 12px;
    color: #1a7a50;
    background: none;
    border: none;
    cursor: pointer;
}
.notif-mark-all:hover { text-decoration: underline; }

.notif-list {
    max-height: 320px;
    overflow-y: auto;
}
.notif-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 16px;
    border-bottom: 1px solid #f9f9f9;
    cursor: pointer;
    transition: background .15s;
}
.notif-item:hover { background: #f9fafb; }
.notif-item.unread { background: #f0faf5; }

.notif-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.notif-icon svg { width: 16px; height: 16px; }
.notif-icon.green  { background: #d1fae5; color: #065f46; }
.notif-icon.yellow { background: #fef3c7; color: #92400e; }
.notif-icon.blue   { background: #dbeafe; color: #1e40af; }
.notif-icon.red    { background: #fee2e2; color: #991b1b; }

.notif-body { flex: 1; min-width: 0; }
.notif-text {
    font-size: 13px;
    color: #222;
    margin: 0 0 3px;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.notif-time { font-size: 11px; color: #999; }

.notif-empty {
    text-align: center;
    padding: 2rem;
    color: #aaa;
    font-size: 13px;
}
.notif-footer {
    padding: 10px 16px;
    border-top: 1px solid #f0f0f0;
    text-align: center;
}
.notif-footer a {
    font-size: 13px;
    color: #1a7a50;
    text-decoration: none;
    font-weight: 500;
}
.notif-footer a:hover { text-decoration: underline; }
/* Tambahkan ke <style> yang sudah ada di topbar */
.notif-item.read {
    background: #fff;
    opacity: 0.75;
}
.notif-item.unread {
    background: #f0faf5;
}
.notif-unread-dot {
    width: 8px;
    height: 8px;
    background: #1a7a50;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 4px;
}

</style>