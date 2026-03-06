@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

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

        {{-- Stats --}}
        <div class="stats-row animate-fade-in" style="animation-delay:.05s">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f5f3ff;color:#7c3aed">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statTotal">12</span>
                    <span class="stat-lbl">Total Permission</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#ecfdf5;color:#10b981">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val">4</span>
                    <span class="stat-lbl">Grup</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:#3b82f6">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val">4</span>
                    <span class="stat-lbl">Role Aktif</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef9c3;color:#ca8a04">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statSystem">5</span>
                    <span class="stat-lbl">Protected</span>
                </div>
            </div>
        </div>

        {{-- Group Sections --}}
        <div id="permContent" class="animate-fade-in" style="animation-delay:.1s"></div>

        <div class="no-results hidden" id="noResults" style="margin-top:40px">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>Tidak ada permission ditemukan</p>
        </div>

    </main>
    @include('components.toast')
</div>

{{-- Modal Permission --}}
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
            <div class="um-grid2">
                <div class="um-field">
                    <label class="um-label">Nama Permission <span class="um-req">*</span></label>
                    <input class="um-input" type="text" id="permNama" placeholder="Contoh: Lihat Laporan">
                </div>
                <div class="um-field">
                    <label class="um-label">Slug <span class="um-req">*</span></label>
                    <input class="um-input" type="text" id="permSlug" placeholder="Contoh: view-laporan">
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
                </div>
                <div class="um-field">
                    <label class="um-label">Tipe Aksi</label>
                    <select class="um-input" id="permAksi">
                        <option value="read">Read (Baca)</option>
                        <option value="write">Write (Tulis)</option>
                        <option value="delete">Delete (Hapus)</option>
                        <option value="manage">Manage (Kelola)</option>
                    </select>
                </div>
            </div>
            <div class="um-field">
                <label class="um-label">Deskripsi</label>
                <textarea class="um-input" id="permDeskripsi" rows="2" placeholder="Jelaskan fungsi permission ini..." style="resize:vertical"></textarea>
            </div>
            <div class="um-field">
                <label class="um-label">Role yang Memiliki Akses Ini</label>
                <div class="role-check-row" id="roleCheckRow"></div>
            </div>
        </div>
        <div class="um-footer">
            <button class="um-btn-cancel" onclick="closePermModal()">Batal</button>
            <button class="um-btn-save" onclick="savePerm()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
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
            <button class="um-btn-hapus" onclick="doHapusPerm()">
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

