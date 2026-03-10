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
                    <option value="X">Kelas X</option>
                    <option value="XI">Kelas XI</option>
                    <option value="XII">Kelas XII</option>
                </select>
                <select class="filter-select" id="filterJurusan">
                    <option value="">Semua Jurusan</option>
                    <option value="RPL">RPL</option>
                    <option value="TKJ">TKJ</option>
                    <option value="MM">MM</option>
                    <option value="AKL">AKL</option>
                </select>
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
            <div class="sm-grid3">
                <div class="sm-field">
                    <label class="sm-label">Tingkat <span class="sm-req">*</span></label>
                    <select class="sm-input" id="smTingkat">
                        <option value="">Pilih...</option>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select>
                </div>
                <div class="sm-field">
                    <label class="sm-label">Jurusan <span class="sm-req">*</span></label>
                    <select class="sm-input" id="smJurusan">
                        <option value="">Pilih...</option>
                        <option value="RPL">RPL</option>
                        <option value="TKJ">TKJ</option>
                        <option value="MM">MM</option>
                        <option value="AKL">AKL</option>
                    </select>
                </div>
                <div class="sm-field">
                    <label class="sm-label">Rombel</label>
                    <input class="sm-input" type="text" id="smRombel" placeholder="Cth: 1">
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
                    <label class="sm-label">No. HP / WA</label>
                    <input class="sm-input" type="text" id="smHp" placeholder="Contoh: 08123456789">
                </div>
            </div>
            <div class="sm-field">
                <label class="sm-label">Email Siswa</label>
                <input class="sm-input" type="email" id="smEmail" placeholder="Contoh: siswa@student.smkm3.sch.id">
            </div>
        </div>
        <div class="sm-footer">
            <button class="sm-btn-cancel" onclick="closeSiswaModal()">Batal</button>
            <button class="sm-btn-save" onclick="saveSiswa()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Simpan
            </button>
        </div>
    </div>
</div>

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
            <button class="sm-btn-hapus" onclick="doHapusSiswa()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script src="{{ asset('js/master-admin-page.js') }}"></script>
<script>
const SISWA_DATA = {
    's1':  { nama:'Ahmad Fauzi',      nis:'11001', tingkat:'X',   jurusan:'RPL', rombel:'1', jk:'L', hp:'081234567890', email:'ahmad.f@student.smkm3.sch.id',  riwayat:0 },
    's2':  { nama:'Siti Rahayu',      nis:'11002', tingkat:'X',   jurusan:'TKJ', rombel:'2', jk:'P', hp:'082345678901', email:'siti.r@student.smkm3.sch.id',   riwayat:1 },
    's3':  { nama:'Budi Santoso',     nis:'11003', tingkat:'X',   jurusan:'MM',  rombel:'1', jk:'L', hp:'083456789012', email:'budi.s@student.smkm3.sch.id',   riwayat:0 },
    's4':  { nama:'Dewi Kusuma',      nis:'11004', tingkat:'XI',  jurusan:'AKL', rombel:'1', jk:'P', hp:'084567890123', email:'dewi.k@student.smkm3.sch.id',   riwayat:2 },
    's5':  { nama:'Rizky Firmansyah', nis:'11005', tingkat:'XI',  jurusan:'RPL', rombel:'2', jk:'L', hp:'085678901234', email:'rizky.f@student.smkm3.sch.id',  riwayat:1 },
    's6':  { nama:'Nurul Aini',       nis:'11006', tingkat:'XI',  jurusan:'TKJ', rombel:'1', jk:'P', hp:'086789012345', email:'nurul.a@student.smkm3.sch.id',  riwayat:0 },
    's7':  { nama:'Arif Hidayat',     nis:'11007', tingkat:'XII', jurusan:'MM',  rombel:'2', jk:'L', hp:'087890123456', email:'arif.h@student.smkm3.sch.id',   riwayat:3 },
    's8':  { nama:'Anggi Permata',    nis:'11008', tingkat:'XII', jurusan:'AKL', rombel:'1', jk:'P', hp:'088901234567', email:'anggi.p@student.smkm3.sch.id',  riwayat:1 },
    's9':  { nama:'Dimas Saputra',    nis:'11009', tingkat:'X',   jurusan:'RPL', rombel:'1', jk:'L', hp:'089012345678', email:'dimas.s@student.smkm3.sch.id',  riwayat:0 },
    's10': { nama:'Putri Handayani',  nis:'11010', tingkat:'XI',  jurusan:'TKJ', rombel:'2', jk:'P', hp:'081123456789', email:'putri.h@student.smkm3.sch.id',  riwayat:1 },
    's11': { nama:'Bagas Pratama',    nis:'11011', tingkat:'XII', jurusan:'MM',  rombel:'1', jk:'L', hp:'082234567890', email:'bagas.p@student.smkm3.sch.id',  riwayat:0 },
    's12': { nama:'Rina Marlina',     nis:'11012', tingkat:'X',   jurusan:'AKL', rombel:'2', jk:'P', hp:'083345678901', email:'rina.m@student.smkm3.sch.id',   riwayat:2 },
};

