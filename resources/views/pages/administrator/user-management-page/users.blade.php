@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

@include('components.sidebar-admin', ['activePage' => 'daftar-users'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Manajemen User',
        'breadcrumbs' => [['label' => 'Administrasi'], ['label' => 'User']],
    ])

    <main class="admin-main">

        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Daftar User</h2>
                <p class="content-sub">Kelola akun pengguna sistem dan atur role akses mereka.</p>
            </div>
            <div class="heading-actions">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari nama / email...">
                </div>
                <select class="filter-select" id="filterRole">
                    <option value="">Semua Role</option>
                    <option value="superadmin">Super Admin</option>
                    <option value="kesiswaan">Kesiswaan</option>
                    <option value="guru-bk">Guru BK</option>
                    <option value="wali-kelas">Wali Kelas</option>
                </select>
                <button class="btn-tambah" onclick="openUserModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah User
                </button>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="stats-row animate-fade-in" style="animation-delay:.05s">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:#3b82f6">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statTotal">8</span>
                    <span class="stat-lbl">Total User</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statAktif">6</span>
                    <span class="stat-lbl">Aktif</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef2f2;color:#ef4444">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statNonaktif">2</span>
                    <span class="stat-lbl">Nonaktif</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef9c3;color:#ca8a04">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val">4</span>
                    <span class="stat-lbl">Total Role</span>
                </div>
            </div>
        </div>

        <div class="table-card animate-fade-in" style="animation-delay:.1s">
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tgl Dibuat</th>
                            <th>Status</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
                <div class="no-results hidden" id="noResults">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Tidak ada user ditemukan</p>
                </div>
            </div>
            <div class="table-footer">
                <p class="table-info" id="tableInfo">Memuat data...</p>
                <div class="pagination" id="paginationWrap"></div>
            </div>
        </div>
    </main>
    @include('components.toast')
</div>

{{-- ===================== MODAL USER ===================== --}}
<div class="um-overlay" id="modalUser" style="display:none">
    <div class="um-panel">
        <div class="um-header" id="umHeader">
            <div class="um-header-left">
                <div class="um-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="um-sublabel" id="umSublabel">Manajemen User</p>
                    <h3 class="um-title" id="umTitle">Tambah User Baru</h3>
                </div>
            </div>
            <button class="um-close" onclick="closeUserModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="um-body">
            <div class="um-avatar-row">
                <div class="um-avatar" id="umAvatar">A</div>
                <div>
                    <p class="um-avatar-hint">Inisial nama akan tampil sebagai avatar</p>
                    <p class="um-avatar-hint2">Format foto profil belum tersedia</p>
                </div>
            </div>
            <div class="um-grid2">
                <div class="um-field">
                    <label class="um-label">Nama Lengkap <span class="um-req">*</span></label>
                    <input class="um-input" type="text" id="umNama" placeholder="Contoh: Budi Santoso" oninput="updateAvatar()">
                </div>
                <div class="um-field">
                    <label class="um-label">Username <span class="um-req">*</span></label>
                    <input class="um-input" type="text" id="umUsername" placeholder="Contoh: budi.santoso">
                </div>
            </div>
            <div class="um-field">
                <label class="um-label">Email <span class="um-req">*</span></label>
                <input class="um-input" type="email" id="umEmail" placeholder="Contoh: budi@smk.sch.id">
            </div>
            <div class="um-grid2">
                <div class="um-field">
                    <label class="um-label">Password <span class="um-req" id="umPwReq">*</span></label>
                    <div class="um-pw-wrap">
                        <input class="um-input" type="password" id="umPassword" placeholder="Min. 8 karakter">
                        <button type="button" class="um-pw-toggle" onclick="togglePw('umPassword',this)">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>
                <div class="um-field">
                    <label class="um-label">Konfirmasi Password <span class="um-req" id="umCpwReq">*</span></label>
                    <div class="um-pw-wrap">
                        <input class="um-input" type="password" id="umConfirmPassword" placeholder="Ulangi password">
                        <button type="button" class="um-pw-toggle" onclick="togglePw('umConfirmPassword',this)">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="um-grid2">
                <div class="um-field">
                    <label class="um-label">Role <span class="um-req">*</span></label>
                    <select class="um-select" id="umRole">
                        <option value="">Pilih Role...</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="kesiswaan">Kesiswaan</option>
                        <option value="guru-bk">Guru BK</option>
                        <option value="wali-kelas">Wali Kelas</option>
                    </select>
                </div>
                <div class="um-field">
                    <label class="um-label">Status</label>
                    <select class="um-select" id="umStatus">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="um-footer">
            <button class="um-btn-cancel" onclick="closeUserModal()">Batal</button>
            <button class="um-btn-save" id="umBtnSave" onclick="saveUser()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Simpan User
            </button>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="um-overlay" id="modalHapus" style="display:none">
    <div class="um-panel" style="max-width:400px">
        <div class="um-header" style="background:linear-gradient(135deg,#ef4444,#b91c1c)">
            <div class="um-header-left">
                <div class="um-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <p class="um-sublabel">Konfirmasi</p>
                    <h3 class="um-title">Hapus User?</h3>
                </div>
            </div>
            <button class="um-close" onclick="closeHapus()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="um-body">
            <div class="um-hapus-info">
                <div class="um-hapus-avatar" id="hapusAvatar">A</div>
                <div>
                    <p class="um-hapus-nama" id="hapusNama">—</p>
                    <p class="um-hapus-email" id="hapusEmail">—</p>
                </div>
            </div>
            <p class="um-hapus-warn">User yang dihapus tidak dapat dikembalikan. Semua data terkait user ini akan ikut terhapus dari sistem.</p>
        </div>
        <div class="um-footer">
            <button class="um-btn-cancel" onclick="closeHapus()">Batal</button>
            <button class="um-btn-hapus" onclick="doHapus()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

