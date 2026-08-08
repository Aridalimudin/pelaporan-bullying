@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report-user-page.css') }}">
    <style>
        /* ══════════════════════════════════
           INLINE LOGIN SECTION
        ══════════════════════════════════ */
        #inlineLoginSection {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transform: translateY(-16px);
            transition:
                max-height  0.5s cubic-bezier(0.4, 0, 0.2, 1),
                opacity     0.4s ease,
                transform   0.4s ease;
        }
        #inlineLoginSection.open {
            max-height: 600px;
            opacity: 1;
            transform: translateY(0);
        }

        .inline-login-card {
            background: #fff;
            border: 1.5px solid #d1fae5;
            border-radius: 16px;
            padding: 24px 22px 20px;
            margin-top: 14px;
            box-shadow: 0 4px 24px rgba(5,150,105,0.10);
        }
        .inline-login-card .login-title {
            font-size: 1rem;
            font-weight: 700;
            color: #064e3b;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .inline-login-card .login-title svg {
            color: #059669;
        }
        .login-field {
            margin-bottom: 14px;
        }
        .login-field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .login-field input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #111827;
            background: #f9fafb;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .login-field input:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5,150,105,0.12);
            background: #fff;
        }
        .login-field input.input-error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.10);
        }
        .login-field .pw-wrap {
            position: relative;
        }
        .login-field .pw-wrap input {
            padding-right: 42px;
        }
        .login-field .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            padding: 2px;
            transition: color 0.2s;
        }
        .login-field .pw-toggle:hover { color: #059669; }
        .login-error-msg {
            font-size: 0.78rem;
            color: #dc2626;
            margin-top: 5px;
            display: none;
        }
        .btn-masuk {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #059669, #047857);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(5,150,105,0.3);
            transition: all 0.25s;
            margin-top: 6px;
        }
        .btn-masuk:hover:not(:disabled) {
            background: linear-gradient(135deg, #047857, #065f46);
            box-shadow: 0 6px 18px rgba(5,150,105,0.4);
            transform: translateY(-1px);
        }
        .btn-masuk:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }
        .btn-masuk .spinner {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }
        .btn-masuk.loading .spinner   { display: block; }
        .btn-masuk.loading .btn-label { display: none; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ══════════════════════════════════
           LOGIN GATE
        ══════════════════════════════════ */
        .login-gate-compact {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1.5px solid #6ee7b7;
            border-radius: 14px;
            padding: 20px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .login-gate-compact .gate-icon {
            width: 46px; height: 46px; flex-shrink: 0;
            background: linear-gradient(135deg, #059669, #10b981);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 3px 10px rgba(5,150,105,0.3);
        }
        .login-gate-compact .gate-text { flex: 1; min-width: 160px; }
        .login-gate-compact .gate-text h4 { font-size: 0.92rem; font-weight: 700; color: #064e3b; margin-bottom: 3px; }
        .login-gate-compact .gate-text p  { font-size: 0.78rem; color: #065f46; }
        .btn-login-inline {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 20px;
            background: linear-gradient(135deg, #059669, #047857);
            color: #fff; font-size: 0.85rem; font-weight: 700;
            border-radius: 50px; border: none; cursor: pointer;
            box-shadow: 0 3px 12px rgba(5,150,105,0.35);
            transition: all 0.25s;
            flex-shrink: 0;
        }
        .btn-login-inline:hover {
            background: linear-gradient(135deg, #047857, #065f46);
            transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(5,150,105,0.4);
        }
        .btn-login-inline svg { transition: transform 0.2s; }
        .btn-login-inline:hover svg { transform: translateX(3px); }

        /* ══════════════════════════════════
           STUDENT LOGGED-IN CARD
        ══════════════════════════════════ */
        .student-card {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1.5px solid #6ee7b7;
            border-radius: 14px;
            padding: 14px 18px;
            flex-wrap: wrap;
        }
        .student-card-info { display: flex; align-items: center; gap: 12px; }
        .student-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, #059669, #047857);
            color: #fff; font-weight: 800; font-size: 1.1rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(5,150,105,0.3);
        }
        .student-name  { font-size: 0.92rem; font-weight: 700; color: #064e3b; }
        .student-meta  { font-size: 0.75rem; color: #065f46; margin-top: 2px; }
        .btn-logout {
            font-size: 0.75rem; color: #dc2626; font-weight: 600;
            background: none; border: none; cursor: pointer;
            padding: 4px 10px; border-radius: 6px;
            transition: background 0.2s;
        }
        .btn-logout:hover { background: #fee2e2; }

        /* ══════════════════════════════════
           FORM BODY — CURTAIN REVEAL
        ══════════════════════════════════ */
        #formBody {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transform: scaleY(0.85);
            transform-origin: top center;
            transition:
                max-height  0.7s cubic-bezier(0.22, 1, 0.36, 1),
                opacity     0.5s ease 0.1s,
                transform   0.5s cubic-bezier(0.22, 1, 0.36, 1) 0.05s;
        }
        #formBody.curtain-open {
            max-height: 9999px;
            opacity: 1;
            transform: scaleY(1);
        }

        /* ── Divider ── */
        .form-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
            margin: 4px 0 12px;
        }

        /* ── Reporter toggle ── */
        .reporter-toggle-wrap {
            display: flex; gap: 8px;
            background: #f3f4f6; border-radius: 12px; padding: 4px;
        }
        .reporter-toggle-btn {
            flex: 1; padding: 9px 12px; border-radius: 9px; border: none;
            font-size: 0.82rem; font-weight: 600; cursor: pointer;
            transition: all 0.25s;
            background: transparent; color: #6b7280;
        }
        .reporter-toggle-btn.active {
            background: #fff;
            color: #059669;
            box-shadow: 0 2px 8px rgba(0,0,0,0.09);
        }

        /* ── Ortu hint ── */
        .ortu-hint {
            background: #eff6ff; border: 1px solid #bfdbfe;
            border-radius: 10px; padding: 10px 14px;
            font-size: 0.8rem; color: #1e40af;
            display: flex; align-items: center; gap: 8px;
        }
    </style>
@endpush

@section('content')
<div class="decorative-circle" style="top: 5%; left: 5%; width: 250px; height: 250px; background: #10b981;"></div>
<div class="decorative-circle" style="bottom: 5%; right: 5%; width: 300px; height: 300px; background: #059669;"></div>

@include('components.navbar')

<main class="form-section relative px-4 sm:px-6 lg:px-8 bg-pattern">
    <div class="max-w-2xl mx-auto relative z-10">
        <div class="w-full delay-3 animate-slide-up">
            <div class="form-card">

                {{-- ── Header ── --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-emerald-50 rounded-2xl mb-4">
                        <svg class="w-7 h-7 text-primary-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
                        Formulir Pelaporan Bullying
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base">
                        Laporan anda akan ditangani secara cepat, rahasia, dan aman.
                    </p>
                </div>

                <form id="reportForm" class="space-y-5" novalidate enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="reporter_type"        name="reporter_type"  value="{{ $student ? 'siswa' : 'siswa' }}">
                    <input type="hidden" id="student_id"           name="student_id"     value="{{ $student ? $student->id : '' }}">
                    <input type="hidden" id="is_student_logged_in" value="{{ $student ? '1' : '0' }}">

                    {{-- ── Toggle ── --}}
                    <div class="reporter-toggle-wrap">
                        <button type="button" class="reporter-toggle-btn active" id="btnSiswa" onclick="handleReporterTypeSwitch('siswa')">
                            👤 Saya Siswa
                        </button>
                        <button type="button" class="reporter-toggle-btn" id="btnOrtu" onclick="handleReporterTypeSwitch('ortu')">
                            👨‍👩‍👧 Saya Orang Tua / Wali
                        </button>
                    </div>

                    {{-- ════════ AREA SISWA ════════ --}}
                    <div id="formSiswaFields">

                        @if($student)
                        {{-- ✅ SUDAH LOGIN — kartu profil --}}
                        <div class="student-card" id="studentCard">
                            <div class="student-card-info">
                                <div class="student-avatar" id="scAvatar">{{ strtoupper(substr($student->fullname, 0, 1)) }}</div>
                                <div>
                                    <div class="student-name" id="scName">{{ $student->fullname }}</div>
                                    <div class="student-meta" id="scMeta">NIS: {{ $student->nis }} &bull; {{ $student->grade }} {{ $student->major }}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-logout" onclick="logoutSiswa()">Keluar</button>
                        </div>
                        <input type="hidden" id="nisn"  name="nisn"  value="{{ $student->nis }}">
                        <div class="form-group" style="margin-top:14px;">
                            <label for="email" class="form-label">
                                <span class="text-gray-800 font-semibold text-sm">Email Aktif Siswa</span>
                                <span class="text-red-500 text-sm">*</span>
                            </label>
                            <input type="email" id="email" name="email"
                                class="form-input" value="{{ $student->email }}" placeholder="emailanda@example.com" required>
                            <p id="email-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                        </div>

                        @else
                        {{-- 🔐 BELUM LOGIN — gate + inline login --}}
                        <div class="login-gate-compact" id="loginGateArea">
                            <div class="gate-icon">
                                <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div class="gate-text">
                                <h4>Login Siswa Diperlukan</h4>
                                <p>Masuk dengan NIS &amp; Password untuk melaporkan sebagai siswa.</p>
                            </div>
                            <button type="button" class="btn-login-inline" id="btnShowLogin" onclick="showInlineLogin()">
                                Masuk
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>

                        {{-- ── Inline login form (tersembunyi, muncul saat klik Masuk) ── --}}
                        <div id="inlineLoginSection">
                            <div class="inline-login-card">
                                <div class="login-title">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Login Akun Siswa
                                </div>

                                <div class="login-field">
                                    <label for="loginNis">NIS (Nomor Induk Siswa)</label>
                                    <input type="text" id="loginNis" placeholder="Masukkan NIS Anda" inputmode="numeric" autocomplete="username">
                                    <p class="login-error-msg" id="loginNisError"></p>
                                </div>

                                <div class="login-field">
                                    <label for="loginPassword">Password</label>
                                    <div class="pw-wrap">
                                        <input type="password" id="loginPassword" placeholder="Masukkan password" autocomplete="current-password">
                                        <button type="button" class="pw-toggle" id="loginPwToggle" onclick="toggleLoginPw()" title="Tampilkan/Sembunyikan">
                                            <svg id="loginEyeIcon" width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="login-error-msg" id="loginPwError"></p>
                                </div>

                                <p class="login-error-msg" id="loginGlobalError" style="text-align:center; margin-bottom:8px;"></p>

                                <button type="button" class="btn-masuk" id="btnMasuk" onclick="submitInlineLogin()">
                                    <span class="spinner"></span>
                                    <span class="btn-label">Masuk &amp; Lanjutkan</span>
                                </button>
                            </div>
                        </div>

                        {{-- Student card (tersembunyi, muncul setelah login berhasil) --}}
                        <div class="student-card" id="studentCard" style="display:none; margin-top:14px;">
                            <div class="student-card-info">
                                <div class="student-avatar" id="scAvatar">?</div>
                                <div>
                                    <div class="student-name" id="scName">-</div>
                                    <div class="student-meta" id="scMeta">-</div>
                                </div>
                            </div>
                            <button type="button" class="btn-logout" onclick="logoutSiswa()">Keluar</button>
                        </div>

                        <input type="hidden" id="nisn"  name="nisn"  value="">
                        <div class="form-group" id="emailFieldSiswa" style="display:none; margin-top:14px;">
                            <label for="email" class="form-label">
                                <span class="text-gray-800 font-semibold text-sm">Email Aktif Siswa</span>
                                <span class="text-red-500 text-sm">*</span>
                            </label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="emailanda@example.com" required>
                            <p id="email-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                        </div>
                        @endif

                        <input type="hidden" id="student_id_field" name="student_id" value="{{ $student ? $student->id : '' }}">
                    </div>
                    {{-- AKHIR AREA SISWA --}}

                    {{-- ════════ AREA ORANG TUA ════════ --}}
                    <div id="formOrtu" class="hidden space-y-4">
                        <div class="ortu-hint">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Laporan orang tua/wali tidak memerlukan login. Isi data di bawah ini.
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label"><span class="text-gray-800 font-semibold text-sm">Nama Orang Tua / Wali</span><span class="text-red-500 text-sm">*</span></label>
                                <input type="text" id="reporter_name" name="reporter_name" class="form-input" placeholder="Nama lengkap Anda">
                                <p id="reporter_name-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><span class="text-gray-800 font-semibold text-sm">No. HP / WhatsApp</span><span class="text-red-500 text-sm">*</span></label>
                                <input type="tel" id="reporter_phone" name="reporter_phone" class="form-input" placeholder="08xxxxxxxxxx" inputmode="numeric">
                                <p id="reporter_phone-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group relative">
                                <label class="form-label"><span class="text-gray-800 font-semibold text-sm">Nama Anak</span><span class="text-red-500 text-sm">*</span></label>
                                <div class="relative">
                                    <input type="text" id="child_name" name="child_name" class="form-input" placeholder="Nama lengkap anak" autocomplete="off">
                                    <div id="child_name-dropdown" class="hidden absolute left-0 right-0 mt-1 max-h-60 overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-lg z-50"></div>
                                </div>
                                <p id="child_name-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><span class="text-gray-800 font-semibold text-sm">Kelas Anak</span><span class="text-red-500 text-sm">*</span></label>
                                <select id="child_grade" name="child_grade" class="form-input">
                                    <option value="" disabled selected>Pilih kelas</option>
                                </select>
                                <p id="child_grade-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label"><span class="text-gray-800 font-semibold text-sm">NIS / NISN Anak</span><span class="text-gray-500 text-xs font-normal ml-1">(Opsional)</span></label>
                                <input type="text" id="child_nisn" name="child_nisn" class="form-input" placeholder="NIS/NISN anak (jika tahu)" inputmode="numeric">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><span class="text-gray-800 font-semibold text-sm">Email</span><span class="text-gray-500 text-xs font-normal ml-1">(Opsional)</span></label>
                                <input type="email" id="email_ortu" name="email_ortu" class="form-input" placeholder="emailanda@example.com">
                            </div>
                        </div>
                    </div>
                    {{-- AKHIR AREA ORANG TUA --}}

                    {{-- ════════ FORM BODY — muncul dengan animasi curtain ════════ --}}
                    <div id="formBody" class="space-y-5">

                        <div class="form-divider"></div>

                        <div class="form-group">
                            <label for="deskripsi" class="form-label">
                                <span class="text-gray-800 font-semibold text-sm">Deskripsi Kejadian</span>
                                <span class="text-red-500 text-sm">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="5"
                                class="form-input resize-none"
                                placeholder="Ceritakan kejadian yang anda alami dengan detail..."
                                required minlength="20"></textarea>
                            <div class="flex justify-between items-center mt-1.5">
                                <p id="deskripsi-error" class="text-xs text-red-600 hidden"></p>
                                <p class="text-xs text-gray-500 ml-auto">Minimal 20 karakter</p>
                            </div>

                            <div id="violation-dropdown" class="hidden"
                                style="border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-top:6px;box-shadow:0 4px 16px rgba(0,0,0,.08);background:#fff;z-index:50;"></div>

                            <div id="violation-required-hint"
                                style="display:flex;align-items:center;gap:5px;margin-top:8px;font-size:.75rem;color:#d97706;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pilih minimal 1 jenis tindakan dari saran di atas untuk melanjutkan
                            </div>

                            <div id="violation_tags_wrap" style="display:none;margin-top:10px;">
                                <p style="font-size:.72rem;font-weight:600;color:#6b7280;margin-bottom:5px;">Tindakan dipilih:</p>
                                <div id="violation_tags" style="display:flex;flex-wrap:wrap;gap:6px;"></div>
                            </div>

                            <input type="hidden" id="violation_ids" name="violation_ids">
                            <p id="violation_ids-error" class="text-xs text-red-600 mt-1 hidden"></p>

                            @include('components.file-upload')

                            <div class="privacy-notice">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-primary-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">Privasi Terjamin</h4>
                                        <p class="text-xs text-gray-600 leading-relaxed">Laporan Anda akan ditangani secara rahasia. Data pribadi dilindungi sesuai kebijakan privasi sekolah.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn-submit w-full" id="submitBtn">
                                    <span>Kirim Laporan</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                    {{-- AKHIR FORM BODY --}}

                </form>
            </div>
        </div>
    </div>
</main>

@include('components.modal-success')
@include('components.modal-alert')
@include('components.footer')

<script src="{{ asset('js/report-user-page.js') }}"></script>
<script>
/* ════════════════════════════════════════════════
   CURTAIN REVEAL HELPER
════════════════════════════════════════════════ */
function curtainOpen() {
    var el = document.getElementById('formBody');
    if (!el) return;
    el.classList.add('curtain-open');
}
function curtainClose() {
    var el = document.getElementById('formBody');
    if (!el) return;
    el.classList.remove('curtain-open');
}

/* ════════════════════════════════════════════════
   INIT — tampilkan/sembunyikan form body saat load
════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
    var isLoggedIn = document.getElementById('is_student_logged_in')?.value === '1';
    if (isLoggedIn) {
        curtainOpen();
    }

    /* Enter key di inline login */
    ['loginNis','loginPassword'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); submitInlineLogin(); }
        });
    });
});

/* ════════════════════════════════════════════════
   INLINE LOGIN
════════════════════════════════════════════════ */
function showInlineLogin() {
    var section = document.getElementById('inlineLoginSection');
    var gate    = document.getElementById('loginGateArea');

    if (!section) return;

    /* Sembunyikan gate, buka login form */
    if (gate) gate.style.display = 'none';
    section.classList.add('open');

    /* Scroll halus ke login form */
    setTimeout(function () {
        section.scrollIntoView({ behavior: 'smooth', block: 'center' });
        var nisInput = document.getElementById('loginNis');
        if (nisInput) nisInput.focus();
    }, 100);
}

function toggleLoginPw() {
    var inp  = document.getElementById('loginPassword');
    var icon = document.getElementById('loginEyeIcon');
    if (!inp) return;
    var isText = inp.type === 'text';
    inp.type = isText ? 'password' : 'text';
    icon.innerHTML = isText
        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
}

function setLoginError(field, msg) {
    var el = document.getElementById(field);
    if (!el) return;
    el.textContent = msg;
    el.style.display = msg ? 'block' : 'none';
}

async function submitInlineLogin() {
    /* Reset errors */
    setLoginError('loginNisError', '');
    setLoginError('loginPwError', '');
    setLoginError('loginGlobalError', '');

    var nis = (document.getElementById('loginNis')?.value || '').trim();
    var pw  = (document.getElementById('loginPassword')?.value || '').trim();

    var valid = true;
    if (!nis) { setLoginError('loginNisError', 'NIS wajib diisi.'); document.getElementById('loginNis').classList.add('input-error'); valid = false; }
    else       { document.getElementById('loginNis').classList.remove('input-error'); }
    if (!pw)  { setLoginError('loginPwError', 'Password wajib diisi.'); document.getElementById('loginPassword').classList.add('input-error'); valid = false; }
    else       { document.getElementById('loginPassword').classList.remove('input-error'); }
    if (!valid) return;

    /* Loading state */
    var btn = document.getElementById('btnMasuk');
    btn.disabled = true;
    btn.classList.add('loading');

    try {
        var csrfToken = document.querySelector('input[name="_token"]')?.value
                     || document.querySelector('meta[name="csrf-token"]')?.content
                     || '';

        var res = await fetch("{{ route('api.siswa.login') }}", {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ _token: csrfToken, nis: nis, password: pw })
        });

        if (res.status === 419) {
            setLoginError('loginGlobalError', '⚠️ Sesi telah berakhir. Memuat ulang halaman...');
            setTimeout(function () { window.location.reload(); }, 1200);
            return;
        }

        var data = await res.json();

        if (data && (data.success === true || data.status === 'success')) {
            /* ✅ Login berhasil */
            if (data.csrf_token) {
                document.querySelectorAll('meta[name="csrf-token"]').forEach(function(el) { el.setAttribute('content', data.csrf_token); });
                document.querySelectorAll('input[name="_token"]').forEach(function(el) { el.value = data.csrf_token; });
            }
            onLoginSuccess(data.student);
        } else {
            var errMsg = data.message || 'NIS atau password salah. Coba lagi.';
            setLoginError('loginGlobalError', '❌ ' + errMsg);
            document.getElementById('loginNis').classList.add('input-error');
            document.getElementById('loginPassword').classList.add('input-error');
        }
    } catch (e) {
        console.error(e);
        setLoginError('loginGlobalError', '⚠️ Gagal terhubung ke server. Periksa koneksi Anda.');
    } finally {
        btn.disabled = false;
        btn.classList.remove('loading');
    }
}

