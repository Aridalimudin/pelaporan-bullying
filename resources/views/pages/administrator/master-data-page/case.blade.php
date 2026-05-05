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
                <p class="content-sub">Kelola jenis pelanggaran bullying verbal dan Fisik dalam sistem pelaporan.</p>
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
                    <option value="Fisik">Bullying Fisik</option>
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
                    <span class="jp-stat-lbl">Bullying Fisik</span>
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
                    {{-- Pesan error muncul di sini secara dinamis --}}
                </div>
                <div class="jp-field">
                    <label class="jp-label">Kategori <span class="jp-req">*</span></label>
                    <select class="jp-input" id="jpKategori">
                        <option value="">Pilih Kategori...</option>
                        <option value="Verbal">Bullying Verbal</option>
                        <option value="Fisik">Bullying Fisik</option>
                    </select>
                    {{-- Pesan error muncul di sini secara dinamis --}}
                </div>
            </div>
            <div class="jp-field">
                <label class="jp-label">Bobot / Poin <span class="jp-req">*</span></label>
                <input class="jp-input" type="number" id="jpBobot" min="1" max="20" placeholder="Contoh: 5">
            </div>
            <div class="jp-field">
                <label class="jp-label">Deskripsi <span style="font-size:10.5px;color:#9ca3af;font-weight:500">(opsional)</span></label>
                <textarea class="jp-input" id="jpDeskripsi" rows="3" placeholder="Jelaskan definisi dan ciri-ciri pelanggaran ini..." style="resize:vertical"></textarea>
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
            <button class="jp-btn-hapus" id="btnDoHapusJp" onclick="doHapusJp()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<style>
.btn-loading{opacity:.6;pointer-events:none;cursor:not-allowed}

/* ── Validasi Inline — sama persis dengan halaman Data Siswa ── */
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
.jp-req { color: #ef4444; }
</style>

<script src="{{ asset('js/report-admin-page.js') }}"></script>
<script src="{{ asset('js/master-admin-page.js') }}"></script>
<script>
/* ─────────────────────────────────────────
   API ENDPOINTS
───────────────────────────────────────── */
var API_JP_LIST   = '{{ route("violation-types.api.list") }}';
var API_JP_SAVE   = '{{ route("violation-types.api.save") }}';
var API_JP_DELETE = '{{ route("violation-types.api.delete", ":id") }}'.replace('/:id', '');
/* ─────────────────────────────────────────
   CSRF TOKEN
───────────────────────────────────────── */
var CSRF_TOKEN_JP = document.querySelector('meta[name="csrf-token"]')
    ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

/* ─────────────────────────────────────────
   FETCH HELPER
───────────────────────────────────────── */
async function apiFetchJp(url, options) {
    options = options || {};
    var headers = options.headers || {};
    headers['X-CSRF-TOKEN'] = CSRF_TOKEN_JP;
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
        console.error('[apiFetchJp]', url, err);
        return { status: 'error', message: 'Terjadi kesalahan jaringan.' };
    }
}

/* ─────────────────────────────────────────
   STATE
───────────────────────────────────────── */
var _jpAll     = [];
var _editJpId  = null;
var _hapusJpId = null;

var KAT_META = {
    'Verbal':     { bg:'#fdf4ff', c:'#7c3aed', label:'Bullying Verbal',
        icon:'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>' },
    'Fisik':  { bg:'#fef2f2', c:'#dc2626', label:'Bullying Fisik',
        icon:'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>' }
};

var SVG_EDIT   = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>';
var SVG_DELETE = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';

