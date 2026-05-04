@extends('layouts.app-admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
<link rel="stylesheet" href="{{ asset('css/master-admin-page.css') }}">

@include('components.sidebar-admin', ['activePage' => 'data-siswa'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Master Data Siswa',
        'breadcrumbs' => [['label' => 'Administrasi'], ['label' => 'Master Data'], ['label' => 'Data Siswa']],
    ])

    <main class="admin-main">

        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Data Siswa</h2>
                <p class="content-sub">Kelola data siswa yang terdaftar dalam sistem pelaporan bullying.</p>
            </div>
            <div class="heading-actions">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari nama / NIS...">
                </div>
                <select class="filter-select" id="filterKelas">
                    <option value="">Semua Kelas</option>
                </select>
                <select class="filter-select" id="filterJurusan">
                    <option value="">Semua Jurusan</option>
                </select>
                <button class="btn-manage-kelas" onclick="openKelasMgr()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Kelas &amp; Jurusan
                </button>
                <button class="btn-tambah" onclick="openSiswaModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Siswa
                </button>
            </div>
        </div>

        <div class="stats-row animate-fade-in" style="animation-delay:.05s">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statTotal">0</span>
                    <span class="stat-lbl">Total Siswa</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;color:#3b82f6">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statKelas">0</span>
                    <span class="stat-lbl">Total Kelas</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef9c3;color:#ca8a04">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statPernahLapor">0</span>
                    <span class="stat-lbl">Pernah Melapor</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef2f2;color:#ef4444">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div class="stat-info">
                    <span class="stat-val" id="statPelaku">0</span>
                    <span class="stat-lbl">Tercatat Pelaku</span>
                </div>
            </div>
        </div>

        <div class="table-card animate-fade-in" style="animation-delay:.1s">
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th>Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Jenis Kelamin</th>
                            <th>No. HP / WA</th>
                            <th>Riwayat Laporan</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
                <div class="no-results hidden" id="noResults">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Tidak ada siswa ditemukan</p>
                </div>
            </div>
            <div class="table-footer">
                <p class="table-info" id="tableInfo">Memuat data...</p>
                <div class="pagination" id="paginationWrap"></div>
            </div>
        </div>

    </main>
    @include('components.footer', ['type' => 'admin'])
    @include('components.toast')
</div>

{{-- ══════ Modal Tambah / Edit Siswa ══════ --}}
<div class="sm-overlay" id="modalSiswa" style="display:none">
    <div class="sm-panel">
        <div class="sm-header">
            <div class="sm-header-left">
                <div class="sm-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="sm-sublabel">Master Data</p>
                    <h3 class="sm-title" id="smTitle">Tambah Siswa</h3>
                </div>
            </div>
            <button class="sm-close" onclick="closeSiswaModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="sm-body">
            <div class="sm-avatar-row">
                <div class="sm-avatar" id="smAvatar">?</div>
                <div>
                    <p style="font-size:12px;font-weight:600;color:#374151;margin-bottom:2px">Avatar Siswa</p>
                    <p style="font-size:11px;color:#9ca3af">Inisial nama akan tampil otomatis</p>
                </div>
            </div>
            <div class="sm-grid2">
                <div class="sm-field">
                    <label class="sm-label">Nama Lengkap <span class="sm-req">*</span></label>
                    <input class="sm-input" type="text" id="smNama" placeholder="Contoh: Ahmad Fauzi" oninput="updateSmAvatar()">
                </div>
                <div class="sm-field">
                    <label class="sm-label">NIS <span class="sm-req">*</span></label>
                    <input class="sm-input" type="text" id="smNis" placeholder="Contoh: 12345">
                </div>
            </div>
            <div class="sm-grid2">
                <div class="sm-field">
                    <label class="sm-label">Tingkat / Kelas <span class="sm-req">*</span></label>
                    <select class="sm-input" id="smTingkat">
                        <option value="">Pilih...</option>
                    </select>
                </div>
                <div class="sm-field">
                    <label class="sm-label">Jurusan <span class="sm-req">*</span></label>
                    <select class="sm-input" id="smJurusan">
                        <option value="">Pilih...</option>
                    </select>
                </div>
            </div>
            <div class="sm-grid2">
                <div class="sm-field">
                    <label class="sm-label">Jenis Kelamin</label>
                    <select class="sm-input" id="smJK">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="sm-field">
                    <label class="sm-label">No. HP / WA <span class="sm-req">*</span></label>
                    <input class="sm-input" type="text" id="smHp" placeholder="Contoh: 08123456789">
                </div>
            </div>
            <div class="sm-field">
                <label class="sm-label">Email Siswa <span class="sm-req">*</span></label>
                <input class="sm-input" type="email" id="smEmail" placeholder="Contoh: siswa@student.smk.sch.id">
            </div>
        </div>
        <div class="sm-footer">
            <button class="sm-btn-cancel" onclick="closeSiswaModal()">Batal</button>
            <button class="sm-btn-save" id="btnSimpanSiswa" onclick="saveSiswa()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- ══════ Modal Hapus Siswa ══════ --}}
<div class="sm-overlay" id="modalHapusSiswa" style="display:none">
    <div class="sm-panel" style="max-width:380px">
        <div class="sm-header" style="background:linear-gradient(135deg,#ef4444,#b91c1c)">
            <div class="sm-header-left">
                <div class="sm-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div><p class="sm-sublabel">Konfirmasi</p><h3 class="sm-title">Hapus Siswa?</h3></div>
            </div>
            <button class="sm-close" onclick="closeHapusSiswa()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="sm-body">
            <p style="font-size:13.5px;color:#374151;line-height:1.7">Data siswa <strong id="hapusSiswaNama">—</strong> akan dihapus permanen dari sistem.</p>
        </div>
        <div class="sm-footer">
            <button class="sm-btn-cancel" onclick="closeHapusSiswa()">Batal</button>
            <button class="sm-btn-hapus" id="btnDoHapus" onclick="doHapusSiswa()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

{{-- ══════ Modal Kelola Kelas & Jurusan ══════ --}}
<div class="sm-overlay" id="modalKelasMgr" style="display:none">
    <div class="sm-panel" style="max-width:600px">
        <div class="sm-header" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8)">
            <div class="sm-header-left">
                <div class="sm-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                </div>
                <div>
                    <p class="sm-sublabel">Master Data</p>
                    <h3 class="sm-title">Kelola Kelas &amp; Jurusan</h3>
                </div>
            </div>
            <button class="sm-close" onclick="closeKelasMgr()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="sm-body" style="gap:22px">

            {{-- ══ TAB NAVIGATION ══ --}}
            <div class="kmgr-tabs">
                <button class="kmgr-tab active" id="tabJurusan" onclick="kmgrSwitchTab('jurusan')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                    Jurusan
                    <span class="kmgr-tab-badge" id="tabJurusanBadge">0</span>
                </button>
                <button class="kmgr-tab" id="tabKelas" onclick="kmgrSwitchTab('kelas')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10h18M3 14h18M10 6v12M14 6v12"/>
                    </svg>
                    Kelas
                    <span class="kmgr-tab-badge" id="tabKelasBadge">0</span>
                </button>
            </div>

            {{-- ══ PANEL JURUSAN ══ --}}
            <div id="panelJurusan">
                <p class="mgr-section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                    Tambah Jurusan Baru
                </p>
                <div style="display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap">
                    <div style="flex:2;min-width:180px">
                        <input class="sm-input" type="text" id="inputJurusanBaru"
                            placeholder="Nama lengkap (cth: Rekayasa Perangkat Lunak)"
                            style="width:100%"
                            maxlength="100"
                            oninput="kmgrNamaCounter()"
                            onkeydown="if(event.key==='Enter') tambahJurusan()">
                        <span id="namaCounter" style="font-size:11px;color:#9ca3af">0/100</span>
                    </div>
                    <input class="sm-input" type="text" id="inputJurusanKode"
                        placeholder="Kode (cth: RPL)"
                        style="flex:1;min-width:80px;text-transform:uppercase"
                        maxlength="30"
                        onkeydown="if(event.key==='Enter') tambahJurusan()">
                    <button class="mgr-btn-add mgr-btn-green" onclick="tambahJurusan()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </button>
                </div>

                <p class="mgr-section-title" style="margin-top:4px">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Daftar Jurusan
                </p>

                {{-- Tabel jurusan + jumlah kelas per jurusan (dirender oleh renderJurusanTable() di JS) --}}
                <div id="daftarJurusanTable" class="kmgr-jurusan-table"></div>

                <div class="mgr-info-box" style="margin-top:12px">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Setelah menambah jurusan, buka tab Kelas untuk mendaftarkan kelas ke jurusan tersebut.
                </div>
            </div>

            {{-- ══ PANEL KELAS ══ --}}
            <div id="panelKelas" style="display:none">
                <p class="mgr-section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kelas Baru
                </p>

                <div class="kmgr-add-kelas-form">
                    {{-- Step 1: Pilih Jurusan --}}
                    <div class="kmgr-form-step">
                        <label class="kmgr-step-label">
                            <span class="kmgr-step-num">1</span>
                            Pilih Jurusan
                        </label>
                        <select class="sm-input" id="selectJurusanUntukKelas" style="width:100%"
                                onchange="kmgrOnJurusanChange()">
                            <option value="">— Pilih jurusan —</option>
                        </select>
                    </div>

                    {{-- Step 2: Isi Nama Kelas --}}
                    <div class="kmgr-form-step">
                        <label class="kmgr-step-label">
                            <span class="kmgr-step-num">2</span>
                            Nama Kelas
                        </label>
                        <div style="display:flex;gap:8px;align-items:center">
                            <input class="sm-input" type="text" id="inputKelasBaru"
                                   placeholder="Cth: XA, XB, XI-1, XII-RPL-A"
                                   style="flex:1;text-transform:uppercase"
                                   onkeydown="if(event.key==='Enter') tambahKelas()">
                            <div class="kmgr-preview-badge" id="kmgrPreviewBadge" style="display:none"></div>
                        </div>
                        <p class="kmgr-hint" id="kmgrHint" style="display:none"></p>
                    </div>

                    <button class="mgr-btn-add" id="btnTambahKelas"
                            style="align-self:flex-end;margin-top:4px" onclick="tambahKelas()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kelas
                    </button>
                </div>

                {{-- Error inline --}}
                <p class="kmgr-err" id="kmgrJurusanErr" style="display:none"></p>
                <p class="kmgr-err" id="kmgrKelasErr" style="display:none"></p>

                <hr style="border:none;border-top:1px solid #f3f4f6;margin:16px 0">

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;flex-wrap:wrap">
                    <p class="mgr-section-title" style="margin:0;flex:1">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        Daftar Kelas
                    </p>
                    <select class="filter-select" id="filterKelasByJurusan"
                            style="font-size:12px;padding:6px 10px;border-radius:8px"
                            onchange="renderKelasTags()">
                        <option value="">Semua Jurusan</option>
                    </select>
                </div>

                <div id="daftarKelas" class="mgr-tag-wrap"></div>

                <div class="mgr-info-box" style="margin-top:12px">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Kelas yang dihapus tidak mempengaruhi data siswa yang sudah terdaftar.
                </div>
            </div>

        </div>{{-- /sm-body --}}

        <div class="sm-footer">
            <button class="sm-btn-cancel" onclick="closeKelasMgr()">Tutup</button>
        </div>
    </div>
