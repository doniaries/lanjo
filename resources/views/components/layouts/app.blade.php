@php
    use App\Models\Pengaturan;
    $pengaturan = \Illuminate\Support\Facades\Cache::rememberForever('site_settings', function () {
        return Pengaturan::first();
    });
    $opdName = $pengaturan->name ?? config('app.name');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="{{ $pengaturan->deskripsi ?? 'Website Resmi ' . $opdName . ' Pemerintah Kabupaten Sijunjung' }}">
    <meta name="keywords"
        content="Disparpora Sijunjung, Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung, Pariwisata Sijunjung, Geopark Ranah Minang Silokek, Berita Sijunjung">
    <meta name="author" content="{{ $opdName }}">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="qNJG2I9hHnS99WzVWE2ageiuNkNXOcKNJV0sP0uFwbg" />
    <meta name="msvalidate.01" content="CE29AB54D18AFCF0B249F162D721C64C" />

    <!-- Open Graph Default -->
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ $opdName }}" />
    <meta property="og:title" content="{{ isset($title) ? $title . ' - ' . $opdName : $opdName }}" />
    <meta property="og:description"
        content="{{ $pengaturan->deskripsi ?? 'Website Resmi ' . $opdName . ' Pemerintah Kabupaten Sijunjung' }}" />
    <meta property="og:image" content="{{ asset('images/logo.png') }}" />

    <title>{{ isset($title) ? $title . ' - ' . $opdName : $opdName }}</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}">

    <script>
        // Initialize dark mode from localStorage before Alpine loads
        const theme = localStorage.getItem('frontend_theme');
        if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Alpine.js dark mode store
        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                on: document.documentElement.classList.contains('dark'),

                toggle() {
                    this.on = !this.on;
                    if (this.on) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('frontend_theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('frontend_theme', 'light');
                    }
                }
            });
        });

        // Ensure dark mode persists after Livewire navigation
        document.addEventListener('livewire:navigated', () => {
            if (localStorage.getItem('frontend_theme') === 'dark' ||
                (!localStorage.getItem('frontend_theme') && window.matchMedia('(prefers-color-scheme: dark)')
                    .matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')
    @stack('meta')

    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    @include('partials.header')

    <main class="flex-1">
        {{ $slot }}
    </main>

    @include('partials.footer')

    <!-- Back to Top Button -->
    <div x-data="{
        show: false,
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }" @scroll.window="show = window.pageYOffset > 500" class="fixed bottom-8 right-8 z-9999">
        <button x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-10" @click="scrollToTop()"
            class="group relative flex items-center justify-center w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-2xl shadow-blue-600/30 transition-all duration-300 hover:scale-110 active:scale-95 border border-white/20 backdrop-blur-sm"
            title="Kembali ke Atas">
            <!-- Ripple Effect Animation -->
            <span class="absolute inset-0 rounded-full bg-blue-600 group-hover:animate-ping opacity-20"></span>

            <i class="bi bi-arrow-up text-2xl group-hover:-translate-y-1 transition-transform duration-300"></i>
        </button>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
