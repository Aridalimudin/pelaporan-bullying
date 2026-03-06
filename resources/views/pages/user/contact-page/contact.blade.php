@extends('layouts.app')

@section('content')

<!-- Decorative Background Elements -->
<div class="decorative-circle" style="top: 5%; left: 5%; width: 250px; height: 250px; background: #10b981;"></div>
<div class="decorative-circle" style="bottom: 5%; right: 5%; width: 300px; height: 300px; background: #059669;"></div>

@include('components.navbar')

<main id="kontak" class="kontak-page relative px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
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

        <!-- Grid: Info + Form -->
        <div class="kontak-grid">

            <!-- Kiri: Info Kontak -->
            <div class="kontak-info-col animate-slide-up" style="animation-delay:.1s">

                <!-- Card Info -->
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

                <!-- Card BK -->
                <div class="kbk-card">
                    <div class="kbk-avatar">BK</div>
                    <div class="kbk-info">
                        <p class="kbk-title">Guru Bimbingan Konseling</p>
                        <p class="kbk-name">Tersedia di sekolah</p>
                        <p class="kbk-desc">Ruang BK terbuka setiap hari sekolah. Konsultasi bersifat rahasia.</p>
                    </div>
                </div>

            </div>

            <!-- Kanan: Form Pesan -->
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
                            <label class="kform-label" for="kKelas">Kelas <span class="kform-req">*</span></label>
                            <div class="kform-input-wrap">
                                <span class="kform-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </span>
                                <input class="kform-input" type="text" id="kKelas"
                                    placeholder="Contoh: X RPL-1">
                            </div>
                            <p class="kform-err hidden" id="err-kelas">Kelas wajib diisi.</p>
                        </div>

                        <div class="kform-group">
                            <label class="kform-label" for="kSubjek">Subjek</label>
                            <div class="kform-input-wrap">
                                <span class="kform-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </span>
                                <input class="kform-input" type="text" id="kSubjek"
                                    placeholder="Topik pesan">
                            </div>
                        </div>

                        <div class="kform-group">
                            <label class="kform-label" for="kPesan">Pesan <span class="kform-req">*</span></label>
                            <textarea class="kform-input kform-textarea" id="kPesan"
                                rows="4" placeholder="Ceritakan apa yang ingin kamu sampaikan..."></textarea>
                            <p class="kform-err hidden" id="err-pesan">Pesan wajib diisi.</p>
                        </div>

                        <!-- Checkbox anonim -->
                        <label class="kform-anon-wrap" id="anonLabel">
                            <input type="checkbox" id="kAnonim" onchange="toggleAnon(this)">
                            <span class="kform-anon-box" id="anonBox"></span>
                            <span class="kform-anon-text">Kirim sebagai anonim <span class="kform-anon-hint">(nama & kelas tidak ditampilkan)</span></span>
                        </label>

                        <!-- Alert error -->
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

                    <!-- Success State -->
                    <div class="kform-success hidden" id="formSuccess">
                        <div class="kform-success-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="kform-success-title">Pesan Terkirim!</h3>
                        <p class="kform-success-sub">Terima kasih sudah menghubungi kami. Kami akan segera merespons pesanmu.</p>
                        <button class="kform-success-btn" onclick="resetForm()">Kirim Pesan Lagi</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

@include('components.footer')

<style>
/* ── Fix scroll global ── */
html, body {
    height: auto !important;
    overflow: visible !important;
    overflow-y: auto !important;
}

/* ── Page layout ── */
.kontak-page {
    width: 100%;
    padding-top: 80px;
    padding-bottom: 80px;
}

/* ── Header ── */
.kontak-header {
    text-align: center;
    margin-bottom: 48px;
}
.kontak-badge {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 6px 16px; background: #ecfdf5; color: #065f46;
    border-radius: 99px; font-size: .75rem; font-weight: 700;
    margin-bottom: 16px; letter-spacing: .02em;
}
.kontak-badge svg { width: 15px; height: 15px; }
.kontak-title {
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    font-weight: 800; color: #111827; line-height: 1.2; margin-bottom: 12px;
}
.kontak-sub {
    font-size: .95rem; color: #6b7280; max-width: 480px; margin: 0 auto; line-height: 1.7;
}

/* ── Grid ── */
.kontak-grid {
    display: grid;
    grid-template-columns: 1fr 1.3fr;
    gap: 24px;
    align-items: start;
}
@media (max-width: 860px) { .kontak-grid { grid-template-columns: 1fr; } }

/* ── Info Col ── */
.kontak-info-col { display: flex; flex-direction: column; gap: 16px; }

