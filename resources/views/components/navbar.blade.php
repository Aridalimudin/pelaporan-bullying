<nav class="glass-effect fixed top-0 left-0 right-0 z-50 animate-fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 delay-1 animate-slide-up hover:opacity-90 transition-opacity" style="text-decoration: none;">
                <div class="logo-container">
                    <img src="{{ asset('images/logoSMK.png') }}" alt="Logo SMK Muhammadiyah 3">
                </div>
                <div class="flex flex-col">
                    <span class="font-display text-lg sm:text-xl font-bold gradient-text">
                        Sekolah Aman
                    </span>
                    <span class="text-xs text-gray-600 hidden sm:block font-medium">SMK Muhammadiyah 3</span>
                </div>
            </a>

            {{-- Desktop Navigation Links --}}
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

                {{-- Tombol Utama di Kanan Navbar: Login Siswa (Guest) ATAU Dashboard Saya (Logged in) --}}
                @if(Auth::guard('student')->check())
                    @php $navStudent = Auth::guard('student')->user(); @endphp
                    <a href="{{ route('siswa.dashboard') }}" 
                       class="ml-2 px-5 py-2.5 bg-emerald-50 hover:bg-emerald-100 border-2 border-emerald-300 text-emerald-800 rounded-full font-extrabold text-sm transition-all duration-300 shadow-sm hover:shadow-md hover:scale-105 inline-flex items-center gap-2 group" style="text-decoration: none;">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-black">
                            {{ strtoupper(substr($navStudent->fullname, 0, 1)) }}
                        </span>
                        <span>Dashboard Saya</span>
                        <svg class="w-4 h-4 text-emerald-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('siswa.login') }}" 
                       class="ml-2 px-6 py-2.5 bg-gradient-to-r from-primary-green to-dark-green text-white rounded-full text-sm font-bold hover-lift shadow-md transition-all inline-flex items-center gap-2 group" style="text-decoration: none;">
                        <svg class="w-4 h-4 text-emerald-200 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l-4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Login Siswa</span>
                    </a>
                @endif
            </div>

            {{-- Mobile Menu Hamburger --}}
            <button class="md:hidden text-gray-800 focus:outline-none p-2" onclick="toggleMobileMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div id="mobileMenu" class="hidden md:hidden mobile-menu">
        <div class="px-4 py-4 space-y-3 bg-white shadow-xl border-t border-gray-100">
            <a href="{{ route('home') }}" class="block font-semibold text-sm text-gray-800 hover:text-primary-green py-2 transition-colors">
                Home
            </a>
            <a href="{{ route('lapor.index') }}" class="block font-semibold text-sm text-gray-800 hover:text-primary-green py-2 transition-colors">
                Lapor
            </a>
            <a href="{{ route('lapor.lacak') }}" class="block font-semibold text-sm text-gray-800 hover:text-primary-green py-2 transition-colors">
                Lacak
            </a>
            @if(Auth::guard('student')->check())
                <div class="pt-2 border-t border-gray-100">
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center justify-between font-bold text-sm text-emerald-700 bg-emerald-50 px-4 py-3 rounded-xl border border-emerald-200">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(Auth::guard('student')->user()->fullname, 0, 1)) }}
                            </span>
                            Dashboard Saya
                        </span>
                        <span>→</span>
                    </a>
                </div>
            @else
                <div class="pt-2 border-t border-gray-100">
                    <a href="{{ route('siswa.login') }}" class="block text-center font-bold text-sm text-white bg-gradient-to-r from-primary-green to-dark-green px-4 py-2.5 rounded-xl shadow">
                        🔐 Login Siswa
                    </a>
                </div>
            @endif
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
</script>