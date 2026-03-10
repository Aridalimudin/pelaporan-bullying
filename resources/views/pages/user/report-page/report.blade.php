@extends('layouts.app')

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

                <form id="reportForm" class="space-y-5" novalidate>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="nisn" class="form-label">
                                <span class="text-gray-800 font-semibold text-sm">NISN</span>
                                <span class="text-red-500 text-sm">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="nisn" 
                                name="nisn" 
                                class="form-input" 
                                placeholder="Nomor Induk Siswa Nasional"
                                required
                                pattern="[0-9]*"
                                maxlength="6"
                                inputmode="numeric"
                            >
                            <p id="nisn-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <span class="text-gray-800 font-semibold text-sm">Email</span>
                                <span class="text-red-500 text-sm">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                placeholder="emailanda@example.com"
                                required
                            >
                            <p id="email-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                        </div>
                    </div>

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
                            <p class="text-xs text-gray-500">Minimal 20 karakter</p>
                        </div>
                    </div>

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
                </form>
            </div>
            
        </div>
    </div>
</main>

@include('components.modal-success')
@include('components.footer')

<script src="{{ asset('js/report-user-page.js') }}"></script>
@endsection