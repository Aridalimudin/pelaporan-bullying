@extends('layouts.app-auth')

@section('content')

<div class="bg-scene">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>
<div class="bg-dots"></div>

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
                         style="width:80px;height:80px;object-fit:contain;filter:drop-shadow(0 4px 12px rgba(0,0,0,.2));"
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

                <h2 class="panel-title">Sistem Pelaporan<br>Bullying</h2>
                <p class="panel-desc">Portal khusus guru & admin untuk mengelola laporan siswa.</p>

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
                        Terpercaya
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
                <div class="welcome-eyebrow">Portal Admin</div>
                <h1 class="welcome-title">Selamat <em>Datang</em></h1>
                <p class="welcome-sub">Masuk untuk mengelola laporan bullying siswa.</p>

                <div class="hint-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Demo: username <strong>admin</strong> · password <strong>admin123</strong></span>
                </div>

                <form id="loginForm" novalidate>
                    <div class="form-group">
                        <label class="form-label" for="username">Username / Email</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input class="form-input" type="text" id="username"
                                placeholder="Masukkan username" autocomplete="username">
                        </div>
                        <p class="error-msg" id="username-err">Username wajib diisi.</p>
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
                            <input class="form-input" type="password" id="password"
                                placeholder="Masukkan password" autocomplete="current-password">
                            <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password">
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

                    <p class="error-msg" id="cred-err" style="margin-bottom:14px; font-size:.8rem;">
                        Username atau password salah.
                    </p>

                    <button type="submit" class="btn-masuk" id="btnMasuk">
                        <div class="spinner"></div>
                        <span class="btn-text">Masuk</span>
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    </main>

    @include('components.footer', ['type' => 'admin'])

</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/login-page.js') }}" data-redirect="{{ route('administrator.dashboard') }}"></script>
@endpush