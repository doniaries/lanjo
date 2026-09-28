@php
    use App\Models\Pengaturan;
    use Illuminate\Support\Str;
    $pengaturan = \Illuminate\Support\Facades\Cache::rememberForever('site_settings', function () {
        return Pengaturan::first();
    });
    $siteName = $pengaturan->name ?? config('app.name');
    $defaultLogo = asset('images/logo.png');

    if ($pengaturan?->logo) {
        if (Str::startsWith($pengaturan->logo, ['http://', 'https://'])) {
            $logoUrl = $pengaturan->logo;
        } elseif (Str::startsWith($pengaturan->logo, 'images/')) {
            $logoUrl = asset($pengaturan->logo);
        } else {
            $logoUrl = asset('storage/' . $pengaturan->logo);
        }
    } else {
        $logoUrl = $defaultLogo;
    }
@endphp

<header x-data="{ scrolled: false }" @scroll.window="scrolled = (window.scrollY > 50)"
    class="sticky top-0 z-50 bg-white dark:bg-gray-900 transition-all duration-300 ease-in-out"
    :class="{ 'shadow-md': scrolled }">
    <!-- Top Bar -->
    <div class="border-b border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between transition-all duration-300 ease-in-out"
                :class="{ 'py-2': scrolled, 'py-3': !scrolled }">
                <!-- Logo Group -->
                <div class="flex items-center gap-4">
                    <a wire:navigate href="{{ url('/') }}"
                        class="flex items-center gap-3 border-r border-gray-200 dark:border-gray-700 pr-4 transition-all duration-300">
                        <img src="{{ $logoUrl }}" alt="Logo"
                            class="w-auto h-12 object-contain transition-all duration-300 ease-in-out"
                            :class="{ 'h-9!': scrolled }" onerror="this.src='{{ $defaultLogo }}'">
                        <div class="flex flex-col justify-center">
                            <span
                                class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 uppercase transition-all duration-300"
                                :class="{ 'opacity-0 h-0 overflow-hidden': scrolled }">Pemerintah Kabupaten
                                {{ $pengaturan->kabupaten ?? 'Sijunjung' }}</span>
                            <h1 class="text-xs sm:text-base font-bold text-gray-900 dark:text-white uppercase leading-tight transition-all duration-300"
                                :class="{ 'text-sm!': scrolled }">{{ $siteName }}</h1>
                        </div>
                    </a>

                    <!-- Partner Logos (Desktop) -->
                    <div class="hidden lg:flex items-center gap-4 transition-all duration-300">
                        <img src="{{ asset('images/geopark.png') }}" alt="Geopark Silokek"
                            class="w-auto h-10 transition-all duration-300 ease-in-out" :class="{ 'h-8!': scrolled }">
                        <img src="{{ asset('images/bangga.png') }}" alt="Bangga"
                            class="w-auto h-8 transition-all duration-300 ease-in-out" :class="{ 'h-6!': scrolled }">
                        <img src="{{ asset('images/berakhlak.png') }}" alt="Berakhlak"
                            class="w-auto h-8 transition-all duration-300 ease-in-out" :class="{ 'h-6!': scrolled }">
                    </div>
                </div>

                <!-- Dark Mode Toggle & Mobile Menu -->
                <div class="flex items-center gap-2">
                    <!-- Live Clock -->
                    <div x-data="{
                        time: '',
                        init() {
                            this.updateTime();
                            // setInterval(() => this.updateTime(), 1000); // Date only, no need for second updates
                        },
                        updateTime() {
                            const options = {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                            };
                            this.time = new Date().toLocaleDateString('id-ID', options);
                        }
                    }"
                        class="hidden md:block text-[11px] sm:text-xs font-medium text-gray-600 dark:text-gray-300 mr-2 sm:mr-4 text-right leading-tight">
                        <span x-text="time"></span>
                    </div>

                    <!-- User Menu (Auth) -->
                    @auth
                        <div x-data="{ open: false }" class="relative hidden sm:block">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 p-1.5 px-3 rounded-full text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-all duration-300 group">
                                <span class="text-xs font-semibold max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                                <div class="relative">
                                    @if (auth()->user()->avatar_url)
                                        <img src="{{ auth()->user()->getFilamentAvatarUrl() }}"
                                            class="w-7 h-7 rounded-full object-cover border border-blue-200" alt="Avatar">
                                    @else
                                        <i class="bi bi-person-circle text-xl"></i>
                                    @endif
                                    <div
                                        class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full">
                                    </div>
                                </div>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 z-[60]"
                                style="display: none;">

                                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 mb-1">
                                    <p
                                        class="text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold">
                                        Menu Akun</p>
                                </div>

                                <a href="{{ route('filament.admin.pages.dashboard') }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    <i class="bi bi-speedometer2"></i> Dashboard Admin
                                </a>

                                <a href="{{ url('/admin/my-profile') }}"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    <i class="bi bi-person-gear"></i> Profil Saya
                                </a>

                                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>

                                <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                    <!-- Dark Mode Toggle -->
                    <button @click="$store.darkMode.toggle()"
                        class="p-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                        aria-label="Mode Gelap/Terang">
                        <i class="bi bi-sun-fill text-xl" x-show="$store.darkMode.on" style="display: none;"></i>
                        <i class="bi bi-moon-fill text-xl" x-show="!$store.darkMode.on"></i>
                    </button>

                    <!-- Mobile Menu Toggle -->
                    <button id="mobile-menu-toggle"
                        class="lg:hidden p-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400"
                        aria-label="Menu Mobile">
                        <i class="bi bi-list text-3xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav id="main-nav" class="hidden lg:block">
        <div class="container mx-auto px-4 lg:px-8">
            <ul class="flex justify-center items-center">
                <!-- Home Icon -->
                <li>
                    <a wire:navigate href="{{ route('home') }}"
                        class="flex items-center px-5 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide hover:text-blue-600 dark:hover:text-blue-400 hover:border-b-2 hover:border-blue-600 dark:hover:border-blue-400 transition-all {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : '' }}">
                        <i class="bi bi-house-door-fill text-xl"></i>
                    </a>
                </li>

                <li>
                    <a wire:navigate href="{{ route('berita.index') }}"
                        class="flex items-center gap-2 px-5 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide hover:text-blue-600 dark:hover:text-blue-400 hover:border-b-2 hover:border-blue-600 dark:hover:border-blue-400 transition-all {{ request()->is('berita*') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : '' }}">
                        Berita
                    </a>
                </li>

                <!-- Profil Dropdown -->
                <li class="relative group">
                    <a href="#"
                        class="flex items-center gap-2 px-5 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide hover:text-blue-600 dark:hover:text-blue-400 transition-all">
                        Profil <i class="bi bi-chevron-down text-xs"></i>
                    </a>
                    <ul
                        class="absolute left-1/2 transform -translate-x-1/2 top-full hidden group-hover:block bg-white dark:bg-gray-800 shadow-lg rounded-b-lg min-w-[220px] py-2 z-50 border border-gray-200 dark:border-gray-700">
                        <!-- <li><a href="{{ route('home') }}#sejarah" class="block px-5 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400">Sejarah</a></li> -->

                        <li><a wire:navigate href="{{ route('struktur-organisasi') }}"
                                class="block px-5 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400">Struktur
                                Organisasi</a></li>
                        <li><a wire:navigate href="{{ route('sambutan-pimpinan') }}"
                                class="block px-5 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400">Sambutan
                                Pimpinan</a></li>
                    </ul>
                </li>

                <!-- Informasi Dropdown -->
                <li class="relative group">
                    <a href="#"
                        class="flex items-center gap-2 px-5 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide hover:text-blue-600 dark:hover:text-blue-400 transition-all {{ request()->is('ekraf*') || request()->is('agenda*') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                        Informasi <i class="bi bi-chevron-down text-xs"></i>
                    </a>
                    <ul
                        class="absolute left-1/2 transform -translate-x-1/2 top-full hidden group-hover:block bg-white dark:bg-gray-800 shadow-lg rounded-b-lg min-w-[220px] py-2 z-50 border border-gray-200 dark:border-gray-700">
                        <li><a wire:navigate href="{{ route('agenda.index') }}"
                                class="block px-5 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400">Agenda
                                Kegiatan</a></li>
                        <li><a wire:navigate href="{{ route('ekraf.index') }}"
                                class="block px-5 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400">Pelaku
                                Ekraf</a></li>

                        @foreach (\App\Models\Bidang::orderBy('name')->get() as $b)
                            <li><a wire:navigate href="{{ route('data.index', ['bidang' => $b->slug]) }}"
                                    class="block px-5 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $b->name }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li>
                    <a wire:navigate href="{{ route('galeri.index') }}"
                        class="flex items-center gap-2 px-5 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide hover:text-blue-600 dark:hover:text-blue-400 hover:border-b-2 hover:border-blue-600 dark:hover:border-blue-400 transition-all {{ request()->routeIs('galeri.index') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : '' }}">
                        Galeri
                    </a>
                </li>

                <li>
                    <a wire:navigate href="{{ route('pengumuman.index') }}"
                        class="flex items-center gap-2 px-5 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide hover:text-blue-600 dark:hover:text-blue-400 hover:border-b-2 hover:border-blue-600 dark:hover:border-blue-400 transition-all {{ request()->is('pengumuman*') ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : '' }}">
                        Pengumuman
                    </a>
                </li>

                <!-- Wisata Sijunjung Link -->
                <li class="ml-2">
                    <a href="https://wisata.sijunjung.go.id" target="_blank"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-green-500 to-emerald-600 rounded-full hover:from-green-600 hover:to-emerald-700 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 group">
                        <i class="bi bi-geo-alt-fill animate-bounce group-hover:animate-none"></i>
                        Wisata Sijunjung
                    </a>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <ul class="py-2">
            <li><a wire:navigate href="{{ route('home') }}"
                    class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 {{ request()->routeIs('home') ? 'bg-blue-50 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}"><i
                        class="bi bi-house-door-fill"></i> Beranda</a></li>
            <li><a wire:navigate href="{{ route('berita.index') }}"
                    class="block px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 {{ request()->is('berita*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">Berita</a>
            </li>

            <!-- Mobile Profil -->
            <li>
                <button
                    class="mobile-dropdown-toggle w-full flex items-center justify-between px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                    Profil <i class="bi bi-chevron-down text-xs"></i>
                </button>
                <ul class="mobile-dropdown-menu hidden bg-gray-50 dark:bg-gray-800">
                    <li><a wire:navigate href="{{ route('home') }}#sejarah"
                            class="block px-10 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Sejarah</a>
                    </li>
                    <li><a wire:navigate href="{{ route('home') }}#visi-misi"
                            class="block px-10 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Visi
                            & Misi</a></li>
                    <li><a wire:navigate href="{{ route('struktur-organisasi') }}"
                            class="block px-10 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Struktur
                            Organisasi</a></li>
                </ul>
            </li>

            <!-- Mobile Informasi -->
            <li>
                <button onclick="toggleMobileDropdown('mobile-informasi')"
                    class="w-full flex items-center justify-between px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                    <span>Informasi</span>
                    <i class="bi bi-chevron-down text-xs" id="icon-mobile-informasi"></i>
                </button>
                <ul id="mobile-informasi" class="hidden bg-gray-50 dark:bg-gray-900/50 py-2">
                    <li><a wire:navigate href="{{ route('agenda.index') }}"
                            class="block px-10 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Agenda
                            Kegiatan</a></li>
                    <li><a wire:navigate href="{{ route('ekraf.index') }}"
                            class="block px-10 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Pelaku
                            Ekraf</a></li>

                    @foreach (\App\Models\Bidang::orderBy('name')->get() as $b)
                        <li><a wire:navigate href="{{ route('data.index', ['bidang' => $b->slug]) }}"
                                class="block px-10 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Data
                                {{ $b->name }}</a></li>
                    @endforeach
                </ul>
            </li>

            <!-- Mobile Galeri -->
            <li><a wire:navigate href="{{ route('galeri.index') }}"
                    class="block px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 {{ request()->routeIs('galeri.index') ? 'bg-blue-50 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">Galeri</a>
            </li>

            <li><a wire:navigate href="{{ route('pengumuman.index') }}"
                    class="block px-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 {{ request()->is('pengumuman*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">Pengumuman</a>
            </li>

            <li class="px-5 py-3">
                <a href="https://wisata.sijunjung.go.id" target="_blank"
                    class="flex items-center justify-center gap-2 p-3 text-sm font-bold text-white bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-md">
                    <i class="bi bi-geo-alt-fill"></i> Kunjungi Wisata Sijunjung
                </a>
            </li>

            <!-- Mobile Login/Dashboard -->
            @auth
                <li class="px-5 py-3 border-t border-gray-100 dark:border-gray-700 mt-2">
                    <div class="flex items-center gap-3 mb-3">
                        @if (auth()->user()->avatar_url)
                            <img src="{{ auth()->user()->getFilamentAvatarUrl() }}"
                                class="w-10 h-10 rounded-full object-cover border border-blue-200" alt="Avatar">
                        @else
                            <i class="bi bi-person-circle text-3xl text-blue-600"></i>
                        @endif
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('filament.admin.pages.dashboard') }}"
                            class="flex items-center justify-center gap-2 p-2 text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 p-2 text-xs font-semibold bg-red-50 dark:bg-red-900/20 text-red-600 rounded-lg">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            @endauth

            <!-- Mobile Partner Logos -->
            <li
                class="px-5 py-6 border-t border-gray-100 dark:border-gray-700 mt-2 flex justify-center items-center gap-6">
                <img src="{{ asset('images/bangga.png') }}" alt="Bangga" class="h-10 w-auto object-contain">
                <img src="{{ asset('images/berakhlak.png') }}" alt="Berakhlak" class="h-10 w-auto object-contain">
            </li>
        </ul>
    </div>
</header>

@push('scripts')
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Mobile dropdown toggles
        document.querySelectorAll('.mobile-dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const menu = this.nextElementSibling;
                const icon = this.querySelector('.bi-chevron-down');
                menu.classList.toggle('hidden');
                icon.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' :
                    'rotate(180deg)';
            });
        });
    </script>
@endpush
