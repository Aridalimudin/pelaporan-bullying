<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin — Sekolah Aman' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>
<body>

    @yield('content')

    <script>
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

        window.openSidebar    = openSidebar;
        window.closeSidebar   = closeSidebar;
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
    });
    </script>

    @stack('scripts')

</body>
</html>