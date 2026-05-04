/**
 * report-user-page.js
 * Handles: NISN search, form validation, file upload, form submission ke API
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
let _studentId = null; // ID siswa yang ditemukan

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
            // Siswa ditemukan
            _studentId = data.data.id;
            document.getElementById('student_id').value = _studentId;

            document.getElementById('student-name').textContent = data.data.fullname;
            document.getElementById('student-class').textContent = `${data.data.grade} - ${data.data.major}`;
            info.classList.remove('hidden');

            // Isi email otomatis kalau ada
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
        } else {
            // Siswa tidak ditemukan
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

    // Hanya angka, maksimal 6 digit
    this.value = this.value.replace(/\D/g, '').slice(0, 6);

    // Shake jika ada karakter non-angka yang diketik
    if (before !== this.value && before.length >= this.value.length) {
        this.classList.add('shake-animation');
        setTimeout(() => this.classList.remove('shake-animation'), 500);
        if (/\D/.test(before)) {
            FormValidator.showError('nisn', 'NISN hanya boleh berisi angka');
            return;
        }
    }

    // Reset student info kalau NISN diubah
    if (_studentId) {
        _studentId = null;
        document.getElementById('student_id').value = '';
        document.getElementById('student-info').classList.add('hidden');
        const emailEl = document.getElementById('email');
        emailEl.readOnly = false;
        emailEl.classList.remove('bg-gray-50');
        document.getElementById('email-hint').classList.add('hidden');
    }

    if (this.value) FormValidator.clearError('nisn');
});

// Enter di field NISN → trigger cari
document.getElementById('nisn').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); cariSiswa(); }
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

/* ─── Form Submit ─────────────────────────── */
document.getElementById('reportForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const nisn      = document.getElementById('nisn').value.trim();
    const email     = document.getElementById('email').value.trim();
    const deskripsi = document.getElementById('deskripsi').value.trim();

    const nv = FormValidator.validateNISN(nisn);
    const ev = FormValidator.validateEmail(email);
    const dv = FormValidator.validateDeskripsi(deskripsi);

    let isValid = true;
    if (!nv.valid) { FormValidator.showError('nisn', nv.message);           isValid = false; }
    if (!ev.valid) { FormValidator.showError('email', ev.message);          isValid = false; }
    if (!dv.valid) { FormValidator.showError('deskripsi', dv.message);      isValid = false; }

    // Wajib cari siswa dulu (tombol cari harus ditekan)
    if (!_studentId && nv.valid) {
        FormValidator.showError('nisn', 'Tekan tombol cari (🔍) untuk validasi NISN terlebih dahulu.');
        isValid = false;
    }

    if (!isValid) {
        document.querySelector('.border-red-500')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    // Loading state
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
        // Kirim sebagai multipart/form-data (ada file)
        const formData = new FormData();
        formData.append('nisn',       nisn);
        formData.append('email',      email);
        formData.append('deskripsi',  deskripsi);
        formData.append('student_id', document.getElementById('student_id').value);
        formData.append('_token',     csrfToken());

        // Tambahkan file bukti
        selectedFiles.forEach(file => formData.append('bukti[]', file));

        const res  = await fetch('/api/reports', { method: 'POST', body: formData });
        const data = await res.json();

        if (res.ok && data.success) {
            // Reset form
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

            openReportModal(data.ticket_code);
        } else if (res.status === 422 && data.errors) {
            // Tampilkan error validasi dari server
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
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalContent;
    }
});