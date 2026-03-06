@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

@include('components.sidebar-admin', ['activePage' => 'jenis-pelanggaran'])

<div class="admin-wrapper" id="adminWrapper">
    @include('components.topbar-admin', [
        'pageTitle'   => 'Jenis Pelanggaran',
        'breadcrumbs' => [['label' => 'Administrasi'], ['label' => 'Master Data'], ['label' => 'Jenis Pelanggaran']],
    ])

    <main class="admin-main">

        <div class="content-heading animate-fade-in">
            <div>
                <h2 class="content-title">Jenis Pelanggaran</h2>
                <p class="content-sub">Kelola jenis pelanggaran bullying verbal dan non-verbal dalam sistem pelaporan.</p>
            </div>
            <div class="heading-actions">
                <div class="search-wrap">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari jenis pelanggaran...">
                </div>
                <select class="filter-select" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    <option value="Verbal">Bullying Verbal</option>
                    <option value="Non-Verbal">Bullying Non-Verbal</option>
                </select>
                <button class="jp-btn-tambah" onclick="openJpModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Jenis
                </button>
            </div>
        </div>

        <div class="jp-stats-row animate-fade-in" style="animation-delay:.05s">
            <div class="jp-stat-card">
                <div class="jp-stat-icon" style="background:#fff7ed;color:#ea580c">
                    <svg fill="none" stroke="#ea580c" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                </div>
                <div>
                    <span class="jp-stat-val" id="statTotal">0</span>
                    <span class="jp-stat-lbl">Total Jenis</span>
                </div>
            </div>
            <div class="jp-stat-card">
                <div class="jp-stat-icon" style="background:#fdf4ff;color:#7c3aed">
                    <svg fill="none" stroke="#7c3aed" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <div>
                    <span class="jp-stat-val" id="statVerbal">0</span>
                    <span class="jp-stat-lbl">Bullying Verbal</span>
                </div>
            </div>
            <div class="jp-stat-card">
                <div class="jp-stat-icon" style="background:#fef2f2;color:#dc2626">
                    <svg fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <span class="jp-stat-val" id="statNonVerbal">0</span>
                    <span class="jp-stat-lbl">Bullying Non-Verbal</span>
                </div>
            </div>
            <div class="jp-stat-card">
                <div class="jp-stat-icon" style="background:#fef9c3;color:#ca8a04">
                    <svg fill="none" stroke="#ca8a04" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"/></svg>
                </div>
                <div>
                    <span class="jp-stat-val" id="statTotalKasus">0</span>
                    <span class="jp-stat-lbl">Total Kasus Tercatat</span>
                </div>
            </div>
        </div>

        <div id="jpContent" class="animate-fade-in" style="animation-delay:.1s"></div>

        <div class="no-results hidden" id="noResults" style="margin-top:40px">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>Tidak ada jenis pelanggaran ditemukan</p>
        </div>
    </main>
    @include('components.toast')
</div>

