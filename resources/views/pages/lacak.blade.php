@extends('layouts.app') @section('content')
@include('components.navbar')

<main class="tracking-page relative bg-pattern min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="tracking-header animate-fade-in">
            <div class="tracking-icon-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <h1>Pantau Laporan Anda</h1>
            <p>Masukkan kode unik untuk melihat perkembangan laporan bullying Anda.</p>
        </div>

        <div class="flex justify-center mt-10">
            <button onclick="lacakModule.openPopup()" class="btn-lacak-page">
                <span>Mulai Melacak</span>
                <svg class="arrow-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </button>
        </div>
    </div>
</main>

@include('components.modal-lacak')
@include('components.footer')

<link rel="stylesheet" href="{{ asset('css/lacak-page.css') }}">
<script src="{{ asset('js/lacak-page.js') }}"></script>
@endsection