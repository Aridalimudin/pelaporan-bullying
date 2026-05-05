// ══════════════════════════════════════════
// TOPBAR — Notifikasi & Avatar Dropdown
// ══════════════════════════════════════════

const notifIcons = {
    default: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
    </svg>`,
    report: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>`,
    warning: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>`,
    info: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>`,
    chat: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
    </svg>`,
    pesan_kontak: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
    </svg>`,
};

const notifIconColors = {
    default      : 'green',
    report       : 'blue',
    warning      : 'yellow',
    info         : 'blue',
    chat         : 'blue',
    pesan_kontak : 'blue',
};

// ── Format waktu relatif ────────────────────
function timeAgo(dateStr) {
    const diff = Math.floor((Date.now() - new Date(dateStr)) / 1000);
    if (diff < 60)    return 'Baru saja';
    if (diff < 3600)  return Math.floor(diff / 60) + ' menit lalu';
    if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
    return Math.floor(diff / 86400) + ' hari lalu';
}

// ── Escape attribute HTML ───────────────────
function escapeAttr(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

// ── Render satu item notifikasi ─────────────
function renderNotifItem(notif) {
    const type   = notif.type  ?? notif.data?.type  ?? 'default';
    const body   = notif.body  ?? notif.data?.body  ?? notif.data?.message ?? 'Notifikasi baru';
    const url    = notif.url   ?? notif.data?.url   ?? '';
    const color  = notif.color ?? notifIconColors[type] ?? 'green';
    const isRead = !!notif.read_at;
    const icon   = notifIcons[type] ?? notifIcons.default;

    // Parse meta untuk pesan_kontak
    let metaAttr = '';
    if (type === 'pesan_kontak' && notif.meta) {
        try {
            const meta = typeof notif.meta === 'string'
                ? JSON.parse(notif.meta)
                : notif.meta;
            meta.waktu = timeAgo(notif.created_at);
            metaAttr = `data-meta="${escapeAttr(JSON.stringify(meta))}"`;
        } catch (e) {}
    }

    // ← TIDAK ADA onclick di sini, pakai event delegation
    return `
        <div class="notif-item ${isRead ? 'read' : 'unread'}"
             data-id="${notif.id}"
             data-url="${escapeAttr(url)}"
             data-type="${type}"
             ${metaAttr}>
            <div class="notif-icon ${color}">${icon}</div>
            <div class="notif-body">
                <p class="notif-text">${body}</p>
                <span class="notif-time">${timeAgo(notif.created_at)}</span>
            </div>
            ${!isRead ? '<div class="notif-unread-dot"></div>' : ''}
        </div>
    `;
}

// ── Load notifikasi dari API ─────────────────
async function loadNotifications() {
    const list = document.getElementById('notifList');
    if (!list) return;

    try {
        const res  = await fetch('/api/admin/notifications?limit=10', {
            headers: { 'Accept': 'application/json' },
        });
        const json = await res.json();
        const data = json.data ?? [];

        if (data.length === 0) {
            list.innerHTML = '<div class="notif-empty">Tidak ada notifikasi.</div>';
            return;
        }

        list.innerHTML = data.map(renderNotifItem).join('');
        updateBadge(data.filter(n => !n.read_at).length);

    } catch (e) {
        console.error('loadNotifications:', e);
        list.innerHTML = '<div class="notif-empty">Gagal memuat notifikasi.</div>';
    }
}

// ── Event delegation untuk klik notif ───────
document.addEventListener('click', async function (e) {
    // Cari ancestor .notif-item dari element yang diklik
    const item = e.target.closest('.notif-item');
    if (!item) return;

    const id   = item.dataset.id;
    const url  = item.dataset.url;
    const type = item.dataset.type;

    // Tandai dibaca
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    fetch(`/api/admin/notifications/${id}/read`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
    }).catch(() => {});

    // Update UI
    item.classList.remove('unread');
    item.classList.add('read');
    item.querySelector('.notif-unread-dot')?.remove();
    updateBadge(document.querySelectorAll('.notif-item.unread').length);

    // Pesan kontak → buka modal
    if (type === 'pesan_kontak' && item.dataset.meta) {
        try {
            const meta = JSON.parse(item.dataset.meta);
            closeAllDropdowns();
            showPesanKontakModal(meta);
        } catch (e) {
            console.error('parse meta error:', e);
        }
        return;
    }

    // Lainnya → navigasi
    if (url) window.location.href = url;
});