const AV_COLORS = [
    { bg:'#dcfce7', c:'#15803d' }, { bg:'#dbeafe', c:'#1d4ed8' }, { bg:'#fce7f3', c:'#be185d' },
    { bg:'#fff7ed', c:'#c2410c' }, { bg:'#fdf4ff', c:'#7e22ce' }, { bg:'#fef9c3', c:'#854d0e' },
];
function avColor(i) { return AV_COLORS[i % AV_COLORS.length]; }

const PER_PAGE = 10;
let _all = Object.keys(SISWA_DATA), _filtered = [..._all], _page = 1, _editId = null, _hapusId = null;

function renderTable() {
    const tbody = document.getElementById('tableBody');
    const noRes = document.getElementById('noResults');
    const start = (_page - 1) * PER_PAGE;
    const rows  = _filtered.slice(start, start + PER_PAGE);

    if (!_filtered.length) { tbody.innerHTML = ''; noRes.classList.remove('hidden'); return; }
    noRes.classList.add('hidden');

    tbody.innerHTML = rows.map((id, i) => {
        const d = SISWA_DATA[id], av = avColor(i);
        const kelas = `${d.tingkat} ${d.jurusan}-${d.rombel}`;
        return `<tr class="table-row" id="${id}">
            <td class="col-no">${start + i + 1}</td>
            <td>
                <div class="pelapor-cell">
                    <div class="pelapor-avatar" style="background:${av.bg};color:${av.c}">${d.nama.charAt(0)}</div>
                    <div>
                        <div style="font-weight:600;font-size:13px;color:#111827">${d.nama}</div>
                        <div style="font-size:11px;color:#9ca3af">${d.email}</div>
                    </div>
                </div>
            </td>
            <td><span class="kode-badge">${d.nis}</span></td>
            <td><span class="kelas-tag">${kelas}</span></td>
            <td style="font-size:12.5px;font-weight:600;color:#374151">${d.jurusan}</td>
            <td><span class="jk-badge ${d.jk}">${d.jk === 'L' ? 'Laki-laki' : 'Perempuan'}</span></td>
            <td style="font-size:12px;color:#6b7280;font-family:monospace">${d.hp || '—'}</td>
            <td>
                ${d.riwayat > 0
                    ? `<span class="riwayat-badge ada">⚠ ${d.riwayat}x Laporan</span>`
                    : `<span class="riwayat-badge bersih">✓ Bersih</span>`}
            </td>
            <td class="col-aksi">
                <div class="aksi-wrap">
                    <button class="btn-aksi edit" title="Edit" onclick="openSiswaModal('${id}')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button class="btn-aksi delete" title="Hapus" onclick="openHapusSiswa('${id}')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');

    buildTableInfo(document.getElementById('tableInfo'), _page, _filtered, PER_PAGE, 'siswa');
    buildPagination(document.getElementById('paginationWrap'), _page, _filtered.length, PER_PAGE, goPage);

    const all = Object.keys(SISWA_DATA);
    document.getElementById('statTotal').textContent      = all.length;
    const kelasSet = new Set(all.map(id => SISWA_DATA[id].tingkat + SISWA_DATA[id].jurusan + SISWA_DATA[id].rombel));
    document.getElementById('statKelas').textContent      = kelasSet.size;
    document.getElementById('statPernahLapor').textContent = all.filter(id => SISWA_DATA[id].riwayat > 0).length;
    document.getElementById('statPelaku').textContent     = all.filter(id => SISWA_DATA[id].riwayat >= 2).length;
}

function goPage(p) {
    const total = Math.ceil(_filtered.length / PER_PAGE);
    if (p < 1 || p > total) return;
    _page = p; renderTable();
}

function applyFilter() {
    const q  = (document.getElementById('searchInput')?.value   || '').toLowerCase();
    const tk = (document.getElementById('filterKelas')?.value   || '');
    const jr = (document.getElementById('filterJurusan')?.value || '');
    _filtered = _all.filter(id => {
        const d = SISWA_DATA[id];
        return (!q || d.nama.toLowerCase().includes(q) || d.nis.includes(q)) &&
               (!tk || d.tingkat === tk) &&
               (!jr || d.jurusan === jr);
    });
    _page = 1; renderTable();
}

function updateSmAvatar() {
    const n = document.getElementById('smNama')?.value || '';
    document.getElementById('smAvatar').textContent = n.trim().charAt(0).toUpperCase() || '?';
}

function openSiswaModal(id = null) {
    _editId = id;
    document.getElementById('smTitle').textContent = id ? 'Edit Data Siswa' : 'Tambah Siswa Baru';
    if (id) {
        const d = SISWA_DATA[id];
        document.getElementById('smNama').value    = d.nama;
        document.getElementById('smNis').value     = d.nis;
        document.getElementById('smTingkat').value = d.tingkat;
        document.getElementById('smJurusan').value = d.jurusan;
        document.getElementById('smRombel').value  = d.rombel;
        document.getElementById('smJK').value      = d.jk;
        document.getElementById('smHp').value      = d.hp;
        document.getElementById('smEmail').value   = d.email;
        document.getElementById('smAvatar').textContent = d.nama.charAt(0);
    } else {
        ['smNama', 'smNis', 'smRombel', 'smHp', 'smEmail'].forEach(i => document.getElementById(i).value = '');
        document.getElementById('smTingkat').value = '';
        document.getElementById('smJurusan').value = '';
        document.getElementById('smJK').value      = 'L';
        document.getElementById('smAvatar').textContent = '?';
    }
    mdOpenOverlay('modalSiswa');
}
function closeSiswaModal() { mdCloseOverlay('modalSiswa'); }

function saveSiswa() {
    const nama    = document.getElementById('smNama').value.trim();
    const nis     = document.getElementById('smNis').value.trim();
    const tingkat = document.getElementById('smTingkat').value;
    const jurusan = document.getElementById('smJurusan').value;
    if (!nama || !nis || !tingkat || !jurusan) { alert('Nama, NIS, Tingkat, dan Jurusan wajib diisi.'); return; }
    const data = { nama, nis, tingkat, jurusan, rombel: document.getElementById('smRombel').value.trim() || '1', jk: document.getElementById('smJK').value, hp: document.getElementById('smHp').value.trim(), email: document.getElementById('smEmail').value.trim(), riwayat: 0 };
    if (_editId) { Object.assign(SISWA_DATA[_editId], data); }
    else { const newId = 's' + (Object.keys(SISWA_DATA).length + 1); SISWA_DATA[newId] = data; _all = Object.keys(SISWA_DATA); }
    closeSiswaModal(); applyFilter();
    if (typeof Toast !== 'undefined') Toast.show('success', 'Berhasil', _editId ? 'Data siswa diperbarui.' : 'Siswa baru ditambahkan.');
}

function openHapusSiswa(id) { _hapusId = id; document.getElementById('hapusSiswaNama').textContent = SISWA_DATA[id]?.nama || id; mdOpenOverlay('modalHapusSiswa'); }
function closeHapusSiswa()  { mdCloseOverlay('modalHapusSiswa'); }
function doHapusSiswa()     { if (!_hapusId) return; delete SISWA_DATA[_hapusId]; _all = Object.keys(SISWA_DATA); closeHapusSiswa(); applyFilter(); if (typeof Toast !== 'undefined') Toast.show('success', 'Dihapus', 'Data siswa berhasil dihapus.'); }

document.getElementById('searchInput')?.addEventListener('input', applyFilter);
document.getElementById('filterKelas')?.addEventListener('change', applyFilter);
document.getElementById('filterJurusan')?.addEventListener('change', applyFilter);
document.getElementById('modalSiswa').addEventListener('click', function (e) { if (e.target === this) closeSiswaModal(); });
document.getElementById('modalHapusSiswa').addEventListener('click', function (e) { if (e.target === this) closeHapusSiswa(); });
document.addEventListener('DOMContentLoaded', () => renderTable());
</script>
@endsection