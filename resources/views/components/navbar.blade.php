<nav class="glass-effect fixed top-0 left-0 right-0 z-50 animate-fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-2 delay-1 animate-slide-up">
                <div class="logo-container">
                    <img src="{{ asset('images/logoSMK.png') }}" alt="Logo SMK Muhammadiyah 3">
                </div>
                <div class="flex flex-col">
                    <span class="font-display text-lg sm:text-xl font-bold gradient-text">
                        Sekolah Aman
                    </span>
                    <span class="text-xs text-gray-600 hidden sm:block font-medium">SMK Muhammadiyah 3</span>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-8 delay-2 animate-slide-up">
                <a href="{{ route('home') }}" 
                   class="nav-link font-semibold text-sm transition-colors {{ Route::is('home') ? 'active text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                    Home
                </a>

                <a href="{{ route('lapor.index') }}" 
                   class="nav-link font-semibold text-sm transition-colors {{ Route::is('lapor.index') ? 'active text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                    Lapor
                </a>

                <a href="{{ route('lapor.lacak') }}" 
                   class="nav-link font-semibold text-sm transition-colors {{ Route::is('lapor.lacak') ? 'active text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                    Lacak
                </a>

                <a href="#kontak" class="ml-2 px-6 py-2.5 bg-gradient-to-r from-primary-green to-dark-green text-white rounded-full text-sm font-bold hover-lift shadow-md transition-all">
                    Kontak
                </a>
            </div>

            <button class="md:hidden text-gray-800 focus:outline-none p-2" onclick="toggleMobileMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <div id="mobileMenu" class="hidden md:hidden mobile-menu">
        <div class="px-4 py-4 space-y-3 bg-white shadow-xl border-t border-gray-100">
            <a href="{{ route('home') }}" class="block font-semibold text-sm text-gray-800 hover:text-primary-green py-2 transition-colors">
                Home
            </a>
            <a href="{{ route('lapor.index') }}" class="block font-semibold text-sm text-gray-800 hover:text-primary-green py-2 transition-colors">
                Lapor
            </a>
            
            <a href="{{ route('lapor.lacak') }}" 
               class="block font-semibold text-sm text-gray-800 hover:text-primary-green py-2 transition-colors">
                Lacak
            </a>
            
            <a href="#kontak" class="block font-semibold text-sm text-primary-green hover:text-dark-green py-2 transition-colors">
                Kontak
            </a>
        </div>
    </div>
</nav>

<script>

function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('hidden');
    }
}

window.openModal = function() {
    if (typeof lacakModule !== 'undefined') {
        lacakModule.openPopup();
    } else {
        console.error('lacakModule is not defined. Pastikan lacak-page.js sudah dimuat.');
    }
};
</script>