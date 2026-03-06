@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">

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
                <button class="td-btn-tambah" onclick="openTdModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Tindakan
                </button>
            </div>
        </div>

        {{-- Stats --}}
        <div class="td-stats-row animate-fade-in" style="animation-delay:.05s">
            <div class="td-stat-card">
                <div class="td-stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="td-stat-val" id="statTotal">9</span>
                    <span class="td-stat-lbl">Total Tindakan</span>
                </div>
            </div>
            <div class="td-stat-card">
                <div class="td-stat-icon" style="background:#f0fdf4;color:#16a34a">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <span class="td-stat-val" id="statRingan">3</span>
                    <span class="td-stat-lbl">Ringan</span>
                </div>
            </div>
            <div class="td-stat-card">
                <div class="td-stat-icon" style="background:#fffbeb;color:#d97706">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <span class="td-stat-val" id="statSedang">4</span>
                    <span class="td-stat-lbl">Sedang</span>
                </div>
            </div>
            <div class="td-stat-card">
                <div class="td-stat-icon" style="background:#fef2f2;color:#dc2626">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div>
                    <span class="td-stat-val" id="statBerat">2</span>
                    <span class="td-stat-lbl">Berat</span>
                </div>
            </div>
        </div>

        {{-- Grouped by Tingkat --}}
        <div id="tdContent" class="animate-fade-in" style="animation-delay:.1s"></div>

        <div class="no-results hidden" id="noResults" style="margin-top:40px">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>Tidak ada tindakan disiplin ditemukan</p>
        </div>

    </main>
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
                </div>
                <div class="td-field">
                    <label class="td-label">Tingkat <span class="td-req">*</span></label>
                    <select class="td-input" id="tdTingkat">
                        <option value="">Pilih Tingkat...</option>
                        <option value="Ringan">Ringan</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Berat">Berat</option>
                    </select>
                </div>
            </div>
            <div class="td-modal-grid2">
                <div class="td-field">
                    <label class="td-label">Durasi / Waktu</label>
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
                <label class="td-label">Deskripsi Tindakan</label>
                <textarea class="td-input" id="tdDeskripsi" rows="3" placeholder="Jelaskan prosedur dan mekanisme tindakan disiplin ini..." style="resize:vertical"></textarea>
            </div>
            <div class="td-field">
                <label class="td-label">Kondisi Penerapan</label>
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
            <button class="td-btn-save" onclick="saveTd()">
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
            <button class="td-btn-hapus" onclick="doHapusTd()">
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

