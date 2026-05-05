/**
 * report-user-page.js
 * Handles: NISN search, form validation, file upload, form submission ke API, 
 * dan Auto-Suggestion Jenis Pelanggaran.
 */

/* ─── CSRF helper ─────────────────────────── */
function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

/* ─── FormValidator ───────────────────────── */
const FormValidator = {
    validateNISN: function(value) {
        if (!value.trim()) return { valid: false, message: 'NISN wajib diisi' };
        if (!/^\d+$/.test(value)) return { valid: false, message: 'NISN hanya boleh berisi angka' };
        if (value.length < 4) return { valid: false, message: 'NISN minimal 4 digit' };
        return { valid: true, message: '' };
    },
    validateEmail: function(value) {
        if (!value.trim()) return { valid: false, message: 'Email wajib diisi' };
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return { valid: false, message: 'Format email tidak valid' };
        return { valid: true, message: '' };
    },
    validateDeskripsi: function(value) {
        if (!value.trim()) return { valid: false, message: 'Deskripsi kejadian wajib diisi' };
        if (value.trim().length < 20) return { valid: false, message: `Minimal 20 karakter (saat ini: ${value.trim().length})` };
        return { valid: true, message: '' };
    },
    validatePhone: function(value) {
        if (!value.trim()) return { valid: false, message: 'Nomor HP wajib diisi' };
        if (!/^\d+$/.test(value.trim())) return { valid: false, message: 'Nomor HP hanya boleh berisi angka' };
        if (value.trim().length < 9) return { valid: false, message: 'Nomor HP minimal 9 digit' };
        if (value.trim().length > 15) return { valid: false, message: 'Nomor HP maksimal 15 digit' };
        return { valid: true, message: '' };
    },
    validateName: function(value) {
        if (!value.trim()) return { valid: false, message: 'Nama wajib diisi' };
        if (value.trim().length < 3) return { valid: false, message: 'Nama minimal 3 karakter' };
        return { valid: true, message: '' };
    },
    showError: function(inputId, message) {
        const input = document.getElementById(inputId);
        const err   = document.getElementById(`${inputId}-error`);
        if (!input || !err) return;
        input.classList.add('border-red-500', 'shake-animation');
        input.classList.remove('border-emerald-500');
        err.textContent = message;
        err.classList.remove('hidden');
        setTimeout(() => input.classList.remove('shake-animation'), 500);
    },
    clearError: function(inputId) {
        const input = document.getElementById(inputId);
        const err   = document.getElementById(`${inputId}-error`);
        if (!input || !err) return;
        input.classList.remove('border-red-500');
        err.classList.add('hidden');
        err.textContent = '';
    },
    showSuccess: function(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.classList.add('border-emerald-500');
        input.classList.remove('border-red-500');
    }
};

/* ─── NISN Search ─────────────────────────── */
let _studentId = null; 

/* ── Reporter Type Toggle ─────────────────── */
let _reporterType = 'siswa';

function setReporterType(type) {
    _reporterType = type;
    document.getElementById('reporter_type').value = type;

    const formOrtu  = document.getElementById('formOrtu');
    const btnSiswa  = document.getElementById('btnSiswa');
    const btnOrtu   = document.getElementById('btnOrtu');

    btnSiswa.classList.toggle('active', type === 'siswa');
    btnOrtu.classList.toggle('active',  type === 'ortu');

    if (type === 'ortu') {
        document.getElementById('formSiswaFields').classList.add('hidden');
        formOrtu.classList.remove('hidden');
        loadGradesForOrtu();
    } else {
        document.getElementById('formSiswaFields').classList.remove('hidden');
        formOrtu.classList.add('hidden');
    }
}

let _gradesLoaded  = false;
let _gradesLoading = false;

