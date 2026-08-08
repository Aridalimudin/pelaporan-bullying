@extends('layouts.app-auth')

@push('styles')
    <style>
        :root {
            --green-primary: #10b981;
            --green-dark:    #059669;
            --green-light:   #d1fae5;
        }

        body { background: #f0fdf4; }

        .bg-scene {
            position: fixed; inset: 0; pointer-events: none; overflow: hidden; z-index: 0;
        }
        .blob {
            position: absolute; border-radius: 50%; filter: blur(80px); opacity: .18;
        }
        .blob-1 { width: 500px; height: 500px; background: #10b981; top: -120px; left: -120px; }
        .blob-2 { width: 420px; height: 420px; background: #34d399; bottom: -100px; right: -80px; }
        .blob-3 { width: 280px; height: 280px; background: #6ee7b7; top: 40%; left: 55%; }

        .page { position: relative; z-index: 1; min-height: 100vh; display: flex; flex-direction: column; }

        .topbar {
            display: flex; align-items: center; gap: 12px;
            padding: 18px 32px;
        }
        .topbar-logo {
            width: 36px; height: 36px; border-radius: 10px;
            background: var(--green-primary);
            display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .topbar-logo img { width: 100%; height: 100%; object-fit: contain; padding: 4px; }
        .topbar-name { font-weight: 700; font-size: .95rem; color: #064e3b; letter-spacing: -.01em; }
        .topbar-sub  { font-size: .72rem; color: #6b7280; }

        .center {
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding: 32px 16px;
        }

        .card {
            display: flex; width: 100%; max-width: 860px;
            background: #fff; border-radius: 24px;
            box-shadow: 0 20px 60px rgba(16,185,129,.12), 0 4px 16px rgba(0,0,0,.06);
            overflow: hidden;
        }

        .panel-left {
            flex: 1; background: linear-gradient(145deg, #064e3b, #065f46, #047857);
            padding: 52px 40px; display: flex; flex-direction: column; justify-content: center;
            position: relative; overflow: hidden;
        }
        .panel-circle {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,.07);
        }
        .panel-circle-1 { width: 260px; height: 260px; top: -80px; right: -80px; }
        .panel-circle-2 { width: 180px; height: 180px; bottom: -60px; left: -40px; }

        .logo-ring {
            width: 90px; height: 90px; border-radius: 50%;
            background: rgba(255,255,255,.15);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px; backdrop-filter: blur(6px);
        }
        .logo-svg svg { width: 46px; height: 46px; color: white; }

        .panel-title {
            font-size: 1.7rem; font-weight: 800; color: #fff;
            line-height: 1.25; margin-bottom: 12px; letter-spacing: -.02em;
        }
        .panel-desc { font-size: .84rem; color: #a7f3d0; line-height: 1.6; margin-bottom: 28px; }

        .badge-row { display: flex; flex-wrap: wrap; gap: 8px; }
        .badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
            border-radius: 100px; padding: 5px 12px;
            font-size: .72rem; font-weight: 600; color: #d1fae5;
            backdrop-filter: blur(4px);
        }
        .badge svg { width: 12px; height: 12px; }

        .panel-right { flex: 1; padding: 52px 44px; display: flex; flex-direction: column; justify-content: center; }

        .welcome-eyebrow {
            display: inline-block; font-size: .72rem; font-weight: 700;
            letter-spacing: .08em; text-transform: uppercase;
            color: var(--green-primary); margin-bottom: 8px;
        }
        .welcome-title {
            font-size: 2rem; font-weight: 800; color: #111827;
            line-height: 1.2; margin-bottom: 8px; letter-spacing: -.03em;
        }
        .welcome-title em { font-style: normal; color: var(--green-primary); }
        .welcome-sub { font-size: .85rem; color: #6b7280; margin-bottom: 32px; line-height: 1.5; }

        .form-group { margin-bottom: 20px; }
        .form-label  { display: block; font-size: .78rem; font-weight: 600; color: #374151; margin-bottom: 7px; }
        .input-wrap  { position: relative; }
        .input-icon  {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; pointer-events: none;
        }
        .input-icon svg { width: 17px; height: 17px; }

        .form-input {
            width: 100%; padding: 11px 42px 11px 40px;
            border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: .88rem; color: #111827; outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: #f9fafb;
        }
        .form-input:focus {
            border-color: var(--green-primary);
            box-shadow: 0 0 0 3px rgba(16,185,129,.12);
            background: #fff;
        }
        .form-input.input-error { border-color: #ef4444; }

        .toggle-pw {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #9ca3af;
            display: flex; align-items: center;
        }
        .toggle-pw svg { width: 17px; height: 17px; }

        .error-msg { font-size: .74rem; color: #ef4444; margin-top: 5px; display: none; }

        .btn-masuk {
            width: 100%; padding: 13px 20px;
            background: linear-gradient(135deg, var(--green-primary), var(--green-dark));
            color: #fff; border: none; border-radius: 12px;
            font-size: .9rem; font-weight: 700; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: transform .15s, box-shadow .15s; position: relative;
            letter-spacing: -.01em; margin-top: 24px;
        }
        .btn-masuk:hover  { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(16,185,129,.35); }
        .btn-masuk:active { transform: none; }
        .btn-masuk:disabled { opacity: .7; cursor: not-allowed; transform: none; }

        .spinner {
            width: 16px; height: 16px;
            border: 2.5px solid rgba(255,255,255,.35);
            border-top-color: #fff; border-radius: 50%;
            animation: spin .7s linear infinite; display: none;
        }
        .btn-masuk.loading .spinner   { display: block; }
        .btn-masuk.loading .btn-text  { display: none; }
        .btn-masuk.loading .btn-icon  { display: none; }
        .btn-icon svg { width: 17px; height: 17px; }

        @keyframes spin { to { transform: rotate(360deg); } }

        .back-link {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: .78rem; color: #6b7280; text-decoration: none;
            margin-top: 16px; transition: color .15s;
        }
        .back-link:hover { color: var(--green-primary); }
        .back-link svg { width: 14px; height: 14px; }

        @media (max-width: 640px) {
            .panel-left { display: none; }
            .panel-right { padding: 40px 28px; }
            .welcome-title { font-size: 1.6rem; }
        }
    </style>
@endpush

@section('content')

<div class="bg-scene">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

<div class="page">
    <header class="topbar">
        <div class="topbar-logo">
            <img src="{{ asset('images/logoSMK.png') }}" alt="Logo SMK"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <svg style="display:none;width:18px;height:18px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
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
                    <img src="{{ asset('images/logoSMK.png') }}" alt="Logo SMK"
                         style="width:60px;height:60px;object-fit:contain;filter:drop-shadow(0 4px 12px rgba(0,0,0,.2));"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="logo-svg" style="display:none;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"
                                d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                </div>

                <h2 class="panel-title">Portal Pelaporan<br>Siswa</h2>
                <p class="panel-desc">Laporkan kejadian bullying dengan aman dan terpercaya. Identitas Anda dijaga kerahasiaannya.</p>

                <div class="badge-row">
                    <span class="badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Aman
                    </span>
                    <span class="badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Rahasia
                    </span>
                    <span class="badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Cepat
                    </span>
                </div>
            </div>

            <div class="panel-right">
                <div class="welcome-eyebrow">Login Siswa</div>
                <h1 class="welcome-title">Selamat <em>Datang</em></h1>
                <p class="welcome-sub">Masuk dengan NIS dan password yang diberikan oleh admin/guru Anda.</p>

                <form id="loginSiswaForm" novalidate autocomplete="off">
                    @csrf
                    <input type="text" name="fake_user" style="display:none" tabindex="-1" autocomplete="off">
                    <input type="password" name="fake_pass" style="display:none" tabindex="-1" autocomplete="off">

                    <div class="form-group">
                        <label class="form-label" for="nis">NIS (Nomor Induk Siswa)</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                            </span>
                            <input class="form-input" type="text" id="nis" name="nis"
                                placeholder="Masukkan NIS Anda" autocomplete="new-password"
                                inputmode="numeric">
                        </div>
                        <p class="error-msg" id="nis-err">NIS wajib diisi.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input class="form-input" type="password" id="password" name="password"
                                placeholder="Masukkan password" autocomplete="new-password">
                            <button type="button" class="toggle-pw" id="togglePw" aria-label="Tampilkan password">
                                <svg id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="error-msg" id="password-err">Password wajib diisi.</p>
                    </div>

                    <p class="error-msg" id="cred-err" style="margin-bottom:10px; font-size:.8rem;"></p>

                    <button type="submit" class="btn-masuk" id="btnMasukSiswa">
                        <div class="spinner"></div>
                        <span class="btn-text">Masuk</span>
                        <span class="btn-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </button>
                </form>

                <a href="{{ url('/lapor') }}" class="back-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke halaman lapor
                </a>
            </div>

        </div>
    </main>

    @include('components.footer', ['type' => 'admin'])
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/student-login-page.js') }}"
        data-login-url="{{ route('api.siswa.login') }}"
        data-csrf="{{ csrf_token() }}"
        data-redirect="{{ route('siswa.dashboard') }}">
    </script>
@endpush
