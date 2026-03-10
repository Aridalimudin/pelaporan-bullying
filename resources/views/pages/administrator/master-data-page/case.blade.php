@extends('layouts.app-admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/report-admin-page.css') }}">
<link rel="stylesheet" href="{{ asset('css/master-admin-page.css') }}">

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
    @include('components.footer', ['type' => 'admin'])
    @include('components.toast')
</div>

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

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script src="{{ asset('js/master-admin-page.js') }}"></script>
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

let _editJpId = null, _hapusJpId = null;

function renderContent() {
    const q   = (document.getElementById('searchInput')?.value  || '').toLowerCase();
    const kf  = (document.getElementById('filterKategori')?.value || '');
    const content = document.getElementById('jpContent');
    const noRes   = document.getElementById('noResults');

    const filtered = Object.entries(JP_DATA).filter(([, d]) =>
        (!q  || d.nama.toLowerCase().includes(q) || d.deskripsi.toLowerCase().includes(q)) &&
        (!kf || d.kategori === kf)
    );

    if (!filtered.length) { content.innerHTML = ''; noRes.classList.remove('hidden'); return; }
    noRes.classList.add('hidden');

    const groups = {};
    filtered.forEach(([id, d]) => { if (!groups[d.kategori]) groups[d.kategori] = []; groups[d.kategori].push([id, d]); });

    content.innerHTML = ['Verbal', 'Non-Verbal'].filter(k => groups[k]).map(kat => {
        const km    = KAT_META[kat];
        const cards = groups[kat].map(([id, d], i) => `
            <div class="jp-card ${kat}" style="animation-delay:${i * .05}s">
                <div class="jp-card-top">
                    <div class="jp-card-top-row">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="jp-card-icon-wrap" style="background:${km.bg}">${km.icon.replace('stroke="currentColor"', 'stroke="' + km.c + '"')}</div>
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
                    ${d.contoh ? `<div class="jp-card-contoh"><strong>Contoh Perilaku</strong>${d.contoh}</div>` : ''}
                    <div class="jp-card-footer">
                        <span class="jp-urgensi-badge ${d.urgensi}">${ucfirst(d.urgensi)}</span>
                        <span class="jp-kasus-count">${d.kasus}x kasus</span>
                        <span class="jp-status-dot ${d.status}">${d.status === 'aktif' ? 'Aktif' : 'Nonaktif'}</span>
                    </div>
                </div>
            </div>`).join('');

        return `<div class="jp-group">
            <div class="jp-group-header">
                <span class="jp-group-badge ${kat}">${km.icon.replace('stroke="currentColor"', 'stroke="' + km.c + '"')} ${km.label}</span>
                <div class="jp-group-line"></div>
                <span class="jp-group-count">${groups[kat].length} jenis</span>
            </div>
            <div class="jp-grid">${cards}</div>
        </div>`;
    }).join('');

    const all = Object.values(JP_DATA);
    document.getElementById('statTotal').textContent      = all.length;
    document.getElementById('statVerbal').textContent     = all.filter(d => d.kategori === 'Verbal').length;
    document.getElementById('statNonVerbal').textContent  = all.filter(d => d.kategori === 'Non-Verbal').length;
    document.getElementById('statTotalKasus').textContent = all.reduce((s, d) => s + d.kasus, 0);
}

function updateModalColor() {
    const kat = document.getElementById('jpKategori').value;
    const h   = document.getElementById('jpModalHeaderBar');
    const b   = document.getElementById('jpBtnSave');
    if (kat === 'Non-Verbal') { h.style.background = 'linear-gradient(135deg,#dc2626,#991b1b)'; b.style.background = '#dc2626'; }
    else                      { h.style.background = 'linear-gradient(135deg,#7c3aed,#5b21b6)'; b.style.background = '#7c3aed'; }
}

function openJpModal(id = null) {
    _editJpId = id;
    document.getElementById('jpModalTitle').textContent = id ? 'Edit Jenis Pelanggaran' : 'Tambah Jenis Pelanggaran';
    if (id) {
        const d = JP_DATA[id];
        document.getElementById('jpNama').value      = d.nama;
        document.getElementById('jpKategori').value  = d.kategori;
        document.getElementById('jpUrgensi').value   = d.urgensi;
        document.getElementById('jpStatus').value    = d.status;
        document.getElementById('jpDeskripsi').value = d.deskripsi;
        document.getElementById('jpContoh').value    = d.contoh;
    } else {
        ['jpNama', 'jpDeskripsi', 'jpContoh'].forEach(i => document.getElementById(i).value = '');
        document.getElementById('jpKategori').value = '';
        document.getElementById('jpUrgensi').value  = 'sedang';
        document.getElementById('jpStatus').value   = 'aktif';
    }
    updateModalColor();
    mdOpenOverlay('modalJp');
}
function closeJpModal()  { mdCloseOverlay('modalJp'); }

function saveJp() {
    const nama     = document.getElementById('jpNama').value.trim();
    const kategori = document.getElementById('jpKategori').value;
    if (!nama || !kategori) { alert('Nama dan Kategori wajib diisi.'); return; }
    const data = { nama, kategori, urgensi: document.getElementById('jpUrgensi').value, status: document.getElementById('jpStatus').value, deskripsi: document.getElementById('jpDeskripsi').value.trim(), contoh: document.getElementById('jpContoh').value.trim(), kasus: 0 };
    if (_editJpId) { Object.assign(JP_DATA[_editJpId], data); }
    else { JP_DATA['jp' + (Object.keys(JP_DATA).length + 1)] = data; }
    closeJpModal(); renderContent();
    if (typeof Toast !== 'undefined') Toast.show('success', 'Berhasil', _editJpId ? 'Data diperbarui.' : 'Jenis pelanggaran ditambahkan.');
}

function openHapusJp(id) { _hapusJpId = id; document.getElementById('hapusJpNama').textContent = JP_DATA[id]?.nama || id; mdOpenOverlay('modalHapusJp'); }
function closeHapusJp()  { mdCloseOverlay('modalHapusJp'); }
function doHapusJp()     { if (!_hapusJpId) return; delete JP_DATA[_hapusJpId]; closeHapusJp(); renderContent(); if (typeof Toast !== 'undefined') Toast.show('success', 'Dihapus', 'Jenis pelanggaran dihapus.'); }

document.getElementById('searchInput')?.addEventListener('input', renderContent);
document.getElementById('filterKategori')?.addEventListener('change', renderContent);
document.getElementById('modalJp').addEventListener('click', function (e) { if (e.target === this) closeJpModal(); });
document.getElementById('modalHapusJp').addEventListener('click', function (e) { if (e.target === this) closeHapusJp(); });
document.addEventListener('DOMContentLoaded', () => renderContent());
</script>
@endsection