// ── Update badge angka ──────────────────────
function updateBadge(count) {
    const badge = document.getElementById('notifBadge');
    if (!badge) return;
    badge.textContent   = count > 0 ? (count > 99 ? '99+' : count) : '';
    badge.style.display = count > 0 ? '' : 'none';
}

// ── Tandai semua dibaca ─────────────────────
async function markAllRead() {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    await fetch('/api/admin/notifications/read-all', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
    }).catch(() => {});

    document.querySelectorAll('.notif-item.unread').forEach(el => {
        el.classList.remove('unread');
        el.classList.add('read');
        el.querySelector('.notif-unread-dot')?.remove();
    });
    updateBadge(0);
}

// ── Toggle dropdown notifikasi ──────────────
function toggleNotif() {
    const dropdown = document.getElementById('notifDropdown');
    const isOpen   = dropdown.classList.contains('open');
    closeAllDropdowns();
    if (!isOpen) {
        dropdown.classList.add('open');
        loadNotifications();
    }
}

// ── Toggle dropdown avatar ──────────────────
function toggleAvatar() {
    const dropdown = document.getElementById('avatarDropdown');
    const isOpen   = dropdown.classList.contains('open');
    closeAllDropdowns();
    if (!isOpen) dropdown.classList.add('open');
}

// ── Tutup semua dropdown ────────────────────
function closeAllDropdowns() {
    document.getElementById('notifDropdown')?.classList.remove('open');
    document.getElementById('avatarDropdown')?.classList.remove('open');
}

// ── Klik di luar untuk tutup ────────────────
document.addEventListener('click', function (e) {
    const notifWrap  = document.getElementById('notifWrap');
    const avatarWrap = document.getElementById('avatarWrap');
    if (notifWrap  && !notifWrap.contains(e.target))  document.getElementById('notifDropdown')?.classList.remove('open');
    if (avatarWrap && !avatarWrap.contains(e.target)) document.getElementById('avatarDropdown')?.classList.remove('open');
});

// ══════════════════════════════════════════
// MODAL PESAN KONTAK
// ══════════════════════════════════════════

