const FormValidator = {
    validateNISN: function(value) {
        if (!value.trim()) {
            return { valid: false, message: 'NISN wajib diisi' };
        }
        if (!/^\d+$/.test(value)) {
            return { valid: false, message: 'NISN hanya boleh berisi angka' };
        }
        if (value.length < 6) {
            return { valid: false, message: 'NISN minimal 6 digit' };
        }
        return { valid: true, message: '' };
    },

    validateEmail: function(value) {
        if (!value.trim()) {
            return { valid: false, message: 'Email wajib diisi' };
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            return { valid: false, message: 'Format email tidak valid' };
        }
        return { valid: true, message: '' };
    },

    validateDeskripsi: function(value) {
        if (!value.trim()) {
            return { valid: false, message: 'Deskripsi kejadian wajib diisi' };
        }
        if (value.trim().length < 20) {
            return { valid: false, message: `Minimal 20 karakter (saat ini: ${value.trim().length})` };
        }
        return { valid: true, message: '' };
    },

    showError: function(inputId, message) {
        const input = document.getElementById(inputId);
        const errorElement = document.getElementById(`${inputId}-error`);

        input.classList.add('border-red-500', 'shake-animation');
        input.classList.remove('border-emerald-500');

        errorElement.textContent = message;
        errorElement.classList.remove('hidden');

        setTimeout(() => {
            input.classList.remove('shake-animation');
        }, 500);
    },

    clearError: function(inputId) {
        const input = document.getElementById(inputId);
        const errorElement = document.getElementById(`${inputId}-error`);

        input.classList.remove('border-red-500');
        errorElement.classList.add('hidden');
        errorElement.textContent = '';
    },

    showSuccess: function(inputId) {
        const input = document.getElementById(inputId);
        input.classList.add('border-emerald-500');
        input.classList.remove('border-red-500');
    }
};

document.getElementById('nisn').addEventListener('input', function(e) {
    const oldValue = this.value;

    this.value = this.value.replace(/\D/g, '');

    if (oldValue !== this.value && oldValue.length > this.value.length) {
        this.classList.add('shake-animation');
        FormValidator.showError('nisn', 'Hanya boleh angka');

        setTimeout(() => {
            this.classList.remove('shake-animation');
        }, 500);
    }

    if (this.value) {
        const validation = FormValidator.validateNISN(this.value);
        if (validation.valid) {
            FormValidator.clearError('nisn');
            FormValidator.showSuccess('nisn');
        } else {
            FormValidator.showError('nisn', validation.message);
        }
    } else {
        FormValidator.clearError('nisn');
    }
});

document.getElementById('email').addEventListener('blur', function() {
    const validation = FormValidator.validateEmail(this.value);
    if (!validation.valid) {
        FormValidator.showError('email', validation.message);
    } else {
        FormValidator.clearError('email');
        FormValidator.showSuccess('email');
    }
});

document.getElementById('email').addEventListener('input', function() {
    if (this.value) {
        FormValidator.clearError('email');
    }
});

document.getElementById('deskripsi').addEventListener('blur', function() {
    const validation = FormValidator.validateDeskripsi(this.value);
    if (!validation.valid) {
        FormValidator.showError('deskripsi', validation.message);
    } else {
        FormValidator.clearError('deskripsi');
        FormValidator.showSuccess('deskripsi');
    }
});

document.getElementById('deskripsi').addEventListener('input', function() {
    if (this.value) {
        FormValidator.clearError('deskripsi');
    }
});

document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const nisn = document.getElementById('nisn').value;
    const email = document.getElementById('email').value;
    const deskripsi = document.getElementById('deskripsi').value;

    const nisnValidation = FormValidator.validateNISN(nisn);
    const emailValidation = FormValidator.validateEmail(email);
    const deskripsiValidation = FormValidator.validateDeskripsi(deskripsi);

    let isValid = true;

    if (!nisnValidation.valid) {
        FormValidator.showError('nisn', nisnValidation.message);
        isValid = false;
    }

    if (!emailValidation.valid) {
        FormValidator.showError('email', emailValidation.message);
        isValid = false;
    }

    if (!deskripsiValidation.valid) {
        FormValidator.showError('deskripsi', deskripsiValidation.message);
        isValid = false;
    }

    if (!isValid) {
        const firstError = document.querySelector('.border-red-500');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
        return;
    }

    const submitBtn = document.getElementById('submitBtn');
    const originalContent = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Mengirim...</span>
    `;

    setTimeout(() => {
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = String(now.getFullYear()).slice(-2);
        const uniqueCode = Math.random().toString(36).substr(2, 4).toUpperCase();

        const generatedCode = `KRF-${day}${month}${year}-${uniqueCode}`;

        this.reset();
        if (window.resetFileUpload) window.resetFileUpload();

        FormValidator.clearError('nisn');
        FormValidator.clearError('email');
        FormValidator.clearError('deskripsi');
        document.getElementById('nisn').classList.remove('border-emerald-500');
        document.getElementById('email').classList.remove('border-emerald-500');
        document.getElementById('deskripsi').classList.remove('border-emerald-500');

        submitBtn.disabled = false;
        submitBtn.innerHTML = originalContent;

        openReportModal(generatedCode);

    }, 1500);
});