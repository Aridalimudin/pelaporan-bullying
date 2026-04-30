function makePagBtn(label, disabled, fn) {
    const b = document.createElement('button');
    b.className   = 'page-btn';
    b.textContent = label;
    b.disabled    = disabled;
    if (disabled) b.style.opacity = '.4';
    b.addEventListener('click', fn);
    return b;
}

function getPageNumbers(total, currentPage) {
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    const p = [];
    if (currentPage <= 4) {
        for (let i = 1; i <= 5; i++) p.push(i);
        p.push('...'); p.push(total);
    } else if (currentPage >= total - 3) {
        p.push(1); p.push('...');
        for (let i = total - 4; i <= total; i++) p.push(i);
    } else {
        p.push(1); p.push('...');
        for (let i = currentPage - 1; i <= currentPage + 1; i++) p.push(i);
        p.push('...'); p.push(total);
    }
    return p;
}

function buildPagination(wrap, currentPage, filteredCount, perPage, goPageFn) {
    if (!wrap) return;
    const total = Math.ceil(filteredCount / perPage);
    wrap.innerHTML = '';
    if (total <= 1) return;

    wrap.appendChild(makePagBtn('‹', currentPage === 1, () => goPageFn(currentPage - 1)));
    getPageNumbers(total, currentPage).forEach(p => {
        if (p === '...') {
            const s = document.createElement('span');
            s.className   = 'page-ellipsis';
            s.textContent = '...';
            wrap.appendChild(s);
        } else {
            const b = makePagBtn(p, false, () => goPageFn(p));
            if (p === currentPage) b.classList.add('active');
            wrap.appendChild(b);
        }
    });
    wrap.appendChild(makePagBtn('›', currentPage === total, () => goPageFn(currentPage + 1)));
}

function buildTableInfo(el, currentPage, filteredRows, perPage, satuan = 'data') {
    if (!el) return;
    const s = (currentPage - 1) * perPage + 1;
    const e = Math.min(currentPage * perPage, filteredRows.length);
    el.textContent = filteredRows.length === 0
        ? `Tidak ada ${satuan} ditemukan`
        : `Menampilkan ${s}–${e} dari ${filteredRows.length} ${satuan}`;
}

function mdOpenOverlay(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function mdCloseOverlay(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function openSidebar() {
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    if (sidebar) sidebar.classList.add('open');
    if (overlay) overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    if (sidebar) sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('open');
    document.body.style.overflow = '';
}

function toggleNavGroup(id) {
    var group = document.getElementById(id);
    if (!group) return;
    var isOpen = group.classList.contains('open');
    document.querySelectorAll('.nav-group.open').forEach(function (g) { g.classList.remove('open'); });
    if (!isOpen) group.classList.add('open');
}

function toggleNotif() {
    var nd = document.getElementById('notifDropdown');
    var ad = document.getElementById('avatarDropdown');
    if (nd) nd.classList.toggle('open');
    if (ad) ad.classList.remove('open');
}

function toggleAvatar() {
    var ad = document.getElementById('avatarDropdown');
    var nd = document.getElementById('notifDropdown');
    if (ad) ad.classList.toggle('open');
    if (nd) nd.classList.remove('open');
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('#notifWrap'))  { var nd = document.getElementById('notifDropdown');  if (nd) nd.classList.remove('open'); }
    if (!e.target.closest('#avatarWrap')) { var ad = document.getElementById('avatarDropdown'); if (ad) ad.classList.remove('open'); }
});

function smSetError(fieldId, message) {
    var field = document.getElementById(fieldId);
    if (!field) return;

    field.classList.add('sm-input-error');

    var errId = fieldId + '_err';
    var errEl = document.getElementById(errId);
    if (!errEl) {
        errEl         = document.createElement('span');
        errEl.id      = errId;
        errEl.className = 'sm-field-error';
        field.parentNode.appendChild(errEl);
    }
    errEl.textContent = message;
    errEl.style.display = 'flex';
}

function smClearError(fieldId) {
    var field = document.getElementById(fieldId);
    if (field) field.classList.remove('sm-input-error');

    var errEl = document.getElementById(fieldId + '_err');
    if (errEl) errEl.style.display = 'none';
}

function smClearAllErrors() {
    ['smNama', 'smNis', 'smTingkat', 'smJurusan', 'smHp', 'smEmail'].forEach(function (id) {
        smClearError(id);
    });
}

function isValidEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function isValidPhone(hp) {
    // Hanya angka, +, spasi, tanda kurung, strip — minimal 8, maksimal 16 karakter
    var re = /^[\d\s\+\-\(\)]{8,16}$/;
    return re.test(hp);
}

