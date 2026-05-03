<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIP — Sekolah Aman' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard-page.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function parseJsonResponse(response) {
            return response.text().then((text) => {
                if (!text) {
                    throw new Error('Empty JSON response');
                }
                try {
                    return JSON.parse(text);
                } catch (error) {
                    console.error('Failed to parse JSON response:', text, error);
                    throw error;
                }
            });
        }

        async function fetchAdminJson(url, options = {}) {
            const response = await fetch(url, options);
            if (!response.ok) {
                const body = await response.text().catch(() => '');
                console.error('Fetch failed:', response.status, response.statusText, body);
                throw new Error(`HTTP ${response.status} ${response.statusText}`);
            }
            return await parseJsonResponse(response);
        }
    </script>

    @stack('styles')
</head>
<body>

    @yield('content')

    <script>
    document.addEventListener('DOMContentLoaded', function () {

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

        window.openSidebar    = openSidebar;
        window.closeSidebar   = closeSidebar;
        window.toggleNavGroup = toggleNavGroup;

       function toggleNotif() {
            const dropdown = document.getElementById('notifDropdown');
            const isOpening = !dropdown.classList.contains('open');
            dropdown.classList.toggle('open');
            document.getElementById('avatarDropdown').classList.remove('open');
            if (isOpening) loadTopbarNotif(); // ← load fresh setiap kali dibuka
        }
        function toggleAvatar() {
            document.getElementById('avatarDropdown').classList.toggle('open');
            document.getElementById('notifDropdown').classList.remove('open');
        }

        window.toggleNotif  = toggleNotif;
        window.toggleAvatar = toggleAvatar;

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#notifWrap'))  document.getElementById('notifDropdown')?.classList.remove('open');
            if (!e.target.closest('#avatarWrap')) document.getElementById('avatarDropdown')?.classList.remove('open');
        });
    });
    </script>

    @stack('scripts')

<script>
// ── Topbar Notifikasi ─────────────────────────────────────
async function loadTopbarNotif() {
    const list = document.getElementById('notifList');
    if (!list) return;

    try {
        const res  = await fetch('/api/admin/notifications?page=1&filter=all');
        const data = await res.json();

        if (!data.success || !data.data?.length) {
            list.innerHTML = '<div class="notif-empty">Tidak ada notifikasi</div>';
            return;
        }

        const iconMap = {
            bell:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>`,
            file:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>`,
            check:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            clock:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            x:      `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            chat:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>`,
        };

        // Ambil 5 terbaru saja
        const items = data.data.slice(0, 5);

        list.innerHTML = items.map(n => `
            <div class="notif-item ${n.read_at ? 'read' : 'unread'}"
                 data-id="${n.id}"
                 data-url="${n.url || ''}"
                 onclick="handleTopbarNotifClick('${n.id}', '${n.url || ''}')">
                <div class="notif-icon ${n.color || 'green'}">
                    ${iconMap[n.icon] ?? iconMap.bell}
                </div>
                <div class="notif-body">
                    <p class="notif-text">${n.body}</p>
                    <span class="notif-time">${n.created_at_human}</span>
                </div>
                ${!n.read_at ? '<div class="notif-unread-dot"></div>' : ''}
            </div>
        `).join('');

        // Update badge
        const badge = document.getElementById('notifBadge');
        if (badge) badge.textContent = data.unread_count > 0 ? data.unread_count : '';

    } catch (e) {
        const list = document.getElementById('notifList');
        if (list) list.innerHTML = '<div class="notif-empty">Gagal memuat notifikasi.</div>';
        console.error(e);
    }
}

async function handleTopbarNotifClick(id, url) {
    try {
        await fetch(`/api/admin/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json',
            },
        });
    } catch (e) { console.error(e); }
    if (url) window.location.href = url;
}

async function markAllRead() {
    try {
        await fetch('/api/admin/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json',
            },
        });
        const badge = document.getElementById('notifBadge');
        if (badge) badge.textContent = '0';
        loadTopbarNotif();
    } catch (e) { console.error(e); }
}
</script>

</body>
</html>