.td-btn-tambah{display:flex;align-items:center;gap:7px;padding:9px 16px;background:#7c3aed;color:white;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .15s;flex-shrink:0;}
.td-btn-tambah svg{width:15px;height:15px;}
.td-btn-tambah:hover{background:#6d28d9;}

/* Stats */
.td-stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:24px;}
@media(max-width:768px){.td-stats-row{grid-template-columns:repeat(2,1fr);}}
.td-stat-card{background:white;border:1.5px solid #f3f4f6;border-radius:14px;padding:16px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 4px rgba(0,0,0,.04);transition:transform .2s,box-shadow .2s;}
.td-stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.07);}
.td-stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.td-stat-icon svg{width:22px;height:22px;}
.td-stat-val{font-size:24px;font-weight:800;color:#111827;display:block;line-height:1;}
.td-stat-lbl{font-size:11px;color:#6b7280;font-weight:500;margin-top:3px;display:block;}

/* Group Section */
.td-group{margin-bottom:28px;}
.td-group-header{display:flex;align-items:center;gap:12px;margin-bottom:14px;}
.td-group-badge{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;padding:5px 14px;border-radius:20px;}
.td-group-badge.Ringan{background:#f0fdf4;color:#16a34a;}
.td-group-badge.Sedang{background:#fffbeb;color:#d97706;}
.td-group-badge.Berat {background:#fef2f2;color:#dc2626;}
.td-group-line{flex:1;height:1px;background:#f3f4f6;}
.td-group-count{font-size:11.5px;color:#9ca3af;font-weight:500;white-space:nowrap;}

/* Tindakan Cards - List style */
.td-list{display:flex;flex-direction:column;gap:10px;}
.td-card{background:white;border:1.5px solid #f3f4f6;border-radius:14px;padding:16px 18px;display:flex;align-items:flex-start;gap:14px;box-shadow:0 1px 4px rgba(0,0,0,.04);transition:box-shadow .2s,transform .2s,border-color .2s;animation:tdIn .3s ease both;}
.td-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);transform:translateY(-1px);}
@keyframes tdIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}

/* Left accent strip */
.td-card.Ringan{border-left:4px solid #16a34a;}
.td-card.Sedang{border-left:4px solid #f59e0b;}
.td-card.Berat {border-left:4px solid #ef4444;}

.td-card-num{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;flex-shrink:0;margin-top:2px;}
.td-card-num.Ringan{background:#f0fdf4;color:#16a34a;}
.td-card-num.Sedang{background:#fffbeb;color:#d97706;}
.td-card-num.Berat {background:#fef2f2;color:#dc2626;}

.td-card-content{flex:1;min-width:0;}
.td-card-name{font-size:14px;font-weight:700;color:#111827;margin-bottom:4px;}
.td-card-desc{font-size:12.5px;color:#6b7280;line-height:1.6;margin-bottom:10px;}
.td-card-meta{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
.td-meta-chip{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:600;padding:3px 10px;border-radius:6px;background:#f3f4f6;color:#374151;}
.td-meta-chip svg{width:11px;height:11px;flex-shrink:0;}
.td-meta-chip.ortua-ya {background:#fff7ed;color:#c2410c;}
.td-meta-chip.ortua-tidak{background:#f0fdf4;color:#16a34a;}

.td-card-actions{display:flex;flex-direction:column;gap:5px;flex-shrink:0;}
.btn-aksi{width:30px;height:30px;border-radius:8px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;}
.btn-aksi svg{width:14px;height:14px;}
.btn-aksi.edit{background:#eff6ff;color:#3b82f6;border:1.5px solid #bfdbfe;}
.btn-aksi.edit:hover{background:#dbeafe;}
.btn-aksi.delete{background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca;}
.btn-aksi.delete:hover{background:#fee2e2;}

/* Modal */
.td-overlay{position:fixed;left:var(--sidebar-width,260px);top:0;right:0;bottom:0;z-index:700;background:rgba(15,23,42,.5);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;}
@media(max-width:768px){.td-overlay{left:0;}}
.td-panel{background:white;border-radius:20px;width:100%;max-width:500px;box-shadow:0 32px 80px rgba(0,0,0,.22);overflow:hidden;animation:tdModalIn .3s cubic-bezier(.16,1,.3,1) both;max-height:90vh;display:flex;flex-direction:column;}
@keyframes tdModalIn{from{opacity:0;transform:translateY(20px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.td-modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:linear-gradient(135deg,#7c3aed,#5b21b6);flex-shrink:0;}
.td-modal-header-left{display:flex;align-items:center;gap:12px;}
.td-modal-icon{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.2);border:1.5px solid rgba(255,255,255,.28);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.td-modal-icon svg{width:20px;height:20px;color:white;}
.td-modal-sub{font-size:.6rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.72);margin-bottom:3px;}
.td-modal-title{font-size:1.05rem;font-weight:800;color:white;}
.td-modal-close{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.22);cursor:pointer;display:flex;align-items:center;justify-content:center;color:white;transition:background .15s;}
.td-modal-close:hover{background:rgba(255,255,255,.28);}
.td-modal-close svg{width:15px;height:15px;}
.td-modal-body{padding:18px 20px;overflow-y:auto;display:flex;flex-direction:column;gap:14px;}
.td-modal-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:480px){.td-modal-grid2{grid-template-columns:1fr;}}
.td-field{display:flex;flex-direction:column;gap:5px;}
.td-label{font-size:11.5px;font-weight:700;color:#374151;letter-spacing:.02em;}
.td-req{color:#ef4444;}
.td-input{padding:9px 12px;border:1.5px solid #e5e7eb;border-radius:9px;font-family:inherit;font-size:13px;color:#111827;background:white;outline:none;transition:border-color .2s,box-shadow .2s;width:100%;box-sizing:border-box;}
.td-input:focus{border-color:#7c3aed;box-shadow:0 0 0 3px rgba(124,58,237,.1);}
.td-modal-footer{display:flex;gap:8px;padding:14px 20px;border-top:1px solid #f3f4f6;background:#fafafa;flex-shrink:0;}
.td-btn-cancel{padding:10px 20px;border-radius:10px;border:1.5px solid #d1d5db;background:white;color:#374151;font-family:inherit;font-size:13px;font-weight:600;cursor:pointer;transition:background .15s;}
.td-btn-cancel:hover{background:#f9fafb;}
.td-btn-save{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#7c3aed;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.td-btn-save svg{width:15px;height:15px;}
.td-btn-save:hover{background:#6d28d9;}
.td-btn-hapus{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border-radius:10px;border:none;background:#ef4444;color:white;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.td-btn-hapus svg{width:15px;height:15px;}
.td-btn-hapus:hover{background:#dc2626;}
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script>
const TD_DATA = {
    'td1': { nama:'Teguran Lisan',             tingkat:'Ringan', durasi:'Saat itu',   pelaksana:'Wali Kelas',      ortua:'tidak', deskripsi:'Teguran secara langsung kepada pelaku untuk menghentikan perilaku bullying dan memberikan peringatan awal.',          kondisi:'Pelanggaran pertama kali dan bersifat ringan.' },
    'td2': { nama:'Surat Peringatan',           tingkat:'Ringan', durasi:'Permanen',   pelaksana:'Wali Kelas',      ortua:'tidak', deskripsi:'Pemberian surat peringatan tertulis yang dicatat dalam buku catatan pelanggaran siswa.',                              kondisi:'Pelanggaran berulang setelah teguran lisan.' },
    'td3': { nama:'Konseling Individual',       tingkat:'Ringan', durasi:'1–3 sesi',   pelaksana:'Guru BK',         ortua:'tidak', deskripsi:'Sesi konseling tatap muka untuk memahami akar masalah dan memberikan pembinaan karakter kepada pelaku.',              kondisi:'Pelanggaran verbal ringan atau pengucilan sosial.' },
    'td4': { nama:'Mediasi dengan Korban',      tingkat:'Sedang', durasi:'1–2 hari',   pelaksana:'Guru BK',         ortua:'opsional', deskripsi:'Pertemuan terfasilitasi antara pelaku dan korban untuk menyelesaikan konflik dan membangun rekonsiliasi.',          kondisi:'Konflik interpersonal yang dapat diselesaikan secara damai.' },
    'td5': { nama:'Pemanggilan Orang Tua',      tingkat:'Sedang', durasi:'1 pertemuan',pelaksana:'Kesiswaan',       ortua:'ya',    deskripsi:'Pemanggilan resmi orang tua/wali untuk berdiskusi mengenai perilaku siswa dan menyusun rencana perbaikan bersama.',  kondisi:'Pelanggaran sedang atau berulang.' },
    'td6': { nama:'Skorsing 1–3 Hari',          tingkat:'Sedang', durasi:'1–3 hari',   pelaksana:'Kepala Sekolah',  ortua:'ya',    deskripsi:'Pemberhentian sementara dari kegiatan sekolah selama 1–3 hari sebagai konsekuensi atas pelanggaran yang serius.',     kondisi:'Pelanggaran fisik ringan atau bullying verbal yang berulang.' },
    'td7': { nama:'Pembinaan Intensif BK',      tingkat:'Sedang', durasi:'2 minggu',   pelaksana:'Guru BK',         ortua:'ya',    deskripsi:'Program pembinaan karakter intensif oleh Guru BK yang meliputi konseling, refleksi, dan kegiatan sosial positif.',     kondisi:'Pelaku dengan pola perilaku agresif berulang.' },
    'td8': { nama:'Skorsing 1–2 Minggu',        tingkat:'Berat',  durasi:'1–2 minggu', pelaksana:'Kepala Sekolah',  ortua:'ya',    deskripsi:'Pemberhentian sementara jangka panjang dengan kewajiban orang tua menandatangani surat pernyataan kesanggupan.',      kondisi:'Kekerasan fisik berat atau intimidasi serius yang terdokumentasi.' },
    'td9': { nama:'Dikeluarkan dari Sekolah',   tingkat:'Berat',  durasi:'Permanen',   pelaksana:'Kepala Sekolah',  ortua:'ya',    deskripsi:'Pengeluaran permanen dari sekolah sebagai tindakan terakhir atas pelanggaran berat yang mengancam keselamatan siswa.', kondisi:'Kekerasan ekstrem, ancaman berbahaya, atau pelanggaran berulang setelah semua tindakan.' },
};

let _editTdId=null,_hapusTdId=null;

function renderContent(){
    const q=(document.getElementById('searchInput')?.value||'').toLowerCase();
    const tf=(document.getElementById('filterTingkat')?.value||'');
    const content=document.getElementById('tdContent');
    const noRes=document.getElementById('noResults');

    const filtered=Object.entries(TD_DATA).filter(([,d])=>(!q||d.nama.toLowerCase().includes(d.deskripsi.toLowerCase().includes(q)||d.nama.toLowerCase().includes(q)))&&(!tf||d.tingkat===tf));
    const filteredAll=Object.entries(TD_DATA).filter(([,d])=>(!q||d.nama.toLowerCase().includes(q)||d.deskripsi.toLowerCase().includes(q))&&(!tf||d.tingkat===tf));

    if(!filteredAll.length){content.innerHTML='';noRes.classList.remove('hidden');return;}
    noRes.classList.add('hidden');

    const ORDER=['Ringan','Sedang','Berat'];
    const groups={};
    filteredAll.forEach(([id,d])=>{
        if(!groups[d.tingkat])groups[d.tingkat]=[];
        groups[d.tingkat].push([id,d]);
    });

    content.innerHTML=ORDER.filter(t=>groups[t]).map(tingkat=>{
        const items=groups[tingkat];
        const cards=items.map(([id,d],i)=>`
            <div class="td-card ${d.tingkat}" style="animation-delay:${i*.05}s">
                <div class="td-card-num ${d.tingkat}">${i+1}</div>
                <div class="td-card-content">
                    <div class="td-card-name">${d.nama}</div>
                    <p class="td-card-desc">${d.deskripsi}</p>
                    <div class="td-card-meta">
                        <span class="td-meta-chip">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            ${d.durasi}
                        </span>
                        <span class="td-meta-chip">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            ${d.pelaksana}
                        </span>
                        <span class="td-meta-chip ortua-${d.ortua==='ya'?'ya':'tidak'}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Ortu: ${d.ortua==='ya'?'Wajib':d.ortua==='opsional'?'Opsional':'Tidak'}
                        </span>
                    </div>
                </div>
                <div class="td-card-actions">
                    <button class="btn-aksi edit" title="Edit" onclick="openTdModal('${id}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                    <button class="btn-aksi delete" title="Hapus" onclick="openHapusTd('${id}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </div>
            </div>`).join('');

        return `<div class="td-group">
            <div class="td-group-header">
                <span class="td-group-badge ${tingkat}">${tingkat}</span>
                <div class="td-group-line"></div>
                <span class="td-group-count">${items.length} tindakan</span>
            </div>
            <div class="td-list">${cards}</div>
        </div>`;
    }).join('');

    // Update stats
    document.getElementById('statTotal').textContent=Object.keys(TD_DATA).length;
    ['Ringan','Sedang','Berat'].forEach(t=>{
        const el=document.getElementById('stat'+t);
        if(el) el.textContent=Object.values(TD_DATA).filter(d=>d.tingkat===t).length;
    });
}

function openTdModal(id=null){
    _editTdId=id;
    document.getElementById('tdModalTitle').textContent=id?'Edit Tindakan Disiplin':'Tambah Tindakan Disiplin';
    if(id){
        const d=TD_DATA[id];
        document.getElementById('tdNama').value=d.nama;
        document.getElementById('tdTingkat').value=d.tingkat;
        document.getElementById('tdDurasi').value=d.durasi;
        document.getElementById('tdPelaksana').value=d.pelaksana;
        document.getElementById('tdDeskripsi').value=d.deskripsi;
        document.getElementById('tdKondisi').value=d.kondisi;
        document.getElementById('tdOrtua').value=d.ortua;
    } else {
        ['tdNama','tdDurasi','tdDeskripsi','tdKondisi'].forEach(i=>document.getElementById(i).value='');
        document.getElementById('tdTingkat').value='';
        document.getElementById('tdPelaksana').value='Guru BK';
        document.getElementById('tdOrtua').value='tidak';
    }
    document.getElementById('modalTd').style.display='flex';
    document.body.style.overflow='hidden';
}
function closeTdModal(){document.getElementById('modalTd').style.display='none';document.body.style.overflow='';}

function saveTd(){
    const nama=document.getElementById('tdNama').value.trim();
    const tingkat=document.getElementById('tdTingkat').value;
    if(!nama||!tingkat){alert('Nama dan Tingkat wajib diisi.');return;}
    const data={nama,tingkat,durasi:document.getElementById('tdDurasi').value.trim(),pelaksana:document.getElementById('tdPelaksana').value,deskripsi:document.getElementById('tdDeskripsi').value.trim(),kondisi:document.getElementById('tdKondisi').value.trim(),ortua:document.getElementById('tdOrtua').value};
    if(_editTdId){Object.assign(TD_DATA[_editTdId],data);}
    else{const newId='td'+(Object.keys(TD_DATA).length+1);TD_DATA[newId]=data;}
    closeTdModal(); renderContent();
    if(typeof Toast!=='undefined')Toast.show('success','Berhasil',_editTdId?'Tindakan disiplin diperbarui.':'Tindakan disiplin ditambahkan.');
}

function openHapusTd(id){_hapusTdId=id;document.getElementById('hapusTdNama').textContent=TD_DATA[id]?.nama||id;document.getElementById('modalHapusTd').style.display='flex';document.body.style.overflow='hidden';}
function closeHapusTd(){document.getElementById('modalHapusTd').style.display='none';document.body.style.overflow='';}
function doHapusTd(){if(!_hapusTdId)return;delete TD_DATA[_hapusTdId];closeHapusTd();renderContent();if(typeof Toast!=='undefined')Toast.show('success','Dihapus','Tindakan disiplin dihapus.');}

document.getElementById('searchInput')?.addEventListener('input',renderContent);
document.getElementById('filterTingkat')?.addEventListener('change',renderContent);
document.getElementById('modalTd').addEventListener('click',function(e){if(e.target===this)closeTdModal();});
document.getElementById('modalHapusTd').addEventListener('click',function(e){if(e.target===this)closeHapusTd();});
document.addEventListener('DOMContentLoaded',()=>renderContent());
</script>
@endsection