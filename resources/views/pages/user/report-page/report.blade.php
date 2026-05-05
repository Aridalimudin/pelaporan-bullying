@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report-user-page.css') }}">
@endpush

@section('content')
<div class="decorative-circle" style="top: 5%; left: 5%; width: 250px; height: 250px; background: #10b981;"></div>
<div class="decorative-circle" style="bottom: 5%; right: 5%; width: 300px; height: 300px; background: #059669;"></div>

@include('components.navbar')

<main class="form-section relative px-4 sm:px-6 lg:px-8 bg-pattern">
    <div class="max-w-2xl mx-auto relative z-10">
        <div class="w-full delay-3 animate-slide-up">

            <div class="form-card">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-emerald-50 rounded-2xl mb-4">
                        <svg class="w-7 h-7 text-primary-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
                        Formulir Pelaporan Siswa
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base">
                        Laporan anda akan ditangani secara cepat dan aman.
                    </p>
                </div>

                <form id="reportForm" class="space-y-5" novalidate enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="reporter_type" name="reporter_type" value="siswa">
                    <div class="reporter-toggle-wrap">
                        <button type="button" class="reporter-toggle-btn active" id="btnSiswa" onclick="setReporterType('siswa')">
                            👤 Saya Siswa
                        </button>
                        <button type="button" class="reporter-toggle-btn" id="btnOrtu" onclick="setReporterType('ortu')">
                            👨‍👩‍👧 Saya Orang Tua / Wali
                        </button>
                    </div>

                    <input type="hidden" id="student_id" name="student_id" value="">

                    {{-- FORM SISWA --}}
                    <div id="formSiswaFields">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- NIS + tombol cari --}}
                            <div class="form-group">
                                <label for="nisn" class="form-label">
                                    <span class="text-gray-800 font-semibold text-sm">NIS</span>
                                    <span class="text-red-500 text-sm">*</span>
                                </label>
                                <div class="nisn-wrap">
                                    <input type="text" id="nisn" name="nisn"
                                        class="form-input nisn-input"
                                        placeholder="Nomor Induk Siswa"
                                        required pattern="[0-9]*" maxlength="6" inputmode="numeric">
                                    <button type="button" class="btn-cari-nisn" id="btnCariNisn"
                                        onclick="cariSiswa()" title="Cari siswa">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <p id="nisn-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                                <div id="student-info" class="student-found hidden">
                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-emerald-800" id="student-name">-</p>
                                        <p class="text-xs text-emerald-600" id="student-class">-</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <span class="text-gray-800 font-semibold text-sm">Email</span>
                                    <span class="text-red-500 text-sm">*</span>
                                </label>
                                <input type="email" id="email" name="email"
                                    class="form-input" placeholder="emailanda@example.com" required>
                                <p id="email-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                                <p id="email-hint" class="text-xs text-gray-400 mt-1 hidden">
                                    Email diisi otomatis dari data siswa. Ubah jika perlu.
                                </p>
                            </div>

                        </div>
                    </div>
                    {{-- AKHIR FORM SISWA --}}

                    {{-- FORM ORTU --}}
                    <div id="formOrtu" class="hidden space-y-4">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <span class="text-gray-800 font-semibold text-sm">Nama Orang Tua / Wali</span>
                                    <span class="text-red-500 text-sm">*</span>
                                </label>
                                <input type="text" id="reporter_name" name="reporter_name"
                                    class="form-input" placeholder="Nama lengkap Anda">
                                <p id="reporter_name-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <span class="text-gray-800 font-semibold text-sm">No. HP / WhatsApp</span>
                                    <span class="text-red-500 text-sm">*</span>
                                </label>
                                <input type="tel" id="reporter_phone" name="reporter_phone"
                                    class="form-input" placeholder="08xxxxxxxxxx" inputmode="numeric">
                                <p id="reporter_phone-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label">
                                    <span class="text-gray-800 font-semibold text-sm">Nama Anak</span>
                                    <span class="text-red-500 text-sm">*</span>
                                </label>
                                <input type="text" id="child_name" name="child_name"
                                    class="form-input" placeholder="Nama lengkap anak">
                                <p id="child_name-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <span class="text-gray-800 font-semibold text-sm">Kelas Anak</span>
                                    <span class="text-red-500 text-sm">*</span>
                                </label>
                                <select id="child_grade" name="child_grade" class="form-input">
                                    <option value="" disabled selected>Pilih kelas</option>
                                </select>
                                <p id="child_grade-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="text-gray-800 font-semibold text-sm">Email</span>
                                <span class="text-gray-500 text-xs font-normal ml-1">(Opsional)</span>
                            </label>
                            <input type="email" id="email_ortu" name="email_ortu"
                                class="form-input" placeholder="emailanda@example.com">
                        </div>

                    </div>
                    {{-- AKHIR FORM ORTU --}}

                    {{-- Deskripsi + Jenis Kejadian terintegrasi --}}
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">
                            <span class="text-gray-800 font-semibold text-sm">Deskripsi Kejadian</span>
                            <span class="text-red-500 text-sm">*</span>
                        </label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="5"
                            class="form-input resize-none"
                            placeholder="Ceritakan kejadian yang anda alami dengan detail..."
                            required
                            minlength="20"
                        ></textarea>
                        <div class="flex justify-between items-center mt-1.5">
                            <p id="deskripsi-error" class="text-xs text-red-600 hidden"></p>
                            <p class="text-xs text-gray-500 ml-auto">Minimal 20 karakter</p>
                        </div>

                        {{-- Dropdown suggestion --}}
                        <div id="violation-dropdown"
                            class="hidden"
                            style="border:1px solid #e5e7eb;border-radius:10px;
                                   overflow:hidden;margin-top:6px;
                                   box-shadow:0 4px 16px rgba(0,0,0,.08);
                                   background:#fff;z-index:50;">
                        </div>

                        {{-- Hint wajib pilih --}}
                        <div id="violation-required-hint"
                            style="display:flex;align-items:center;gap:5px;
                                   margin-top:8px;font-size:.75rem;color:#d97706;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pilih minimal 1 jenis tindakan dari saran di atas untuk melanjutkan
                        </div>

                        {{-- Tags terpilih --}}
                        <div id="violation_tags_wrap" style="display:none;margin-top:10px;">
                            <p style="font-size:.72rem;font-weight:600;color:#6b7280;margin-bottom:5px;">
                                Tindakan dipilih:
                            </p>
                            <div id="violation_tags" style="display:flex;flex-wrap:wrap;gap:6px;"></div>
                        </div>

                        <input type="hidden" id="violation_ids" name="violation_ids">
                        <p id="violation_ids-error" class="text-xs text-red-600 mt-1 hidden"></p>

                        @include('components.file-upload')

                        <div class="privacy-notice">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-primary-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1">Privasi Terjamin</h4>
                                    <p class="text-xs text-gray-600 leading-relaxed">
                                        Laporan Anda akan ditangani secara rahasia. Data pribadi dilindungi sesuai kebijakan privasi sekolah.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button
                                type="submit"
                                class="btn-submit w-full"
                                id="submitBtn"
                            >
                                <span>Kirim Laporan</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    {{-- AKHIR FORM GROUP DESKRIPSI --}}

                </form>
            </div>

        </div>
    </div>
</main>

@include('components.modal-success')

{{-- Modal: NIS tidak ditemukan --}}
<div id="modalNisnNotFound" class="modal-overlay hidden" onclick="closeNisnModal(event)">
    <div class="modal-box-sm">
        <div class="modal-icon-wrap" style="background:#fef2f2">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="modal-box-title">NIS Tidak Ditemukan</h3>
        <p class="modal-box-desc" id="nisnNotFoundMsg">NIS tidak ditemukan dalam database. Periksa kembali atau hubungi wali kelas Anda.</p>
        <button class="btn-modal-close" onclick="document.getElementById('modalNisnNotFound').classList.add('hidden')">
            Tutup
        </button>
    </div>
</div>

@include('components.footer')

<script src="{{ asset('js/report-user-page.js') }}"></script>
@endsection