</div>

{{-- ══════ Modal Konfirmasi Hapus Kelas / Jurusan ══════ --}}
<div class="sm-overlay" id="modalDeleteConfirm" style="display:none">
    <div class="sm-panel" style="max-width:400px">
        <div class="sm-header" id="confirmDeleteIcon" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8)">
            <div class="sm-header-left">
                <div class="sm-header-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <p class="sm-sublabel">Konfirmasi Hapus</p>
                    <h3 class="sm-title" id="confirmDeleteLabel">Hapus Item</h3>
                </div>
            </div>
            <button class="sm-close" onclick="closeDeleteConfirm()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="sm-body" style="gap:12px">
            <div style="display:flex;justify-content:center;padding:8px 0">
                <div style="width:60px;height:60px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center">
                    <svg fill="none" stroke="#ef4444" viewBox="0 0 24 24" style="width:30px;height:30px">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <p style="text-align:center;font-size:15px;font-weight:700;color:#111827" id="confirmDeleteNama">"—"</p>
            <p style="text-align:center;font-size:13px;color:#6b7280;line-height:1.7" id="confirmDeleteInfo">
                Item ini akan dihapus dari daftar.
            </p>
            <div style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:10px;padding:10px 14px;display:flex;gap:8px;align-items:flex-start">
                <svg fill="none" stroke="#d97706" viewBox="0 0 24 24" style="width:15px;height:15px;flex-shrink:0;margin-top:1px">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span style="font-size:12px;color:#92400e;line-height:1.6">Data siswa yang sudah terdaftar <strong>tidak akan terpengaruh</strong> oleh penghapusan ini.</span>
            </div>
        </div>
        <div class="sm-footer">
            <button class="sm-btn-cancel" onclick="closeDeleteConfirm()">Batal</button>
            <button class="sm-btn-hapus" onclick="doDeleteConfirm()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script src="{{ asset('js/master-admin-page.js') }}"></script>
