document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar ──────────────────────────────────────────────
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

    // ── Dropdown toggle ──────────────────────────────────────
    function toggleNotif() {
        document.getElementById('notifDropdown').classList.toggle('open');
        document.getElementById('avatarDropdown').classList.remove('open');
    }
    function toggleAvatar() {
        document.getElementById('avatarDropdown').classList.toggle('open');
        document.getElementById('notifDropdown').classList.remove('open');
    }

    window.toggleNotif  = toggleNotif;
    window.toggleAvatar = toggleAvatar;

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#notifWrap'))  document.getElementById('notifDropdown')?.classList.remove('open');
        if (!e.target.closest('#avatarWrap')) document.getElementById('avatarDropdown')?.classList.remove('open');
    });

    // ── Clock ────────────────────────────────────────────────
    function updateClock() {
        const now    = new Date();
        const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni',
                        'Juli','Agustus','September','Oktober','November','Desember'];

        const dayEl  = document.getElementById('dashDay');
        const dateEl = document.getElementById('dashDate');
        const timeEl = document.getElementById('dashTime');

        if (dayEl)  dayEl.textContent  = now.getDate().toString().padStart(2, '0');
        if (dateEl) dateEl.textContent = `${days[now.getDay()]}, ${months[now.getMonth()]} ${now.getFullYear()}`;
        if (timeEl) {
            const hh = now.getHours().toString().padStart(2, '0');
            const mm = now.getMinutes().toString().padStart(2, '0');
            const ss = now.getSeconds().toString().padStart(2, '0');
            timeEl.textContent = `${hh}:${mm}:${ss}`;
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

// ── Notifikasi ───────────────────────────────────────────
function startNotifPolling() {
    fetchNotifCount();
    setInterval(fetchNotifCount, 30000);
}

async function fetchNotifCount() {
    try {
        const res  = await fetch('/api/admin/notifications/count');
        const data = await res.json();
        if (!data.success) return;

        const badge = document.getElementById('notifBadge');
        const text  = document.getElementById('notifCountText');

        if (badge) {
            const count = data.unread_count ?? 0;
            badge.textContent   = count > 0 ? (count > 99 ? '99+' : count) : '';
            badge.style.display = count > 0 ? 'flex' : 'none';
            // Sinkronkan juga style display dengan topbar
            badge.style.visibility = 'visible';
        }

        if (text) text.textContent = (data.unread_count ?? 0) + ' baru';

        renderNotifList(data.recent);
    } catch (e) {
        console.error('Notif error:', e);
        // Jangan hide badge kalau fetch gagal
    }
}

function renderNotifList(items) {
    const list = document.getElementById('notifList');
    if (!list) return;

    if (!items || !items.length) {
        list.innerHTML = '<div class="notif-empty">Tidak ada notifikasi</div>';
        return;
    }

    list.innerHTML = items.map(n => {
        // Parse meta untuk pesan_kontak
        let metaAttr = '';
        if (n.type === 'pesan_kontak' && n.meta) {
            try {
                const meta = typeof n.meta === 'string' ? JSON.parse(n.meta) : n.meta;
                meta.waktu = n.created_at_human;
                metaAttr = `data-meta="${escapeAttr(JSON.stringify(meta))}"`;
            } catch (e) {}
        }

        return `
            <div class="notif-item ${n.read_at ? '' : 'unread'}"
                 data-id="${n.id}"
                 data-url="${n.url || ''}"
                 data-type="${n.type || ''}"
                 ${metaAttr}
                 style="cursor:pointer;">
                <div class="notif-item-icon ${n.color}">
                    ${getNotifIconSvg(n.icon)}
                </div>
                <div class="notif-item-body">
                    <p class="notif-item-text">${n.body}</p>
                    <span class="notif-item-time">${n.created_at_human}</span>
                </div>
            </div>
        `;
    }).join('');
}

function escapeAttr(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

// ── Event delegation untuk klik notif ───────
document.addEventListener('click', async function (e) {
    const item = e.target.closest('.notif-item');
    if (!item) return;

    const id   = item.dataset.id;
    const url  = item.dataset.url;
    const type = item.dataset.type;

    // Tandai dibaca
    if (item.classList.contains('unread')) {
        item.classList.remove('unread');
        await fetch(`/api/admin/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json',
            },
        }).catch(() => {});
        fetchNotifCount();
    }

    // Pesan kontak → buka modal
    if (type === 'pesan_kontak' && item.dataset.meta) {
        try {
            const meta = JSON.parse(item.dataset.meta);
            // Tutup dropdown dulu
            document.getElementById('notifDropdown')?.classList.remove('open');
            showPesanKontakModal(meta);
        } catch (e) {
            console.error('parse meta error:', e);
        }
        return;
    }

    // Lainnya → navigasi
    if (url) window.location.href = url;
});

async function markAllNotifRead() {
    await fetch('/api/admin/notifications/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            'Accept': 'application/json',
        },
    });
    fetchNotifCount();
}
    function getNotifIconSvg(icon) {
        const map = {
            file:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>`,
            check:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            clock:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            x:      `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            chat:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>`,
            shield: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>`,
            bell:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>`,
        };
        return map[icon] ?? map.bell;
    }

    window.markAllNotifRead  = markAllNotifRead;

    startNotifPolling();

});