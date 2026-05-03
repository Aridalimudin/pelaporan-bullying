(function () {
    let currentPage   = 1;
    let currentFilter = 'all';

    // ── Load notifikasi ──────────────────────────────────────
    async function loadNotifications(page, filter) {
        const list = document.getElementById('notifPageList');
        list.innerHTML = '<div class="notif-page-loading">Memuat notifikasi...</div>';

        try {
            const params = new URLSearchParams({ page, filter });
            const res    = await fetch(`/api/admin/notifications?${params}`);
            const data   = await res.json();

            if (!data.success) {
                list.innerHTML = '<div class="notif-page-empty">Gagal memuat notifikasi.</div>';
                return;
            }

            renderList(data.data);
            renderPagination(data.pagination);
        } catch (e) {
            list.innerHTML = '<div class="notif-page-empty">Terjadi kesalahan.</div>';
            console.error(e);
        }
    }

    // ── Render list ──────────────────────────────────────────
    function renderList(items) {
        const list = document.getElementById('notifPageList');

        if (!items || !items.length) {
            list.innerHTML = '<div class="notif-page-empty">Tidak ada notifikasi.</div>';
            return;
        }

        list.innerHTML = items.map(n => `
            <div class="notif-page-item ${n.read_at ? '' : 'unread'}"
                 data-id="${n.id}"
                 data-url="${n.url || ''}"
                 onclick="handleItemClick(this)">
                <div class="notif-page-icon ${n.color}">
                    ${getIconSvg(n.icon)}
                </div>
                <div class="notif-page-body">
                    <p class="notif-page-text">${n.body}</p>
                    <span class="notif-page-time">${n.created_at_human}</span>
                </div>
                ${!n.read_at ? '<div class="notif-page-unread-dot"></div>' : ''}
            </div>
        `).join('');
    }

    // ── Render pagination ────────────────────────────────────
    function renderPagination(pagination) {
        const wrap = document.getElementById('notifPagePagination');
        if (!pagination || pagination.last_page <= 1) {
            wrap.innerHTML = '';
            return;
        }

        const { current_page, last_page } = pagination;
        let html = '';

        html += `<button class="notif-page-btn" onclick="goToPage(${current_page - 1})"
                    ${current_page === 1 ? 'disabled' : ''}>← Sebelumnya</button>`;

        for (let i = 1; i <= last_page; i++) {
            html += `<button class="notif-page-btn ${i === current_page ? 'active' : ''}"
                        onclick="goToPage(${i})">${i}</button>`;
        }

        html += `<button class="notif-page-btn" onclick="goToPage(${current_page + 1})"
                    ${current_page === last_page ? 'disabled' : ''}>Selanjutnya →</button>`;

        wrap.innerHTML = html;
    }

    // ── Klik item ────────────────────────────────────────────
    window.handleItemClick = async function (el) {
        const id  = el.dataset.id;
        const url = el.dataset.url;

        if (el.classList.contains('unread')) {
            el.classList.remove('unread');
            el.querySelector('.notif-page-unread-dot')?.remove();
            await fetch(`/api/admin/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    'Accept': 'application/json',
                },
            });
        }

        if (url) window.location.href = url;
    };

    // ── Filter ───────────────────────────────────────────────
    window.setFilter = function (filter) {
        currentFilter = filter;
        currentPage   = 1;

        document.querySelectorAll('.notif-tab').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.filter === filter);
        });

        loadNotifications(currentPage, currentFilter);
    };

    // ── Tandai semua dibaca ──────────────────────────────────
    window.pageMarkAllRead = async function () {
        await fetch('/api/admin/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json',
            },
        });
        loadNotifications(currentPage, currentFilter);
    };

    // ── Paginasi ─────────────────────────────────────────────
    window.goToPage = function (page) {
        currentPage = page;
        loadNotifications(currentPage, currentFilter);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // ── Icon SVG ─────────────────────────────────────────────
    function getIconSvg(icon) {
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

    // ── Init ─────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        loadNotifications(currentPage, currentFilter);
    });

})();