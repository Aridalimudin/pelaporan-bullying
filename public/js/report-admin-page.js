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

function toggleNotif() {
    document.getElementById('notifDropdown').classList.toggle('open');
    document.getElementById('avatarDropdown').classList.remove('open');
}
function toggleAvatar() {
    document.getElementById('avatarDropdown').classList.toggle('open');
    document.getElementById('notifDropdown').classList.remove('open');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('#notifWrap'))  document.getElementById('notifDropdown')?.classList.remove('open');
    if (!e.target.closest('#avatarWrap')) document.getElementById('avatarDropdown')?.classList.remove('open');
});

function initTableFilter() {
    const rows      = document.querySelectorAll('#tableBody .table-row:not(.empty-row)');
    const emptyRows = document.querySelectorAll('.empty-row');
    const noResults = document.getElementById('noResults');
    const tableInfo = document.getElementById('tableInfo');
    const total     = rows.length;

    function filter() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        const u = document.getElementById('filterUrgensi').value.toLowerCase();
        let visible = 0;
        rows.forEach(row => {
            const show = row.textContent.toLowerCase().includes(q) && (u === '' || row.dataset.urgensi === u);
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        emptyRows.forEach(r => r.style.display = visible > 0 ? '' : 'none');
        noResults?.classList.toggle('hidden', visible > 0);
        if (tableInfo) tableInfo.textContent = `Menampilkan ${visible} dari ${total} laporan`;
    }

    document.getElementById('searchInput')?.addEventListener('input', filter);
    document.getElementById('filterUrgensi')?.addEventListener('change', filter);
}

function openModal(data) {
    document.getElementById('modalKode').textContent      = data.kode     || '—';
    document.getElementById('mNama').textContent          = data.nama     || '—';
    document.getElementById('mNis').textContent           = data.nis      || '—';
    document.getElementById('mKelas').textContent         = data.kelas    || '—';
    document.getElementById('mUrgensi').textContent       = data.urgensi  || '—';
    document.getElementById('mDeskripsi').textContent     = data.deskripsi|| '—';
    if (document.getElementById('mTanggal'))
        document.getElementById('mTanggal').textContent  = data.tanggal  || '—';
    document.getElementById('detailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.body.style.overflow = '';
}
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('detailModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    initTableFilter();
});