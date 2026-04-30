@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
<script src="{{ asset('js/users-management-admin-page.js') }}" defer></script>

@include('components.sidebar-admin', ['activePage' => 'daftar-permissions'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Manajemen Permission',
        'breadcrumbs' => [['label' => 'Administrasi'], ['label' => 'Permission']],
    ])

    <main class="admin-main">

        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Daftar Permission</h2>
                <p class="content-sub">Kelola hak akses sistem yang dapat diberikan kepada setiap role.</p>
            </div>
            <div class="heading-actions">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari permission...">
                </div>
                <select class="filter-select" id="filterGroup">
                    <option value="">Semua Grup</option>
                    <option value="Laporan">Laporan</option>
                    <option value="User">User</option>
                    <option value="Analitik">Analitik</option>
                    <option value="Sistem">Sistem</option>
                </select>
                <button class="btn-tambah" onclick="openPermModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Permission
                </button>
            </div>
        </div>

        <div class="stats-row animate-fade-in" style="animation-delay:.05s">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f5f3ff;color:#7c3aed">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statTotal">—</span>
                    <span class="stat-lbl">Total Permission</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#ecfdf5;color:#10b981">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statGroups">—</span>
                    <span class="stat-lbl">Grup</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:#3b82f6">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statRoles">—</span>
                    <span class="stat-lbl">Role Aktif</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef9c3;color:#ca8a04">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statProtected">—</span>
                    <span class="stat-lbl">Protected</span>
                </div>
            </div>
        </div>

        <div id="permContent" class="animate-fade-in" style="animation-delay:.1s">
            <p style="color:#9ca3af;padding:20px;"><span class="spinner-inline"></span> Memuat data...</p>
        </div>

        <div class="no-results hidden" id="noResults" style="margin-top:40px">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>Tidak ada permission ditemukan</p>
        </div>

    </main>
    @include('components.toast')
</div>

{{-- ══════ Modal Tambah / Edit Permission ══════ --}}
<div class="um-overlay" id="modalPerm" style="display:none">
    <div class="um-panel" style="max-width:460px">
        <div class="um-header">
            <div class="um-header-left">
                <div class="um-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div>
                    <p class="um-sublabel">Manajemen Permission</p>
                    <h3 class="um-title" id="permTitleModal">Tambah Permission</h3>
                </div>
            </div>
            <button class="um-close" onclick="closePermModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="um-body">

            {{--
                PENTING: Setiap .um-field sudah berisi <span class="um-field-error">
                yang tersembunyi. Ini agar error SELALU berada di dalam .um-field
                sehingga layout grid tidak rusak saat error muncul.
            --}}
            <div class="um-grid2">
                <div class="um-field">
                    <label class="um-label">Nama Permission <span class="um-req">*</span></label>
                    <input class="um-input" type="text" id="permNama" placeholder="Contoh: Lihat Laporan">
                    <span class="um-field-error" id="permNama_err" style="display:none"></span>
                </div>
                <div class="um-field">
                    <label class="um-label">Slug <span class="um-req">*</span></label>
                    <input class="um-input" type="text" id="permSlug" placeholder="Contoh: view-laporan">
                    <span class="um-field-error" id="permSlug_err" style="display:none"></span>
                </div>
            </div>

            <div class="um-grid2">
                <div class="um-field">
                    <label class="um-label">Grup <span class="um-req">*</span></label>
                    <select class="um-input" id="permGroup">
                        <option value="">Pilih Grup...</option>
                        <option value="Laporan">Laporan</option>
                        <option value="User">User</option>
                        <option value="Analitik">Analitik</option>
                        <option value="Sistem">Sistem</option>
                    </select>
                    <span class="um-field-error" id="permGroup_err" style="display:none"></span>
                </div>
                <div class="um-field">
                    <label class="um-label">Tipe Aksi <span class="um-req">*</span></label>
                    <select class="um-input" id="permAksi">
                        <option value="read">Read (Baca)</option>
                        <option value="write">Write (Tulis)</option>
                        <option value="delete">Delete (Hapus)</option>
                        <option value="manage">Manage (Kelola)</option>
                    </select>
                    {{-- Aksi tidak perlu validasi karena selalu ada value default --}}
                </div>
            </div>

            <div class="um-field">
                <label class="um-label">Deskripsi</label>
                <textarea class="um-input" id="permDeskripsi" rows="2" placeholder="Jelaskan fungsi permission ini..." style="resize:vertical"></textarea>
            </div>

            <div class="um-field">
                <label class="um-label">Role yang Memiliki Akses Ini</label>
                <div class="role-check-row" id="roleCheckRow">
                    <p style="color:#9ca3af;font-size:12px;">Memuat roles...</p>
                </div>
            </div>

        </div>
        <div class="um-footer">
            <button class="um-btn-cancel" onclick="closePermModal()">Batal</button>
            <button class="um-btn-save" id="permBtnSave" onclick="savePerm()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- ══════ Modal Hapus Permission ══════ --}}