function showPesanKontakModal(meta) {
    if (!document.getElementById('pesanKontakModal')) {
        const el = document.createElement('div');
        el.id = 'pesanKontakModal';
        el.style.cssText = [
            'display:none',
            'position:fixed',
            'inset:0',
            'z-index:9999',
            'background:rgba(0,0,0,0.5)',
            'align-items:center',
            'justify-content:center',
            'padding:16px',
        ].join(';');

        el.innerHTML = `
            <div style="background:#fff;border-radius:16px;width:100%;max-width:460px;
                        box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden">
                <div style="background:linear-gradient(135deg,#059669,#10b981);padding:20px 24px;
                            display:flex;align-items:center;justify-content:space-between">
                    <div style="display:flex;align-items:center;gap:10px">
                        <div style="background:rgba(255,255,255,0.2);border-radius:8px;width:36px;height:36px;
                                    display:flex;align-items:center;justify-content:center">
                            <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
                            </svg>
                        </div>
                        <div>
                            <p style="color:white;font-weight:600;font-size:14px;margin:0">Pesan dari Halaman Kontak</p>
                            <p style="color:rgba(255,255,255,0.8);font-size:12px;margin:0" id="pkm-time"></p>
                        </div>
                    </div>
                    <button id="pkm-close-btn"
                            style="background:rgba(255,255,255,0.2);border:none;border-radius:8px;
                                   width:32px;height:32px;cursor:pointer;color:white;
                                   display:flex;align-items:center;justify-content:center">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div style="padding:24px;display:flex;flex-direction:column;gap:16px">
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;
                                  letter-spacing:.05em;margin:0 0 6px">Nama</p>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div id="pkm-avatar"
                                 style="width:34px;height:34px;border-radius:50%;background:#d1fae5;
                                        display:flex;align-items:center;justify-content:center;
                                        font-weight:700;font-size:13px;color:#065f46;flex-shrink:0"></div>
                            <span id="pkm-nama" style="font-size:15px;font-weight:600;color:#111"></span>
                        </div>
                    </div>
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;
                                  letter-spacing:.05em;margin:0 0 6px">Email</p>
                        <a id="pkm-email-link" href="#"
                           style="font-size:14px;color:#059669;font-weight:500;text-decoration:none"></a>
                    </div>
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#6b7280;text-transform:uppercase;
                                  letter-spacing:.05em;margin:0 0 8px">Pesan</p>
                        <div id="pkm-pesan"
                             style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;
                                    padding:14px;font-size:14px;color:#374151;line-height:1.7;
                                    max-height:200px;overflow-y:auto;white-space:pre-wrap"></div>
                    </div>
                </div>

                <div style="padding:0 24px 20px;display:flex;gap:8px">
                    <a id="pkm-reply-btn" href="#"
                       style="flex:1;background:#059669;color:white;border-radius:8px;padding:10px 16px;
                              font-size:13px;font-weight:600;text-align:center;text-decoration:none;display:block">
                        Balas via Email
                    </a>
                    <button id="pkm-tutup-btn"
                            style="flex:1;background:#f3f4f6;color:#374151;border:none;border-radius:8px;
                                   padding:10px 16px;font-size:13px;font-weight:600;cursor:pointer">
                        Tutup
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(el);

        // Event listener pakai JS, bukan onclick attribute
        el.addEventListener('click', e => { if (e.target === el) closePesanKontakModal(); });
        el.querySelector('#pkm-close-btn').addEventListener('click', closePesanKontakModal);
        el.querySelector('#pkm-tutup-btn').addEventListener('click', closePesanKontakModal);
    }

    // Isi data
    const nama = meta.nama || 'Anonim';
    document.getElementById('pkm-nama').textContent   = nama;
    document.getElementById('pkm-avatar').textContent = nama.charAt(0).toUpperCase();
    document.getElementById('pkm-pesan').textContent  = meta.pesan || '-';
    document.getElementById('pkm-time').textContent   = meta.waktu || '';

    const emailEl  = document.getElementById('pkm-email-link');
    const replyBtn = document.getElementById('pkm-reply-btn');

    if (meta.email) {
        emailEl.textContent          = meta.email;
        emailEl.href                 = `mailto:${meta.email}`;
        replyBtn.textContent         = 'Balas via Email';
        replyBtn.href                = `mailto:${meta.email}`;
        replyBtn.style.pointerEvents = '';
        replyBtn.style.opacity       = '1';
        replyBtn.style.background    = '#059669';
    } else {
        emailEl.textContent          = '— (anonim) —';
        emailEl.href                 = '#';
        replyBtn.textContent         = 'Pengirim Anonim';
        replyBtn.href                = '#';
        replyBtn.style.pointerEvents = 'none';
        replyBtn.style.opacity       = '0.45';
        replyBtn.style.background    = '#9ca3af';
    }

    document.getElementById('pesanKontakModal').style.display = 'flex';
}

function closePesanKontakModal() {
    const modal = document.getElementById('pesanKontakModal');
    if (modal) modal.style.display = 'none';
}

// ── Expose ke global ────────────────────────
window.toggleNotif           = toggleNotif;
window.toggleAvatar          = toggleAvatar;
window.markAllRead           = markAllRead;
window.closePesanKontakModal = closePesanKontakModal;