.kinfo-card {
    background: white; border-radius: 20px;
    border: 1.5px solid #f3f4f6;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    overflow: hidden;
}
.kinfo-header {
    display: flex; align-items: center; gap: 14px;
    padding: 20px 22px 16px;
    background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
    border-bottom: 1px solid #d1fae5;
}
.kinfo-logo {
    width: 60px; height: 60px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.kinfo-logo-fallback {
    width: 56px; height: 56px; background: #dcfce7; border-radius: 14px;
    align-items: center; justify-content: center; color: #10b981;
}
.kinfo-logo-fallback svg { width: 30px; height: 30px; }
.kinfo-school { font-size: .95rem; font-weight: 800; color: #111827; }
.kinfo-school-sub { font-size: .75rem; color: #059669; font-weight: 600; }

.kinfo-list { padding: 10px 0; }
.kinfo-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 13px 22px; transition: background .15s;
}
.kinfo-item:hover { background: #fafafa; }
.kinfo-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;
}
.kinfo-icon svg { width: 17px; height: 17px; }
.kinfo-green { background: #ecfdf5; color: #10b981; }
.kinfo-blue  { background: #eff6ff; color: #3b82f6; }
.kinfo-amber { background: #fffbeb; color: #d97706; }
.kinfo-item-label { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #9ca3af; margin-bottom: 2px; }
.kinfo-item-val   { font-size: .83rem; color: #374151; font-weight: 500; line-height: 1.5; }

/* BK Card */
.kbk-card {
    background: linear-gradient(135deg, #059669, #047857);
    border-radius: 16px; padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: 0 6px 20px rgba(5,150,105,.25);
}
.kbk-avatar {
    width: 46px; height: 46px; border-radius: 50%;
    background: rgba(255,255,255,.2); border: 2px solid rgba(255,255,255,.3);
    color: white; font-weight: 800; font-size: .85rem;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.kbk-title  { font-size: .72rem; font-weight: 700; color: rgba(255,255,255,.75); text-transform: uppercase; letter-spacing: .06em; }
.kbk-name   { font-size: .9rem; font-weight: 800; color: white; margin: 2px 0; }
.kbk-desc   { font-size: .72rem; color: rgba(255,255,255,.7); line-height: 1.5; }

/* ── Form Col ── */
.kform-card {
    background: white; border-radius: 20px;
    border: 1.5px solid #f3f4f6;
    box-shadow: 0 4px 24px rgba(0,0,0,.07);
    overflow: hidden;
}
.kform-header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid #f9fafb;
    background: linear-gradient(135deg, #f9fafb, #f0fdf4);
}
.kform-title { font-size: 1.05rem; font-weight: 800; color: #111827; }
.kform-sub   { font-size: .75rem; color: #9ca3af; margin-top: 3px; }

form#kontakForm { padding: 20px 24px; display: flex; flex-direction: column; gap: 14px; }

.kform-group { display: flex; flex-direction: column; gap: 5px; }
.kform-label { font-size: .78rem; font-weight: 700; color: #374151; }
.kform-req   { color: #ef4444; }
.kform-input-wrap { position: relative; }
.kform-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    display: flex; align-items: center; pointer-events: none;
}
.kform-icon svg { width: 16px; height: 16px; color: #9ca3af; transition: color .2s; }
.kform-input {
    width: 100%; padding: 10px 12px 10px 38px;
    border: 1.5px solid #e5e7eb; border-radius: 10px;
    font-family: inherit; font-size: .85rem; color: #111827;
    background: #f9fafb; outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
}
.kform-input:focus {
    border-color: #10b981; background: white;
    box-shadow: 0 0 0 3px rgba(16,185,129,.1);
}
.kform-input:focus ~ .kform-icon svg,
.kform-input-wrap:focus-within .kform-icon svg { color: #10b981; }
.kform-input.error { border-color: #ef4444; background: #fef2f2; }
.kform-textarea {
    padding: 10px 12px; resize: vertical; min-height: 100px;
}
.kform-err { font-size: .72rem; color: #ef4444; }
.kform-err.hidden { display: none; }

/* Anon checkbox */
.kform-anon-wrap {
    display: flex; align-items: center; gap: 10px; cursor: pointer;
    padding: 10px 14px; background: #f9fafb; border-radius: 10px;
    border: 1.5px solid #f3f4f6; transition: border-color .2s;
}
.kform-anon-wrap:hover { border-color: #d1fae5; background: #f0fdf4; }
.kform-anon-wrap input { display: none; }
.kform-anon-box {
    width: 18px; height: 18px; border-radius: 5px;
    border: 1.5px solid #d1d5db; background: white; flex-shrink: 0;
    transition: all .15s; display: flex; align-items: center; justify-content: center;
}
.kform-anon-wrap input:checked + .kform-anon-box {
    background: #10b981; border-color: #10b981;
}
.kform-anon-wrap input:checked + .kform-anon-box::after {
    content: '✓'; color: white; font-size: 11px; font-weight: 700;
}
.kform-anon-text { font-size: .8rem; font-weight: 600; color: #374151; }
.kform-anon-hint { font-size: .72rem; color: #9ca3af; font-weight: 400; }

/* Alert */
.kform-alert {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 14px; background: #fef2f2; border: 1px solid #fecaca;
    border-radius: 10px; font-size: .78rem; color: #dc2626;
}
.kform-alert svg { width: 16px; height: 16px; flex-shrink: 0; }
.kform-alert.hidden { display: none; }

/* Submit button */
.kform-btn {
    width: 100%; padding: 12px; border-radius: 12px; border: none; cursor: pointer;
    background: linear-gradient(135deg, #10b981, #047857);
    font-family: inherit; font-size: .9rem; font-weight: 700; color: white;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 6px 20px rgba(16,185,129,.3);
    transition: transform .15s, box-shadow .15s, opacity .15s;
}
.kform-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(16,185,129,.4); }
.kform-btn:active { transform: translateY(0); }
.kform-btn-icon { width: 18px; height: 18px; }
.kform-btn.loading { opacity: .8; pointer-events: none; }
.kform-spinner {
    width: 18px; height: 18px; border: 2px solid rgba(255,255,255,.4);
    border-top-color: white; border-radius: 50%; animation: spin .7s linear infinite;
}
.kform-btn.loading .kform-btn-text,
.kform-btn.loading .kform-btn-icon { display: none; }
.kform-btn.loading .kform-spinner { display: block; }
@keyframes spin { to { transform: rotate(360deg); } }

/* Success */
.kform-success {
    padding: 48px 24px; text-align: center;
}
.kform-success.hidden { display: none; }
.kform-success-icon {
    width: 64px; height: 64px; border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #047857);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    box-shadow: 0 8px 24px rgba(16,185,129,.3);
    animation: popIn .4s cubic-bezier(.16,1,.3,1) both;
}
.kform-success-icon svg { width: 28px; height: 28px; color: white; }
@keyframes popIn { from { opacity:0; transform:scale(.7); } to { opacity:1; transform:scale(1); } }
.kform-success-title { font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 6px; }
.kform-success-sub   { font-size: .82rem; color: #6b7280; line-height: 1.6; max-width: 280px; margin: 0 auto 20px; }
.kform-success-btn {
    padding: 9px 24px; border-radius: 10px; border: 1.5px solid #10b981;
    background: white; color: #059669; font-family: inherit; font-size: .83rem;
    font-weight: 700; cursor: pointer; transition: background .15s;
}
.kform-success-btn:hover { background: #f0fdf4; }
</style>

<script>
function toggleAnon(cb) {
    const nama  = document.getElementById('kNama');
    const kelas = document.getElementById('kKelas');
    if (cb.checked) {
        nama.disabled  = true; nama.placeholder  = '— Anonim —'; nama.value = '';
        kelas.disabled = true; kelas.placeholder = '— Anonim —'; kelas.value = '';
        nama.classList.remove('error'); kelas.classList.remove('error');
        document.getElementById('err-nama').classList.add('hidden');
        document.getElementById('err-kelas').classList.add('hidden');
    } else {
        nama.disabled  = false; nama.placeholder  = 'Nama kamu';
        kelas.disabled = false; kelas.placeholder = 'Contoh: X RPL-1';
    }
}

document.getElementById('kontakForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const anonim = document.getElementById('kAnonim').checked;
    const nama   = document.getElementById('kNama').value.trim();
    const kelas  = document.getElementById('kKelas').value.trim();
    const pesan  = document.getElementById('kPesan').value.trim();
    const alert  = document.getElementById('formAlert');

    let valid = true;

    // Reset errors
    ['kNama','kKelas','kPesan'].forEach(id => {
        document.getElementById(id).classList.remove('error');
    });
    ['err-nama','err-kelas','err-pesan'].forEach(id => {
        document.getElementById(id).classList.add('hidden');
    });
    alert.classList.add('hidden');

    if (!anonim && !nama) {
        document.getElementById('kNama').classList.add('error');
        document.getElementById('err-nama').classList.remove('hidden');
        valid = false;
    }
    if (!anonim && !kelas) {
        document.getElementById('kKelas').classList.add('error');
        document.getElementById('err-kelas').classList.remove('hidden');
        valid = false;
    }
    if (!pesan) {
        document.getElementById('kPesan').classList.add('error');
        document.getElementById('err-pesan').classList.remove('hidden');
        valid = false;
    }

    if (!valid) {
        alert.classList.remove('hidden');
        return;
    }

    const btn = document.getElementById('kformSubmit');
    btn.classList.add('loading');

    /* Simulasi submit — ganti dengan fetch/axios ke route Laravel */
    setTimeout(function() {
        btn.classList.remove('loading');
        document.getElementById('kontakForm').classList.add('hidden');
        document.getElementById('formSuccess').classList.remove('hidden');
    }, 1400);
});

function resetForm() {
    document.getElementById('kontakForm').reset();
    document.getElementById('kontakForm').classList.remove('hidden');
    document.getElementById('formSuccess').classList.add('hidden');
    toggleAnon({ checked: false });
}
</script>

@endsection