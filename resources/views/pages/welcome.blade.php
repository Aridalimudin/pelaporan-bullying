@extends('layouts.app')

@section('content')
<!-- Decorative Background Elements -->
<div class="decorative-circle" style="top: 5%; left: 5%; width: 250px; height: 250px; background: #10b981;"></div>
<div class="decorative-circle" style="bottom: 5%; right: 5%; width: 300px; height: 300px; background: #059669;"></div>

<!-- Navigation Component -->
@include('components.navbar')

<!-- Hero Section - Full Screen -->
<main id="home" class="hero-section relative px-4 sm:px-6 lg:px-8 bg-pattern">
    <div class="max-w-7xl mx-auto h-full flex items-center">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center w-full">
            
            <!-- Left Content -->
            <div class="space-y-4 delay-3 animate-slide-up">
                <!-- Badge -->
                <div class="inline-block">
                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-800 rounded-full text-xs font-semibold inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Platform Pelaporan Bullying
                    </span>
                </div>

                <div class="py-1">
                    <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight">
                        <span class="text-gray-900 block mb-2">Berbagi cerita adalah</span>
                        <span class="gradient-text block">langkah awal</span>
                    </h1>
                </div>

                <p class="text-base sm:text-lg text-gray-600 leading-relaxed pt-1">
                    untuk mendapatkan perlindungan
                    <span class="font-bold text-primary-green">STOP BULLYING!</span>
                </p>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="{{ route('lapor.index') }}" class="btn-primary px-6 py-3 bg-gradient-to-r from-primary-green to-dark-green text-white rounded-xl font-semibold text-base shadow-xl flex items-center justify-center gap-2 group">
                        <span>Buat Laporan</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>

                    <a href="#kontak" class="px-6 py-3 bg-white text-gray-800 rounded-xl font-semibold text-base shadow-lg hover-lift flex items-center justify-center gap-2 border-2 border-gray-200">
                        <svg class="w-5 h-5 text-primary-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>Kontak</span>
                    </a>
                </div>

                <div class="stats-compact max-w-md">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Laporan Ditangani</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Kasus Terselesaikan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Siap Membantu</div>
                    </div>
                </div>
            </div>

            <div class="illustration-wrapper delay-4 animate-slide-up">
                <div class="relative animate-float">
                    <div class="illustration-card">
                        <div class="illustration-inner">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-full -mr-12 -mt-12 opacity-60"></div>
                            <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-br from-emerald-200 to-emerald-100 rounded-full -ml-10 -mb-10 opacity-40"></div>

                            <div class="relative z-10 p-4">
                                <img src="{{ asset('images/logoSMK.png') }}" alt="Logo SMK Muhammadiyah 3" class="w-48 h-48 lg:w-56 lg:h-56 object-contain mx-auto" style="filter: drop-shadow(0 10px 25px rgba(16, 185, 129, 0.15));">
                            </div>
                        </div>
                    </div>

                    <div class="floating-badge absolute -top-2 -left-2">
                        <div class="flex items-center gap-2">
                            <div class="floating-badge-icon">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Privacy</div>
                                <div class="font-bold text-gray-900 text-xs">Terjamin</div>
                            </div>
                        </div>
                    </div>

                    <div class="floating-badge absolute -bottom-2 -right-2">
                        <div class="flex items-center gap-2">
                            <div class="floating-badge-icon">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Response</div>
                                <div class="font-bold text-gray-900 text-xs">Cepat</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</main>

@include('components.footer')

@endsection