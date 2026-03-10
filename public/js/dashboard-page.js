document.addEventListener('DOMContentLoaded', function () {

    function openSidebar() {
        document.getElementById('adminSidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('adminSidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }
    function toggleNavGroup(id) {
        const group  = document.getElementById(id);
        const isOpen = group.classList.contains('open');
        document.querySelectorAll('.nav-group.open').forEach(g => g.classList.remove('open'));
        if (!isOpen) group.classList.add('open');
    }

    window.openSidebar   = openSidebar;
    window.closeSidebar  = closeSidebar;
    window.toggleNavGroup = toggleNavGroup;

    function toggleNotif() {
        document.getElementById('notifDropdown').classList.toggle('open');
        document.getElementById('avatarDropdown').classList.remove('open');
    }
    function toggleAvatar() {
        document.getElementById('avatarDropdown').classList.toggle('open');
        document.getElementById('notifDropdown').classList.remove('open');
    }

    window.toggleNotif  = toggleNotif;
    window.toggleAvatar = toggleAvatar;

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#notifWrap'))  document.getElementById('notifDropdown')?.classList.remove('open');
        if (!e.target.closest('#avatarWrap')) document.getElementById('avatarDropdown')?.classList.remove('open');
    });

    function updateClock() {
        const now    = new Date();
        const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        const dayEl  = document.getElementById('dashDay');
        const dateEl = document.getElementById('dashDate');
        const timeEl = document.getElementById('dashTime');

        if (dayEl)  dayEl.textContent  = now.getDate().toString().padStart(2, '0');
        if (dateEl) dateEl.textContent = `${days[now.getDay()]}, ${months[now.getMonth()]} ${now.getFullYear()}`;
        if (timeEl) {
            const hh = now.getHours().toString().padStart(2, '0');
            const mm = now.getMinutes().toString().padStart(2, '0');
            const ss = now.getSeconds().toString().padStart(2, '0');
            timeEl.textContent = `${hh}:${mm}:${ss}`;
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

});