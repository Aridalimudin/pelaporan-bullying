// public/js/login-page.js

const form    = document.getElementById('loginForm');
const btnMasuk = document.getElementById('btnMasuk');
const REDIRECT = document.querySelector('script[data-redirect]')?.dataset.redirect
               || '/dashboard';

// Toggle password visibility
document.getElementById('togglePw')?.addEventListener('click', () => {
    const pw = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    const isHidden = pw.type === 'password';
    pw.type = isHidden ? 'text' : 'password';
    // Ganti icon eye/eye-off sesuai state
});

form?.addEventListener('submit', async (e) => {
    e.preventDefault(); // ← INI yang paling penting, cegah reload halaman

    // Reset error
    document.getElementById('username-err').style.display = 'none';
    document.getElementById('password-err').style.display = 'none';
    document.getElementById('cred-err').style.display     = 'none';

    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;

    // Validasi sederhana di frontend
    let hasError = false;
    if (!username) {
        document.getElementById('username-err').style.display = 'block';
        hasError = true;
    }
    if (!password) {
        document.getElementById('password-err').style.display = 'block';
        hasError = true;
    }
    if (hasError) return;

    // Loading state
    btnMasuk.disabled = true;
    btnMasuk.querySelector('.spinner').style.display = 'block';
    btnMasuk.querySelector('.btn-text').textContent  = 'Memproses...';

    try {
        const res  = await fetch('/api/admin/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ username, password }),
        });

        const data = await res.json();

        if (res.ok && data.success) {
            // Redirect ke dashboard
            window.location.href = data.redirect || REDIRECT;
        } else {
            // Tampilkan error dari server
            document.getElementById('cred-err').style.display = 'block';
            document.getElementById('cred-err').textContent   = data.message || 'Login gagal.';
        }

    } catch (err) {
        console.error(err);
        document.getElementById('cred-err').style.display = 'block';
        document.getElementById('cred-err').textContent   = 'Koneksi bermasalah. Coba lagi.';
    } finally {
        btnMasuk.disabled = false;
        btnMasuk.querySelector('.spinner').style.display = 'none';
        btnMasuk.querySelector('.btn-text').textContent  = 'Masuk';
    }
});