@extends('layouts.app') @section('content')
@include('components.navbar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/track-user-page.css') }}">
@endpush

<main class="tracking-page relative bg-pattern min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="tracking-header animate-fade-in">
            <div class="tracking-icon-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <h1>Pantau Laporan Anda</h1>
            <p>Masukkan kode unik untuk melihat perkembangan laporan bullying Anda.</p>
        </div>

        <div class="flex justify-center items-center gap-3 mt-10 flex-wrap">
            <button onclick="lacakModule.openPopup()" class="btn-lacak-page">
                <span>Mulai Melacak</span>
                <svg class="arrow-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </button>

            @if(Auth::guard('student')->check())
                <a href="{{ route('siswa.dashboard') }}" class="px-6 py-3.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border-2 border-emerald-300 rounded-xl font-bold text-sm shadow-md hover:scale-105 transition-all inline-flex items-center gap-2" style="text-decoration:none;">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>📊 Dashboard Saya</span>
                </a>
            @endif
        </div>
    </div>
</main>

@include('components.modal-lacak')
@include('components.footer')

@push('scripts')
    <script src="{{ asset('js/track-user-page.js') }}"></script>
@endpush

@endsection