/* Stats */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;}
@media(max-width:768px){.stats-row{grid-template-columns:repeat(2,1fr);}}
.stat-card{background:white;border:1.5px solid #f3f4f6;border-radius:14px;padding:16px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 4px rgba(0,0,0,.04);}
.stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-icon svg{width:22px;height:22px;}
.stat-val{font-size:22px;font-weight:800;color:#111827;display:block;line-height:1;}
.stat-lbl{font-size:11px;color:#6b7280;font-weight:500;margin-top:3px;display:block;}

/* Group Section */
.perm-group-section{margin-bottom:24px;}
.perm-group-header{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
.perm-group-label{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;padding:4px 12px;border-radius:20px;}
.perm-group-count{font-size:11px;color:#9ca3af;font-weight:500;}

/* Permission Grid */
.perm-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;}

/* Permission Card */
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

/* Btn aksi */
.btn-aksi{width:30px;height:30px;border-radius:8px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;}
.btn-aksi svg{width:14px;height:14px;}
.btn-aksi.edit{background:#eff6ff;color:#3b82f6;border:1.5px solid #bfdbfe;}
.btn-aksi.edit:hover{background:#dbeafe;}
.btn-aksi.delete{background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca;}
.btn-aksi.delete:hover{background:#fee2e2;}

/* Role check pills */
.role-check-row{display:flex;flex-wrap:wrap;gap:8px;}
.role-check-pill{display:flex;align-items:center;gap:6px;padding:6px 12px;border:1.5px solid #e5e7eb;border-radius:20px;cursor:pointer;transition:all .15s;font-size:12px;font-weight:600;color:#374151;}
.role-check-pill:hover{border-color:#c4b5fd;}
.role-check-pill.checked{border-color:#7c3aed;background:#f5f3ff;color:#7c3aed;}
.role-check-pill input{display:none;}
.role-check-pill .pill-dot{width:8px;height:8px;border-radius:50%;background:#d1d5db;transition:background .15s;}
.role-check-pill.checked .pill-dot{background:#7c3aed;}

/* Modal shared */
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
.um-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:480px){.um-grid2{grid-template-columns:1fr;}}
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
.um-btn-hapus{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#ef4444;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.um-btn-hapus:hover{background:#dc2626;}
.um-btn-hapus svg{width:15px;height:15px;}
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
/* ── Data ── */
const PERM_DATA = {
    /* Laporan */
    'p1':  { nama:'Lihat Laporan',       slug:'view-laporan',      group:'Laporan',  aksi:'read',   deskripsi:'Melihat daftar dan detail laporan bullying yang masuk.',      roles:['r1','r2','r3','r4'], protected:true  },
    'p2':  { nama:'Buat Laporan',        slug:'create-laporan',    group:'Laporan',  aksi:'write',  deskripsi:'Membuat dan mengajukan laporan bullying baru ke sistem.',      roles:['r1','r2','r4'],      protected:false },
    'p3':  { nama:'Verifikasi Laporan',  slug:'verify-laporan',    group:'Laporan',  aksi:'write',  deskripsi:'Memverifikasi laporan yang masuk sebelum diproses lebih lanjut.',roles:['r1','r2'],          protected:false },
    'p4':  { nama:'Proses Laporan',      slug:'process-laporan',   group:'Laporan',  aksi:'manage', deskripsi:'Melakukan tindak lanjut dan menyelesaikan laporan bullying.',  roles:['r1','r2','r3'],      protected:false },
    'p5':  { nama:'Tolak Laporan',       slug:'reject-laporan',    group:'Laporan',  aksi:'write',  deskripsi:'Menolak laporan dengan alasan yang valid dan terdokumentasi.', roles:['r1','r2'],           protected:false },
    /* User */
    'p6':  { nama:'Kelola User',         slug:'manage-user',       group:'User',     aksi:'manage', deskripsi:'Menambah, mengedit, dan menghapus akun pengguna sistem.',      roles:['r1'],                protected:true  },
    'p7':  { nama:'Kelola Role',         slug:'manage-role',       group:'User',     aksi:'manage', deskripsi:'Menambah dan mengatur role beserta hak akses yang dimiliki.', roles:['r1'],                protected:true  },
    'p8':  { nama:'Kelola Permission',   slug:'manage-permission', group:'User',     aksi:'manage', deskripsi:'Menambah dan mengatur permission yang tersedia di sistem.',    roles:['r1'],                protected:true  },
    /* Analitik */
    'p9':  { nama:'Lihat Rekapitulasi',  slug:'view-rekap',        group:'Analitik', aksi:'read',   deskripsi:'Melihat laporan rekapitulasi kasus per bulan dan semester.',  roles:['r1','r2'],           protected:false },
    'p10': { nama:'Export Data',         slug:'export-data',       group:'Analitik', aksi:'read',   deskripsi:'Mengunduh data laporan dalam format Excel atau PDF.',          roles:['r1','r2'],           protected:false },
    /* Sistem */
    'p11': { nama:'Pengaturan Sistem',   slug:'system-settings',   group:'Sistem',   aksi:'manage', deskripsi:'Mengakses dan mengubah pengaturan umum aplikasi.',             roles:['r1'],                protected:true  },
    'p12': { nama:'Log Aktivitas',       slug:'view-logs',         group:'Sistem',   aksi:'read',   deskripsi:'Melihat riwayat aktivitas dan audit log seluruh pengguna.',   roles:['r1'],                protected:true  },
};

const ROLE_META = {
    r1:{ nama:'Super Admin', bg:'#fdf4ff', c:'#9333ea' },
    r2:{ nama:'Kesiswaan',   bg:'#f0fdf4', c:'#16a34a' },
    r3:{ nama:'Guru BK',     bg:'#eff6ff', c:'#3b82f6' },
    r4:{ nama:'Wali Kelas',  bg:'#fff7ed', c:'#ea580c' },
};

const GROUP_META = {
    Laporan:  { bg:'#ecfdf5', c:'#059669', iconColor:'#059669' },
    User:     { bg:'#f5f3ff', c:'#7c3aed', iconColor:'#7c3aed' },
    Analitik: { bg:'#eff6ff', c:'#3b82f6', iconColor:'#3b82f6' },
    Sistem:   { bg:'#fef9c3', c:'#ca8a04', iconColor:'#ca8a04' },
};

const AKSI_ICONS = {
    read:   `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`,
    write:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>`,
    delete: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`,
    manage: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`,
};

let _editPermId=null,_hapusPermId=null,_checkedRoles=new Set();

/* ── Render ── */
function renderContent(){
    const q=(document.getElementById('searchInput')?.value||'').toLowerCase();
    const gf=(document.getElementById('filterGroup')?.value||'');
    const content=document.getElementById('permContent');
    const noRes=document.getElementById('noResults');

    const filtered=Object.entries(PERM_DATA).filter(([,d])=>{
        return(!q||d.nama.toLowerCase().includes(q)||d.slug.toLowerCase().includes(q))&&(!gf||d.group===gf);
    });

    if(!filtered.length){content.innerHTML='';noRes.classList.remove('hidden');return;}
    noRes.classList.add('hidden');

    const groups={};
    filtered.forEach(([id,d])=>{
        if(!groups[d.group])groups[d.group]=[];
        groups[d.group].push([id,d]);
    });

    content.innerHTML=Object.entries(groups).map(([grp,items])=>{
        const gm=GROUP_META[grp]||{bg:'#f3f4f6',c:'#374151'};
        const cards=items.map(([id,d],i)=>{
            const roleDots=d.roles.map(rid=>{const rm=ROLE_META[rid];return rm?`<div class="perm-role-dot" style="background:${rm.bg};color:${rm.c}" title="${rm.nama}">${rm.nama.charAt(0)}</div>`:''}).join('');
            const deleteBtn=d.protected?'':`<button class="btn-aksi delete" title="Hapus" onclick="openHapusPerm('${id}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>`;
            const lockIcon=d.protected?`<div class="perm-protected"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>`:'';
            return `<div class="perm-card" style="animation-delay:${i*0.04}s">
                ${lockIcon}
                <div class="perm-card-top">
                    <div class="perm-card-left">
                        <div class="perm-icon-wrap" style="background:${gm.bg}">${AKSI_ICONS[d.aksi]?.replace('stroke="currentColor"',`stroke="${gm.c}"`)}</div>
                        <div>
                            <div class="perm-card-name">${d.nama}</div>
                            <div class="perm-card-slug">${d.slug}</div>
                        </div>
                    </div>
                    <div class="perm-card-actions">
                        <button class="btn-aksi edit" title="Edit" onclick="openPermModal('${id}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                        ${deleteBtn}
                    </div>
                </div>
                <p class="perm-card-desc">${d.deskripsi}</p>
                <div class="perm-card-footer">
                    <span class="perm-aksi-badge aksi-${d.aksi}">${d.aksi.toUpperCase()}</span>
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

    document.getElementById('statTotal').textContent=Object.keys(PERM_DATA).length;
    document.getElementById('statSystem').textContent=Object.values(PERM_DATA).filter(d=>d.protected).length;
}

/* ── Role check pills ── */
function buildRolePills(checked=[]){
    _checkedRoles=new Set(checked);
    const row=document.getElementById('roleCheckRow'); if(!row)return;
    row.innerHTML=Object.entries(ROLE_META).map(([id,r])=>{
        const isChk=checked.includes(id);
        return `<label class="role-check-pill ${isChk?'checked':''}" id="rcp-${id}" style="${isChk?`border-color:${r.c};background:${r.bg};color:${r.c}`:''}">
            <input type="checkbox" value="${id}" ${isChk?'checked':''} onchange="toggleRolePill(this,'${id}')">
            <span class="pill-dot" style="${isChk?`background:${r.c}`:''}"></span>
            ${r.nama}
        </label>`;
    }).join('');
}

function toggleRolePill(el,id){
    const rm=ROLE_META[id];
    const pill=document.getElementById('rcp-'+id);
    if(el.checked){
        _checkedRoles.add(id);
        pill.classList.add('checked');
        if(rm){pill.style.borderColor=rm.c;pill.style.background=rm.bg;pill.style.color=rm.c;pill.querySelector('.pill-dot').style.background=rm.c;}
    }else{
        _checkedRoles.delete(id);
        pill.classList.remove('checked');
        pill.style.cssText='';
        if(rm)pill.querySelector('.pill-dot').style.background='';
    }
}

/* ── Modal Perm ── */
function openPermModal(id=null){
    _editPermId=id;
    document.getElementById('permTitleModal').textContent=id?'Edit Permission':'Tambah Permission';
    if(id){
        const d=PERM_DATA[id];
        document.getElementById('permNama').value=d.nama;
        document.getElementById('permSlug').value=d.slug;
        document.getElementById('permGroup').value=d.group;
        document.getElementById('permAksi').value=d.aksi;
        document.getElementById('permDeskripsi').value=d.deskripsi;
        buildRolePills(d.roles);
    } else {
        ['permNama','permSlug','permDeskripsi'].forEach(i=>document.getElementById(i).value='');
        document.getElementById('permGroup').value='';
        document.getElementById('permAksi').value='read';
        buildRolePills([]);
    }
    document.getElementById('modalPerm').style.display='flex';
    document.body.style.overflow='hidden';
}
function closePermModal(){document.getElementById('modalPerm').style.display='none';document.body.style.overflow='';}

function savePerm(){
    const nama=document.getElementById('permNama').value.trim();
    const slug=document.getElementById('permSlug').value.trim();
    const group=document.getElementById('permGroup').value;
    if(!nama||!slug||!group){alert('Nama, Slug, dan Grup wajib diisi.');return;}
    const data={nama,slug,group,aksi:document.getElementById('permAksi').value,deskripsi:document.getElementById('permDeskripsi').value.trim(),roles:[..._checkedRoles],protected:false};
    if(_editPermId){Object.assign(PERM_DATA[_editPermId],data);}
    else{const newId='p'+(Object.keys(PERM_DATA).length+1);PERM_DATA[newId]=data;}
    closePermModal();renderContent();
    if(typeof Toast!=='undefined')Toast.show('success','Berhasil',_editPermId?'Permission berhasil diperbarui.':'Permission baru ditambahkan.');
}

function openHapusPerm(id){_hapusPermId=id;document.getElementById('hapusPermNama').textContent=PERM_DATA[id]?.nama||id;document.getElementById('modalHapusPerm').style.display='flex';document.body.style.overflow='hidden';}
function closeHapusPerm(){document.getElementById('modalHapusPerm').style.display='none';document.body.style.overflow='';}
function doHapusPerm(){if(!_hapusPermId)return;delete PERM_DATA[_hapusPermId];closeHapusPerm();renderContent();if(typeof Toast!=='undefined')Toast.show('success','Dihapus','Permission berhasil dihapus.');}

document.getElementById('searchInput')?.addEventListener('input',renderContent);
document.getElementById('filterGroup')?.addEventListener('change',renderContent);
document.getElementById('modalPerm').addEventListener('click',function(e){if(e.target===this)closePermModal();});
document.getElementById('modalHapusPerm').addEventListener('click',function(e){if(e.target===this)closeHapusPerm();});
document.addEventListener('DOMContentLoaded',()=>renderContent());
</script>
@endsection