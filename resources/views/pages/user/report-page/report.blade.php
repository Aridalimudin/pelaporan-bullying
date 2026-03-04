@extends('layouts.app-form')

@section('content')
<div class="decorative-circle" style="top: 5%; left: 5%; width: 250px; height: 250px; background: #10b981;"></div>
<div class="decorative-circle" style="bottom: 5%; right: 5%; width: 300px; height: 300px; background: #059669;"></div>

@include('components.navbar')

<main class="form-section relative px-4 sm:px-6 lg:px-8 bg-pattern">
    <div class="max-w-2xl mx-auto relative z-10">
        <div class="w-full delay-3 animate-slide-up">

            <div class="form-card">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-emerald-50 rounded-2xl mb-4">
                        <svg class="w-7 h-7 text-primary-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
                        Formulir Pelaporan Siswa
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base">
                        Laporan anda akan ditangani secara cepat dan aman.
                    </p>
                </div>

                <form id="reportForm" class="space-y-5" novalidate>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="nisn" class="form-label">
                                <span class="text-gray-800 font-semibold text-sm">NISN</span>
                                <span class="text-red-500 text-sm">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="nisn" 
                                name="nisn" 
                                class="form-input" 
                                placeholder="Nomor Induk Siswa Nasional"
                                required
                                pattern="[0-9]*"
                                maxlength="6"
                                inputmode="numeric"
                            >
                            <p id="nisn-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <span class="text-gray-800 font-semibold text-sm">Email</span>
                                <span class="text-red-500 text-sm">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                placeholder="emailanda@example.com"
                                required
                            >
                            <p id="email-error" class="text-xs text-red-600 mt-1.5 hidden"></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="form-label">
                            <span class="text-gray-800 font-semibold text-sm">Deskripsi Kejadian</span>
                            <span class="text-red-500 text-sm">*</span>
                        </label>
                        <textarea 
                            id="deskripsi" 
                            name="deskripsi" 
                            rows="5" 
                            class="form-input resize-none" 
                            placeholder="Ceritakan kejadian yang anda alami dengan detail..."
                            required
                            minlength="20"
                        ></textarea>
                        <div class="flex justify-between items-center mt-1.5">
                            <p id="deskripsi-error" class="text-xs text-red-600 hidden"></p>
                            <p class="text-xs text-gray-500">Minimal 20 karakter</p>
                        </div>
                    </div>

                    @include('components.file-upload')

                    <div class="privacy-notice">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 mb-1">Privasi Terjamin</h4>
                                <p class="text-xs text-gray-600 leading-relaxed">
                                    Laporan Anda akan ditangani secara rahasia. Data pribadi dilindungi sesuai kebijakan privasi sekolah.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="btn-submit w-full"
                            id="submitBtn"
                        >
                            <span>Kirim Laporan</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</main>

@include('components.modal-success')
@include('components.footer')

<script>
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
</script>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-8px); }
    20%, 40%, 60%, 80% { transform: translateX(8px); }
}

.shake-animation {
    animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
}

.form-input.border-red-500 {
    background-color: #fef2f2;
}

.form-input.border-red-500:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.form-input.border-emerald-500 {
    background-color: #f0fdf4;
}
</style>
@endsection