{{-- Modal Tambah/Edit --}}
<div class="jp-overlay" id="modalJp" style="display:none">
    <div class="jp-panel">
        <div class="jp-modal-header" id="jpModalHeaderBar">
            <div class="jp-modal-header-left">
                <div class="jp-modal-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="jp-modal-sub">Master Data</p>
                    <h3 class="jp-modal-title" id="jpModalTitle">Tambah Jenis Pelanggaran</h3>
                </div>
            </div>
            <button class="jp-modal-close" onclick="closeJpModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="jp-modal-body">
            <div class="jp-modal-grid2">
                <div class="jp-field">
                    <label class="jp-label">Nama Pelanggaran <span class="jp-req">*</span></label>
                    <input class="jp-input" type="text" id="jpNama" placeholder="Contoh: Penghinaan Verbal">
                </div>
                <div class="jp-field">
                    <label class="jp-label">Kategori <span class="jp-req">*</span></label>
                    <select class="jp-input" id="jpKategori" onchange="updateModalColor()">
                        <option value="">Pilih Kategori...</option>
                        <option value="Verbal">Bullying Verbal</option>
                        <option value="Non-Verbal">Bullying Non-Verbal</option>
                    </select>
                </div>
            </div>
            <div class="jp-modal-grid2">
                <div class="jp-field">
                    <label class="jp-label">Tingkat Urgensi</label>
                    <select class="jp-input" id="jpUrgensi">
                        <option value="rendah">Rendah</option>
                        <option value="sedang" selected>Sedang</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                </div>
                <div class="jp-field">
                    <label class="jp-label">Status</label>
                    <select class="jp-input" id="jpStatus">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="jp-field">
                <label class="jp-label">Deskripsi</label>
                <textarea class="jp-input" id="jpDeskripsi" rows="3" placeholder="Jelaskan definisi dan ciri-ciri pelanggaran ini..." style="resize:vertical"></textarea>
            </div>
            <div class="jp-field">
                <label class="jp-label">Contoh Perilaku</label>
                <textarea class="jp-input" id="jpContoh" rows="2" placeholder="Contoh perilaku yang termasuk kategori ini..." style="resize:vertical"></textarea>
            </div>
        </div>
        <div class="jp-modal-footer">
            <button class="jp-btn-cancel" onclick="closeJpModal()">Batal</button>
            <button class="jp-btn-save" id="jpBtnSave" onclick="saveJp()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="jp-overlay" id="modalHapusJp" style="display:none">
    <div class="jp-panel" style="max-width:380px">
        <div class="jp-modal-header" style="background:linear-gradient(135deg,#ef4444,#b91c1c)">
            <div class="jp-modal-header-left">
                <div class="jp-modal-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div><p class="jp-modal-sub">Konfirmasi</p><h3 class="jp-modal-title">Hapus Pelanggaran?</h3></div>
            </div>
            <button class="jp-modal-close" onclick="closeHapusJp()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="jp-modal-body">
            <p style="font-size:13.5px;color:#374151;line-height:1.7">Jenis pelanggaran <strong id="hapusJpNama">—</strong> akan dihapus permanen dari sistem.</p>
        </div>
        <div class="jp-modal-footer">
            <button class="jp-btn-cancel" onclick="closeHapusJp()">Batal</button>
            <button class="jp-btn-hapus" onclick="doHapusJp()">
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
.jp-btn-tambah{display:flex;align-items:center;gap:7px;padding:9px 16px;background:#7c3aed;color:white;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .15s;flex-shrink:0;}
.jp-btn-tambah svg{width:15px;height:15px;}
.jp-btn-tambah:hover{background:#6d28d9;}
.jp-stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;}
@media(max-width:768px){.jp-stats-row{grid-template-columns:repeat(2,1fr);}}
.jp-stat-card{background:white;border:1.5px solid #f3f4f6;border-radius:14px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 4px rgba(0,0,0,.04);transition:transform .2s,box-shadow .2s;}
.jp-stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.07);}
.jp-stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.jp-stat-icon svg{width:22px;height:22px;}
.jp-stat-val{font-size:24px;font-weight:800;color:#111827;display:block;line-height:1;}
.jp-stat-lbl{font-size:11px;color:#6b7280;font-weight:500;margin-top:3px;display:block;}
.jp-group{margin-bottom:30px;}
.jp-group-header{display:flex;align-items:center;gap:12px;margin-bottom:16px;}
.jp-group-badge{display:flex;align-items:center;gap:8px;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;padding:6px 16px;border-radius:20px;}
.jp-group-badge svg{width:14px;height:14px;}
.jp-group-badge.Verbal{background:#fdf4ff;color:#7c3aed;border:1.5px solid #e9d5ff;}
.jp-group-badge.Non-Verbal{background:#fef2f2;color:#dc2626;border:1.5px solid #fecaca;}
.jp-group-line{flex:1;height:1px;background:#f3f4f6;}
.jp-group-count{font-size:11.5px;color:#9ca3af;font-weight:500;white-space:nowrap;}
.jp-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:14px;}
.jp-card{background:white;border:1.5px solid #f3f4f6;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.04);transition:box-shadow .2s,transform .2s;animation:jpCardIn .3s ease both;}
.jp-card:hover{box-shadow:0 8px 28px rgba(0,0,0,.08);transform:translateY(-2px);}
@keyframes jpCardIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.jp-card.Verbal{border-top:3px solid #7c3aed;}
.jp-card.Non-Verbal{border-top:3px solid #dc2626;}
.jp-card-top{padding:14px 16px 12px;border-bottom:1px solid #f9fafb;}
.jp-card-top-row{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;}
.jp-card-icon-wrap{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.jp-card-icon-wrap svg{width:17px;height:17px;}
.jp-card-name{font-size:13.5px;font-weight:700;color:#111827;margin-bottom:3px;}
.jp-card-kat{font-size:10px;font-weight:700;padding:2px 8px;border-radius:6px;display:inline-block;letter-spacing:.04em;}
.jp-card-kat.Verbal{background:#fdf4ff;color:#7c3aed;}
.jp-card-kat.Non-Verbal{background:#fef2f2;color:#dc2626;}
.jp-card-actions{display:flex;gap:5px;flex-shrink:0;}
.jp-card-body{padding:12px 16px 14px;}
.jp-card-desc{font-size:12px;color:#6b7280;line-height:1.65;margin-bottom:10px;min-height:36px;}
.jp-card-contoh{font-size:11px;color:#9ca3af;background:#f9fafb;border-radius:6px;padding:6px 8px;line-height:1.5;margin-bottom:10px;}
.jp-card-contoh strong{color:#6b7280;font-size:10px;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:2px;}
.jp-card-footer{display:flex;align-items:center;justify-content:space-between;gap:6px;flex-wrap:wrap;}
.jp-urgensi-badge{font-size:10px;font-weight:700;padding:3px 9px;border-radius:6px;}
.jp-urgensi-badge.tinggi{background:#fef2f2;color:#dc2626;}
.jp-urgensi-badge.sedang{background:#fffbeb;color:#d97706;}
.jp-urgensi-badge.rendah{background:#f0fdf4;color:#16a34a;}
.jp-status-dot{display:flex;align-items:center;gap:5px;font-size:11px;font-weight:600;}
.jp-status-dot::before{content:'';width:7px;height:7px;border-radius:50%;flex-shrink:0;}
.jp-status-dot.aktif{color:#16a34a;}
.jp-status-dot.aktif::before{background:#16a34a;}
.jp-status-dot.nonaktif{color:#9ca3af;}
.jp-status-dot.nonaktif::before{background:#d1d5db;}
.jp-kasus-count{font-size:11px;color:#9ca3af;}
.btn-aksi{width:30px;height:30px;border-radius:8px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;}
.btn-aksi svg{width:14px;height:14px;}
.btn-aksi.edit{background:#eff6ff;color:#3b82f6;border:1.5px solid #bfdbfe;}
.btn-aksi.edit:hover{background:#dbeafe;}
.btn-aksi.delete{background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca;}
.btn-aksi.delete:hover{background:#fee2e2;}
.jp-overlay{position:fixed;left:var(--sidebar-width,260px);top:0;right:0;bottom:0;z-index:700;background:rgba(15,23,42,.5);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;}
@media(max-width:768px){.jp-overlay{left:0;}}
.jp-panel{background:white;border-radius:20px;width:100%;max-width:500px;box-shadow:0 32px 80px rgba(0,0,0,.22);overflow:hidden;animation:jpIn .3s cubic-bezier(.16,1,.3,1) both;max-height:90vh;display:flex;flex-direction:column;}
@keyframes jpIn{from{opacity:0;transform:translateY(20px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.jp-modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:linear-gradient(135deg,#7c3aed,#5b21b6);flex-shrink:0;transition:background .3s;}
.jp-modal-header-left{display:flex;align-items:center;gap:12px;}
.jp-modal-icon{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.28);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.jp-modal-icon svg{width:20px;height:20px;color:white;}
.jp-modal-sub{font-size:.6rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.72);margin-bottom:3px;}
.jp-modal-title{font-size:1.05rem;font-weight:800;color:white;}
.jp-modal-close{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.22);cursor:pointer;display:flex;align-items:center;justify-content:center;color:white;transition:background .15s;}
.jp-modal-close:hover{background:rgba(255,255,255,.28);}
.jp-modal-close svg{width:15px;height:15px;}
.jp-modal-body{padding:18px 20px;overflow-y:auto;display:flex;flex-direction:column;gap:14px;}
.jp-modal-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:480px){.jp-modal-grid2{grid-template-columns:1fr;}}
.jp-field{display:flex;flex-direction:column;gap:5px;}
.jp-label{font-size:11.5px;font-weight:700;color:#374151;letter-spacing:.02em;}
.jp-req{color:#ef4444;}
.jp-input{padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:9px;font-family:inherit;font-size:13px;color:#111827;background:white;outline:none;transition:border-color .2s,box-shadow .2s;width:100%;box-sizing:border-box;}
.jp-input:focus{border-color:#7c3aed;box-shadow:0 0 0 3px rgba(124,58,237,.1);}
.jp-modal-footer{display:flex;gap:8px;padding:14px 20px;border-top:1px solid #f3f4f6;background:#fafafa;flex-shrink:0;}
.jp-btn-cancel{padding:10px 20px;border-radius:10px;border:1.5px solid #d1d5db;background:white;color:#374151;font-family:inherit;font-size:13px;font-weight:600;cursor:pointer;}
.jp-btn-cancel:hover{background:#f9fafb;}
.jp-btn-save{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#7c3aed;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.jp-btn-save svg{width:15px;height:15px;}
.jp-btn-save:hover{background:#6d28d9;}
.jp-btn-hapus{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#ef4444;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;}
.jp-btn-hapus:hover{background:#dc2626;}
.jp-btn-hapus svg{width:15px;height:15px;}
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
const JP_DATA = {
    'jp1': { nama:'Penghinaan & Ejekan',        kategori:'Verbal',     urgensi:'sedang', status:'aktif', kasus:15, deskripsi:'Menghina, mengejek, atau merendahkan korban melalui kata-kata secara langsung.',         contoh:'Memanggil dengan julukan buruk, mengejek fisik, melontarkan kata-kata kasar.' },
    'jp2': { nama:'Ancaman & Intimidasi Lisan', kategori:'Verbal',     urgensi:'tinggi', status:'aktif', kasus:7,  deskripsi:'Mengancam atau mengintimidasi korban secara lisan untuk memaksanya menuruti keinginan pelaku.', contoh:'Mengancam akan memukul, mengancam menyebarkan rahasia, membentak untuk menakut-nakuti.' },
    'jp3': { nama:'Gosip & Fitnah',             kategori:'Verbal',     urgensi:'sedang', status:'aktif', kasus:9,  deskripsi:'Menyebarkan rumor atau informasi palsu tentang korban untuk merusak reputasinya.',       contoh:'Menyebarkan kabar bohong, memfitnah di depan teman, menceritakan rahasia pribadi.' },
    'jp4': { nama:'Membentak & Meneriaki',      kategori:'Verbal',     urgensi:'rendah', status:'aktif', kasus:4,  deskripsi:'Berteriak atau membentak korban di depan umum untuk mempermalukan dan merendahkan.',      contoh:'Membentak di kelas, meneriaki di koridor, berteriak kasar atas kesalahan kecil.' },
    'jp5': { nama:'Meremehkan & Merendahkan',   kategori:'Verbal',     urgensi:'rendah', status:'aktif', kasus:6,  deskripsi:'Secara verbal meremehkan kemampuan atau latar belakang korban untuk menurunkan kepercayaan dirinya.', contoh:'Mengatakan korban tidak berguna, meledek nilai, menghina keluarga korban.' },
    'jp6': { nama:'Kekerasan Fisik',            kategori:'Non-Verbal', urgensi:'tinggi', status:'aktif', kasus:8,  deskripsi:'Tindakan menyakiti secara fisik seperti memukul, menendang, atau mendorong yang menyebabkan rasa sakit.', contoh:'Memukul, menendang, mendorong hingga jatuh, mencubit dengan keras.' },
    'jp7': { nama:'Merusak / Mengambil Barang', kategori:'Non-Verbal', urgensi:'sedang', status:'aktif', kasus:3,  deskripsi:'Sengaja merusak, menyembunyikan, atau mengambil barang milik korban sebagai bentuk intimidasi.', contoh:'Merobek buku, memecahkan kacamata, mengambil uang atau barang berharga.' },
    'jp8': { nama:'Pengucilan Sosial',          kategori:'Non-Verbal', urgensi:'sedang', status:'aktif', kasus:6,  deskripsi:'Mengasingkan korban dari kelompok pertemanan melalui tindakan non-verbal secara sengaja.', contoh:'Tidak mengajak bergabung, melarang orang lain berteman, silent treatment kolektif.' },
    'jp9': { nama:'Gestur & Ekspresi Mengancam',kategori:'Non-Verbal', urgensi:'sedang', status:'aktif', kasus:5,  deskripsi:'Menggunakan gestur tubuh atau mimik wajah yang bersifat mengancam atau merendahkan korban.', contoh:'Memelototkan mata, mengacungkan tinju, membuat gestur kasar, wajah mengintimidasi.' },
    'jp10':{ nama:'Cyberbullying',              kategori:'Non-Verbal', urgensi:'tinggi', status:'aktif', kasus:11, deskripsi:'Perundungan melalui media sosial, pesan digital, atau platform online.',                 contoh:'Komentar jahat di medsos, menyebarkan foto tanpa izin, membuat akun palsu.' },
    'jp11':{ nama:'Manipulasi & Pengisolasian', kategori:'Non-Verbal', urgensi:'sedang', status:'aktif', kasus:3,  deskripsi:'Memanipulasi hubungan sosial korban untuk mengisolasinya dari lingkungan pertemanan.',   contoh:'Mempengaruhi teman agar menjauh, menyebarkan sinyal negatif non-verbal tentang korban.' },
};

const KAT_META = {
    'Verbal':     { bg:'#fdf4ff', c:'#7c3aed', label:'Bullying Verbal',     icon:'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>' },
    'Non-Verbal': { bg:'#fef2f2', c:'#dc2626', label:'Bullying Non-Verbal', icon:'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>' },
};

let _editJpId=null,_hapusJpId=null;

function renderContent(){
    const q=(document.getElementById('searchInput')?.value||'').toLowerCase();
    const kf=(document.getElementById('filterKategori')?.value||'');
    const content=document.getElementById('jpContent');
    const noRes=document.getElementById('noResults');
    const filtered=Object.entries(JP_DATA).filter(([,d])=>(!q||d.nama.toLowerCase().includes(q)||d.deskripsi.toLowerCase().includes(q))&&(!kf||d.kategori===kf));
    if(!filtered.length){content.innerHTML='';noRes.classList.remove('hidden');return;}
    noRes.classList.add('hidden');
    const groups={};
    filtered.forEach(([id,d])=>{if(!groups[d.kategori])groups[d.kategori]=[];groups[d.kategori].push([id,d]);});
    content.innerHTML=['Verbal','Non-Verbal'].filter(k=>groups[k]).map(kat=>{
        const km=KAT_META[kat];
        const cards=groups[kat].map(([id,d],i)=>`
            <div class="jp-card ${kat}" style="animation-delay:${i*.05}s">
                <div class="jp-card-top">
                    <div class="jp-card-top-row">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="jp-card-icon-wrap" style="background:${km.bg}">${km.icon.replace('stroke="currentColor"','stroke="'+km.c+'"')}</div>
                            <div><div class="jp-card-name">${d.nama}</div><span class="jp-card-kat ${kat}">${km.label}</span></div>
                        </div>
                        <div class="jp-card-actions">
                            <button class="btn-aksi edit" onclick="openJpModal('${id}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <button class="btn-aksi delete" onclick="openHapusJp('${id}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </div>
                    </div>
                </div>
                <div class="jp-card-body">
                    <p class="jp-card-desc">${d.deskripsi}</p>
                    ${d.contoh?`<div class="jp-card-contoh"><strong>Contoh Perilaku</strong>${d.contoh}</div>`:''}
                    <div class="jp-card-footer">
                        <span class="jp-urgensi-badge ${d.urgensi}">${d.urgensi.charAt(0).toUpperCase()+d.urgensi.slice(1)}</span>
                        <span class="jp-kasus-count">${d.kasus}x kasus</span>
                        <span class="jp-status-dot ${d.status}">${d.status==='aktif'?'Aktif':'Nonaktif'}</span>
                    </div>
                </div>
            </div>`).join('');
        return `<div class="jp-group">
            <div class="jp-group-header">
                <span class="jp-group-badge ${kat}">${km.icon.replace('stroke="currentColor"','stroke="'+km.c+'"')} ${km.label}</span>
                <div class="jp-group-line"></div>
                <span class="jp-group-count">${groups[kat].length} jenis</span>
            </div>
            <div class="jp-grid">${cards}</div>
        </div>`;
    }).join('');
    const all=Object.values(JP_DATA);
    document.getElementById('statTotal').textContent=all.length;
    document.getElementById('statVerbal').textContent=all.filter(d=>d.kategori==='Verbal').length;
    document.getElementById('statNonVerbal').textContent=all.filter(d=>d.kategori==='Non-Verbal').length;
    document.getElementById('statTotalKasus').textContent=all.reduce((s,d)=>s+d.kasus,0);
}

function updateModalColor(){
    const kat=document.getElementById('jpKategori').value;
    const h=document.getElementById('jpModalHeaderBar');
    const b=document.getElementById('jpBtnSave');
    if(kat==='Non-Verbal'){h.style.background='linear-gradient(135deg,#dc2626,#991b1b)';b.style.background='#dc2626';}
    else{h.style.background='linear-gradient(135deg,#7c3aed,#5b21b6)';b.style.background='#7c3aed';}
}

function openJpModal(id=null){
    _editJpId=id;
    document.getElementById('jpModalTitle').textContent=id?'Edit Jenis Pelanggaran':'Tambah Jenis Pelanggaran';
    if(id){const d=JP_DATA[id];document.getElementById('jpNama').value=d.nama;document.getElementById('jpKategori').value=d.kategori;document.getElementById('jpUrgensi').value=d.urgensi;document.getElementById('jpStatus').value=d.status;document.getElementById('jpDeskripsi').value=d.deskripsi;document.getElementById('jpContoh').value=d.contoh;}
    else{['jpNama','jpDeskripsi','jpContoh'].forEach(i=>document.getElementById(i).value='');document.getElementById('jpKategori').value='';document.getElementById('jpUrgensi').value='sedang';document.getElementById('jpStatus').value='aktif';}
    updateModalColor();
    document.getElementById('modalJp').style.display='flex';
    document.body.style.overflow='hidden';
}
function closeJpModal(){document.getElementById('modalJp').style.display='none';document.body.style.overflow='';}
function saveJp(){
    const nama=document.getElementById('jpNama').value.trim();
    const kategori=document.getElementById('jpKategori').value;
    if(!nama||!kategori){alert('Nama dan Kategori wajib diisi.');return;}
    const data={nama,kategori,urgensi:document.getElementById('jpUrgensi').value,status:document.getElementById('jpStatus').value,deskripsi:document.getElementById('jpDeskripsi').value.trim(),contoh:document.getElementById('jpContoh').value.trim(),kasus:0};
    if(_editJpId){Object.assign(JP_DATA[_editJpId],data);}else{JP_DATA['jp'+(Object.keys(JP_DATA).length+1)]=data;}
    closeJpModal();renderContent();
    if(typeof Toast!=='undefined')Toast.show('success','Berhasil',_editJpId?'Data diperbarui.':'Jenis pelanggaran ditambahkan.');
}
function openHapusJp(id){_hapusJpId=id;document.getElementById('hapusJpNama').textContent=JP_DATA[id]?.nama||id;document.getElementById('modalHapusJp').style.display='flex';document.body.style.overflow='hidden';}
function closeHapusJp(){document.getElementById('modalHapusJp').style.display='none';document.body.style.overflow='';}
function doHapusJp(){if(!_hapusJpId)return;delete JP_DATA[_hapusJpId];closeHapusJp();renderContent();if(typeof Toast!=='undefined')Toast.show('success','Dihapus','Jenis pelanggaran dihapus.');}

document.getElementById('searchInput')?.addEventListener('input',renderContent);
document.getElementById('filterKategori')?.addEventListener('change',renderContent);
document.getElementById('modalJp').addEventListener('click',function(e){if(e.target===this)closeJpModal();});
document.getElementById('modalHapusJp').addEventListener('click',function(e){if(e.target===this)closeHapusJp();});
document.addEventListener('DOMContentLoaded',()=>renderContent());
</script>
@endsection