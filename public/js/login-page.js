document.addEventListener('DOMContentLoaded', function () {

    const REDIRECT = document.currentScript?.dataset.redirect
        || document.querySelector('script[data-redirect]')?.dataset.redirect
        || '/dashboard';

    const DUMMY = { username: 'admin', password: 'admin123' };

    const toggleBtn = document.getElementById('togglePw');
    const pwInput   = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');

    const eyeOpen   = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    const eyeClosed = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;

    toggleBtn.addEventListener('click', function () {
        const isHidden = pwInput.type === 'password';
        pwInput.type = isHidden ? 'text' : 'password';
        eyeIcon.innerHTML = isHidden ? eyeClosed : eyeOpen;
    });

    function showErr(id, msg) {
        const el = document.getElementById(id);
        if (msg) el.textContent = msg;
        el.classList.add('show');
        el.style.animation = 'none';
        void el.offsetWidth;
        el.style.animation = '';
    }

    function hideErr(id) {
        document.getElementById(id).classList.remove('show');
    }

    function setInputError(id) {
        document.getElementById(id).classList.add('error');
    }

    function clearInputError(id) {
        document.getElementById(id).classList.remove('error');
    }

    ['username', 'password'].forEach(function (id) {
        document.getElementById(id).addEventListener('input', function () {
            clearInputError(id);
            hideErr(id + '-err');
            hideErr('cred-err');
        });
    });

    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const user = document.getElementById('username').value.trim();
        const pass = document.getElementById('password').value;
        let valid = true;

        hideErr('cred-err');

        if (!user) { showErr('username-err'); setInputError('username'); valid = false; }
        if (!pass) { showErr('password-err'); setInputError('password'); valid = false; }
        if (!valid) return;

        const btn = document.getElementById('btnMasuk');
        btn.classList.add('loading');

        setTimeout(function () {
            btn.classList.remove('loading');

            if (user === DUMMY.username && pass === DUMMY.password) {
                btn.style.background = 'linear-gradient(135deg, #34d399, #059669)';
                btn.innerHTML = `
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Berhasil!</span>
                `;
                setTimeout(function () {
                    window.location.href = REDIRECT;
                }, 1200);
            } else {
                showErr('cred-err');
                setInputError('username');
                setInputError('password');
                document.getElementById('password').value = '';
                document.getElementById('password').focus();
            }
        }, 1400);
    });

});