function smValidateAll() {
    smClearAllErrors();
    var valid = true;

    var nama    = (document.getElementById('smNama').value    || '').trim();
    var nis     = (document.getElementById('smNis').value     || '').trim();
    var tingkat = (document.getElementById('smTingkat').value || '').trim();
    var jurusan = (document.getElementById('smJurusan').value || '').trim();
    var hp      = (document.getElementById('smHp').value      || '').trim();
    var email   = (document.getElementById('smEmail').value   || '').trim();

    // ── Nama: wajib, minimal 2 karakter ──
    if (!nama) {
        smSetError('smNama', 'Nama lengkap wajib diisi.');
        valid = false;
    } else if (nama.length < 2) {
        smSetError('smNama', 'Nama minimal 2 karakter.');
        valid = false;
    }

    // ── NIS: wajib, hanya angka, 4–15 digit ──
    if (!nis) {
        smSetError('smNis', 'NIS wajib diisi.');
        valid = false;
    } else if (!/^\d{4,15}$/.test(nis)) {
        smSetError('smNis', 'NIS hanya boleh berisi angka (4–15 digit).');
        valid = false;
    }

    // ── Tingkat/kelas: wajib dipilih ──
    if (!tingkat) {
        smSetError('smTingkat', 'Tingkat / kelas wajib dipilih.');
        valid = false;
    }

    // ── Jurusan: wajib dipilih ──
    if (!jurusan) {
        smSetError('smJurusan', 'Jurusan wajib dipilih.');
        valid = false;
    }

    // ── No HP / WA: WAJIB diisi dan format harus valid ──
    if (!hp) {
        smSetError('smHp', 'No. HP / WA wajib diisi.');
        valid = false;
    } else if (!isValidPhone(hp)) {
        smSetError('smHp', 'Format nomor HP tidak valid (contoh: 08123456789).');
        valid = false;
    }

    // ── Email: WAJIB diisi dan format harus valid ──
    if (!email) {
        smSetError('smEmail', 'Email siswa wajib diisi.');
        valid = false;
    } else if (!isValidEmail(email)) {
        smSetError('smEmail', 'Format email tidak valid (harus mengandung @ dan domain).');
        valid = false;
    }

    return valid;
}

/* Listener realtime: error hilang otomatis saat user mulai mengetik / memilih */
document.addEventListener('DOMContentLoaded', function () {
    ['smNama', 'smNis', 'smHp', 'smEmail'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', function () { smClearError(id); });
    });
    ['smTingkat', 'smJurusan'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('change', function () { smClearError(id); });
    });
});

var _confirmCallback = null;

/**
 * Tampilkan modal konfirmasi hapus.
 * @param {object} opts
 * opts.type      - 'kelas' | 'jurusan'
 * opts.nama      - nama item yang akan dihapus
 * opts.onConfirm - function yang dipanggil jika user klik "Ya, Hapus"
 */
function showDeleteConfirm(opts) {
    var type      = opts.type      || 'item';
    var nama      = opts.nama      || '';
    var onConfirm = opts.onConfirm;

    _confirmCallback = onConfirm;

    var labelEl = document.getElementById('confirmDeleteLabel');
    var namaEl  = document.getElementById('confirmDeleteNama');
    var infoEl  = document.getElementById('confirmDeleteInfo');
    var iconEl  = document.getElementById('confirmDeleteIcon');

    if (labelEl) labelEl.textContent = type === 'kelas' ? 'Hapus Kelas' : 'Hapus Jurusan';
    if (namaEl)  namaEl.textContent  = '"' + nama + '"';
    if (infoEl)  infoEl.textContent  = type === 'kelas'
        ? 'Kelas "' + nama + '" akan dihapus dari daftar. Siswa yang sudah terdaftar di kelas ini tidak akan terpengaruh.'
        : 'Jurusan "' + nama + '" akan dihapus dari daftar. Siswa yang sudah terdaftar di jurusan ini tidak akan terpengaruh.';

    // Warna header: biru untuk kelas, hijau untuk jurusan
    if (iconEl) {
        iconEl.style.background = type === 'kelas'
            ? 'linear-gradient(135deg,#3b82f6,#1d4ed8)'
            : 'linear-gradient(135deg,#16a34a,#15803d)';
    }

    mdOpenOverlay('modalDeleteConfirm');
}

function doDeleteConfirm() {
    mdCloseOverlay('modalDeleteConfirm');
    if (typeof _confirmCallback === 'function') {
        _confirmCallback();
        _confirmCallback = null;
    }
}

function closeDeleteConfirm() {
    mdCloseOverlay('modalDeleteConfirm');
    _confirmCallback = null;
}

var API_STUDENTS_LIST        = '/api/data-siswa/list';
var API_STUDENTS_SAVE        = '/api/data-siswa/save';
var API_STUDENTS_DELETE      = '/api/data-siswa/delete';
var API_GRADES_LIST          = '/api/data-siswa/grades';
var API_GRADES_SAVE          = '/api/data-siswa/grades/save';
var API_GRADES_DELETE        = '/api/data-siswa/grades/delete';
var API_MAJORS_LIST          = '/api/data-siswa/majors';
var API_MAJORS_SAVE          = '/api/data-siswa/majors/save';
var API_MAJORS_DELETE        = '/api/data-siswa/majors/delete';
// ── Endpoint baru (di-override via blade dengan route()) ──
var API_GRADE_MAJORS_PAIRS   = '/api/data-siswa/grade-major-pairs';
var API_GRADES_BY_MAJOR      = '/api/data-siswa/grades-by-major';

