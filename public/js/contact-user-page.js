document.addEventListener('DOMContentLoaded', function () {

    function toggleAnon(cb) {
        const nama  = document.getElementById('kNama');
        if (cb.checked) {
            nama.disabled  = true; nama.placeholder  = '— Anonim —'; nama.value = '';
            nama.classList.remove('error');
            document.getElementById('err-nama').classList.add('hidden');
        } else {
            nama.disabled  = false; nama.placeholder  = 'Nama kamu';
        }
    }

    window.toggleAnon = toggleAnon;

    document.getElementById('kAnonim').addEventListener('change', function () {
        toggleAnon(this);
    });

    window.openKontakModal = function () {
        const modal   = document.getElementById('kontakSuccessModal');
        const content = document.getElementById('kontakModalContent');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        setTimeout(function () {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    };

    window.closeKontakModal = function () {
        const modal   = document.getElementById('kontakSuccessModal');
        const content = document.getElementById('kontakModalContent');

        content.classList.add('scale-95', 'opacity-0');
        content.classList.remove('scale-100', 'opacity-100');

        setTimeout(function () {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';

            document.getElementById('kontakForm').reset();
            toggleAnon({ checked: false });
        }, 300);
    };

    window.resetKontakForm = function () {
        document.getElementById('kontakForm').reset();
        toggleAnon({ checked: false });
        closeKontakModal();
    };

    document.getElementById('kontakSuccessModal').addEventListener('click', function (e) {
        if (e.target === this) closeKontakModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('kontakSuccessModal');
            if (!modal.classList.contains('hidden')) closeKontakModal();
        }
    });

    document.getElementById('kontakForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const anonim  = document.getElementById('kAnonim').checked;
        const nama    = document.getElementById('kNama').value.trim();
        const email   = document.getElementById('kEmail').value.trim();
        const pesan   = document.getElementById('kPesan').value.trim();
        const alertEl = document.getElementById('formAlert');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let valid = true;

        ['kNama', 'kEmail', 'kPesan'].forEach(function (id) {
            document.getElementById(id).classList.remove('error');
        });
        ['err-nama', 'err-email', 'err-pesan'].forEach(function (id) {
            document.getElementById(id).classList.add('hidden');
        });
        alertEl.classList.add('hidden');

        if (!anonim && !nama) {
            document.getElementById('kNama').classList.add('error');
            document.getElementById('err-nama').classList.remove('hidden');
            valid = false;
        }
        if (!anonim && !email) {
            document.getElementById('kEmail').classList.add('error');
            document.getElementById('err-email').textContent = 'Email wajib diisi.';
            document.getElementById('err-email').classList.remove('hidden');
            valid = false;
        } else if (!anonim && !emailRegex.test(email)) {
            document.getElementById('kEmail').classList.add('error');
            document.getElementById('err-email').textContent = 'Format email tidak valid.';
            document.getElementById('err-email').classList.remove('hidden');
            valid = false;
        }
        if (!pesan) {
            document.getElementById('kPesan').classList.add('error');
            document.getElementById('err-pesan').classList.remove('hidden');
            valid = false;
        }

        if (!valid) {
            alertEl.classList.remove('hidden');
            return;
        }

        const btn = document.getElementById('kformSubmit');
        btn.classList.add('loading');

        setTimeout(function () {
            btn.classList.remove('loading');
            openKontakModal();
        }, 1400);
    });

});