function onLoginSuccess(student) {
    /* Update hidden fields */
    document.getElementById('is_student_logged_in').value = '1';
    document.getElementById('student_id').value = student.id || '';
    var nisnEl = document.getElementById('nisn');
    if (nisnEl) nisnEl.value = student.nis || '';
    var emailEl = document.getElementById('email');
    if (emailEl) emailEl.value = student.email || '';

    /* Sembunyikan login form */
    var loginSection = document.getElementById('inlineLoginSection');
    if (loginSection) {
        loginSection.classList.remove('open');
        setTimeout(function () { loginSection.style.display = 'none'; }, 400);
    }

    /* Tampilkan kartu profil siswa */
    var card   = document.getElementById('studentCard');
    var avatar = document.getElementById('scAvatar');
    var name   = document.getElementById('scName');
    var meta   = document.getElementById('scMeta');
    var emailF = document.getElementById('emailFieldSiswa');

    if (avatar) avatar.textContent = (student.fullname || '?').charAt(0).toUpperCase();
    if (name)   name.textContent = student.fullname || '-';
    if (meta)   meta.textContent = 'NIS: ' + (student.nis || '-') + ' • ' + (student.grade || '') + ' ' + (student.major || '');
    if (card) {
        card.style.display = 'flex';
        card.style.opacity = '0';
        card.style.transform = 'translateY(-10px)';
        card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        setTimeout(function () {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 50);
    }
    if (emailF) {
        emailF.style.display = 'block';
        emailF.style.opacity = '0';
        setTimeout(function () {
            emailF.style.opacity = '1';
            emailF.style.transition = 'opacity 0.4s ease';
        }, 200);
    }

    /* ✨ Curtain reveal form body */
    setTimeout(function () {
        curtainOpen();
        /* Scroll halus ke form body */
        setTimeout(function () {
            document.getElementById('formBody')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 300);
    }, 350);
}

/* ════════════════════════════════════════════════
   TOGGLE TIPE PELAPOR
════════════════════════════════════════════════ */
function handleReporterTypeSwitch(type) {
    var isLoggedIn = document.getElementById('is_student_logged_in')?.value === '1';

    if (type === 'siswa' && !isLoggedIn) {
        /* Pastikan login section muncul */
        setReporterType(type);
        showInlineLogin();
        return;
    }

    setReporterType(type);

    if (type === 'ortu' || isLoggedIn) {
        curtainOpen();
    } else {
        curtainClose();
    }
}

/* ════════════════════════════════════════════════
   LOGOUT SISWA
════════════════════════════════════════════════ */
function logoutSiswa() {
    if (typeof showCustomConfirm === 'function') {
        showCustomConfirm(
            'Konfirmasi Keluar',
            'Apakah Anda yakin ingin keluar dari akun siswa ini?',
            doLogoutSiswa,
            'Ya, Keluar',
            'danger'
        );
    } else {
        if (confirm('Apakah Anda yakin ingin keluar dari akun siswa ini?')) {
            doLogoutSiswa();
        }
    }
}

async function doLogoutSiswa() {
    try {
        var csrfToken = document.querySelector('input[name="_token"]')?.value
                     || document.querySelector('meta[name="csrf-token"]')?.content
                     || '';
        var res  = await fetch("{{ route('api.siswa.logout') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        var data = await res.json();
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            window.location.reload();
        }
    } catch (e) {
        window.location.reload();
    }
}
</script>
@endsection