/* ─────────────────────────────────────────
   VALIDASI INLINE — Jenis Pelanggaran
   (Deskripsi dikecualikan karena opsional)
───────────────────────────────────────── */
function jpSetError(fieldId, message) {
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

function jpClearError(fieldId) {
    var field = document.getElementById(fieldId);
    if (field) field.classList.remove('sm-input-error');
    var errEl = document.getElementById(fieldId + '_err');
    if (errEl) errEl.style.display = 'none';
}

function jpClearAllErrors() {
    ['jpNama', 'jpKategori', 'jpBobot'].forEach(function(id) { jpClearError(id); });
}

function jpValidateAll() {
    jpClearAllErrors();
    var valid = true;

    var nama     = (document.getElementById('jpNama').value     || '').trim();
    var kategori = (document.getElementById('jpKategori').value || '').trim();

    // ── Nama: wajib, minimal 3 karakter ──
    if (!nama) {
        jpSetError('jpNama', 'Nama pelanggaran wajib diisi.');
        valid = false;
    } else if (nama.length < 3) {
        jpSetError('jpNama', 'Nama pelanggaran minimal 3 karakter.');
        valid = false;
    }

    // ── Kategori: wajib dipilih ──
    if (!kategori) {
        jpSetError('jpKategori', 'Kategori wajib dipilih.');
        valid = false;
    }

    // ── Bobot: wajib, minimal 1 ──
    var bobot = parseInt(document.getElementById('jpBobot').value);
    if (!bobot || bobot < 1) {
        jpSetError('jpBobot', 'Bobot wajib diisi minimal 1.');
        valid = false;
    }

    return valid;
}

/* ─────────────────────────────────────────
   LOAD FROM DB
───────────────────────────────────────── */
async function loadJp() {
    var res = await apiFetchJp(API_JP_LIST);
    _jpAll  = Array.isArray(res) ? res : [];
    renderContent();
}

/* ─────────────────────────────────────────
   RENDER
───────────────────────────────────────── */
function renderContent() {
    var q       = (document.getElementById('searchInput').value || '').toLowerCase();
    var kf      = document.getElementById('filterKategori').value || '';
    var content = document.getElementById('jpContent');
    var noRes   = document.getElementById('noResults');

    var filtered = _jpAll.filter(function(d) {
        return (!q  || d.name.toLowerCase().indexOf(q) !== -1 || (d.description || '').toLowerCase().indexOf(q) !== -1) &&
               (!kf || d.category === kf);
    });

    if (!filtered.length) { content.innerHTML = ''; noRes.classList.remove('hidden'); updateStats(); return; }
    noRes.classList.add('hidden');

    var groups = {};
    filtered.forEach(function(d) {
        if (!groups[d.category]) groups[d.category] = [];
        groups[d.category].push(d);
    });

    content.innerHTML = ['Verbal', 'Fisik'].filter(function(k) { return groups[k]; }).map(function(kat) {
        var km           = KAT_META[kat];
        var iconColored  = km.icon.replace('stroke="currentColor"', 'stroke="' + km.c + '"');

        var cards = groups[kat].map(function(d, i) {
            var namaSafe = (d.name || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'");
            return '<div class="jp-card ' + kat + '" style="animation-delay:' + (i * 0.05) + 's">' +
                '<div class="jp-card-top">' +
                    '<div class="jp-card-top-row">' +
                        '<div style="display:flex;align-items:center;gap:10px">' +
                            '<div class="jp-card-icon-wrap" style="background:' + km.bg + '">' + iconColored + '</div>' +
                            '<div>' +
                                '<div class="jp-card-name">' + d.name + '</div>' +
                                '<span class="jp-card-kat ' + kat + '">' + km.label + '</span>' +
                            '</div>' +
                        '</div>' +
                        '<div class="jp-card-actions">' +
                            '<button class="btn-aksi edit" onclick="openJpModal(' + d.id + ')">' + SVG_EDIT + '</button>' +
                            '<button class="btn-aksi delete" onclick="openHapusJp(' + d.id + ', \'' + namaSafe + '\')">' + SVG_DELETE + '</button>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="jp-card-body">' +
                    '<p class="jp-card-desc">' + (d.description || '<em style="color:#d1d5db">Tidak ada deskripsi</em>') + '</p>' +
                '</div>' +
            '</div>';
        }).join('');

        return '<div class="jp-group">' +
            '<div class="jp-group-header">' +
                '<span class="jp-group-badge ' + kat + '">' + iconColored + ' ' + km.label + '</span>' +
                '<div class="jp-group-line"></div>' +
                '<span class="jp-group-count">' + groups[kat].length + ' jenis</span>' +
            '</div>' +
            '<div class="jp-grid">' + cards + '</div>' +
        '</div>';
    }).join('');

    updateStats();
}

function updateStats() {
    document.getElementById('statTotal').textContent     = _jpAll.length;
    document.getElementById('statVerbal').textContent    = _jpAll.filter(function(d) { return d.category === 'Verbal'; }).length;
    document.getElementById('statNonVerbal').textContent = _jpAll.filter(function(d) { return d.category === 'Fisik'; }).length;
}

/* ─────────────────────────────────────────
   MODAL WARNA
───────────────────────────────────────── */
function updateModalColor() {
    var kat = document.getElementById('jpKategori').value;
    var h   = document.getElementById('jpModalHeaderBar');
    var b   = document.getElementById('jpBtnSave');
    if (kat === 'Fisik') {
        h.style.background = 'linear-gradient(135deg,#dc2626,#991b1b)';
        b.style.background = '#dc2626';
    } else {
        h.style.background = 'linear-gradient(135deg,#7c3aed,#5b21b6)';
        b.style.background = '#7c3aed';
    }
}

/* ─────────────────────────────────────────
   MODAL TAMBAH / EDIT
───────────────────────────────────────── */
function openJpModal(id) {
    id = id || null;
    _editJpId = id;
    document.getElementById('jpModalTitle').textContent = id ? 'Edit Jenis Pelanggaran' : 'Tambah Jenis Pelanggaran';

    // Bersihkan semua error setiap kali modal dibuka
    jpClearAllErrors();

    if (id) {
        var d = _jpAll.find(function(x) { return x.id == id; });
    if (d) {
            document.getElementById('jpNama').value      = d.name;
            document.getElementById('jpKategori').value  = d.category;
            document.getElementById('jpBobot').value     = d.weight || '';
            document.getElementById('jpDeskripsi').value = d.description || '';
        }
    } else {
            document.getElementById('jpNama').value      = '';
            document.getElementById('jpKategori').value  = '';
            document.getElementById('jpBobot').value     = '';
            document.getElementById('jpDeskripsi').value = '';
        }
    updateModalColor();
    mdOpenOverlay('modalJp');
}

function closeJpModal() {
    // Bersihkan error saat modal ditutup
    jpClearAllErrors();
    mdCloseOverlay('modalJp');
}

async function saveJp() {
    // Validasi client-side dulu — jika ada error, hentikan dan scroll ke field bermasalah
    if (!jpValidateAll()) {
        var firstErr = document.querySelector('.sm-input-error');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    var btn = document.getElementById('jpBtnSave');
    btn.classList.add('btn-loading');
    btn.textContent = 'Menyimpan...';

    var res = await apiFetchJp(API_JP_SAVE, {
        method : 'POST',
        body   : {
            id          : _editJpId || null,
            name        : document.getElementById('jpNama').value.trim(),
            category    : document.getElementById('jpKategori').value,
            weight      : parseInt(document.getElementById('jpBobot').value) || 1,
            description : document.getElementById('jpDeskripsi').value.trim()
        }
    });

    btn.classList.remove('btn-loading');
    btn.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Simpan';

    if (res.status === 'success') {
        closeJpModal();
        await loadJp();
        if (typeof Toast !== 'undefined') Toast.show('success', 'Berhasil', _editJpId ? 'Data diperbarui.' : 'Jenis pelanggaran ditambahkan.');
    } else {
        // Tampilkan error validasi dari server (Laravel) secara inline per field
        if (res.errors) {
            var fieldMap = { name: 'jpNama', category: 'jpKategori' };
            Object.keys(res.errors).forEach(function(key) {
                var htmlId = fieldMap[key];
                if (htmlId) jpSetError(htmlId, res.errors[key][0]);
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
function openHapusJp(id, nama) {
    _hapusJpId = id;
    document.getElementById('hapusJpNama').textContent = nama || id;
    mdOpenOverlay('modalHapusJp');
}

function closeHapusJp() { mdCloseOverlay('modalHapusJp'); }

async function doHapusJp() {
    if (!_hapusJpId) return;
    var btn = document.getElementById('btnDoHapusJp');
    btn.classList.add('btn-loading');
    btn.textContent = 'Menghapus...';

    var res = await apiFetchJp(API_JP_DELETE + '/' + _hapusJpId, { method: 'DELETE' });

    btn.classList.remove('btn-loading');
    btn.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Ya, Hapus';

    if (res.status === 'success') {
        closeHapusJp();
        await loadJp();
        if (typeof Toast !== 'undefined') Toast.show('success', 'Dihapus', 'Jenis pelanggaran dihapus.');
    } else {
        alert(res.message || 'Gagal menghapus.');
    }
}

/* ─────────────────────────────────────────
   EVENT LISTENERS & INIT
───────────────────────────────────────── */
document.getElementById('searchInput').addEventListener('input', renderContent);
document.getElementById('filterKategori').addEventListener('change', renderContent);
document.getElementById('modalJp').addEventListener('click', function(e) { if (e.target === this) closeJpModal(); });
document.getElementById('modalHapusJp').addEventListener('click', function(e) { if (e.target === this) closeHapusJp(); });

// Listener realtime: error hilang otomatis saat user mengetik / memilih
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('jpNama').addEventListener('input', function() {
        jpClearError('jpNama');
    });
        document.getElementById('jpBobot').addEventListener('input', function() {
        jpClearError('jpBobot');
    });
    document.getElementById('jpKategori').addEventListener('change', function() {
        jpClearError('jpKategori');
        updateModalColor(); // tetap update warna header saat pilih kategori
    });

    loadJp();
});
</script>
@endsection