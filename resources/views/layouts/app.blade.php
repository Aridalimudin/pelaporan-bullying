<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sekolah Aman - Stop Bullying' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-green': '#10b981',
                        'dark-green': '#059669',
                        'light-green': '#d1fae5',
                        'soft-green': '#ecfdf5',
                    },
                    fontFamily: {
                        'sans': ['Plus Jakarta Sans', 'sans-serif'],
                        'display': ['Lexend', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        h1, h2, h3, h4, h5, h6 {
            overflow: visible !important;
            line-height: 1.3 !important;
        }

        .gradient-text {
            padding: 2px 0;
            display: inline-block;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/welcome-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report-user-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/track-user-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact-user-page.css') }}">
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans">

    @yield('content')

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const menuButton = event.target.closest('button[onclick="toggleMobileMenu()"]');
            const isClickInsideMenu = event.target.closest('#mobileMenu');

            if (mobileMenu && !mobileMenu.classList.contains('hidden') && !menuButton && !isClickInsideMenu) {
                mobileMenu.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu) {
                const links = mobileMenu.querySelectorAll('a');
                links.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                    });
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>