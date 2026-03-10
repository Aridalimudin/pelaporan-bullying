@extends('layouts.app')

@section('content')

<div class="decorative-circle" style="top: 5%; left: 5%; width: 250px; height: 250px; background: #10b981;"></div>
<div class="decorative-circle" style="bottom: 5%; right: 5%; width: 300px; height: 300px; background: #059669;"></div>

@include('components.navbar')

<main id="kontak" class="kontak-page relative px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">


        <div class="kontak-header animate-slide-up">
            <span class="kontak-badge">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Hubungi Kami
            </span>
            <h1 class="kontak-title">
                Ada yang ingin<br>
                <span class="gradient-text">kamu sampaikan?</span>
            </h1>
            <p class="kontak-sub">
                Kami siap mendengarkan. Hubungi langsung pihak sekolah atau kirim pesan melalui formulir di bawah ini.
            </p>
        </div>

        <div class="kontak-grid">

            <div class="kontak-info-col animate-slide-up" style="animation-delay:.1s">

                <div class="kinfo-card">
                    <div class="kinfo-header">
                        <div class="kinfo-logo">
                            <img src="{{ asset('images/logoSMK.png') }}" alt="Logo SMK"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                 style="width:56px;height:56px;object-fit:contain">
                            <div class="kinfo-logo-fallback" style="display:none">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="kinfo-school">SMK Muhammadiyah 3</p>
                            <p class="kinfo-school-sub">Kadungora, Garut</p>
                        </div>
                    </div>

                    <div class="kinfo-list">
                        <div class="kinfo-item">
                            <div class="kinfo-icon kinfo-green">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="kinfo-item-label">Alamat</p>
                                <p class="kinfo-item-val">Jl. Raya Kadungora No.1,<br>Kadungora, Kab. Garut, Jawa Barat</p>
                            </div>
                        </div>

                        <div class="kinfo-item">
                            <div class="kinfo-icon kinfo-blue">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="kinfo-item-label">Telepon</p>
                                <p class="kinfo-item-val">(0262) 123-4567</p>
                            </div>
                        </div>

                        <div class="kinfo-item">
                            <div class="kinfo-icon kinfo-amber">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="kinfo-item-label">Email</p>
                                <p class="kinfo-item-val">info@smkm3kadungora.sch.id</p>
                            </div>
                        </div>

                        <div class="kinfo-item">
                            <div class="kinfo-icon kinfo-green">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="kinfo-item-label">Jam Operasional</p>
                                <p class="kinfo-item-val">Senin – Jumat: 07.00 – 15.00<br>Sabtu: 07.00 – 12.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kbk-card">
                    <div class="kbk-avatar">BK</div>
                    <div class="kbk-info">
                        <p class="kbk-title">Guru Bimbingan Konseling</p>
                        <p class="kbk-name">Tersedia di sekolah</p>
                        <p class="kbk-desc">Ruang BK terbuka setiap hari sekolah. Konsultasi bersifat rahasia.</p>
                    </div>
                </div>

            </div>

            <div class="kontak-form-col animate-slide-up" style="animation-delay:.18s">
                <div class="kform-card">
                    <div class="kform-header">
                        <h2 class="kform-title">Kirim Pesan</h2>
                        <p class="kform-sub">Identitasmu terjaga kerahasiaannya.</p>
                    </div>

                    <form id="kontakForm" novalidate>
                        @csrf

                        <div class="kform-group">
                            <label class="kform-label" for="kNama">Nama <span class="kform-req">*</span></label>
                            <div class="kform-input-wrap">
                                <span class="kform-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </span>
                                <input class="kform-input" type="text" id="kNama"
                                    placeholder="Nama kamu" autocomplete="name">
                            </div>
                            <p class="kform-err hidden" id="err-nama">Nama wajib diisi.</p>
                        </div>

                        <div class="kform-group">
                            <label class="kform-label" for="kEmail">Email <span class="kform-req">*</span></label>
                            <div class="kform-input-wrap">
                                <span class="kform-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <input class="kform-input" type="email" id="kEmail"
                                    placeholder="emailkamu@example.com" autocomplete="email">
                            </div>
                            <p class="kform-err hidden" id="err-email">Email wajib diisi.</p>
                        </div>

                        <div class="kform-group">
                            <label class="kform-label" for="kPesan">Pesan <span class="kform-req">*</span></label>
                            <textarea class="kform-input kform-textarea" id="kPesan"
                                rows="4" placeholder="Ceritakan apa yang ingin kamu sampaikan..."></textarea>
                            <p class="kform-err hidden" id="err-pesan">Pesan wajib diisi.</p>
                        </div>

                        <label class="kform-anon-wrap" id="anonLabel">
                            <input type="checkbox" id="kAnonim">
                            <span class="kform-anon-box" id="anonBox"></span>
                            <span class="kform-anon-text">Kirim sebagai anonim <span class="kform-anon-hint">(nama tidak ditampilkan)</span></span>
                        </label>

                        <div class="kform-alert hidden" id="formAlert">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span id="alertText">Harap isi semua field yang wajib diisi.</span>
                        </div>

                        <button type="submit" class="kform-btn" id="kformSubmit">
                            <span class="kform-btn-text">Kirim Pesan</span>
                            <svg class="kform-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <span class="kform-spinner hidden"></span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

<div
    id="kontakSuccessModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="kontakModalTitle"
>
    <div
        id="kontakModalContent"
        class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all scale-95 opacity-0 duration-300"
    >
        <div class="pt-8 pb-6 px-6 text-center">
            <div class="kmodal-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 id="kontakModalTitle" class="kmodal-title">Pesan Terkirim!</h3>
            <p class="kmodal-sub">Terima kasih sudah menghubungi kami. Kami akan segera merespons pesanmu.</p>
            <div class="flex flex-col gap-2 mt-6">
                <button onclick="closeKontakModal()" class="kmodal-btn-primary">Tutup</button>
                <button onclick="resetKontakForm()" class="kmodal-btn-secondary">Kirim Pesan Lagi</button>
            </div>
        </div>
    </div>
</div>

@include('components.footer')

@push('scripts')
    <script src="{{ asset('js/contact-user-page.js') }}"></script>
@endpush

@endsection