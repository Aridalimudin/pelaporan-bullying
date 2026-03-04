<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sekolah Aman</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-primary: #10b981;
            --green-dark:    #059669;
            --green-deeper:  #047857;
            --green-light:   #d1fae5;
            --green-faint:   #f0fdf4;
            --gray-900:      #111827;
            --gray-700:      #374151;
            --gray-500:      #6b7280;
            --gray-300:      #d1d5db;
            --gray-100:      #f3f4f6;
            --white:         #ffffff;
            --shadow-card:   0 25px 60px rgba(16,185,129,.12), 0 8px 24px rgba(0,0,0,.08);
            --radius-card:   24px;
            --radius-input:  12px;
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--green-faint);
            overflow: hidden;
        }

        .bg-scene {
            position: fixed; inset: 0;
            background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 40%, #d1fae5 100%);
            z-index: 0;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .35;
            animation: drift 12s ease-in-out infinite alternate;
        }
        .blob-1 { width: 420px; height: 420px; background: #6ee7b7; top: -120px; left: -100px; animation-delay: 0s; }
        .blob-2 { width: 320px; height: 320px; background: #34d399; bottom: -80px; right: -60px; animation-delay: -4s; }
        .blob-3 { width: 200px; height: 200px; background: #10b981; top: 50%; left: 55%; animation-delay: -7s; }

        @keyframes drift {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(30px, 20px) scale(1.06); }
        }

        .bg-dots {
            position: fixed; inset: 0; z-index: 0;
            background-image: radial-gradient(circle, #10b98122 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .page {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            padding: 18px 40px;
            display: flex; align-items: center; gap: 10px;
            animation: slideDown .6s cubic-bezier(.16,1,.3,1) both;
        }
        .topbar-logo {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--green-primary), var(--green-darker, #065f46));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .topbar-logo svg { width: 18px; height: 18px; color: white; }
        .topbar-name { font-weight: 700; font-size: .95rem; color: var(--gray-900); }
        .topbar-sub  { font-size: .75rem; color: var(--gray-500); }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .center {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 860px;
            background: var(--white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            animation: popIn .7s cubic-bezier(.16,1,.3,1) .15s both;
        }

        @keyframes popIn {
            from { opacity: 0; transform: translateY(32px) scale(.97); }
            to   { opacity: 1; transform: translateY(0)  scale(1); }
        }

        .panel-left {
            background: linear-gradient(160deg, var(--green-primary) 0%, var(--green-deeper) 100%);
            padding: 52px 40px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            position: relative; overflow: hidden;
            text-align: center;
        }
        .panel-left::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1.5' fill='%23ffffff18'/%3E%3C/svg%3E");
            background-size: 30px 30px;
        }
        .panel-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.07);
        }
        .panel-circle-1 { width: 280px; height: 280px; top: -80px; right: -80px; }
        .panel-circle-2 { width: 180px; height: 180px; bottom: -50px; left: -50px; }

        .logo-ring {
            position: relative; z-index: 1;
            width: 130px; height: 130px;
            background: rgba(255,255,255,.15);
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,.25);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px;
            animation: pulse-ring 3s ease-in-out infinite;
        }
        @keyframes pulse-ring {
            0%,100% { box-shadow: 0 0 0 0 rgba(255,255,255,.25); }
            50%      { box-shadow: 0 0 0 14px rgba(255,255,255,.0); }
        }
        .logo-ring img {
            width: 96px; height: 96px; object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,.2));
        }

        .logo-fallback {
            width: 96px; height: 96px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-fallback svg { width: 64px; height: 64px; color: white; }

        .panel-title {
            position: relative; z-index: 1;
            font-family: 'Instrument Serif', serif;
            font-size: 1.65rem;
            color: white;
            line-height: 1.25;
            margin-bottom: 10px;
        }
        .panel-desc {
            position: relative; z-index: 1;
            font-size: .82rem;
            color: rgba(255,255,255,.75);
            line-height: 1.6;
            max-width: 200px;
        }

        .badge-row {
            position: relative; z-index: 1;
            display: flex; gap: 8px; margin-top: 28px;
            flex-wrap: wrap; justify-content: center;
        }
        .badge {
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            color: white;
            font-size: .7rem; font-weight: 600;
            padding: 5px 12px; border-radius: 99px;
            display: flex; align-items: center; gap: 5px;
            backdrop-filter: blur(4px);
        }
        .badge svg { width: 12px; height: 12px; }

        .panel-right {
            padding: 52px 44px;
            display: flex; flex-direction: column; justify-content: center;
        }

        .welcome-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--green-primary);
            margin-bottom: 6px;
        }
        .welcome-title {
            font-family: 'Instrument Serif', serif;
            font-size: 2rem;
            color: var(--gray-900);
            line-height: 1.15;
            margin-bottom: 6px;
        }
        .welcome-title em { color: var(--green-primary); font-style: italic; }
        .welcome-sub {
            font-size: .82rem;
            color: var(--gray-500);
            margin-bottom: 32px;
        }

        /* Form */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: .78rem; font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 7px;
        }
        .input-wrap {
            position: relative;
            display: flex; align-items: center;
        }
        .input-icon {
            position: absolute; left: 14px;
            display: flex; align-items: center;
            pointer-events: none;
        }
        .input-icon svg { width: 17px; height: 17px; color: var(--gray-500); transition: color .2s; }
        .form-input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid var(--gray-300);
            border-radius: var(--radius-input);
            font-family: inherit; font-size: .87rem;
            color: var(--gray-900);
            background: var(--gray-100);
            outline: none;
            transition: border-color .2s, background .2s, box-shadow .2s;
        }
        .form-input::placeholder { color: #9ca3af; }
        .form-input:focus {
            border-color: var(--green-primary);
            background: var(--white);
            box-shadow: 0 0 0 3.5px rgba(16,185,129,.12);
        }
        .form-input:focus + .focus-line,
        .input-wrap:focus-within .input-icon svg { color: var(--green-primary); }

        .toggle-pw {
            position: absolute; right: 14px;
            background: none; border: none; cursor: pointer;
            padding: 4px; color: var(--gray-500);
            display: flex; align-items: center;
            transition: color .2s;
        }
        .toggle-pw:hover { color: var(--green-primary); }
        .toggle-pw svg { width: 17px; height: 17px; }

        .error-msg {
            display: none;
            margin-top: 6px;
            font-size: .75rem; color: #ef4444;
            animation: shake .45s cubic-bezier(.36,.07,.19,.97) both;
        }
        .error-msg.show { display: block; }
        @keyframes shake {
            10%,90%  { transform: translateX(-3px); }
            20%,80%  { transform: translateX(4px); }
            30%,50%,70% { transform: translateX(-5px); }
            40%,60%  { transform: translateX(5px); }
        }
        .form-input.error { border-color: #ef4444; background: #fef2f2; }

        .hint-box {
            background: var(--green-faint);
            border: 1px solid var(--green-light);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .75rem;
            color: var(--gray-700);
            margin-bottom: 22px;
            display: flex; align-items: flex-start; gap: 8px;
        }
        .hint-box svg { width: 15px; height: 15px; color: var(--green-primary); flex-shrink: 0; margin-top: 1px; }

        .btn-masuk {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--green-primary), var(--green-deeper));
            color: white;
            font-family: inherit; font-size: .9rem; font-weight: 700;
            border: none; border-radius: var(--radius-input);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 6px 20px rgba(16,185,129,.35);
            transition: transform .15s, box-shadow .15s, opacity .15s;
            position: relative; overflow: hidden;
        }
        .btn-masuk::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.15), transparent);
            opacity: 0; transition: opacity .2s;
        }
        .btn-masuk:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(16,185,129,.4); }
        .btn-masuk:hover::after { opacity: 1; }
        .btn-masuk:active { transform: translateY(0); }
        .btn-masuk svg { width: 18px; height: 18px; transition: transform .2s; }
        .btn-masuk:hover svg { transform: translateX(3px); }

        .btn-masuk.loading { opacity: .8; pointer-events: none; }
        .spinner { display: none; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,.4); border-top-color: white; border-radius: 50%; animation: spin .7s linear infinite; }
        .btn-masuk.loading .btn-text, .btn-masuk.loading .btn-icon { display: none; }
        .btn-masuk.loading .spinner { display: block; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .page-footer {
            padding: 16px; text-align: center;
            font-size: .73rem; color: var(--gray-500);
            animation: slideDown .6s cubic-bezier(.16,1,.3,1) .3s both;
        }
        .page-footer strong { color: var(--gray-700); }

        @media (max-width: 640px) {
            body { overflow: auto; }
            .card { grid-template-columns: 1fr; max-width: 400px; }
            .panel-left { padding: 36px 28px; }
            .logo-ring { width: 90px; height: 90px; }
            .logo-ring img, .logo-fallback { width: 66px; height: 66px; }
            .panel-title { font-size: 1.3rem; }
            .panel-right { padding: 36px 28px; }
        }
    </style>
</head>
<body>

<div class="bg-scene">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>
<div class="bg-dots"></div>

<div class="page">

    <header class="topbar">
        <div class="topbar-logo">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <div>
            <div class="topbar-name">Sekolah Aman</div>
            <div class="topbar-sub">SMK Muhammadiyah 3</div>
        </div>
    </header>

    <main class="center">
        <div class="card">

            <div class="panel-left">
                <div class="panel-circle panel-circle-1"></div>
                <div class="panel-circle panel-circle-2"></div>

                <div class="logo-ring">
                    <!-- Ganti src dengan {{ asset('images/logoSMK.png') }} di Laravel -->
                    <div class="logo-fallback">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                        </svg>
                    </div>
                </div>

                <h2 class="panel-title">Sistem Pelaporan<br>Bullying</h2>
                <p class="panel-desc">Portal khusus guru & admin untuk mengelola laporan siswa.</p>

                <div class="badge-row">
                    <span class="badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Aman
                    </span>
                    <span class="badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Terpercaya
                    </span>
                    <span class="badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Cepat
                    </span>
                </div>
            </div>

            <div class="panel-right">
                <div class="welcome-eyebrow">Portal Admin</div>
                <h1 class="welcome-title">Selamat <em>Datang</em></h1>
                <p class="welcome-sub">Masuk untuk mengelola laporan bullying siswa.</p>

                <div class="hint-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Demo: username <strong>admin</strong> · password <strong>admin123</strong></span>
                </div>

                <form id="loginForm" novalidate>
                    <div class="form-group">
                        <label class="form-label" for="username">Username / Email</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input class="form-input" type="text" id="username" placeholder="Masukkan username" autocomplete="username">
                        </div>
                        <p class="error-msg" id="username-err">Username wajib diisi.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input class="form-input" type="password" id="password" placeholder="Masukkan password" autocomplete="current-password">
                            <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password">
                                <svg id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="error-msg" id="password-err">Password wajib diisi.</p>
                    </div>

                    <p class="error-msg" id="cred-err" style="margin-bottom:14px; font-size:.8rem;">Username atau password salah.</p>

                    <button type="submit" class="btn-masuk" id="btnMasuk">
                        <div class="spinner"></div>
                        <span class="btn-text">Masuk</span>
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    </main>

    <footer class="page-footer">
        <strong>SMK Muhammadiyah 3 Kadungora</strong> · Bersama Sekolah Aman. Semua Hak Terlindungi.
    </footer>

</div>

<script>
    const DUMMY = { username: 'admin', password: 'admin123' };
    const REDIRECT = '/dashboard';

    const toggleBtn = document.getElementById('togglePw');
    const pwInput   = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');

    const eyeOpen  = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    const eyeClosed = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;

    toggleBtn.addEventListener('click', () => {
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
    function hideErr(id) { document.getElementById(id).classList.remove('show'); }
    function setInputError(id)    { document.getElementById(id).classList.add('error'); }
    function clearInputError(id)  { document.getElementById(id).classList.remove('error'); }

    ['username','password'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => {
            clearInputError(id);
            hideErr(id + '-err');
            hideErr('cred-err');
        });
    });

    document.getElementById('loginForm').addEventListener('submit', function(e) {
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

        setTimeout(() => {
            btn.classList.remove('loading');

            if (user === DUMMY.username && pass === DUMMY.password) {
                btn.style.background = 'linear-gradient(135deg, #34d399, #059669)';
                btn.innerHTML = `<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>Berhasil!</span>`;

                setTimeout(() => {
                    window.location.href = "{{ route('administrator.incoming-report') }}"; 
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
</script>
</body>
</html>