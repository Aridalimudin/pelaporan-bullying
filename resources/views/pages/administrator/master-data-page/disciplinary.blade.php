@extends('layouts.app-admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
<link rel="stylesheet" href="{{ asset('css/master-admin-page.css') }}">

@include('components.sidebar-admin', ['activePage' => 'tindakan-disiplin'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Tindakan Disiplin',
        'breadcrumbs' => [['label' => 'Administrasi'], ['label' => 'Master Data'], ['label' => 'Tindakan Disiplin']],
    ])

    <main class="admin-main">

        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Tindakan Disiplin</h2>
                <p class="content-sub">Kelola jenis tindakan disiplin yang dapat diterapkan dalam penanganan kasus bullying.</p>
            </div>
            <div class="heading-actions">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari tindakan disiplin...">
                </div>
                <select class="filter-select" id="filterTingkat">
                    <option value="">Semua Tingkat</option>
                    <option value="Ringan">Ringan</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Berat">Berat</option>
                </select>
                <button class="td-btn-tambah" onclick="openKorbanPage()"
                    style="background:linear-gradient(135deg,#2563eb,#1d4ed8); margin-right:8px;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 
                            11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 
                            9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Kelola Tindakan Korban
                </button>
                <button class="td-btn-tambah" onclick="openTdModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Tindakan
                </button>
            </div>
        </div>

        <div class="td-stats-row animate-fade-in" style="animation-delay:.05s">
            <div class="td-stat-card">
                <div class="td-stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="td-stat-val" id="statTotal">0</span>
                    <span class="td-stat-lbl">Total Tindakan</span>
                </div>
            </div>
            <div class="td-stat-card">
                <div class="td-stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <span class="td-stat-val" id="statRingan">0</span>
                    <span class="td-stat-lbl">Ringan</span>
                </div>
            </div>
            <div class="td-stat-card">
                <div class="td-stat-icon" style="background:#fffbeb;color:#d97706">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <span class="td-stat-val" id="statSedang">0</span>
                    <span class="td-stat-lbl">Sedang</span>
                </div>
            </div>
            <div class="td-stat-card">
                <div class="td-stat-icon" style="background:#fef2f2;color:#dc2626">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div>
                    <span class="td-stat-val" id="statBerat">0</span>
                    <span class="td-stat-lbl">Berat</span>
                </div>
            </div>
        </div>

        <div id="tdContent" class="animate-fade-in" style="animation-delay:.1s"></div>

        <div class="no-results hidden" id="noResults" style="margin-top:40px">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>Tidak ada tindakan disiplin ditemukan</p>
        </div>

    </main>
    @include('components.footer', ['type' => 'admin'])
    @include('components.toast')
</div>

{{-- Modal Tambah/Edit --}}
<div class="td-overlay" id="modalTd" style="display:none">
    <div class="td-panel">
        <div class="td-modal-header">
            <div class="td-modal-header-left">
                <div class="td-modal-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                </div>
                <div>
                    <p class="td-modal-sub">Master Data</p>
                    <h3 class="td-modal-title" id="tdModalTitle">Tambah Tindakan Disiplin</h3>
                </div>
            </div>
            <button class="td-modal-close" onclick="closeTdModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="td-modal-body">
            <div class="td-modal-grid2">
                <div class="td-field">
                    <label class="td-label">Nama Tindakan <span class="td-req">*</span></label>
                    <input class="td-input" type="text" id="tdNama" placeholder="Contoh: Teguran Lisan">
                    {{-- Pesan error muncul di sini secara dinamis --}}
                </div>
                <div class="td-field">
                    <label class="td-label">Tingkat <span class="td-req">*</span></label>
                    <select class="td-input" id="tdTingkat">
                        <option value="">Pilih Tingkat...</option>
                        <option value="Ringan">Ringan</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Berat">Berat</option>
                    </select>
                    {{-- Pesan error muncul di sini secara dinamis --}}
                </div>
            </div>
            <div class="td-modal-grid2">
                <div class="td-field">
                    <label class="td-label">Durasi / Waktu <span style="font-size:10.5px;color:#9ca3af;font-weight:500">(opsional)</span></label>
                    <input class="td-input" type="text" id="tdDurasi" placeholder="Contoh: 1 hari, 1 minggu">
                </div>
                <div class="td-field">
                    <label class="td-label">Pelaksana</label>
                    <select class="td-input" id="tdPelaksana">
                        <option value="Guru BK">Guru BK</option>
                        <option value="Kesiswaan">Kesiswaan</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                        <option value="Wali Kelas">Wali Kelas</option>
                    </select>
                </div>
            </div>
            <div class="td-field">
                <label class="td-label">Deskripsi Tindakan <span style="font-size:10.5px;color:#9ca3af;font-weight:500">(opsional)</span></label>
                <textarea class="td-input" id="tdDeskripsi" rows="3" placeholder="Jelaskan prosedur dan mekanisme tindakan disiplin ini..." style="resize:vertical"></textarea>
            </div>
            <div class="td-field">
                <label class="td-label">Kondisi Penerapan <span style="font-size:10.5px;color:#9ca3af;font-weight:500">(opsional)</span></label>
                <textarea class="td-input" id="tdKondisi" rows="2" placeholder="Kondisi atau pelanggaran apa yang membutuhkan tindakan ini..." style="resize:vertical"></textarea>
            </div>
            <div class="td-field">
                <label class="td-label">Melibatkan Orang Tua?</label>
                <select class="td-input" id="tdOrtua">
                    <option value="tidak">Tidak</option>
                    <option value="ya">Ya</option>
                    <option value="opsional">Opsional</option>
                </select>
            </div>
        </div>
        <div class="td-modal-footer">
            <button class="td-btn-cancel" onclick="closeTdModal()">Batal</button>
            <button class="td-btn-save" id="tdBtnSave" onclick="saveTd()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="td-overlay" id="modalHapusTd" style="display:none">
    <div class="td-panel" style="max-width:380px">
        <div class="td-modal-header" style="background:linear-gradient(135deg,#ef4444,#b91c1c)">
            <div class="td-modal-header-left">
                <div class="td-modal-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div><p class="td-modal-sub">Konfirmasi</p><h3 class="td-modal-title">Hapus Tindakan?</h3></div>
            </div>
            <button class="td-modal-close" onclick="closeHapusTd()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="td-modal-body">
            <p style="font-size:13.5px;color:#374151;line-height:1.7">Tindakan disiplin <strong id="hapusTdNama">—</strong> akan dihapus permanen dari sistem.</p>
        </div>
        <div class="td-modal-footer">
            <button class="td-btn-cancel" onclick="closeHapusTd()">Batal</button>
            <button class="td-btn-hapus" id="btnDoHapusTd" onclick="doHapusTd()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<!-- Modal Kelola Tindakan Korban -->
<div class="td-overlay" id="modalKorban" style="display:none">
    <div class="td-panel" style="max-width:620px;">
        
        <!-- Header -->
        <div class="td-modal-header" 
            style="background:linear-gradient(135deg,#2563eb,#1d4ed8)">
            <div class="td-modal-header-left">
                <div class="td-modal-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 
                            11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 
                            12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 
                            9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <p class="td-modal-sub">Master Data</p>
                    <h3 class="td-modal-title">Kelola Tindakan untuk Korban</h3>
                </div>
            </div>
            <button class="td-modal-close" onclick="closeKorbanPage()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Body: daftar + form tambah -->
        <div class="td-modal-body" style="max-height:70vh;overflow-y:auto;">

            <!-- Tombol tambah baru -->
            <div style="display:flex;justify-content:flex-end;margin-bottom:12px;">
                <button type="button" onclick="openFormTambahKorban()"
                    id="btnShowFormKorban"
                    style="
                        display:flex;align-items:center;gap:6px;
                        padding:8px 16px;border-radius:9px;border:none;
                        background:#2563eb;color:white;font-family:inherit;
                        font-size:.82rem;font-weight:700;cursor:pointer;
                    ">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                        width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Tindakan Korban
                </button>
            </div>

            <!-- Form tambah/edit (accordion, tersembunyi default) -->
            <div id="formKorban" style="display:none;margin-bottom:14px;
                background:#eff6ff;border:1.5px solid #bfdbfe;
                border-radius:12px;padding:14px;">
                
                <div style="font-size:.65rem;font-weight:800;letter-spacing:.1em;
                    color:#1e40af;margin-bottom:12px;" id="formKorbanTitle">
                    ＋ TAMBAH TINDAKAN KORBAN
                </div>

                <div class="td-field" style="margin-bottom:10px;">
                    <label class="td-label">
                        Nama Tindakan <span class="td-req">*</span>
                    </label>
                    <input class="td-input" type="text" id="korbanNama"
                        placeholder="cth: Konseling Korban, Pendampingan Psikolog...">
                </div>

                <div class="td-field" style="margin-bottom:10px;">
                    <label class="td-label">
                        Deskripsi 
                        <span style="font-size:10.5px;color:#9ca3af;font-weight:500">
                            (opsional)
                        </span>
                    </label>
                    <textarea class="td-input" id="korbanDeskripsi" rows="2"
                        placeholder="Jelaskan tindakan penanganan untuk korban ini..."
                        style="resize:vertical"></textarea>
                </div>

                <div class="td-field" style="margin-bottom:12px;">
                    <label class="td-label">
                        Catatan Pelaksanaan
                        <span style="font-size:10.5px;color:#9ca3af;font-weight:500">
                            (opsional)
                        </span>
                    </label>
                    <input class="td-input" type="text" id="korbanCatatan"
                        placeholder="cth: Dilaksanakan oleh Guru BK, 3 sesi...">
                </div>

                <div style="display:flex;gap:8px;justify-content:flex-end;">
                    <button type="button" onclick="closeFormKorban()"
                        style="padding:8px 16px;border-radius:8px;
                        border:1.5px solid #d1d5db;background:white;
                        font-family:inherit;font-size:.82rem;font-weight:600;
                        color:#374151;cursor:pointer;">
                        Batal
                    </button>
                    <button type="button" onclick="saveKorbanAction()"
                        id="btnSaveKorban"
                        style="padding:8px 16px;border-radius:8px;border:none;
                        background:#2563eb;color:white;font-family:inherit;
                        font-size:.82rem;font-weight:700;cursor:pointer;
                        display:flex;align-items:center;gap:6px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                            width="13" height="13">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span id="btnSaveKorbanLabel">Simpan</span>
                    </button>
                </div>
            </div>

            <!-- Daftar tindakan korban -->
            <div id="listKorbanActions">
                <!-- diisi oleh renderKorbanList() -->
            </div>

        </div>

        <div class="td-modal-footer">
            <button class="td-btn-cancel" onclick="closeKorbanPage()">Tutup</button>
        </div>
    </div>
</div>

<style>
.btn-loading{opacity:.6;pointer-events:none;cursor:not-allowed}

/* ── Validasi Inline — sama persis dengan halaman Data Siswa & Jenis Pelanggaran ── */
.sm-input-error {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239,68,68,.12) !important;
    background: #fff8f8 !important;
}
.sm-field-error {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    color: #dc2626;
    margin-top: 4px;
    animation: errSlideIn .2s ease both;
}
.sm-field-error::before {
    content: '';
    display: inline-block;
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23dc2626' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-size: contain;
}
@keyframes errSlideIn {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}
.td-req { color: #ef4444; }
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
/* ─────────────────────────────────────────
   MODAL OVERLAY HELPERS
   (Inlined to decouple from master-admin-page.js)
───────────────────────────────────────── */
function mdOpenOverlay(id) {
    var el = document.getElementById(id);
    if (el) {
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function mdCloseOverlay(id) {
    var el = document.getElementById(id);
    if (el) {
        el.style.display = 'none';
        document.body.style.overflow = '';
    }
}

/* ─────────────────────────────────────────
   API ENDPOINTS
   ───────────────────────────────────────── */
var API_TD_LIST   = '{{ route("discipline-actions.api.list") }}';
var API_TD_SAVE   = '{{ route("discipline-actions.api.save") }}';
var API_TD_DELETE = '{{ route("discipline-actions.api.delete", ":id") }}'.replace('/:id', '');

var API_KORBAN_LIST   = '{{ route("korban-actions.index") }}';
var API_KORBAN_SAVE   = '{{ route("korban-actions.store") }}';
var API_KORBAN_DELETE = '{{ route("korban-actions.index") }}';

/* ─────────────────────────────────────────
   CSRF TOKEN
───────────────────────────────────────── */
var CSRF_TOKEN_TD = document.querySelector('meta[name="csrf-token"]')
    ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

/* ─────────────────────────────────────────
   FETCH HELPER
───────────────────────────────────────── */
async function apiFetchTd(url, options) {
    options = options || {};
    var headers = options.headers || {};
    headers['X-CSRF-TOKEN'] = CSRF_TOKEN_TD;
    headers['Accept']       = 'application/json';
    if (options.body && typeof options.body === 'object') {
        headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(options.body);
    }
    options.headers = headers;
    try {
        var res = await fetch(url, options);
        return await res.json();
    } catch (err) {
        console.error('[apiFetchTd]', url, err);
        return { status: 'error', message: 'Terjadi kesalahan jaringan.' };
    }
}

/* ─────────────────────────────────────────
   STATE
───────────────────────────────────────── */
var _tdAll     = [];
var _editTdId  = null;
var _hapusTdId = null;

var _korbanActions = [];
var _editKorbanId  = null;

var SVG_EDIT   = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>';
var SVG_DELETE = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
var SVG_CLOCK  = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
var SVG_USER   = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>';
var SVG_HOME   = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>';

/* ─────────────────────────────────────────
   VALIDASI INLINE — Tindakan Disiplin
   Wajib  : Nama Tindakan, Tingkat
   Opsional: Durasi, Deskripsi, Kondisi, Pelaksana, Ortu
───────────────────────────────────────── */
function tdSetError(fieldId, message) {
    var field = document.getElementById(fieldId);
    if (!field) return;
    field.classList.add('sm-input-error');

    var errId = fieldId + '_err';
    var errEl = document.getElementById(errId);
    if (!errEl) {
        errEl           = document.createElement('span');
        errEl.id        = errId;
        errEl.className = 'sm-field-error';
        field.parentNode.appendChild(errEl);
    }
    errEl.textContent   = message;
    errEl.style.display = 'flex';
}

function tdClearError(fieldId) {
    var field = document.getElementById(fieldId);
    if (field) field.classList.remove('sm-input-error');
    var errEl = document.getElementById(fieldId + '_err');
    if (errEl) errEl.style.display = 'none';
}

function tdClearAllErrors() {
    // Hanya field wajib yang perlu dibersihkan
    ['tdNama', 'tdTingkat'].forEach(function(id) { tdClearError(id); });
}

function tdValidateAll() {
    tdClearAllErrors();
    var valid = true;

    var nama    = (document.getElementById('tdNama').value    || '').trim();
    var tingkat = (document.getElementById('tdTingkat').value || '').trim();

    // ── Nama Tindakan: wajib, minimal 3 karakter ──
    if (!nama) {
        tdSetError('tdNama', 'Nama tindakan wajib diisi.');
        valid = false;
    } else if (nama.length < 3) {
        tdSetError('tdNama', 'Nama tindakan minimal 3 karakter.');
        valid = false;
    }

    // ── Tingkat: wajib dipilih ──
    if (!tingkat) {
        tdSetError('tdTingkat', 'Tingkat wajib dipilih.');
        valid = false;
    }

    return valid;
}

/* ─────────────────────────────────────────
   LOAD FROM DB
───────────────────────────────────────── */
async function loadTd() {
    var res = await apiFetchTd(API_TD_LIST);
    _tdAll  = Array.isArray(res) ? res : [];
    renderContent();
}

/* ─────────────────────────────────────────
   RENDER
───────────────────────────────────────── */
function renderContent() {
    var q       = (document.getElementById('searchInput').value || '').toLowerCase();
    var tf      = document.getElementById('filterTingkat').value || '';
    var content = document.getElementById('tdContent');
    var noRes   = document.getElementById('noResults');

    var filtered = _tdAll.filter(function(d) {
        return (!q  || d.name.toLowerCase().indexOf(q) !== -1 || (d.description || '').toLowerCase().indexOf(q) !== -1) &&
               (!tf || d.level === tf);
    });

    if (!filtered.length) { content.innerHTML = ''; noRes.classList.remove('hidden'); updateStats(); return; }
    noRes.classList.add('hidden');

    var ORDER  = ['Ringan', 'Sedang', 'Berat'];
    var groups = {};
    filtered.forEach(function(d) {
        if (!groups[d.level]) groups[d.level] = [];
        groups[d.level].push(d);
    });

    content.innerHTML = ORDER.filter(function(t) { return groups[t]; }).map(function(tingkat) {
        var items = groups[tingkat];
        var cards = items.map(function(d, i) {
            var ortuClass = d.parent_involvement === 'ya' ? 'ya' : 'tidak';
            var ortuLabel = d.parent_involvement === 'ya' ? 'Wajib' : (d.parent_involvement === 'opsional' ? 'Opsional' : 'Tidak');
            var namaSafe  = (d.name || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'");
            var kondisiHtml = d.condition
                ? '<div class="jp-card-contoh" style="margin-top:8px"><strong>Kondisi Penerapan</strong>' + d.condition + '</div>'
                : '';
            return '<div class="td-card ' + d.level + '" style="animation-delay:' + (i * 0.05) + 's">' +
                '<div class="td-card-num ' + d.level + '">' + (i + 1) + '</div>' +
                '<div class="td-card-content">' +
                    '<div class="td-card-name">' + d.name + '</div>' +
                    '<p class="td-card-desc">' + (d.description || '<em style="color:#d1d5db">Tidak ada deskripsi</em>') + '</p>' +
                    '<div class="td-card-meta">' +
                        (d.duration ? '<span class="td-meta-chip">' + SVG_CLOCK + d.duration + '</span>' : '') +
                        '<span class="td-meta-chip">' + SVG_USER + (d.executor || '—') + '</span>' +
                        '<span class="td-meta-chip ortua-' + ortuClass + '">' + SVG_HOME + 'Ortu: ' + ortuLabel + '</span>' +
                    '</div>' +
                    kondisiHtml +
                '</div>' +
                '<div class="td-card-actions">' +
                    '<button class="btn-aksi edit" title="Edit" onclick="openTdModal(' + d.id + ')">' + SVG_EDIT + '</button>' +
                    '<button class="btn-aksi delete" title="Hapus" onclick="openHapusTd(' + d.id + ', \'' + namaSafe + '\')">' + SVG_DELETE + '</button>' +
                '</div>' +
            '</div>';
        }).join('');

        return '<div class="td-group">' +
            '<div class="td-group-header">' +
                '<span class="td-group-badge ' + tingkat + '">' + tingkat + '</span>' +
                '<div class="td-group-line"></div>' +
                '<span class="td-group-count">' + items.length + ' tindakan</span>' +
            '</div>' +
            '<div class="td-list">' + cards + '</div>' +
        '</div>';
    }).join('');

    updateStats();
}

function updateStats() {
    document.getElementById('statTotal').textContent = _tdAll.length;
    ['Ringan', 'Sedang', 'Berat'].forEach(function(t) {
        var el = document.getElementById('stat' + t);
        if (el) el.textContent = _tdAll.filter(function(d) { return d.level === t; }).length;
    });
}

/* ─────────────────────────────────────────
   MODAL TAMBAH / EDIT
───────────────────────────────────────── */
function openTdModal(id) {
    id = id || null;
    _editTdId = id;
    document.getElementById('tdModalTitle').textContent = id ? 'Edit Tindakan Disiplin' : 'Tambah Tindakan Disiplin';

    // Bersihkan semua error setiap kali modal dibuka
    tdClearAllErrors();

    if (id) {
        var d = _tdAll.find(function(x) { return x.id == id; });
        if (d) {
            document.getElementById('tdNama').value      = d.name;
            document.getElementById('tdTingkat').value   = d.level;
            document.getElementById('tdDurasi').value    = d.duration || '';
            document.getElementById('tdPelaksana').value = d.executor || 'Guru BK';
            document.getElementById('tdDeskripsi').value = d.description || '';
            document.getElementById('tdKondisi').value   = d.condition || '';
            document.getElementById('tdOrtua').value     = d.parent_involvement || 'tidak';
        }
    } else {
        ['tdNama', 'tdDurasi', 'tdDeskripsi', 'tdKondisi'].forEach(function(fid) {
            document.getElementById(fid).value = '';
        });
        document.getElementById('tdTingkat').value   = '';
        document.getElementById('tdPelaksana').value = 'Guru BK';
        document.getElementById('tdOrtua').value     = 'tidak';
    }
    mdOpenOverlay('modalTd');
}

function closeTdModal() {
    // Bersihkan error saat modal ditutup
    tdClearAllErrors();
    mdCloseOverlay('modalTd');
}

async function saveTd() {
    // Validasi client-side dulu — jika ada error, hentikan dan scroll ke field bermasalah
    if (!tdValidateAll()) {
        var firstErr = document.querySelector('.sm-input-error');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    var btn = document.getElementById('tdBtnSave');
    btn.classList.add('btn-loading');
    btn.textContent = 'Menyimpan...';

    var res = await apiFetchTd(API_TD_SAVE, {
        method : 'POST',
        body   : {
            id                 : _editTdId || null,
            name               : document.getElementById('tdNama').value.trim(),
            level              : document.getElementById('tdTingkat').value,
            duration           : document.getElementById('tdDurasi').value.trim(),
            executor           : document.getElementById('tdPelaksana').value,
            description        : document.getElementById('tdDeskripsi').value.trim(),
            condition          : document.getElementById('tdKondisi').value.trim(),
            parent_involvement : document.getElementById('tdOrtua').value
        }
    });

    btn.classList.remove('btn-loading');
    btn.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Simpan';

    if (res.status === 'success') {
        closeTdModal();
        await loadTd();
        if (typeof Toast !== 'undefined') Toast.show('success', 'Berhasil', _editTdId ? 'Tindakan disiplin diperbarui.' : 'Tindakan disiplin ditambahkan.');
    } else {
        // Tampilkan error validasi dari server (Laravel) secara inline per field
        if (res.errors) {
            var fieldMap = { name: 'tdNama', level: 'tdTingkat' };
            Object.keys(res.errors).forEach(function(key) {
                var htmlId = fieldMap[key];
                if (htmlId) tdSetError(htmlId, res.errors[key][0]);
            });
            var firstErr = document.querySelector('.sm-input-error');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            alert(res.message || 'Gagal menyimpan.');
        }
    }
}

/* ─────────────────────────────────────────
   MODAL HAPUS
───────────────────────────────────────── */
function openHapusTd(id, nama) {
    _hapusTdId = id;
    document.getElementById('hapusTdNama').textContent = nama || id;
    mdOpenOverlay('modalHapusTd');
}

function closeHapusTd() { mdCloseOverlay('modalHapusTd'); }

async function doHapusTd() {
    if (!_hapusTdId) return;
    var btn = document.getElementById('btnDoHapusTd');
    btn.classList.add('btn-loading');
    btn.textContent = 'Menghapus...';

    var res = await apiFetchTd(API_TD_DELETE + '/' + _hapusTdId, { method: 'DELETE' });

    btn.classList.remove('btn-loading');
    btn.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Ya, Hapus';

    if (res.status === 'success') {
        closeHapusTd();
        await loadTd();
        if (typeof Toast !== 'undefined') Toast.show('success', 'Dihapus', 'Tindakan disiplin dihapus.');
    } else {
        alert(res.message || 'Gagal menghapus.');
    }
}

/* ─────────────────────────────────────────
   EVENT LISTENERS & INIT
───────────────────────────────────────── */
document.getElementById('searchInput').addEventListener('input', renderContent);
document.getElementById('filterTingkat').addEventListener('change', renderContent);
document.getElementById('modalTd').addEventListener('click', function(e) { if (e.target === this) closeTdModal(); });
document.getElementById('modalHapusTd').addEventListener('click', function(e) { if (e.target === this) closeHapusTd(); });

// Listener realtime: error hilang otomatis saat user mengetik / memilih
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tdNama').addEventListener('input', function() {
        tdClearError('tdNama');
    });
    document.getElementById('tdTingkat').addEventListener('change', function() {
        tdClearError('tdTingkat');
    });

    loadTd();
});

// Buka modal kelola korban
async function openKorbanPage() {
    await loadKorbanActions();
    mdOpenOverlay('modalKorban');
}

function closeKorbanPage() {
    closeFormKorban();
    mdCloseOverlay('modalKorban');
}

// Load data dari API
async function loadKorbanActions() {
    try {
        const res = await apiFetchTd(API_KORBAN_LIST);
        _korbanActions = Array.isArray(res) ? res : (res.data || []);
        renderKorbanList();
    } catch(e) {
        console.error('Gagal load tindakan korban', e);
    }
}

// Render daftar tindakan korban
function renderKorbanList() {
    const list = document.getElementById('listKorbanActions');
    if (!list) return;

    if (_korbanActions.length === 0) {
        list.innerHTML = `
            <div style="text-align:center;padding:32px 20px;color:#9ca3af;">
                <div style="font-size:2rem;margin-bottom:8px;">🛡️</div>
                <div style="font-size:.85rem;font-weight:600;">
                    Belum ada tindakan korban
                </div>
                <div style="font-size:.78rem;margin-top:4px;">
                    Klik "Tambah Tindakan Korban" untuk menambahkan
                </div>
            </div>`;
        return;
    }

    list.innerHTML = _korbanActions.map((item, i) => `
        <div style="
            display:flex;align-items:flex-start;justify-content:space-between;
            gap:12px;padding:12px 14px;
            background:${i % 2 === 0 ? '#f8fafc' : 'white'};
            border:1.5px solid #e5e7eb;border-radius:10px;margin-bottom:8px;
        ">
            <div style="flex:1;min-width:0;">
                <div style="font-weight:700;font-size:.88rem;color:#111827;
                    margin-bottom:4px;">
                    🛡️ ${item.name}
                </div>
                ${item.description ? `
                <div style="font-size:.78rem;color:#6b7280;
                    line-height:1.5;margin-bottom:3px;">
                    ${item.description}
                </div>` : ''}
                ${item.catatan ? `
                <div style="font-size:.74rem;color:#9ca3af;font-style:italic;">
                    📌 ${item.catatan}
                </div>` : ''}
            </div>
            <div style="display:flex;gap:6px;flex-shrink:0;">
                <button onclick="editKorbanAction(${item.id})"
                    style="width:32px;height:32px;border-radius:8px;border:none;
                    background:#eff6ff;color:#2563eb;cursor:pointer;
                    display:flex;align-items:center;justify-content:center;"
                    title="Edit">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                        width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 
                            002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 
                            112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
                <button onclick="hapusKorbanAction(${item.id}, '${(item.name||'').replace(/'/g,"\\'")}' )"
                    style="width:32px;height:32px;border-radius:8px;border:none;
                    background:#fef2f2;color:#dc2626;cursor:pointer;
                    display:flex;align-items:center;justify-content:center;"
                    title="Hapus">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                        width="14" height="14">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            stroke-width="2" d="M19 7l-.867 12.142A2 2 0 
                            0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 
                            4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 
                            1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        </div>
    `).join('');
}

// Buka form tambah
function openFormTambahKorban() {
    _editKorbanId = null;
    document.getElementById('korbanNama').value      = '';
    document.getElementById('korbanDeskripsi').value = '';
    document.getElementById('korbanCatatan').value   = '';
    document.getElementById('formKorbanTitle').textContent = '＋ TAMBAH TINDAKAN KORBAN';
    document.getElementById('btnSaveKorbanLabel').textContent = 'Simpan';
    document.getElementById('formKorban').style.display = '';
    document.getElementById('korbanNama').focus();
}

// Buka form edit
function editKorbanAction(id) {
    const item = _korbanActions.find(x => x.id == id);
    if (!item) return;
    _editKorbanId = id;
    document.getElementById('korbanNama').value      = item.name        || '';
    document.getElementById('korbanDeskripsi').value = item.description || '';
    document.getElementById('korbanCatatan').value   = item.catatan     || '';
    document.getElementById('formKorbanTitle').textContent = '✏️ EDIT TINDAKAN KORBAN';
    document.getElementById('btnSaveKorbanLabel').textContent = 'Update';
    document.getElementById('formKorban').style.display = '';
    document.getElementById('korbanNama').focus();
    document.getElementById('formKorban').scrollIntoView({ behavior:'smooth', block:'start' });
}

// Tutup form
function closeFormKorban() {
    _editKorbanId = null;
    document.getElementById('formKorban').style.display = 'none';
    document.getElementById('korbanNama').value      = '';
    document.getElementById('korbanDeskripsi').value = '';
    document.getElementById('korbanCatatan').value   = '';
}

// Simpan tindakan korban
async function saveKorbanAction() {
    const nama = document.getElementById('korbanNama')?.value?.trim();
    if (!nama) {
        document.getElementById('korbanNama').focus();
        if (typeof Toast !== 'undefined') {
            Toast.show('error', 'Validasi', 'Nama tindakan wajib diisi.');
        }
        return;
    }

    const btn = document.getElementById('btnSaveKorban');
    if (btn) { btn.style.opacity = '.6'; btn.style.pointerEvents = 'none'; }

    const payload = {
        id          : _editKorbanId || null,
        name        : nama,
        description : document.getElementById('korbanDeskripsi')?.value?.trim() || null,
        catatan     : document.getElementById('korbanCatatan')?.value?.trim()   || null,
    };

    const url    = _editKorbanId 
        ? API_KORBAN_SAVE + '/' + _editKorbanId 
        : API_KORBAN_SAVE;
    const method = _editKorbanId ? 'PUT' : 'POST';

    try {
        const res = await apiFetchTd(url, { method, body: payload });
        if (btn) { btn.style.opacity = ''; btn.style.pointerEvents = ''; }

        if (res.status === 'success' || res.id) {
            closeFormKorban();
            await loadKorbanActions();
            if (typeof loadKorbanActionsForSelect === 'function') {
                loadKorbanActionsForSelect();
            }
            if (typeof Toast !== 'undefined') {
                Toast.show('success', 'Berhasil', 
                    _editKorbanId ? 'Tindakan korban diperbarui.' : 'Tindakan korban ditambahkan.');
            }
        } else {
            if (typeof Toast !== 'undefined') {
                Toast.show('error', 'Gagal', res.message || 'Gagal menyimpan.');
            }
        }
    } catch(err) {
        if (btn) { btn.style.opacity = ''; btn.style.pointerEvents = ''; }
        console.error(err);
    }
}

// Hapus tindakan korban
async function hapusKorbanAction(id, nama) {
    if (!confirm(`Hapus tindakan korban "${nama}"?`)) return;
    
    const res = await apiFetchTd(API_KORBAN_DELETE + '/' + id, { method: 'DELETE' });
    
    if (res.status === 'success') {
        await loadKorbanActions();
        if (typeof Toast !== 'undefined') {
            Toast.show('success', 'Dihapus', 'Tindakan korban dihapus.');
        }
    } else {
        if (typeof Toast !== 'undefined') {
            Toast.show('error', 'Gagal', res.message || 'Gagal menghapus.');
        }
    }
}

// Tutup modal jika klik backdrop
document.getElementById('modalKorban').addEventListener('click', function(e) { 
    if (e.target === this) closeKorbanPage(); 
});
</script>
@endsection