<script>
/* ─────────────────────────────────────────
   API ENDPOINTS — override nilai default di master-admin-page.js
   menggunakan Laravel route() agar otomatis mengikuti prefix apapun
───────────────────────────────────────── */
var API_STUDENTS_LIST      = '{{ route("students.api.list") }}';
var API_STUDENTS_SAVE      = '{{ route("students.api.save") }}';
var API_STUDENTS_DELETE    = '{{ route("students.api.delete", ":id") }}'.replace('/:id', '');
var API_GRADES_LIST        = '{{ route("api.students.grades.public") }}';
var API_GRADES_SAVE        = '{{ route("students.api.grades.save") }}';
var API_GRADES_DELETE      = '{{ route("students.api.grades.delete", ":name") }}'.replace('/:name', '');
var API_MAJORS_LIST        = '{{ route("students.api.majors.public") }}';
var API_MAJORS_SAVE        = '{{ route("students.api.majors.save") }}';
var API_MAJORS_DELETE      = '{{ route("students.api.majors.delete", ":name") }}'.replace('/:name', '');
var API_GRADE_MAJORS_PAIRS = '{{ route("api.grade.majors.pairs") }}';
var API_GRADES_BY_MAJOR    = '{{ route("api.grades.by.major", ":major") }}'.replace('/:major', '');
var API_MAJORS_FULL = '{{ route("students.api.majors.full.public") }}';

/* ─────────────────────────────────────────
   CSRF TOKEN — override nilai default di master-admin-page.js
───────────────────────────────────────── */
var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')
    ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
</script>
@endsection