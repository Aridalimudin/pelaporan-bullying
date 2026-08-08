(function () {
    const script      = document.currentScript;
    const loginUrl    = script?.dataset.loginUrl;
    const csrfToken   = script?.dataset.csrf;
    const redirectUrl = script?.dataset.redirect;

    const form      = document.getElementById('loginSiswaForm');
    const btnMasuk  = document.getElementById('btnMasukSiswa');
    const nisInput  = document.getElementById('nis');
    const pwInput   = document.getElementById('password');
    const nisErr    = document.getElementById('nis-err');
    const pwErr     = document.getElementById('password-err');
    const credErr   = document.getElementById('cred-err');
    const togglePw  = document.getElementById('togglePw');
    const eyeIcon   = document.getElementById('eyeIcon');

    const eyeOpen  = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    const eyeClosed = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;

    if (togglePw && eyeIcon && pwInput) {
        togglePw.addEventListener('click', function () {
            const isText = pwInput.type === 'text';
            pwInput.type = isText ? 'password' : 'text';
            eyeIcon.innerHTML = isText ? eyeOpen : eyeClosed;
        });
    }

    function setLoading(state) {
        btnMasuk.disabled = state;
        btnMasuk.classList.toggle('loading', state);
    }

    function showErr(el, msg) {
        el.textContent = msg;
        el.style.display = 'block';
    }

    function hideErr(el) {
        el.style.display = 'none';
        el.textContent = '';
    }

    nisInput?.addEventListener('input', () => hideErr(nisErr));
    pwInput?.addEventListener('input',  () => hideErr(pwErr));

    form?.addEventListener('submit', async function (e) {
        e.preventDefault();

        hideErr(nisErr);
        hideErr(pwErr);
        hideErr(credErr);

        const nis      = nisInput.value.trim();
        const password = pwInput.value;
        let valid = true;

        if (!nis) { showErr(nisErr, 'NIS wajib diisi.'); valid = false; }
        if (!password) { showErr(pwErr, 'Password wajib diisi.'); valid = false; }
        if (!valid) return;

        setLoading(true);

        try {
            const res  = await fetch(loginUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ nis, password }),
            });

            const data = await res.json();

            if (res.ok && data.success) {
                if (data.csrf_token) {
                    document.querySelectorAll('meta[name="csrf-token"]').forEach(el => el.setAttribute('content', data.csrf_token));
                    document.querySelectorAll('input[name="_token"]').forEach(el => el.value = data.csrf_token);
                }
                window.location.href = data.redirect || redirectUrl;
            } else {
                showErr(credErr, data.message || 'Login gagal. Coba lagi.');
                setLoading(false);
            }
        } catch (err) {
            showErr(credErr, 'Koneksi bermasalah. Periksa internet Anda.');
            setLoading(false);
        }
    });
})();