async function loadGradesForOrtu() {
    if (_gradesLoaded || _gradesLoading) return;

    const sel = document.getElementById('child_grade');
    _gradesLoading = true;

    const loadingOpt = document.createElement('option');
    loadingOpt.value       = '';
    loadingOpt.textContent = 'Memuat kelas...';
    loadingOpt.disabled    = true;
    sel.appendChild(loadingOpt);

    try {
        const res  = await fetch('/api/data-siswa/grade-majors');
        const json = await res.json();

        while (sel.options.length > 1) sel.remove(1);

        if (Array.isArray(json) && json.length > 0) {
            const unique = new Map();
            json.forEach(p => {
                const key = `${p.grade} ${p.major}`.trim();
                if (!unique.has(key)) unique.set(key, key);
            });

            [...unique.keys()].sort().forEach(g => {
                const opt = document.createElement('option');
                opt.value = opt.textContent = g;
                sel.appendChild(opt);
            });

            _gradesLoaded = true;
        } else {
            const errOpt = document.createElement('option');
            errOpt.value       = '';
            errOpt.textContent = 'Gagal memuat — coba lagi';
            errOpt.disabled    = true;
            sel.appendChild(errOpt);
        }
    } catch(e) {
        console.error(e);
        while (sel.options.length > 1) sel.remove(1);

        const errOpt = document.createElement('option');
        errOpt.value       = '';
        errOpt.textContent = 'Gagal memuat — coba lagi';
        errOpt.disabled    = true;
        sel.appendChild(errOpt);
        _gradesLoaded = false;
    } finally {
        _gradesLoading = false;
    }
}