var CSRF_TOKEN = (function () {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
})();

async function apiFetch(url, options) {
    options = options || {};
    var headers = options.headers || {};
    headers['X-CSRF-TOKEN'] = CSRF_TOKEN;
    headers['Accept']       = 'application/json';

    if (options.body && typeof options.body === 'object') {
        headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(options.body);
    }

    options.headers = headers;

    try {
        var res  = await fetch(url, options);
        var json = await res.json();
        return json;
    } catch (err) {
        console.error('[apiFetch] Error:', url, err);
        return { status: 'error', message: 'Terjadi kesalahan jaringan.' };
    }
}

var _allStudents = [];  // array of student objects dari DB
var _allGrades   = [];  // array of string, e.g. ['X','XI','XII']
var _allMajors   = [];  // array of string, e.g. ['RPL','TKJ']
var _allPairs    = [];  // array of {grade, major}, e.g. [{grade:"XA", major:"RPL"}]
var _filtered    = [];  // hasil filter dari _allStudents
var _allMajorsData = [];
var _page        = 1;
var _editId      = null;
var _hapusId     = null;
var PER_PAGE     = 10;

var AV_COLORS = [
    { bg: '#dcfce7', c: '#15803d' },
    { bg: '#dbeafe', c: '#1d4ed8' },
    { bg: '#fce7f3', c: '#be185d' },
    { bg: '#fff7ed', c: '#c2410c' },
    { bg: '#fdf4ff', c: '#7e22ce' },
    { bg: '#fef9c3', c: '#854d0e' }
];

function avColor(name) {
    var h = 0;
    for (var i = 0; i < name.length; i++) {
        h = name.charCodeAt(i) + ((h << 5) - h);
    }
    return AV_COLORS[Math.abs(h) % AV_COLORS.length];
}

var SVG_EDIT   = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>';
var SVG_DELETE = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';

async function loadAll() {
    document.getElementById('tableInfo').textContent = 'Memuat data...';

    var results = await Promise.all([
        apiFetch(API_STUDENTS_LIST),
        apiFetch(API_GRADES_LIST),
        apiFetch(API_MAJORS_LIST),      // return array of CODE string
        apiFetch(API_GRADE_MAJORS_PAIRS),
        apiFetch(API_MAJORS_FULL)       // return array of {name, code}
    ]);

    _allStudents   = Array.isArray(results[0]) ? results[0] : [];
    _allGrades     = Array.isArray(results[1]) ? results[1] : [];
    _allMajors     = Array.isArray(results[2]) ? results[2] : [];
    _allPairs      = Array.isArray(results[3]) ? results[3] : [];
    _allMajorsData = Array.isArray(results[4]) ? results[4] : [];

    var badgeEl = document.getElementById('tabKelasBadge');
    if (badgeEl) badgeEl.textContent = _allPairs.length;

    populateFilterKelas();
    populateFilterJurusan();
    applyFilter();
}

function populateFilterKelas() {
    var sel = document.getElementById('filterKelas');
    var cur = sel.value;
    sel.innerHTML = '<option value="">Semua Kelas</option>' +
        _allGrades.map(function (k) {
            return '<option value="' + k + '"' + (k === cur ? ' selected' : '') + '>Kelas ' + k + '</option>';
        }).join('');
}

function populateFilterJurusan() {
    var sel = document.getElementById('filterJurusan');
    var cur = sel.value;
    sel.innerHTML = '<option value="">Semua Jurusan</option>' +
        _allMajors.map(function (j) {
            return '<option value="' + j + '"' + (j === cur ? ' selected' : '') + '>' + j + '</option>';
        }).join('');
}

function populateFormKelas(selected) {
    var sel = document.getElementById('smTingkat');
    // Deduplikasi — pakai Set atau filter
    var uniqueGrades = _allGrades.filter(function (k, i) {
        return _allGrades.indexOf(k) === i;
    });
    sel.innerHTML = '<option value="">Pilih...</option>' +
        uniqueGrades.map(function (k) {
            return '<option value="' + k + '"' + (k === selected ? ' selected' : '') + '>' + k + '</option>';
        }).join('');
}

function populateFormJurusan(selected) {
    var sel = document.getElementById('smJurusan');
    sel.innerHTML = '<option value="">Pilih...</option>' +
        _allMajors.map(function (j) {
            return '<option value="' + j + '"' + (j === selected ? ' selected' : '') + '>' + j + '</option>';
        }).join('');
}

/**
 * Filter dropdown Jurusan berdasarkan Kelas yang dipilih.
 * Hanya tampilkan jurusan yang punya pasangan dengan kelas tsb di _allPairs.
 * Jika kelas kosong (belum dipilih) → tampilkan semua jurusan.
 */