@include('components.toast')

<style>
html,body{height:100%;overflow:auto;}
.admin-wrapper{min-height:100vh;overflow-y:auto;}
.admin-main{overflow:visible;padding-bottom:40px;}
.table-card{overflow:visible;}
.table-scroll{overflow-x:auto;overflow-y:visible;}

/* Btn tambah */
.btn-tambah{display:flex;align-items:center;gap:7px;padding:9px 16px;background:#16a34a;color:white;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .15s;flex-shrink:0;}
.btn-tambah svg{width:15px;height:15px;}
.btn-tambah:hover{background:#15803d;}

/* Stats */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
@media(max-width:768px){.stats-row{grid-template-columns:repeat(2,1fr);}}
.stat-card{background:white;border:1.5px solid #f3f4f6;border-radius:14px;padding:16px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 4px rgba(0,0,0,.04);}
.stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-icon svg{width:22px;height:22px;}
.stat-val{font-size:22px;font-weight:800;color:#111827;display:block;line-height:1;}
.stat-lbl{font-size:11px;color:#6b7280;font-weight:500;margin-top:3px;display:block;}

/* User avatar in table */
.user-cell{display:flex;align-items:center;gap:10px;}
.user-av{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0;}
.user-name{font-weight:600;font-size:13px;color:#111827;}
.user-uname{font-size:11px;color:#9ca3af;}

/* Role badge */
.role-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap;}
.role-badge.superadmin{background:#fdf4ff;color:#9333ea;}
.role-badge.kesiswaan{background:#f0fdf4;color:#16a34a;}
.role-badge.guru-bk{background:#eff6ff;color:#3b82f6;}
.role-badge.wali-kelas{background:#fff7ed;color:#ea580c;}

/* Status */
.status-user{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
.status-user.aktif{background:#f0fdf4;color:#16a34a;}
.status-user::before{content:'';width:6px;height:6px;border-radius:50%;background:currentColor;flex-shrink:0;}
.status-user.nonaktif{background:#f9fafb;color:#6b7280;}

/* Aksi */
.btn-aksi.edit{background:#eff6ff;color:#3b82f6;border:1.5px solid #bfdbfe;}
.btn-aksi.edit:hover{background:#dbeafe;}
.btn-aksi.delete{background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca;}
.btn-aksi.delete:hover{background:#fee2e2;}

/* ---- Modal User ---- */
.um-overlay{position:fixed;left:var(--sidebar-width,260px);top:0;right:0;bottom:0;z-index:700;background:rgba(15,23,42,.5);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;}
@media(max-width:768px){.um-overlay{left:0;}}
.um-panel{background:white;border-radius:20px;width:100%;max-width:520px;box-shadow:0 32px 80px rgba(0,0,0,.22);overflow:hidden;animation:umIn .3s cubic-bezier(.16,1,.3,1) both;max-height:90vh;display:flex;flex-direction:column;}
@keyframes umIn{from{opacity:0;transform:translateY(20px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.um-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:linear-gradient(135deg,#16a34a,#15803d);flex-shrink:0;}
.um-header-left{display:flex;align-items:center;gap:12px;}
.um-header-icon{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.28);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.um-header-icon svg{width:20px;height:20px;color:white;}
.um-sublabel{font-size:.6rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.72);margin-bottom:3px;}
.um-title{font-size:1.05rem;font-weight:800;color:white;}
.um-close{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.22);cursor:pointer;display:flex;align-items:center;justify-content:center;color:white;transition:background .15s;}
.um-close:hover{background:rgba(255,255,255,.28);}
.um-close svg{width:15px;height:15px;}
.um-body{padding:18px 20px;overflow-y:auto;display:flex;flex-direction:column;gap:14px;}
.um-avatar-row{display:flex;align-items:center;gap:14px;padding:12px 14px;background:#f9fafb;border-radius:12px;border:1.5px solid #f3f4f6;}
.um-avatar{width:48px;height:48px;border-radius:50%;background:#16a34a;color:white;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;flex-shrink:0;}
.um-avatar-hint{font-size:12px;font-weight:600;color:#374151;margin-bottom:2px;}
.um-avatar-hint2{font-size:11px;color:#9ca3af;}
.um-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:480px){.um-grid2{grid-template-columns:1fr;}}
.um-field{display:flex;flex-direction:column;gap:5px;}
.um-label{font-size:11.5px;font-weight:700;color:#374151;letter-spacing:.02em;}
.um-req{color:#ef4444;}
.um-input,.um-select{padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:9px;font-family:inherit;font-size:13px;color:#111827;background:white;outline:none;transition:border-color .2s,box-shadow .2s;width:100%;box-sizing:border-box;}
.um-input:focus,.um-select:focus{border-color:#16a34a;box-shadow:0 0 0 3px rgba(22,163,74,.1);}
.um-select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;background-size:13px;padding-right:32px;cursor:pointer;}
.um-pw-wrap{position:relative;}
.um-pw-wrap .um-input{padding-right:40px;}
.um-pw-toggle{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;padding:2px;}
.um-pw-toggle svg{width:16px;height:16px;}
.um-pw-toggle:hover{color:#374151;}
.um-footer{display:flex;gap:8px;padding:14px 20px;border-top:1px solid #f3f4f6;background:#fafafa;flex-shrink:0;}
.um-btn-cancel{padding:10px 20px;border-radius:10px;border:1.5px solid #d1d5db;background:white;color:#374151;font-family:inherit;font-size:13px;font-weight:600;cursor:pointer;transition:background .15s;}
.um-btn-cancel:hover{background:#f9fafb;}
.um-btn-save{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#16a34a;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.um-btn-save svg{width:15px;height:15px;}
.um-btn-save:hover{background:#15803d;}
.um-btn-hapus{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#ef4444;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.um-btn-hapus svg{width:15px;height:15px;}
.um-btn-hapus:hover{background:#dc2626;}
.um-hapus-info{display:flex;align-items:center;gap:14px;padding:14px;background:#fef2f2;border-radius:12px;border:1.5px solid #fecaca;}
.um-hapus-avatar{width:44px;height:44px;border-radius:50%;background:#ef4444;color:white;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;flex-shrink:0;}
.um-hapus-nama{font-size:14px;font-weight:700;color:#111827;margin-bottom:3px;}
.um-hapus-email{font-size:12px;color:#6b7280;}
.um-hapus-warn{font-size:12.5px;color:#7f1d1d;background:#fff5f5;border:1.5px solid #fecaca;border-radius:10px;padding:10px 13px;line-height:1.6;}
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
/* Pastikan toggleNavGroup dari sidebar tidak ditimpa */
if (typeof toggleNavGroup === 'undefined') {
    function toggleNavGroup(id) {
        const group = document.getElementById(id);
        if (!group) return;
        const isOpen = group.classList.contains('open');
        document.querySelectorAll('.nav-group.open').forEach(g => { if (g.id !== id) g.classList.remove('open'); });
        group.classList.toggle('open', !isOpen);
    }
}
const USER_DATA = {
    'u1': { nama:'Ahmad Fauzi',     username:'ahmad.fauzi',    email:'ahmad.fauzi@smkm3.sch.id',    role:'superadmin', status:'aktif',    tgl:'01 Jan 2024', av:{bg:'#fdf4ff',c:'#9333ea'} },
    'u2': { nama:'Sari Dewi',       username:'sari.dewi',      email:'sari.dewi@smkm3.sch.id',       role:'kesiswaan',  status:'aktif',    tgl:'15 Jan 2024', av:{bg:'#f0fdf4',c:'#16a34a'} },
    'u3': { nama:'Budi Santoso',    username:'budi.santoso',   email:'budi.santoso@smkm3.sch.id',    role:'guru-bk',    status:'aktif',    tgl:'20 Jan 2024', av:{bg:'#eff6ff',c:'#3b82f6'} },
    'u4': { nama:'Rina Kartika',    username:'rina.kartika',   email:'rina.kartika@smkm3.sch.id',    role:'wali-kelas', status:'aktif',    tgl:'01 Feb 2024', av:{bg:'#fff7ed',c:'#ea580c'} },
    'u5': { nama:'Deni Pratama',    username:'deni.pratama',   email:'deni.pratama@smkm3.sch.id',    role:'kesiswaan',  status:'aktif',    tgl:'10 Feb 2024', av:{bg:'#f0fdf4',c:'#16a34a'} },
    'u6': { nama:'Mega Wulandari',  username:'mega.wulandari', email:'mega.wulandari@smkm3.sch.id',  role:'guru-bk',    status:'aktif',    tgl:'15 Feb 2024', av:{bg:'#eff6ff',c:'#3b82f6'} },
    'u7': { nama:'Hendra Wijaya',   username:'hendra.wijaya',  email:'hendra.wijaya@smkm3.sch.id',   role:'wali-kelas', status:'nonaktif', tgl:'01 Mar 2024', av:{bg:'#f9fafb',c:'#6b7280'} },
    'u8': { nama:'Putri Anggraini', username:'putri.anggraini',email:'putri.anggraini@smkm3.sch.id', role:'wali-kelas', status:'nonaktif', tgl:'05 Mar 2024', av:{bg:'#f9fafb',c:'#6b7280'} },
};

const ROLE_LABEL = { superadmin:'Super Admin', kesiswaan:'Kesiswaan', 'guru-bk':'Guru BK', 'wali-kelas':'Wali Kelas' };

const PER_PAGE=10; let _all=Object.keys(USER_DATA),_filtered=[..._all],_page=1,_editId=null,_hapusId=null;

function renderTable(){
    const tbody=document.getElementById('tableBody'),noRes=document.getElementById('noResults');
    const start=(_page-1)*PER_PAGE,rows=_filtered.slice(start,start+PER_PAGE);
    if(!_filtered.length){tbody.innerHTML='';noRes.classList.remove('hidden');}
    else{
        noRes.classList.add('hidden');
        tbody.innerHTML=rows.map((id,i)=>{
            const d=USER_DATA[id];
            return `<tr class="table-row" id="${id}">
                <td class="col-no">${start+i+1}</td>
                <td><div class="user-cell"><div class="user-av" style="background:${d.av.bg};color:${d.av.c}">${d.nama.charAt(0)}</div><div><div class="user-name">${d.nama}</div><div class="user-uname">@${d.username}</div></div></div></td>
                <td style="font-size:12.5px;color:#6b7280">${d.email}</td>
                <td><span class="role-badge ${d.role}">${ROLE_LABEL[d.role]||d.role}</span></td>
                <td style="font-size:12px;color:#9ca3af;font-family:monospace">${d.tgl}</td>
                <td><span class="status-user ${d.status}">${d.status==='aktif'?'Aktif':'Nonaktif'}</span></td>
                <td class="col-aksi"><div class="aksi-wrap">
                    <button class="btn-aksi edit" title="Edit" onclick="openUserModal('${id}')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button class="btn-aksi delete" title="Hapus" onclick="openHapus('${id}')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div></td>
            </tr>`;
        }).join('');
    }
    updateInfo();renderPag();
}

function updateInfo(){const el=document.getElementById('tableInfo');const s=(_page-1)*PER_PAGE+1,e=Math.min(_page*PER_PAGE,_filtered.length);if(el)el.textContent=_filtered.length?`Menampilkan ${s}–${e} dari ${_filtered.length} user`:'Tidak ada user ditemukan';}
function renderPag(){const w=document.getElementById('paginationWrap');if(!w)return;const t=Math.ceil(_filtered.length/PER_PAGE);w.innerHTML='';if(t<=1)return;w.appendChild(mkBtn('‹',_page===1,()=>goP(_page-1)));getPNums(t).forEach(p=>{if(p==='...'){const s=document.createElement('span');s.className='page-ellipsis';s.textContent='...';w.appendChild(s);}else{const b=mkBtn(p,false,()=>goP(p));if(p===_page)b.classList.add('active');w.appendChild(b);}});w.appendChild(mkBtn('›',_page===t,()=>goP(_page+1)));}
function mkBtn(l,d,f){const b=document.createElement('button');b.className='page-btn';b.textContent=l;b.disabled=d;if(d)b.style.opacity='.4';b.addEventListener('click',f);return b;}
function getPNums(t){if(t<=7)return Array.from({length:t},(_,i)=>i+1);const p=[];if(_page<=4){for(let i=1;i<=5;i++)p.push(i);p.push('...');p.push(t);}else if(_page>=t-3){p.push(1);p.push('...');for(let i=t-4;i<=t;i++)p.push(i);}else{p.push(1);p.push('...');for(let i=_page-1;i<=_page+1;i++)p.push(i);p.push('...');p.push(t);}return p;}
function goP(p){const t=Math.ceil(_filtered.length/PER_PAGE);if(p<1||p>t)return;_page=p;renderTable();window.scrollTo({top:0,behavior:'smooth'});}

function applyFilter(){const q=(document.getElementById('searchInput')?.value||'').toLowerCase();const r=(document.getElementById('filterRole')?.value||'');_filtered=_all.filter(id=>{const d=USER_DATA[id];return(!q||d.nama.toLowerCase().includes(q)||d.email.toLowerCase().includes(q)||d.username.toLowerCase().includes(q))&&(!r||d.role===r);});_page=1;renderTable();}
document.getElementById('searchInput')?.addEventListener('input',applyFilter);
document.getElementById('filterRole')?.addEventListener('change',applyFilter);

function updateAvatar(){const n=document.getElementById('umNama')?.value||'';document.getElementById('umAvatar').textContent=n.trim().charAt(0).toUpperCase()||'?';}
function togglePw(id,btn){const i=document.getElementById(id);i.type=i.type==='password'?'text':'password';}

function openUserModal(id=null){
    _editId=id;
    const isEdit=!!id;
    document.getElementById('umTitle').textContent=isEdit?'Edit User':'Tambah User Baru';
    document.getElementById('umSublabel').textContent=isEdit?'Edit Data User':'Manajemen User';
    document.getElementById('umPwReq').style.display=isEdit?'none':'';
    document.getElementById('umCpwReq').style.display=isEdit?'none':'';
    if(isEdit){
        const d=USER_DATA[id];
        document.getElementById('umNama').value=d.nama;
        document.getElementById('umUsername').value=d.username;
        document.getElementById('umEmail').value=d.email;
        document.getElementById('umPassword').value='';
        document.getElementById('umConfirmPassword').value='';
        document.getElementById('umRole').value=d.role;
        document.getElementById('umStatus').value=d.status;
        document.getElementById('umAvatar').textContent=d.nama.charAt(0);
    } else {
        ['umNama','umUsername','umEmail','umPassword','umConfirmPassword'].forEach(id=>document.getElementById(id).value='');
        document.getElementById('umRole').value='';
        document.getElementById('umStatus').value='aktif';
        document.getElementById('umAvatar').textContent='?';
    }
    document.getElementById('modalUser').style.display='flex';
    document.body.style.overflow='hidden';
}

function closeUserModal(){document.getElementById('modalUser').style.display='none';document.body.style.overflow='';}

function saveUser(){
    const nama=document.getElementById('umNama').value.trim();
    const email=document.getElementById('umEmail').value.trim();
    const role=document.getElementById('umRole').value;
    if(!nama||!email||!role){alert('Nama, Email, dan Role wajib diisi.');return;}
    if(_editId){
        USER_DATA[_editId].nama=nama;
        USER_DATA[_editId].username=document.getElementById('umUsername').value.trim();
        USER_DATA[_editId].email=email;
        USER_DATA[_editId].role=role;
        USER_DATA[_editId].status=document.getElementById('umStatus').value;
        USER_DATA[_editId].av={bg:USER_DATA[_editId].av.bg,c:USER_DATA[_editId].av.c};
    } else {
        const newId='u'+(Object.keys(USER_DATA).length+1);
        USER_DATA[newId]={nama,username:document.getElementById('umUsername').value.trim(),email,role,status:document.getElementById('umStatus').value,tgl:new Date().toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'}),av:{bg:'#f0fdf4',c:'#16a34a'}};
        _all=Object.keys(USER_DATA);
    }
    closeUserModal(); applyFilter();
    if(typeof Toast!=='undefined') Toast.show('success','Berhasil',_editId?'Data user berhasil diperbarui.':'User baru berhasil ditambahkan.');
}

function openHapus(id){
    _hapusId=id; const d=USER_DATA[id];
    document.getElementById('hapusAvatar').textContent=d.nama.charAt(0);
    document.getElementById('hapusNama').textContent=d.nama;
    document.getElementById('hapusEmail').textContent=d.email;
    document.getElementById('modalHapus').style.display='flex';
    document.body.style.overflow='hidden';
}
function closeHapus(){document.getElementById('modalHapus').style.display='none';document.body.style.overflow='';}
function doHapus(){
    if(!_hapusId)return;
    delete USER_DATA[_hapusId];
    _all=Object.keys(USER_DATA);
    closeHapus(); applyFilter();
    if(typeof Toast!=='undefined') Toast.show('success','Dihapus','User berhasil dihapus dari sistem.');
}

document.getElementById('modalUser').addEventListener('click',function(e){if(e.target===this)closeUserModal();});
document.getElementById('modalHapus').addEventListener('click',function(e){if(e.target===this)closeHapus();});
document.addEventListener('DOMContentLoaded',()=>renderTable());
</script>
@endsection