async function cariSiswa() {
    const nisn    = document.getElementById('nisn').value.trim();
    const btn     = document.getElementById('btnCariNisn');
    const info    = document.getElementById('student-info');
    const emailEl = document.getElementById('email');
    const hint    = document.getElementById('email-hint');

    const validation = FormValidator.validateNISN(nisn);
    if (!validation.valid) {
        FormValidator.showError('nisn', validation.message);
        return;
    }

    FormValidator.clearError('nisn');
    btn.disabled = true;
    btn.innerHTML = `<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>`;

    try {
        const res  = await fetch(`/api/students/search?nisn=${encodeURIComponent(nisn)}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
        });
        const data = await res.json();

        if (res.ok && data.success) {
            _studentId = data.data.id;
            document.getElementById('student_id').value = _studentId;

            document.getElementById('student-name').textContent = data.data.fullname;
            document.getElementById('student-class').textContent = `${data.data.grade} - ${data.data.major}`;
            info.classList.remove('hidden');

            if (data.data.has_email) {
                emailEl.value = data.data.email;
                emailEl.readOnly = true;
                emailEl.classList.add('bg-gray-50');
                hint.classList.remove('hidden');
            } else {
                emailEl.value = '';
                emailEl.readOnly = false;
                emailEl.classList.remove('bg-gray-50');
                hint.classList.add('hidden');
            }

            FormValidator.showSuccess('nisn');
            FormValidator.clearError('email');
            if (emailEl.value) FormValidator.showSuccess('email');
        } else {
            _studentId = null;
            document.getElementById('student_id').value = '';
            info.classList.add('hidden');
            emailEl.readOnly = false;
            emailEl.classList.remove('bg-gray-50');
            hint.classList.add('hidden');

            document.getElementById('nisnNotFoundMsg').textContent =
                data.message || 'NIS tidak ditemukan. Periksa kembali atau hubungi wali kelas.';
            document.getElementById('modalNisnNotFound').classList.remove('hidden');
            FormValidator.showError('nisn', 'NIS tidak ditemukan');
        }
    } catch (e) {
        console.error(e);
        FormValidator.showError('nisn', 'Koneksi bermasalah. Coba lagi.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>`;
    }
}

function closeNisnModal(e) {
    if (e.target === e.currentTarget) {
        document.getElementById('modalNisnNotFound').classList.add('hidden');
    }
}

/* ─── Real-time validation ────────────────── */
document.getElementById('nisn').addEventListener('input', function() {
    const before = this.value;
    this.value = this.value.replace(/\D/g, '').slice(0, 6);

    if (before !== this.value && before.length >= this.value.length) {
        this.classList.add('shake-animation');
        setTimeout(() => this.classList.remove('shake-animation'), 500);
        if (/\D/.test(before)) {
            FormValidator.showError('nisn', 'NISN hanya boleh berisi angka');
            return;
        }
    }

    if (_studentId) {
        _studentId = null;
        document.getElementById('student_id').value = '';
        document.getElementById('student-info').classList.add('hidden');
        const emailEl = document.getElementById('email');
        emailEl.value    = ''; 
        emailEl.readOnly = false;
        emailEl.classList.remove('bg-gray-50');
        document.getElementById('email-hint').classList.add('hidden');
        FormValidator.clearError('email');
    }

    if (this.value) FormValidator.clearError('nisn');
});

let _nisnEnterTimeout = null;
document.getElementById('nisn').addEventListener('keydown', function(e) {
    if (e.key !== 'Enter') return;
    e.preventDefault();
    clearTimeout(_nisnEnterTimeout);
    _nisnEnterTimeout = setTimeout(() => cariSiswa(), 50);
});

document.getElementById('email').addEventListener('blur', function() {
    const v = FormValidator.validateEmail(this.value);
    if (!v.valid) FormValidator.showError('email', v.message);
    else { FormValidator.clearError('email'); FormValidator.showSuccess('email'); }
});
document.getElementById('email').addEventListener('input', function() {
    if (this.value) FormValidator.clearError('email');
});

document.getElementById('deskripsi').addEventListener('blur', function() {
    const v = FormValidator.validateDeskripsi(this.value);
    if (!v.valid) FormValidator.showError('deskripsi', v.message);
    else { FormValidator.clearError('deskripsi'); FormValidator.showSuccess('deskripsi'); }
});
document.getElementById('deskripsi').addEventListener('input', function() {
    if (this.value) FormValidator.clearError('deskripsi');
});

/* ─── Form Submission ─────────────────────── */
let _isSubmitting = false;
document.getElementById('reportForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (_isSubmitting) return;
    _isSubmitting = true;

    const deskripsi = document.getElementById('deskripsi').value.trim();
    const dv        = FormValidator.validateDeskripsi(deskripsi);
    let isValid     = true;

    if (!dv.valid) { FormValidator.showError('deskripsi', dv.message); isValid = false; }
    
    const wrap = document.getElementById('violation_tags_wrap');
    if (wrap && _selectedViolations.length === 0) {
        const errEl = document.getElementById('violation_ids-error');
        if (errEl) {
            errEl.textContent = 'Pilih minimal 1 kata kunci yang sesuai dengan kejadian.';
            errEl.classList.remove('hidden');
            errEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        isValid = false;
    }

    if (_reporterType === 'siswa') {
        const nisn  = document.getElementById('nisn').value.trim();
        const email = document.getElementById('email').value.trim();
        const nv    = FormValidator.validateNISN(nisn);
        const ev    = FormValidator.validateEmail(email);
        if (!nv.valid) { FormValidator.showError('nisn', nv.message);  isValid = false; }
        if (!ev.valid) { FormValidator.showError('email', ev.message); isValid = false; }
        if (!_studentId && nv.valid) {
            FormValidator.showError('nisn', 'Tekan tombol cari (🔍) untuk validasi NIS terlebih dahulu.');
            isValid = false;
        }
    } else {
        const rName  = document.getElementById('reporter_name').value.trim();
        const rPhone = document.getElementById('reporter_phone').value.trim();
        const cName  = document.getElementById('child_name').value.trim();
        const cGrade = document.getElementById('child_grade').value;
        const rnv = FormValidator.validateName(rName);
        const rpv = FormValidator.validatePhone(rPhone);
        const cnv = FormValidator.validateName(cName);
        if (!rnv.valid) { FormValidator.showError('reporter_name',  rnv.message); isValid = false; }
        if (!rpv.valid) { FormValidator.showError('reporter_phone', rpv.message); isValid = false; }
        if (!cnv.valid) { FormValidator.showError('child_name',     cnv.message); isValid = false; }
        if (!cGrade)    { FormValidator.showError('child_grade', 'Kelas anak wajib dipilih.');     isValid = false; }
    }

    if (!isValid) {
        _isSubmitting = false;
        document.querySelector('.border-red-500')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    const submitBtn = document.getElementById('submitBtn');
    const originalContent = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
        <span>Mengirim...</span>
    `;

    try {
        const formData = new FormData();
        formData.append('reporter_type', _reporterType);
        formData.append('deskripsi',     deskripsi);
        formData.append('_token',        csrfToken());

        if (_reporterType === 'siswa') {
            formData.append('nisn',       document.getElementById('nisn').value.trim());
            formData.append('email',      document.getElementById('email').value.trim());
            formData.append('student_id', document.getElementById('student_id').value);
        } else {
            formData.append('reporter_name',  document.getElementById('reporter_name').value.trim());
            formData.append('reporter_phone', document.getElementById('reporter_phone').value.trim());
            formData.append('child_name',     document.getElementById('child_name').value.trim());
            formData.append('child_grade',    document.getElementById('child_grade').value);
            const emailOrtu = document.getElementById('email_ortu').value.trim();
            if (emailOrtu) formData.append('email', emailOrtu);
        }

        // Handle file uploads jika ada variabel global selectedFiles dari komponen file-upload
        if (typeof selectedFiles !== 'undefined') {
            if (selectedFiles.length > 5) {
                alert('Maksimal 5 file yang bisa dikirim (foto atau video).');
                submitBtn.disabled  = false;
                submitBtn.innerHTML = originalContent;
                return;
            }

            const IMG_MAX   = 5  * 1024 * 1024;
            const VIDEO_MAX = 50 * 1024 * 1024;
            const videoTypes = ['video/mp4','video/quicktime','video/x-msvideo','video/webm'];
            const imgTypes   = ['image/jpeg','image/jpg','image/png','image/webp'];

            for (const file of selectedFiles) {
                const isVideo = videoTypes.includes(file.type);
                const isImage = imgTypes.includes(file.type);

                if (!isVideo && !isImage) {
                    alert(`File "${file.name}" tidak didukung.`);
                    submitBtn.disabled  = false;
                    submitBtn.innerHTML = originalContent;
                    return;
                }

                if (isImage && file.size > IMG_MAX) {
                    alert(`Foto "${file.name}" terlalu besar. Maksimal 5MB.`);
                    submitBtn.disabled  = false;
                    submitBtn.innerHTML = originalContent;
                    return;
                }

                if (isVideo && file.size > VIDEO_MAX) {
                    alert(`Video "${file.name}" terlalu besar. Maksimal 50MB.`);
                    submitBtn.disabled  = false;
                    submitBtn.innerHTML = originalContent;
                    return;
                }
            }
            selectedFiles.forEach(file => formData.append('bukti[]', file));
        }

        // Tambahkan violation_ids kalau terpilih
        if (_selectedViolations.length > 0) {
            const ids = _selectedViolations.map(v => v.id);
            formData.append('violation_ids', JSON.stringify(ids));
        }

        const res  = await fetch('/api/reports', { method: 'POST', body: formData });

        let data;
        const contentType = res.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
            data = await res.json();
        } else {
            if (res.status === 413) {
                alert('File yang Anda kirim terlalu besar. Batas ukuran: foto maks 5MB, video maks 50MB.');
            } else {
                alert(`Terjadi kesalahan server (${res.status}). Coba lagi.`);
            }
            submitBtn.disabled  = false;
            submitBtn.innerHTML = originalContent;
            return;
        }

        if (res.ok && data.success) {
            this.reset();
            _studentId = null;
            document.getElementById('student_id').value = '';
            document.getElementById('student-info').classList.add('hidden');
            document.getElementById('email-hint').classList.add('hidden');
            if (window.resetFileUpload) window.resetFileUpload();
            ['nisn','email','deskripsi'].forEach(id => {
                FormValidator.clearError(id);
                document.getElementById(id)?.classList.remove('border-emerald-500');
            });
            _selectedViolations = [];
            renderViolationTags();
            updateViolationIds();
            updateSubmitState();

            if (typeof openReportModal === 'function') openReportModal(data.ticket_code);
        } else if (res.status === 422 && data.errors) {
            Object.entries(data.errors).forEach(([field, msgs]) => {
                FormValidator.showError(field, Array.isArray(msgs) ? msgs[0] : msgs);
            });
        } else {
            alert(data.message || 'Terjadi kesalahan. Coba lagi.');
        }
    } catch (err) {
        console.error(err);
        alert('Koneksi bermasalah. Periksa internet Anda dan coba lagi.');
    } finally {
        _isSubmitting = false;
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalContent;
    }
});

/* ─── Real-time validasi field ortu ──────── */
document.getElementById('reporter_phone').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 15);
    if (this.value) FormValidator.clearError('reporter_phone');
});
document.getElementById('reporter_phone').addEventListener('blur', function() {
    const v = FormValidator.validatePhone(this.value);
    if (!v.valid) FormValidator.showError('reporter_phone', v.message);
    else { FormValidator.clearError('reporter_phone'); FormValidator.showSuccess('reporter_phone'); }
});
document.getElementById('reporter_name').addEventListener('blur', function() {
    const v = FormValidator.validateName(this.value);
    if (!v.valid) FormValidator.showError('reporter_name', v.message);
    else { FormValidator.clearError('reporter_name'); FormValidator.showSuccess('reporter_name'); }
});
document.getElementById('reporter_name').addEventListener('input', function() {
    if (this.value.length >= 3) FormValidator.clearError('reporter_name');
});
document.getElementById('child_name').addEventListener('blur', function() {
    const v = FormValidator.validateName(this.value);
    if (!v.valid) FormValidator.showError('child_name', v.message);
    else { FormValidator.clearError('child_name'); FormValidator.showSuccess('child_name'); }
});
document.getElementById('child_name').addEventListener('input', function() {
    if (this.value.length >= 3) FormValidator.clearError('child_name');
});

/* ─── Violation Suggestion dari Deskripsi ── */
let _selectedViolations  = [];
let _suggestionTimeout   = null;
let _allViolations       = [];
let _activeSuggestionIdx = -1;
let _currentMatches      = [];

// 1. Ambil Data API & Pasang CCTV Log
// 1. Ambil Data & Otomatis Hapus Duplikat (Misal: Isolasi ada 2)
async function loadAllViolations() {
    try {
        const res  = await fetch('/api/violation-types/autocomplete');
        let data = await res.json();
        
        // Jaga-jaga kalau Laravel membungkus dalam "data: []"
        if (data && Array.isArray(data.data)) data = data.data;

        if (Array.isArray(data)) {
            // FILTER: Hapus nama tindakan yang dobel dari database
            const unique = [];
            const seen = new Set();
            for (const item of data) {
                const cleanName = (item.name || '').trim().toLowerCase();
                if (!seen.has(cleanName)) {
                    seen.add(cleanName);
                    unique.push(item);
                }
            }
            _allViolations = unique; // Simpan data yang sudah bersih
        }
    } catch(e) { 
        console.error("❌ GAGAL MEMUAT API:", e); 
    }
}
loadAllViolations();

function scanDeskripsi(text) {
    if (!_allViolations || _allViolations.length === 0) return [];

    const cleanText = text.toLowerCase().replace(/[^\w\s]/g, '');
    const words = cleanText.split(/\s+/).filter(w => w.length >= 3);

    return _allViolations.filter(vt => {
        if (_selectedViolations.find(s => s.id === vt.id)) return false;

        const nameLower = (vt.name || '').toLowerCase();
        const nameWords = nameLower.split(/\s+/).filter(w => w.length >= 2);

        const keywordList = (vt.keywords || '')
            .split(',')
            .map(k => k.trim().toLowerCase())
            .filter(k => k.length >= 2);

        const allTerms = [...nameWords, ...keywordList];

        // Aturan 1: nama lengkap ada di teks
        if (cleanText.includes(nameLower)) return true;

        for (const w of words) {
            for (const term of allTerms) {
                if (w === term) return true;
                if (w.startsWith(term) && term.length >= 3) return true;
                if (term.startsWith(w) && w.length >= 3) return true;
                if (w.includes(term) && term.length >= 4) return true;
            }
        }

        return false;
    });
}

function showDropdown(matches) {
    const box = document.getElementById('violation-dropdown');
    if (!box) return;

    _currentMatches      = matches;
    _activeSuggestionIdx = -1;

    if (matches.length === 0) {
        box.classList.add('hidden');
        box.innerHTML = '';
        return;
    }

    box.innerHTML = matches.map((v, i) => `
        <div class="vt-suggestion-item" data-idx="${i}" data-id="${v.id}"
            onmouseover="setActiveIdx(${i})"
            onmouseout="setActiveIdx(-1)"
            onmousedown="selectViolation(${v.id},'${v.name.replace(/'/g,"\\'")}','${v.category}',${v.weight})">
            <span class="vt-suggestion-icon">
                ${v.category === 'Fisik' ? '🥊' : '💬'}
            </span>
            <span class="vt-suggestion-name">${v.name}</span>
            <span class="vt-suggestion-cat">${v.category === 'Fisik' ? 'Fisik' : 'Verbal'}</span>
        </div>
    `).join('');

    box.classList.remove('hidden');
}

function hideDropdown() {
    const box = document.getElementById('violation-dropdown');
    if (box) box.classList.add('hidden');
    _activeSuggestionIdx = -1;
}

function setActiveIdx(idx) {
    _activeSuggestionIdx = idx;
    const items = document.querySelectorAll('#violation-dropdown .vt-suggestion-item');
    items.forEach((el, i) => {
        el.classList.toggle('vt-suggestion-active', i === idx);
    });
}

// 4. Memilih Tindakan
function selectViolation(id, name, category, weight) {
    if (_selectedViolations.find(v => v.id === id)) return;
    _selectedViolations.push({ id, name, category, weight });

    const textarea = document.getElementById('deskripsi');
    const fullText = textarea.value;
    const words    = fullText.trimEnd().split(/\s+/);
    const lastWord = words[words.length - 1] ?? '';

    const nameWords = name.toLowerCase().split(/\s+/);
    const matchedNameWord = nameWords.find(w => w.startsWith(lastWord.toLowerCase()) && lastWord.length >= 3);

// Tentukan apakah nama perlu kapital atau lowercase
    function smartCase(nameStr, fullStr) {
        const trimmed = fullStr.trimEnd();
        // Kapital jika: teks kosong, atau karakter terakhir adalah titik/tanda tanya/seru
        const lastChar = trimmed.slice(-1);
        const isStartOfSentence = trimmed === '' || ['.', '!', '?'].includes(lastChar);
        if (isStartOfSentence) {
            return nameStr.charAt(0).toUpperCase() + nameStr.slice(1).toLowerCase();
        }
        return nameStr.toLowerCase();
    }

    const casedName = smartCase(name, fullText);

    if (matchedNameWord && lastWord.length >= 3) {
        words[words.length - 1] = casedName;
        textarea.value = words.join(' ') + ' ';
    } else {
        textarea.value = fullText.trimEnd() ? fullText.trimEnd() + ' ' + casedName + ' ' : casedName + ' ';
    }

    textarea.focus();
    textarea.setSelectionRange(textarea.value.length, textarea.value.length);

    renderViolationTags();
    updateViolationIds();
    updateSubmitState();
    hideDropdown();

    showDropdown(scanDeskripsi(textarea.value));
    document.getElementById('violation_ids-error')?.classList.add('hidden');
}

function removeViolation(id) {
    const removed = _selectedViolations.find(v => v.id === id);
    _selectedViolations = _selectedViolations.filter(v => v.id !== id);

    // Hapus nama violation dari textarea (case-insensitive)
    if (removed) {
        const textarea = document.getElementById('deskripsi');
        const regex = new RegExp('\\s*' + removed.name.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\s*', 'gi');
        textarea.value = textarea.value.replace(regex, ' ').trim();
    }

    renderViolationTags();
    updateViolationIds();
    updateSubmitState();

    const deskripsi = document.getElementById('deskripsi').value;
    showDropdown(scanDeskripsi(deskripsi));
}

function renderViolationTags() {
    const tags = document.getElementById('violation_tags');
    const wrap = document.getElementById('violation_tags_wrap');
    if (!tags) return;

    tags.innerHTML = _selectedViolations.map(v => `
        <span class="vt-tag" style="
            display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 500;
            /* CEK KATEGORI FISIK DI SINI */
            background:${v.category === 'Fisik' ? '#fee2e2' : '#ede9fe'};
            color:${v.category === 'Fisik' ? '#991b1b' : '#4c1d95'};
            border: 1px solid ${v.category === 'Fisik' ? '#fca5a5' : '#c4b5fd'};">
            <span>${v.name}</span>
            <button type="button" onclick="removeViolation(${v.id})" style="cursor:pointer; font-weight:bold; color:inherit; background:none; border:none;">✕</button>
        </span>
    `).join('');

    if (wrap) wrap.style.display = _selectedViolations.length > 0 ? 'block' : 'none';
}

function updateViolationIds() {
    const el = document.getElementById('violation_ids');
    if (el) el.value = _selectedViolations.map(v => v.id).join(',');
}

function updateSubmitState() {
    const btn  = document.getElementById('submitBtn');
    const hint = document.getElementById('violation-required-hint');
    const hasViolation = _selectedViolations.length > 0;

    if(btn) {
        btn.disabled = !hasViolation;
        btn.classList.toggle('opacity-50', !hasViolation);
        btn.classList.toggle('cursor-not-allowed', !hasViolation);
    }
    if (hint) hint.style.display = hasViolation ? 'none' : 'flex';
}

/* ── Keyboard & Input Navigation ── */
document.getElementById('deskripsi').addEventListener('keydown', function(e) {
    const box = document.getElementById('violation-dropdown');
    if (box?.classList.contains('hidden')) return;

    if (e.key === 'ArrowDown') {
        e.preventDefault();
        setActiveIdx(Math.min(_activeSuggestionIdx + 1, _currentMatches.length - 1));
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        setActiveIdx(Math.max(_activeSuggestionIdx - 1, 0));
    } else if (e.key === 'Enter') {
        e.preventDefault();
        if (_activeSuggestionIdx >= 0 && _currentMatches[_activeSuggestionIdx]) {
            const v = _currentMatches[_activeSuggestionIdx];
            selectViolation(v.id, v.name, v.category, v.weight);
        }
    } else if (e.key === 'Escape') {
        hideDropdown();
    }
});

document.getElementById('deskripsi').addEventListener('input', function() {
    clearTimeout(_suggestionTimeout);
    if (this.value) FormValidator.clearError('deskripsi');

    // Auto hapus tag jika namanya tidak ada lagi di textarea
    const currentText = this.value.toLowerCase();
    const toRemove = _selectedViolations.filter(v => {
        return !currentText.includes(v.name.toLowerCase());
    });
    if (toRemove.length > 0) {
        toRemove.forEach(v => {
            _selectedViolations = _selectedViolations.filter(s => s.id !== v.id);
        });
        renderViolationTags();
        updateViolationIds();
        updateSubmitState();
    }

    _suggestionTimeout = setTimeout(() => {
        showDropdown(scanDeskripsi(this.value));
    }, 300);
});

document.getElementById('deskripsi').addEventListener('blur', function() {
    setTimeout(() => hideDropdown(), 250); 
});

// Init — disable submit saat pertama load
updateSubmitState();