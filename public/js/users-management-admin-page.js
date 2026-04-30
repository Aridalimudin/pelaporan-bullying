/**
 * admin-shared.js
 * File JS bersama yang digunakan oleh:
 *   - daftar-roles.blade.php
 *   - daftar-users.blade.php
 *   - daftar-permissions.blade.php
 *
 * Berisi: toggleNavGroup, helper modal overlay, logout, dan utilitas umum
 */

/* ───────────────────────────────────────────
   1. Sidebar nav group toggle
─────────────────────────────────────────── */
function toggleNavGroup(id) {
    const group = document.getElementById(id);
    if (!group) return;
    const isOpen = group.classList.contains('open');
    document.querySelectorAll('.nav-group.open').forEach(g => {
        if (g.id !== id) g.classList.remove('open');
    });
    group.classList.toggle('open', !isOpen);
}

/* ───────────────────────────────────────────
   2. Generic overlay helpers
─────────────────────────────────────────── */
function bindOverlayClose(overlayId, closeFn) {
    const el = document.getElementById(overlayId);
    if (!el) return;
    el.addEventListener('click', function (e) {
        if (e.target === this) closeFn();
    });
}

function closeOverlay(overlayId) {
    const el = document.getElementById(overlayId);
    if (!el) return;
    el.style.display = 'none';
    document.body.style.overflow = '';
}

function openOverlay(overlayId) {
    const el = document.getElementById(overlayId);
    if (!el) return;
    el.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

/* ───────────────────────────────────────────
   3. Password visibility toggle
─────────────────────────────────────────── */
function togglePw(inputId) {
    const input = document.getElementById(inputId);
    if (!input) return;
    input.type = input.type === 'password' ? 'text' : 'password';
}

/* ───────────────────────────────────────────
   4. JSON request headers (CSRF + Accept)
   Dipakai oleh semua fetch POST/PUT/DELETE
─────────────────────────────────────────── */
function jsonHeaders() {
    return {
        'Content-Type': 'application/json',
        'Accept':       'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
    };
}

/* ───────────────────────────────────────────
   5. Logout
   Dipanggil dari tombol "Keluar" di sidebar
─────────────────────────────────────────── */
async function doLogout() {
    // Tampilkan konfirmasi sederhana sebelum logout
    if (!confirm('Yakin ingin keluar?')) return;

    try {
        const res  = await fetch('/api/admin/logout', {
            method: 'POST',
            headers: jsonHeaders(),
        });
        const data = await res.json();

        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            window.location.href = '/login';
        }
    } catch (err) {
        console.error('Logout error:', err);
        // Tetap redirect ke login meski fetch gagal
        window.location.href = '/login';
    }
}