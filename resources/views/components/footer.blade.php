@if(($type ?? 'user') === 'admin')

    <footer class="page-footer">
        <strong>SMK Muhammadiyah 3 Kadungora</strong> · Bersama Sekolah Aman. Semua Hak Terlindungi.
    </footer>

@else

    <footer class="footer-compact animate-fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-base sm:text-lg font-bold mb-0.5">
                    SMK Muhammadiyah 3 Kadungora
                </p>
            </div>
        </div>
    </footer>

@endif