// Ganti fungsi filterJurusanByKelas
function filterJurusanByKelas(grade) {
    var sel = document.getElementById('smJurusan');
    var currentVal = sel.value;

    if (!grade) {
        populateFormJurusan(currentVal);
        return;
    }

    // ✅ Cari SEMUA jurusan yang punya kelas ini (bukan cuma satu)
    var majorsForGrade = _allPairs
        .filter(function (p) { return p.grade === grade; })
        .map(function (p) { return p.major; });

    if (majorsForGrade.length === 0) {
        sel.innerHTML = '<option value="">— Tidak ada jurusan —</option>';
        return;
    }

    // Tampilkan semua jurusan yang sesuai
    sel.innerHTML = '<option value="">Pilih...</option>' +
        majorsForGrade.map(function (m) {
            return '<option value="' + m + '"' + (m === currentVal ? ' selected' : '') + '>' + m + '</option>';
        }).join('');

    // Auto-select jika hanya ada satu pilihan
    if (majorsForGrade.length === 1) {
        sel.value = majorsForGrade[0];
    }
}

function renderTable() {
    var tbody = document.getElementById('tableBody');
    var noRes = document.getElementById('noResults');
    var start = (_page - 1) * PER_PAGE;
    var rows  = _filtered.slice(start, start + PER_PAGE);

    if (!_filtered.length) {
        tbody.innerHTML = '';
        noRes.classList.remove('hidden');
        updateStats();
        return;
    }

    noRes.classList.add('hidden');

    tbody.innerHTML = rows.map(function (d, i) {
        var av       = avColor(d.fullname);
        var kelas    = d.grade + ' ' + d.major;
        var namaSafe = (d.fullname || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'");
        var riwayat  = d.report_history || 0;

        return '<tr class="table-row">' +
            '<td class="col-no">' + (start + i + 1) + '</td>' +
            '<td>' +
                '<div class="pelapor-cell">' +
                    '<div class="pelapor-avatar" style="background:' + av.bg + ';color:' + av.c + '">' +
                        d.fullname.charAt(0).toUpperCase() +
                    '</div>' +
                    '<div>' +
                        '<div style="font-weight:600;font-size:13px;color:#111827">' + d.fullname + '</div>' +
                        '<div style="font-size:11px;color:#9ca3af">' + (d.email || '—') + '</div>' +
                    '</div>' +
                '</div>' +
            '</td>' +
            '<td><span class="kode-badge">' + d.nis + '</span></td>' +
            '<td><span class="kelas-tag">' + kelas + '</span></td>' +
            '<td style="font-size:12.5px;font-weight:600;color:#374151">' + d.major + '</td>' +
            '<td><span class="jk-badge ' + d.gender + '">' + (d.gender === 'L' ? 'Laki-laki' : 'Perempuan') + '</span></td>' +
            '<td style="font-size:12px;color:#6b7280;font-family:monospace">' + (d.phone || '—') + '</td>' +
            '<td>' + (riwayat > 0
                ? '<span class="riwayat-badge ada">&#9888; ' + riwayat + 'x Laporan</span>'
                : '<span class="riwayat-badge bersih">&#10003; Bersih</span>') +
            '</td>' +
            '<td class="col-aksi">' +
                '<div class="aksi-wrap">' +
                    '<button class="btn-aksi edit" title="Edit" onclick="openSiswaModal(' + d.id + ')">' + SVG_EDIT + '</button>' +
                    '<button class="btn-aksi delete" title="Hapus" onclick="openHapusSiswa(' + d.id + ', \'' + namaSafe + '\')">' + SVG_DELETE + '</button>' +
                '</div>' +
            '</td>' +
        '</tr>';
    }).join('');

    buildTableInfo(document.getElementById('tableInfo'), _page, _filtered, PER_PAGE, 'siswa');
    buildPagination(document.getElementById('paginationWrap'), _page, _filtered.length, PER_PAGE, goPage);
    updateStats();
}

function goPage(p) {
    var total = Math.ceil(_filtered.length / PER_PAGE);
    if (p < 1 || p > total) return;
    _page = p;
    renderTable();
}

function applyFilter() {
    var q  = (document.getElementById('searchInput').value || '').toLowerCase().trim();
    var tk = document.getElementById('filterKelas').value || '';
    var jr = document.getElementById('filterJurusan').value || '';

    _filtered = _allStudents.filter(function (d) {
        var matchSearch  = !q  || d.fullname.toLowerCase().indexOf(q) !== -1 || (d.nis || '').toLowerCase().indexOf(q) !== -1;
        var matchKelas   = !tk || d.grade === tk;
        var matchJurusan = !jr || d.major === jr;
        return matchSearch && matchKelas && matchJurusan;
    });

    _page = 1;
    renderTable();
}

function updateStats() {
    document.getElementById('statTotal').textContent = _allStudents.length;

    var kelasSet = {};
    _allStudents.forEach(function (d) {
        kelasSet[d.grade + '-' + d.major] = 1;
    });
    document.getElementById('statKelas').textContent = Object.keys(kelasSet).length;

    document.getElementById('statPernahLapor').textContent =
        _allStudents.filter(function (d) { return (d.report_history || 0) > 0; }).length;

    document.getElementById('statPelaku').textContent =
        _allStudents.filter(function (d) { return (d.report_history || 0) >= 2; }).length;
}

function updateSmAvatar() {
    var n = document.getElementById('smNama').value || '';
    document.getElementById('smAvatar').textContent = n.trim().charAt(0).toUpperCase() || '?';
}

function openSiswaModal(id) {
    id = id || null;
    _editId = id;

    document.getElementById('smTitle').textContent = id ? 'Edit Data Siswa' : 'Tambah Siswa Baru';

    // Bersihkan semua error setiap kali modal dibuka
    smClearAllErrors();

    if (id) {
        var d = _allStudents.find(function (x) { return x.id == id; });
        if (d) {
            document.getElementById('smNama').value  = d.fullname;
            document.getElementById('smNis').value   = d.nis;
            populateFormKelas(d.grade);
            populateFormJurusan(d.major);
            document.getElementById('smJK').value    = d.gender;
            document.getElementById('smHp').value    = d.phone || '';
            document.getElementById('smEmail').value = d.email || '';
            document.getElementById('smAvatar').textContent = d.fullname.charAt(0).toUpperCase();
        }
    } else {
        ['smNama', 'smNis', 'smHp', 'smEmail'].forEach(function (fid) {
            document.getElementById(fid).value = '';
        });
        populateFormKelas('');
        populateFormJurusan('');
        document.getElementById('smJK').value = 'L';
        document.getElementById('smAvatar').textContent = '?';
    }

    mdOpenOverlay('modalSiswa');
}

function closeSiswaModal() {
    smClearAllErrors();
    mdCloseOverlay('modalSiswa');
}

async function saveSiswa() {
    // Validasi client-side dulu — jika ada error, hentikan dan scroll ke field bermasalah
    if (!smValidateAll()) {
        var firstErr = document.querySelector('.sm-input-error');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    var btnSimpan = document.getElementById('btnSimpanSiswa');
    btnSimpan.classList.add('btn-loading');
    btnSimpan.textContent = 'Menyimpan...';

    var payload = {
        id       : _editId || null,
        fullname : document.getElementById('smNama').value.trim(),
        nis      : document.getElementById('smNis').value.trim(),
        grade    : document.getElementById('smTingkat').value,
        major    : document.getElementById('smJurusan').value,
        gender   : document.getElementById('smJK').value,
        phone    : document.getElementById('smHp').value.trim(),
        email    : document.getElementById('smEmail').value.trim()
    };

    var res = await apiFetch(API_STUDENTS_SAVE, { method: 'POST', body: payload });

    btnSimpan.classList.remove('btn-loading');
    btnSimpan.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Simpan';

    if (res.status === 'success') {
        closeSiswaModal();
        await loadAll();
        if (typeof Toast !== 'undefined') {
            Toast.show('success', 'Berhasil', _editId ? 'Data siswa diperbarui.' : 'Siswa baru ditambahkan.');
        }
    } else {
        // Tampilkan error validasi dari server (Laravel) secara inline per field
        if (res.errors) {
            var fieldMap = {
                fullname : 'smNama',
                nis      : 'smNis',
                grade    : 'smTingkat',
                major    : 'smJurusan',
                phone    : 'smHp',
                email    : 'smEmail'
            };
            Object.keys(res.errors).forEach(function (key) {
                var htmlId = fieldMap[key];
                if (htmlId) smSetError(htmlId, res.errors[key][0]);
            });
            var firstErr = document.querySelector('.sm-input-error');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            alert(res.message || 'Gagal menyimpan data.');
        }
    }
}

function openHapusSiswa(id, nama) {
    _hapusId = id;
    document.getElementById('hapusSiswaNama').textContent = nama || id;
    mdOpenOverlay('modalHapusSiswa');
}

function closeHapusSiswa() {
    mdCloseOverlay('modalHapusSiswa');
}

async function doHapusSiswa() {
    if (!_hapusId) return;

    var btnHapus = document.getElementById('btnDoHapus');
    btnHapus.classList.add('btn-loading');
    btnHapus.textContent = 'Menghapus...';

    var res = await apiFetch(API_STUDENTS_DELETE + '/' + _hapusId, { method: 'DELETE' });

    btnHapus.classList.remove('btn-loading');
    btnHapus.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Ya, Hapus';

    if (res.status === 'success') {
        closeHapusSiswa();
        await loadAll();
        if (typeof Toast !== 'undefined') {
            Toast.show('success', 'Dihapus', 'Data siswa berhasil dihapus.');
        }
    } else {
        alert(res.message || 'Gagal menghapus data.');
    }
}


function openKelasMgr() {
    kmgrSwitchTab('jurusan');           // mulai dari tab Jurusan
    renderJurusanTable();
    renderKelasTags();
    kmgrRefreshJurusanSelect();
    mdOpenOverlay('modalKelasMgr');
}

function closeKelasMgr() {
    populateFilterKelas();
    populateFilterJurusan();
    mdCloseOverlay('modalKelasMgr');
}

/* ── TAB SWITCH ── */
function kmgrSwitchTab(tab) {
    var isJurusan = tab === 'jurusan';

    document.getElementById('tabJurusan').classList.toggle('active',  isJurusan);
    document.getElementById('tabKelas').classList.toggle('active',   !isJurusan);
    document.getElementById('panelJurusan').style.display = isJurusan ? '' : 'none';
    document.getElementById('panelKelas').style.display   = isJurusan ? 'none' : '';

    if (!isJurusan) {
        kmgrRefreshJurusanSelect();
        kmgrRefreshFilterKelasByJurusan();
        renderKelasTags();
    }

    // Update badge jumlah kelas di tab
    document.getElementById('tabKelasBadge').textContent = _allPairs.length;
}

/* ── RENDER DAFTAR JURUSAN (tabel dengan jumlah kelas) ── */
function renderJurusanTable() {
    var wrap = document.getElementById('daftarJurusanTable');

    if (!_allMajorsData.length) {
        wrap.innerHTML = '<span class="empty-tag-hint">Belum ada jurusan. Tambahkan di atas.</span>';
        return;
    }

    var countMap = {};
    _allPairs.forEach(function (p) {
        countMap[p.major] = (countMap[p.major] || 0) + 1;
    });

    wrap.innerHTML = _allMajorsData.map(function (j) {
        var count   = countMap[j.code] || 0;
        var codeSafe = j.code.replace(/'/g, "\\'");
        var label   = j.name + ' <span style="font-weight:700;color:#3b82f6">(' + j.code + ')</span>';
        var meta    = count > 0
            ? count + ' kelas terdaftar'
            : '<em style="color:#d1d5db">Belum ada kelas</em>';

        return '<div class="kmgr-jurusan-row">' +
            '<div>' +
                '<div class="kmgr-jurusan-name">' + label + '</div>' +
                '<div class="kmgr-jurusan-meta">' + meta + '</div>' +
            '</div>' +
            '<div class="kmgr-jurusan-actions">' +
                '<button class="kmgr-btn-goto" ' +
                    'onclick="kmgrGotoKelasJurusan(\'' + codeSafe + '\')" ' +
                    'title="Lihat kelas ' + j.code + '">' +
                    'Lihat Kelas &rsaquo;' +
                '</button>' +
                '<button class="kmgr-btn-del" ' +
                    'onclick="konfirmasiHapusJurusan(\'' + codeSafe + '\')" ' +
                    'title="Hapus ' + j.code + '">&#215;</button>' +
            '</div>' +
        '</div>';
    }).join('');
}

/* Shortcut: klik "Lihat Kelas" dari tab Jurusan → pindah ke tab Kelas dan filter */
function kmgrGotoKelasJurusan(jurusan) {
    kmgrSwitchTab('kelas');
    document.getElementById('filterKelasByJurusan').value = jurusan;
    renderKelasTags();
}

/* ── RENDER DAFTAR KELAS (tags dengan label jurusan) ── */
function renderKelasTags() {
    var wrap   = document.getElementById('daftarKelas');
    var filter = (document.getElementById('filterKelasByJurusan') || {}).value || '';

    var pairs = filter
        ? _allPairs.filter(function (p) { return p.major === filter; })
        : _allPairs;

    if (!pairs.length) {
        wrap.innerHTML = '<span class="empty-tag-hint">' +
            (filter ? 'Belum ada kelas untuk jurusan ' + filter + '.' : 'Belum ada kelas. Tambahkan di atas.') +
            '</span>';
        return;
    }

    wrap.innerHTML = pairs.map(function (p) {
        var gSafe = p.grade.replace(/'/g, "\\'");
        return '<span class="kmgr-kelas-tag">' +
            p.grade +
            '<span class="kmgr-tag-major">' + p.major + '</span>' +
            '<button onclick="konfirmasiHapusKelas(\'' + gSafe + '\')" title="Hapus kelas ' + p.grade + '">&#215;</button>' +
        '</span>';
    }).join('');
}

/* ── POPULATE SELECT JURUSAN DI FORM TAMBAH KELAS ── */
function kmgrRefreshJurusanSelect() {
    var sel = document.getElementById('selectJurusanUntukKelas');
    if (!sel) return;
    var cur = sel.value;
    sel.innerHTML = '<option value="">— Pilih jurusan —</option>' +
        _allMajors.map(function (j) {
            return '<option value="' + j + '"' + (j === cur ? ' selected' : '') + '>' + j + '</option>';
        }).join('');
}

function kmgrRefreshFilterKelasByJurusan() {
    var sel = document.getElementById('filterKelasByJurusan');
    if (!sel) return;
    var cur = sel.value;
    sel.innerHTML = '<option value="">Semua Jurusan</option>' +
        _allMajors.map(function (j) {
            return '<option value="' + j + '"' + (j === cur ? ' selected' : '') + '>' + j + '</option>';
        }).join('');
}

/* ── LIVE PREVIEW "XA - RPL" saat user mengetik ── */
function kmgrOnJurusanChange() {
    kmgrUpdatePreview();
    var jurusan  = document.getElementById('selectJurusanUntukKelas').value;
    var hintEl   = document.getElementById('kmgrHint');
    if (!jurusan) { hintEl.style.display = 'none'; return; }

    var existing = _allPairs
        .filter(function (p) { return p.major === jurusan; })
        .map(function (p) { return p.grade; });

    if (existing.length) {
        hintEl.textContent = 'Kelas ' + jurusan + ' yang sudah ada: ' + existing.join(', ');
        hintEl.style.display = '';
    } else {
        hintEl.textContent = 'Belum ada kelas untuk jurusan ' + jurusan + '.';
        hintEl.style.display = '';
    }
}

function kmgrUpdatePreview() {
    var jurusan   = (document.getElementById('selectJurusanUntukKelas') || {}).value || '';
    var kelas     = ((document.getElementById('inputKelasBaru') || {}).value || '').trim().toUpperCase();
    var badgeEl   = document.getElementById('kmgrPreviewBadge');
    if (!badgeEl) return;

    if (jurusan && kelas) {
        badgeEl.textContent    = kelas + ' - ' + jurusan;
        badgeEl.style.display  = '';
    } else {
        badgeEl.style.display  = 'none';
    }
}

/* ── TAMBAH JURUSAN ── */
async function tambahJurusan() {
    var inputNama = document.getElementById('inputJurusanBaru');
    var inputKode = document.getElementById('inputJurusanKode');
    var nama = (inputNama.value || '').trim();
    var kode = (inputKode.value || '').trim().toUpperCase();

    if (!nama) { showKmgrErr('Nama jurusan wajib diisi.', 'jurusan'); return; }
    if (!kode) { showKmgrErr('Kode/inisial jurusan wajib diisi.', 'jurusan'); return; }

    if (_allMajors.indexOf(kode) !== -1) {
        showKmgrErr('Kode "' + kode + '" sudah digunakan.', 'jurusan');
        return;
    }

    var res = await apiFetch(API_MAJORS_SAVE, {
        method : 'POST',
        body   : { name: nama, code: kode }
    });

    if (res.status === 'success') {
        _allMajors.push(res.code);
        _allMajors.sort();
        _allMajorsData.push({ name: res.name, code: res.code });
        _allMajorsData.sort(function(a, b) { return a.name.localeCompare(b.name); });

        inputNama.value = '';
        inputKode.value = '';

        renderJurusanTable();
        kmgrRefreshJurusanSelect();
        kmgrRefreshFilterKelasByJurusan();

        if (typeof Toast !== 'undefined') {
            Toast.show('success', 'Jurusan ditambahkan',
                nama + ' (' + kode + ') berhasil ditambahkan.');
        }
    } else {
        var msg = res.message || '';
        if (res.errors && res.errors.name) msg = res.errors.name[0];
        else if (res.errors && res.errors.code) msg = res.errors.code[0];
        showKmgrErr(msg || 'Gagal menambahkan jurusan.', 'jurusan');
    }
}

async function hapusJurusan(nama) {
    var res = await apiFetch(API_MAJORS_DELETE + '/' + encodeURIComponent(nama), { method: 'DELETE' });

    if (res.status === 'success') {
        _allMajors     = _allMajors.filter(function (j) { return j !== nama; });
        _allMajorsData = _allMajorsData.filter(function (j) { return j.code !== nama; });
        renderJurusanTable();
        kmgrRefreshJurusanSelect();
        kmgrRefreshFilterKelasByJurusan();
        renderKelasTags();
        if (typeof Toast !== 'undefined') {
            Toast.show('success', 'Dihapus', 'Jurusan "' + nama + '" dihapus.');
        }
    } else {
        alert(res.message || 'Gagal menghapus jurusan.');
    }
}

async function hapusJurusan(nama) {
    var res = await apiFetch(API_MAJORS_DELETE + '/' + encodeURIComponent(nama), { method: 'DELETE' });

    if (res.status === 'success') {
        _allMajors = _allMajors.filter(function (j) { return j !== nama; });
        renderJurusanTable();
        kmgrRefreshJurusanSelect();
        kmgrRefreshFilterKelasByJurusan();
        renderKelasTags();
        if (typeof Toast !== 'undefined') {
            Toast.show('success', 'Dihapus', 'Jurusan "' + nama + '" dihapus.');
        }
    } else {
        alert(res.message || 'Gagal menghapus jurusan.');
    }
}

/* ── TAMBAH KELAS (dengan jurusan) ── */
async function tambahKelas() {
    var jurusan  = document.getElementById('selectJurusanUntukKelas').value;
    var input    = document.getElementById('inputKelasBaru');
    var kelasVal = (input.value || '').trim().toUpperCase();
    var errEl    = document.getElementById('kmgrKelasErr');

    if (!jurusan) {
        showKmgrErr('Pilih jurusan terlebih dahulu.', 'kelas');
        return;
    }
    if (!kelasVal) {
        showKmgrErr('Nama kelas wajib diisi.', 'kelas');
        return;
    }

    // Cek duplikat di state lokal
    var duplicate = _allPairs.find(function (p) {
        return p.grade === kelasVal && p.major === jurusan;
    });
    if (duplicate) {
        showKmgrErr(
            'Kelas "' + kelasVal + '" sudah terdaftar di jurusan ' + jurusan + '.',
            'kelas'
        );
        return;
    }

    if (errEl) errEl.style.display = 'none';

    var res = await apiFetch(API_GRADES_SAVE, {
        method : 'POST',
        body   : { grade: kelasVal, major: jurusan }
    });

    if (res.status === 'success') {
        _allPairs.push({ grade: kelasVal, major: jurusan });
        _allPairs.sort(function (a, b) {
            return a.major.localeCompare(b.major) || a.grade.localeCompare(b.grade);
        });
        if (_allGrades.indexOf(kelasVal) === -1) {
            _allGrades.push(kelasVal);
            _allGrades.sort();
        }

        // Reset form
        input.value = '';
        document.getElementById('kmgrPreviewBadge').style.display = 'none';

        // Refresh UI
        renderKelasTags();
        renderJurusanTable();
        document.getElementById('tabKelasBadge').textContent = _allPairs.length;

        if (typeof Toast !== 'undefined') {
            Toast.show('success', 'Kelas ditambahkan',
                'Kelas "' + kelasVal + ' - ' + jurusan + '" berhasil ditambahkan.');
        }
    } else {
        var msg = res.message || '';
        if (res.errors && res.errors.grade) msg = res.errors.grade[0];
        else if (res.errors && res.errors.major) msg = res.errors.major[0];
        showKmgrErr(msg || 'Gagal menambahkan kelas.', 'kelas');
    }
}

/* ── HAPUS KELAS ── */
function konfirmasiHapusKelas(grade) {
    showDeleteConfirm({
        type      : 'kelas',
        nama      : grade,
        onConfirm : function () { hapusKelas(grade); }
    });
}

async function hapusKelas(grade) {
    var res = await apiFetch(API_GRADES_DELETE + '/' + encodeURIComponent(grade), { method: 'DELETE' });

    if (res.status === 'success') {
        _allPairs  = _allPairs.filter(function (p) { return p.grade !== grade; });
        _allGrades = _allGrades.filter(function (k) { return k !== grade; });
        renderKelasTags();
        renderJurusanTable();
        document.getElementById('tabKelasBadge').textContent = _allPairs.length;
        if (typeof Toast !== 'undefined') {
            Toast.show('success', 'Dihapus', 'Kelas "' + grade + '" dihapus.');
        }
    } else {
        alert(res.message || 'Gagal menghapus kelas.');
    }
}

/* ── HELPER ERROR INLINE DI MODAL KELAS-JURUSAN ── */
function showKmgrErr(msg, scope) {
    var errEl = document.getElementById('kmgrKelasErr');
    if (!errEl) return;
    errEl.textContent  = msg;
    errEl.style.display = 'flex';
    setTimeout(function () { errEl.style.display = 'none'; }, 4000);
}

/* ── HELPER UNTUK PAGE LAPORAN — filter kelas berdasarkan jurusan ── */
function populateKelasByJurusan(selectId, jurusan, selectedGrade) {
    var sel = document.getElementById(selectId);
    if (!sel) return;

    var grades = jurusan
        ? _allPairs.filter(function (p) { return p.major === jurusan; }).map(function (p) { return p.grade; })
        : _allGrades;

    sel.innerHTML = '<option value="">— Pilih kelas —</option>' +
        grades.map(function (g) {
            return '<option value="' + g + '"' + (g === selectedGrade ? ' selected' : '') + '>' + g + '</option>';
        }).join('');
}

/**
 * Ambil jurusan berdasarkan kelas dari state lokal (tanpa request ke server)
 */
function getMajorByGrade(grade) {
    var pair = _allPairs.find(function (p) { return p.grade === grade; });
    return pair ? pair.major : null;
}

/* =============================================================
   EVENT LISTENERS
============================================================= */
document.getElementById('searchInput').addEventListener('input', applyFilter);
document.getElementById('filterKelas').addEventListener('change', applyFilter);
document.getElementById('filterJurusan').addEventListener('change', applyFilter);

// Tutup modal saat klik overlay (area di luar panel)
document.getElementById('modalSiswa').addEventListener('click', function (e) {
    if (e.target === this) closeSiswaModal();
});
document.getElementById('modalHapusSiswa').addEventListener('click', function (e) {
    if (e.target === this) closeHapusSiswa();
});
document.getElementById('modalKelasMgr').addEventListener('click', function (e) {
    if (e.target === this) closeKelasMgr();
});
document.getElementById('modalDeleteConfirm').addEventListener('click', function (e) {
    if (e.target === this) closeDeleteConfirm();
});

/* =============================================================
   INIT — Jalankan saat DOM siap
============================================================= */
document.addEventListener('DOMContentLoaded', function () {
    loadAll();

    // Live preview input kelas baru di modal kelola kelas
    var inputKelas = document.getElementById('inputKelasBaru');
    if (inputKelas) {
        inputKelas.addEventListener('input', function () {
            kmgrUpdatePreview();
            var errEl = document.getElementById('kmgrKelasErr');
            if (errEl) errEl.style.display = 'none';
        });
    }
     var smTingkat = document.getElementById('smTingkat');
    if (smTingkat) {
        smTingkat.addEventListener('change', function () {
            filterJurusanByKelas(this.value);
        });
    }
});