<div class="um-overlay" id="modalHapusPerm" style="display:none">
    <div class="um-panel" style="max-width:380px">
        <div class="um-header" style="background:linear-gradient(135deg,#ef4444,#b91c1c)">
            <div class="um-header-left">
                <div class="um-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div><p class="um-sublabel">Konfirmasi</p><h3 class="um-title">Hapus Permission?</h3></div>
            </div>
            <button class="um-close" onclick="closeHapusPerm()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="um-body">
            <p style="font-size:13.5px;color:#374151;line-height:1.7">Permission <strong id="hapusPermNama">—</strong> akan dihapus permanen. Role yang memiliki permission ini akan kehilangan akses tersebut.</p>
        </div>
        <div class="um-footer">
            <button class="um-btn-cancel" onclick="closeHapusPerm()">Batal</button>
            <button class="um-btn-hapus" id="btnHapusPerm" onclick="doHapusPerm()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<style>
html,body{height:100%;overflow:auto;}
.admin-wrapper{min-height:100vh;overflow-y:auto;}
.admin-main{overflow:visible;padding-bottom:40px;}

.btn-tambah{display:flex;align-items:center;gap:7px;padding:9px 16px;background:#7c3aed;color:white;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .15s;flex-shrink:0;}
.btn-tambah svg{width:15px;height:15px;}
.btn-tambah:hover{background:#6d28d9;}

.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;}
@media(max-width:768px){.stats-row{grid-template-columns:repeat(2,1fr);}}
.stat-card{background:white;border:1.5px solid #f3f4f6;border-radius:14px;padding:16px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 4px rgba(0,0,0,.04);}
.stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-icon svg{width:22px;height:22px;}
.stat-val{font-size:22px;font-weight:800;color:#111827;display:block;line-height:1;}
.stat-lbl{font-size:11px;color:#6b7280;font-weight:500;margin-top:3px;display:block;}

.perm-group-section{margin-bottom:24px;}
.perm-group-header{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
.perm-group-label{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;padding:4px 12px;border-radius:20px;}
.perm-group-count{font-size:11px;color:#9ca3af;font-weight:500;}
.perm-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;}
.perm-card{background:white;border:1.5px solid #f3f4f6;border-radius:14px;padding:16px;transition:box-shadow .2s,transform .2s,border-color .2s;position:relative;animation:fadeUp .3s ease both;}
.perm-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);transform:translateY(-2px);border-color:#e9d5ff;}
@keyframes fadeUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.perm-card-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:10px;}
.perm-card-left{display:flex;align-items:center;gap:10px;}
.perm-icon-wrap{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.perm-icon-wrap svg{width:17px;height:17px;}
.perm-card-name{font-size:13.5px;font-weight:700;color:#111827;margin-bottom:2px;}
.perm-card-slug{font-size:11px;color:#9ca3af;font-family:monospace;}
.perm-card-actions{display:flex;gap:5px;flex-shrink:0;}
.perm-card-desc{font-size:12px;color:#6b7280;line-height:1.6;margin-bottom:12px;min-height:32px;}
.perm-card-footer{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;}
.perm-aksi-badge{font-size:10px;font-weight:700;padding:2px 8px;border-radius:6px;letter-spacing:.04em;}
.aksi-read{background:#ecfdf5;color:#059669;}
.aksi-write{background:#eff6ff;color:#3b82f6;}
.aksi-delete{background:#fef2f2;color:#ef4444;}
.aksi-manage{background:#fdf4ff;color:#9333ea;}
.perm-roles-wrap{display:flex;gap:4px;flex-wrap:wrap;}
.perm-role-dot{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;border:2px solid white;cursor:default;}
.perm-protected{position:absolute;top:10px;right:10px;width:18px;height:18px;background:#fef9c3;border-radius:50%;display:flex;align-items:center;justify-content:center;}
.perm-protected svg{width:10px;height:10px;color:#ca8a04;}

.btn-aksi{width:30px;height:30px;border-radius:8px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;}
.btn-aksi svg{width:14px;height:14px;}
.btn-aksi.edit{background:#eff6ff;color:#3b82f6;border:1.5px solid #bfdbfe;}
.btn-aksi.edit:hover{background:#dbeafe;}
.btn-aksi.delete{background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca;}
.btn-aksi.delete:hover{background:#fee2e2;}

.role-check-row{display:flex;flex-wrap:wrap;gap:8px;}
.role-check-pill{display:flex;align-items:center;gap:6px;padding:6px 12px;border:1.5px solid #e5e7eb;border-radius:20px;cursor:pointer;transition:all .15s;font-size:12px;font-weight:600;color:#374151;}
.role-check-pill:hover{border-color:#c4b5fd;}
.role-check-pill.checked{border-color:#7c3aed;background:#f5f3ff;color:#7c3aed;}
.role-check-pill input{display:none;}
.pill-dot{width:8px;height:8px;border-radius:50%;background:#d1d5db;transition:background .15s;}
.role-check-pill.checked .pill-dot{background:#7c3aed;}

/* ══════════════════════════════════════════════════════════
   VALIDASI INLINE — selaras dengan halaman User & Role
   Span error sudah ada di HTML (display:none), hanya di-show
   saat error. Grid TIDAK rusak karena DOM tidak berubah.
══════════════════════════════════════════════════════════ */

/* Input / select gagal validasi */
.um-input-error {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239,68,68,.12) !important;
    background: #fff8f8 !important;
}

/* Pesan error */
.um-field-error {
    display: none;       /* default tersembunyi */
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    color: #dc2626;
    margin-top: 4px;
    animation: umErrSlideIn .2s ease both;
}
.um-field-error::before {
    content: '';
    display: inline-block;
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23dc2626' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-size: contain;
}
@keyframes umErrSlideIn {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ══ Modal layout ══ */
.um-overlay{position:fixed;left:var(--sidebar-width,260px);top:0;right:0;bottom:0;z-index:700;background:rgba(15,23,42,.5);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;}
@media(max-width:768px){.um-overlay{left:0;}}
.um-panel{background:white;border-radius:20px;width:100%;max-width:520px;box-shadow:0 32px 80px rgba(0,0,0,.22);overflow:hidden;animation:umIn .3s cubic-bezier(.16,1,.3,1) both;max-height:90vh;display:flex;flex-direction:column;}
@keyframes umIn{from{opacity:0;transform:translateY(20px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.um-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:linear-gradient(135deg,#7c3aed,#5b21b6);flex-shrink:0;}
.um-header-left{display:flex;align-items:center;gap:12px;}
.um-header-icon{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.28);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.um-header-icon svg{width:20px;height:20px;color:white;}
.um-sublabel{font-size:.6rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.72);margin-bottom:3px;}
.um-title{font-size:1.05rem;font-weight:800;color:white;}
.um-close{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.22);cursor:pointer;display:flex;align-items:center;justify-content:center;color:white;transition:background .15s;}
.um-close:hover{background:rgba(255,255,255,.28);}
.um-close svg{width:15px;height:15px;}
.um-body{padding:18px 20px;overflow-y:auto;display:flex;flex-direction:column;gap:14px;}

/* Grid 2 kolom — align-items:start agar kolom tidak sama tinggi paksa */
.um-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;align-items:start;}
@media(max-width:480px){.um-grid2{grid-template-columns:1fr;}}

/* Field adalah flex-column sehingga error span tumbuh ke bawah di dalam kolom masing-masing */
.um-field{display:flex;flex-direction:column;gap:5px;}
.um-label{font-size:11.5px;font-weight:700;color:#374151;letter-spacing:.02em;}
.um-req{color:#ef4444;}
.um-input{padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:9px;font-family:inherit;font-size:13px;color:#111827;background:white;outline:none;transition:border-color .2s,box-shadow .2s;width:100%;box-sizing:border-box;}
.um-input:focus{border-color:#7c3aed;box-shadow:0 0 0 3px rgba(124,58,237,.1);}
.um-footer{display:flex;gap:8px;padding:14px 20px;border-top:1px solid #f3f4f6;background:#fafafa;flex-shrink:0;}
.um-btn-cancel{padding:10px 20px;border-radius:10px;border:1.5px solid #d1d5db;background:white;color:#374151;font-family:inherit;font-size:13px;font-weight:600;cursor:pointer;transition:background .15s;}
.um-btn-cancel:hover{background:#f9fafb;}
.um-btn-save{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#7c3aed;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.um-btn-save svg{width:15px;height:15px;}
.um-btn-save:hover{background:#6d28d9;}
.um-btn-save:disabled{opacity:.6;cursor:not-allowed;}
.um-btn-hapus{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#ef4444;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.um-btn-hapus:hover{background:#dc2626;}
.um-btn-hapus svg{width:15px;height:15px;}
.spinner-inline{display:inline-block;width:16px;height:16px;border:2px solid #e5e7eb;border-top-color:#6b7280;border-radius:50%;animation:spin .7s linear infinite;vertical-align:middle;margin-right:6px;}
@keyframes spin{to{transform:rotate(360deg)}}
</style>

<script>
/* ════════════════════════════════════════════════════════════
   VALIDASI INLINE — selaras dengan halaman User & Role
   ─────────────────────────────────────────────────────────
   Span error sudah ada di HTML, jadi pmSetError hanya perlu:
   1. Tambah class error pada input/select
   2. Isi teks dan tampilkan span yang sudah ada
   Ini mencegah layout grid rusak karena DOM tidak berubah struktur.
════════════════════════════════════════════════════════════ */

function pmSetError(fieldId, message) {
    var field = document.getElementById(fieldId);
    if (!field) return;

    if (field.tagName === 'SELECT') {
        field.classList.add('um-input-error');
    } else {
        field.classList.add('um-input-error');
    }

    var errEl = document.getElementById(fieldId + '_err');
    if (errEl) {
        errEl.textContent = message;
        errEl.style.display = 'flex';
    }
}

function pmClearError(fieldId) {
    var field = document.getElementById(fieldId);
    if (field) field.classList.remove('um-input-error');

    var errEl = document.getElementById(fieldId + '_err');
    if (errEl) {
        errEl.textContent = '';
        errEl.style.display = 'none';
    }
}

function clearPermErrors() {
    ['permNama', 'permSlug', 'permGroup'].forEach(function(id) {
        pmClearError(id);
    });
}

function pmValidateAll() {
    clearPermErrors();
    var valid = true;

    var nama  = (document.getElementById('permNama').value  || '').trim();
    var slug  = (document.getElementById('permSlug').value  || '').trim();
    var group = (document.getElementById('permGroup').value || '').trim();

    // ── Nama Permission ──
    if (!nama) {
        pmSetError('permNama', 'Nama permission wajib diisi.');
        valid = false;
    } else if (nama.length < 2) {
        pmSetError('permNama', 'Nama permission minimal 2 karakter.');
        valid = false;
    }

    // ── Slug ──
    if (!slug) {
        pmSetError('permSlug', 'Slug wajib diisi.');
        valid = false;
    } else if (!/^[a-z0-9]+(-[a-z0-9]+)*$/.test(slug)) {
        pmSetError('permSlug', 'Slug hanya huruf kecil, angka, dan tanda hubung (-).');
        valid = false;
    }

    // ── Grup ──
    if (!group) {
        pmSetError('permGroup', 'Grup wajib dipilih.');
        valid = false;
    }

    return valid;
}

/* Error hilang otomatis saat user mulai mengetik / memilih */
document.addEventListener('DOMContentLoaded', function () {
    ['permNama', 'permSlug'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', function() { pmClearError(id); });
    });
    var groupEl = document.getElementById('permGroup');
    if (groupEl) groupEl.addEventListener('change', function() { pmClearError('permGroup'); });
});

/* ════════════════════════════════════════════════════════════
   STATE
════════════════════════════════════════════════════════════ */
let _allPerms    = [];
let _allRoles    = [];
let _editPermId  = null;
let _hapusPermId = null;
let _checkedRoleIds = new Set();

const GROUP_META = {
    Laporan:  { bg: '#ecfdf5', c: '#059669' },
    User:     { bg: '#f5f3ff', c: '#7c3aed' },
    Analitik: { bg: '#eff6ff', c: '#3b82f6' },
    Sistem:   { bg: '#fef9c3', c: '#ca8a04' },
};

const AKSI_SVG = {
    read:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`,
    write:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>`,
    delete: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`,
    manage: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`,
};

/* ── Helper: XSRF ── */
function getXsrf() {
    const m = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
    return m ? decodeURIComponent(m[1]) : '';
}
function jsonHeaders() {
    return { 'Content-Type':'application/json','Accept':'application/json','X-XSRF-TOKEN':getXsrf() };
}

/* ── Load data ── */
async function loadPerms() {
    const res  = await fetch('/api/admin/permissions', { headers: { 'Accept': 'application/json' } });
    const data = await res.json();
    if (data.success) {
        _allPerms = data.data;
        document.getElementById('statTotal').textContent     = data.stats.total;
        document.getElementById('statProtected').textContent = data.stats.protected;
        document.getElementById('statGroups').textContent    = data.stats.groups;
        renderContent();
    }
}

async function loadRoles() {
    const res  = await fetch('/api/admin/roles', { headers: { 'Accept': 'application/json' } });
    const data = await res.json();
    if (data.success) {
        _allRoles = data.data;
        document.getElementById('statRoles').textContent = _allRoles.length;
    }
}

/* ── Render konten per grup ── */
function renderContent() {
    const q  = (document.getElementById('searchInput')?.value || '').toLowerCase();
    const gf = (document.getElementById('filterGroup')?.value || '');
    const content = document.getElementById('permContent');
    const noRes   = document.getElementById('noResults');

    const filtered = _allPerms.filter(d =>
        (!q || d.nama.toLowerCase().includes(q) || d.slug.toLowerCase().includes(q)) &&
        (!gf || d.group === gf)
    );

    if (!filtered.length) { content.innerHTML = ''; noRes.classList.remove('hidden'); return; }
    noRes.classList.add('hidden');

    // Kelompokkan per grup
    const groups = {};
    filtered.forEach(p => { if (!groups[p.group]) groups[p.group] = []; groups[p.group].push(p); });

    content.innerHTML = Object.entries(groups).map(([grp, items]) => {
        const gm = GROUP_META[grp] || { bg: '#f3f4f6', c: '#374151' };
        const cards = items.map((p, i) => {
            const roleDots = p.roles.map(r =>
                `<div class="perm-role-dot" style="background:${r.bg};color:${r.c}" title="${r.nama}">${r.nama.charAt(0)}</div>`
            ).join('');
            const deleteBtn = p.is_protected ? '' :
                `<button class="btn-aksi delete" onclick="openHapusPerm(${p.id})">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>`;
            const lockIcon = p.is_protected ?
                `<div class="perm-protected"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>` : '';
            const iconSvg = (AKSI_SVG[p.aksi] || '').replace('stroke="currentColor"', `stroke="${gm.c}"`);

            return `<div class="perm-card" style="animation-delay:${i * 0.04}s">
                ${lockIcon}
                <div class="perm-card-top">
                    <div class="perm-card-left">
                        <div class="perm-icon-wrap" style="background:${gm.bg}">${iconSvg}</div>
                        <div>
                            <div class="perm-card-name">${p.nama}</div>
                            <div class="perm-card-slug">${p.slug}</div>
                        </div>
                    </div>
                    <div class="perm-card-actions">
                        <button class="btn-aksi edit" onclick="openPermModal(${p.id})">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        ${deleteBtn}
                    </div>
                </div>
                <p class="perm-card-desc">${p.deskripsi || '—'}</p>
                <div class="perm-card-footer">
                    <span class="perm-aksi-badge aksi-${p.aksi}">${p.aksi.toUpperCase()}</span>
                    <div class="perm-roles-wrap">${roleDots}</div>
                </div>
            </div>`;
        }).join('');

        return `<div class="perm-group-section">
            <div class="perm-group-header">
                <span class="perm-group-label" style="background:${gm.bg};color:${gm.c}">${grp}</span>
                <span class="perm-group-count">${items.length} permission</span>
            </div>
            <div class="perm-grid">${cards}</div>
        </div>`;
    }).join('');
}

/* ── Role pills di modal ── */
function buildRolePills(checkedIds = []) {
    _checkedRoleIds = new Set(checkedIds);
    const row = document.getElementById('roleCheckRow');
    if (!row) return;
    if (!_allRoles.length) { row.innerHTML = '<p style="color:#9ca3af;font-size:12px;">Tidak ada role.</p>'; return; }

    row.innerHTML = _allRoles.map(r => {
        const isChk = checkedIds.includes(r.id);
        return `<label class="role-check-pill ${isChk ? 'checked' : ''}" id="rcp-${r.id}"
            style="${isChk ? `border-color:${r.c};background:${r.bg};color:${r.c}` : ''}">
            <input type="checkbox" value="${r.id}" ${isChk ? 'checked' : ''} onchange="toggleRolePill(this, ${r.id})">
            <span class="pill-dot" style="${isChk ? `background:${r.c}` : ''}"></span>
            ${r.nama}
        </label>`;
    }).join('');
}

function toggleRolePill(el, id) {
    const role = _allRoles.find(r => r.id === id);
    const pill = document.getElementById('rcp-' + id);
    if (el.checked) {
        _checkedRoleIds.add(id);
        pill?.classList.add('checked');
        if (role && pill) { pill.style.borderColor = role.c; pill.style.background = role.bg; pill.style.color = role.c; pill.querySelector('.pill-dot').style.background = role.c; }
    } else {
        _checkedRoleIds.delete(id);
        pill?.classList.remove('checked');
        if (pill) { pill.style.cssText = ''; }
    }
}

/* ── Modal Permission ── */
function openPermModal(id = null) {
    _editPermId = id;
    clearPermErrors();
    document.getElementById('permTitleModal').textContent = id ? 'Edit Permission' : 'Tambah Permission';

    if (id) {
        const p = _allPerms.find(x => x.id === id);
        if (!p) return;
        document.getElementById('permNama').value      = p.nama;
        document.getElementById('permSlug').value      = p.slug;
        document.getElementById('permGroup').value     = p.group;
        document.getElementById('permAksi').value      = p.aksi;
        document.getElementById('permDeskripsi').value = p.deskripsi || '';
        buildRolePills(p.roles.map(r => r.id));
    } else {
        ['permNama','permSlug','permDeskripsi'].forEach(i => document.getElementById(i).value = '');
        document.getElementById('permGroup').value = '';
        document.getElementById('permAksi').value  = 'read';
        buildRolePills([]);
    }

    openOverlay('modalPerm');
}

function closePermModal() {
    clearPermErrors();
    closeOverlay('modalPerm');
}

async function savePerm() {
    // ── Validasi lokal dulu ──
    if (!pmValidateAll()) {
        var firstErr = document.querySelector('.um-input-error');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    const btn = document.getElementById('permBtnSave');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const body = {
        nama:      document.getElementById('permNama').value.trim(),
        slug:      document.getElementById('permSlug').value.trim(),
        group:     document.getElementById('permGroup').value,
        aksi:      document.getElementById('permAksi').value,
        deskripsi: document.getElementById('permDeskripsi').value.trim(),
        roles:     [..._checkedRoleIds],
    };

    const url    = _editPermId ? `/api/admin/permissions/${_editPermId}` : '/api/admin/permissions';
    const method = _editPermId ? 'PUT' : 'POST';

    try {
        const res  = await fetch(url, { method, headers: jsonHeaders(), body: JSON.stringify(body) });
        const data = await res.json();

        if (res.ok && data.success) {
            closePermModal();
            await loadPerms();
            if (typeof Toast !== 'undefined') Toast.show('success', 'Berhasil', data.message);
        } else if (res.status === 422 && data.errors) {
            // Mapping error dari backend ke field HTML
            const fieldMap = {
                nama:  'permNama',
                slug:  'permSlug',
                group: 'permGroup',
            };
            Object.entries(data.errors).forEach(([field, msgs]) => {
                const htmlId = fieldMap[field];
                if (htmlId) pmSetError(htmlId, Array.isArray(msgs) ? msgs[0] : msgs);
            });
            var firstErr = document.querySelector('.um-input-error');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            alert(data.message || 'Terjadi kesalahan.');
        }
    } catch (e) {
        console.error(e);
        alert('Koneksi bermasalah.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Simpan';
    }
}

/* ── Modal Hapus ── */
function openHapusPerm(id) {
    _hapusPermId = id;
    const p = _allPerms.find(x => x.id === id);
    document.getElementById('hapusPermNama').textContent = p?.nama || '—';
    openOverlay('modalHapusPerm');
}

function closeHapusPerm() { closeOverlay('modalHapusPerm'); }

async function doHapusPerm() {
    if (!_hapusPermId) return;
    const btn = document.getElementById('btnHapusPerm');
    btn.disabled = true;
    btn.textContent = 'Menghapus...';

    try {
        const res  = await fetch(`/api/admin/permissions/${_hapusPermId}`, { method: 'DELETE', headers: jsonHeaders() });
        const data = await res.json();

        if (res.ok && data.success) {
            closeHapusPerm();
            await loadPerms();
            if (typeof Toast !== 'undefined') Toast.show('success', 'Dihapus', data.message);
        } else {
            alert(data.message || 'Gagal menghapus permission.');
        }
    } catch (e) {
        console.error(e);
        alert('Koneksi bermasalah.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Ya, Hapus';
    }
}

/* ── Init ── */
document.getElementById('searchInput')?.addEventListener('input', renderContent);
document.getElementById('filterGroup')?.addEventListener('change', renderContent);

document.addEventListener('DOMContentLoaded', async () => {
    await Promise.all([loadRoles(), loadPerms()]);
    bindOverlayClose('modalPerm',      closePermModal);
    bindOverlayClose('modalHapusPerm', closeHapusPerm);
});
</script>
@endsection