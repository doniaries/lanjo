<div x-data="{ cartOpen: false }" class="flex flex-row h-screen min-h-screen overflow-hidden select-none"
    @keydown.window.enter.prevent="if(!['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName) && Object.keys($wire.cart).length > 0 && !$wire.showCheckout && !$wire.showSuccess) $wire.set('showCheckout', true)">

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- LEFT PANEL — Menu Browser                              --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div class="flex flex-col flex-1 min-h-0 min-w-0 overflow-hidden">

        {{-- TOP BAR --}}
        <div x-data="{
            isFullscreen: false,
            toggleFullscreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                    this.isFullscreen = true;
                } else {
                    document.exitFullscreen();
                    this.isFullscreen = false;
                }
            }
        }"
            class="flex flex-wrap md:flex-nowrap items-center justify-between px-4 py-2.5 bg-surface-card border-b border-surface-border shrink-0 gap-2">

            {{-- Logo & Nama Toko --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-main" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-main leading-tight">
                        {{ $this->pengaturan?->nama_toko ?? config('app.name') }}</p>
                </div>
            </div>

            {{-- Quick Action Buttons --}}
            <div
                class="flex items-center gap-1.5 overflow-x-auto [&::-webkit-scrollbar]:hidden w-full md:w-auto order-last md:order-none pb-1 md:pb-0">
                {{-- Riwayat --}}
                <button wire:click="$set('showRiwayat', true)" title="Riwayat Transaksi"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-blue-500/10 text-blue-500 border border-blue-500/20 hover:bg-blue-500 hover:text-white transition group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-[10px] font-medium">Riwayat</span>
                </button>

                {{-- Pending --}}
                {{-- <button wire:click="$set('showPending', true)" title="Pesanan Pending"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-amber-500/10 text-amber-500 border border-amber-500/20 hover:bg-amber-500 hover:text-white transition group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-[10px] font-medium">Pending</span>
                </button> --}}

                {{-- Reset / Bersihkan Cart --}}
                <button wire:click="clearCart" wire:confirm="Kosongkan semua pesanan?" title="Reset Pesanan"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span class="text-[10px] font-medium">Reset</span>
                </button>

                {{-- Laporan --}}
                <button wire:click="$set('showLaporan', true)" title="Cetak Laporan"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white transition group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-[10px] font-medium">Laporan</span>
                </button>

                {{-- Theme Toggle --}}
                <button x-data="{
                    toggleTheme() {
                        let theme = localStorage.getItem('theme') || 'dark';
                        theme = theme === 'dark' ? 'light' : 'dark';
                        localStorage.setItem('theme', theme);
                        if (theme === 'dark') {
                            document.documentElement.classList.add('dark');
                            document.documentElement.classList.remove('light');
                        } else {
                            document.documentElement.classList.remove('dark');
                            document.documentElement.classList.add('light');
                        }
                    }
                }" @click="toggleTheme()" title="Ubah Tema"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-purple-500/10 text-purple-500 border border-purple-500/20 hover:bg-purple-500 hover:text-white transition group">
                    <svg class="w-4 h-4 dark:hidden block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <span class="text-[10px] font-medium">Tema</span>
                </button>

                {{-- Fullscreen --}}
                <button @click="toggleFullscreen()" title="Full Screen"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-cyan-500/10 text-cyan-500 border border-cyan-500/20 hover:bg-cyan-500 hover:text-white transition group">
                    <svg x-show="!isFullscreen" class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <svg x-show="isFullscreen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                    </svg>
                    <span class="text-[10px] font-medium" x-text="isFullscreen ? 'Keluar' : 'Fullscr'"></span>
                </button>

                {{-- Divider --}}
                <div class="w-px h-8 bg-surface-border mx-1"></div>

                {{-- Kasir info --}}
                <div class="flex items-center gap-2">
                    <div
                        class="w-7 h-7 bg-brand-700 rounded-full flex items-center justify-center text-xs font-bold text-main">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-xs text-main font-medium">{{ auth()->user()->name }}</span>
                    <a href="{{ route('filament.admin.auth.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="text-xs text-gray-500 dark:text-gray-300 hover:text-red-400 transition">Keluar</a>
                    <form id="logout-form" action="{{ route('filament.admin.auth.logout') }}" method="POST"
                        class="hidden">@csrf</form>
                </div>
            </div>

            {{-- Live Clock --}}
            <div x-data="{
                now: new Date(),
                init() { setInterval(() => this.now = new Date(), 1000) },
                get jam() { return String(this.now.getHours()).padStart(2, '0') + ':' + String(this.now.getMinutes()).padStart(2, '0'); },
                get tanggal() { return this.now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); }
            }" class="flex flex-col items-end">
                <span x-text="jam" class="text-xl font-black text-main tracking-wider tabular-nums"></span>
                <span x-text="tanggal" class="hidden sm:block text-[11px] text-main opacity-80 font-medium"></span>
            </div>
        </div>

        {{-- KATEGORI TABS + SEARCH --}}
        <div
            class="flex flex-col sm:flex-row sm:items-center gap-2.5 px-4 sm:px-5 py-3 border-b border-surface-border bg-surface-card shrink-0">
            <div class="flex items-center gap-2 overflow-x-auto order-2 sm:order-1 w-full sm:w-auto pb-0.5">
                @php
                    $allColor = 'bg-brand-600 text-white shadow-lg shadow-brand-900';
                    $allInactive =
                        'bg-brand-500/10 text-brand-500 border border-brand-500/20 hover:bg-brand-500 hover:text-white';
                    $colors = [
                        [
                            'active' => 'bg-indigo-600 text-white shadow-lg shadow-indigo-900',
                            'inactive' =>
                                'bg-indigo-500/10 text-indigo-500 border border-indigo-500/20 hover:bg-indigo-500 hover:text-white',
                        ],
                        [
                            'active' => 'bg-pink-600 text-white shadow-lg shadow-pink-900',
                            'inactive' =>
                                'bg-pink-500/10 text-pink-500 border border-pink-500/20 hover:bg-pink-500 hover:text-white',
                        ],
                        [
                            'active' => 'bg-orange-600 text-white shadow-lg shadow-orange-900',
                            'inactive' =>
                                'bg-orange-500/10 text-orange-500 border border-orange-500/20 hover:bg-orange-500 hover:text-white',
                        ],
                        [
                            'active' => 'bg-teal-600 text-white shadow-lg shadow-teal-900',
                            'inactive' =>
                                'bg-teal-500/10 text-teal-500 border border-teal-500/20 hover:bg-teal-500 hover:text-white',
                        ],
                        [
                            'active' => 'bg-fuchsia-600 text-white shadow-lg shadow-fuchsia-900',
                            'inactive' =>
                                'bg-fuchsia-500/10 text-fuchsia-500 border border-fuchsia-500/20 hover:bg-fuchsia-500 hover:text-white',
                        ],
                    ];
                @endphp
                {{-- Tombol Semua --}}
                <button wire:click="$set('selectedKategori', null)"
                    class="shrink-0 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $selectedKategori === null ? $allColor : $allInactive }}">
                    Semua
                </button>

                @foreach ($this->kategoris as $kat)
                    @php $c = $colors[$loop->index % count($colors)]; @endphp
                    <button wire:click="selectKategori({{ $kat->id }})"
                        class="shrink-0 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $selectedKategori === $kat->id ? $c['active'] : $c['inactive'] }}">
                        {{ $kat->nama }}
                    </button>
                @endforeach

            </div>

            <div class="relative shrink-0 w-full sm:w-56 order-1 sm:order-2">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 dark:text-gray-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input wire:model.live.debounce.300ms="searchMenu" type="text" placeholder="Cari menu..."
                    class="w-full bg-surface border border-surface-border rounded-xl pl-10 pr-4 py-2 text-sm text-main placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:border-brand-500 transition">
            </div>
        </div>


        {{-- MENU GRID --}}
        <div class="flex-1 min-h-0 overflow-y-auto p-3 sm:p-5">
            @if ($this->menus->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-gray-500 dark:text-gray-300 gap-3">
                    <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm">Menu tidak ditemukan</p>
                </div>
            @else
                {{-- MENU GRID: lebih banyak kolom, gambar lebih kecil --}}
                <div
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-3">
                    @foreach ($this->menus as $menu)
                        <button
                            wire:click="addToCart({{ $menu->id }}, '{{ addslashes($menu->nama) }}', {{ $menu->harga_jual }}, '{{ $menu->gambar ?? '' }}')"
                            wire:loading.class="opacity-50 scale-95 pointer-events-none"
                            wire:target="addToCart({{ $menu->id }})"
                            class="menu-card group relative bg-surface-card border border-surface-border rounded-xl overflow-hidden text-left
                        hover:border-brand-500 hover:shadow-lg hover:shadow-brand-900/30 active:scale-95 transition-all duration-200 cursor-pointer">

                            {{-- Gambar lebih kecil: h-28 (bukan aspect-square) --}}
                            <div class="relative w-full h-24 sm:h-28 overflow-hidden bg-surface">
                                @if ($menu->gambar)
                                    <img src="{{ $menu->gambar }}" alt="{{ $menu->nama }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg class=\'w-8 h-8 text-gray-500 dark:text-gray-300 opacity-40\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-500 dark:text-gray-300 opacity-30"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Qty badge jika sudah di cart --}}
                                @if (isset($cart[$menu->id]))
                                    <div
                                        class="absolute top-2 right-2 w-6 h-6 bg-brand-500 rounded-full flex items-center justify-center text-xs font-bold shadow-lg">
                                        {{ $cart[$menu->id]['qty'] }}
                                    </div>
                                @endif

                                {{-- Add overlay --}}
                                <div
                                    class="absolute inset-0 bg-brand-600/0 group-hover:bg-brand-600/10 transition flex items-center justify-center">
                                    <div
                                        class="opacity-0 group-hover:opacity-100 transition bg-brand-600 rounded-full p-2 shadow-lg">
                                        <svg class="w-5 h-5 text-main" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="p-3">
                                <p class="text-sm font-semibold text-main leading-tight break-words">
                                    {{ $menu->nama }}</p>
                                <p class="text-xs text-brand-400 font-bold mt-1">Rp
                                    {{ number_format($menu->harga_jual, 0, ',', '.') }}</p>

                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- FAB Mobile Cart --}}
        <button @click="cartOpen = true"
            class="md:hidden fixed bottom-6 right-6 z-40 bg-brand-600 text-white rounded-full p-4 shadow-xl shadow-brand-900/50 flex items-center justify-center transition active:scale-95">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            @if(count($cart) > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full border-2 border-surface-card shadow-sm">
                    {{ collect($cart)->sum('qty') }}
                </span>
            @endif
        </button>
    </div>

    {{-- OVERLAY MOBILE --}}
    <div x-show="cartOpen" x-transition.opacity style="display: none;"
         @click="cartOpen = false"
         class="md:hidden fixed inset-0 bg-black/60 z-40 backdrop-blur-sm"></div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- RIGHT PANEL — Cart                                     --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div :class="cartOpen ? 'translate-x-0' : 'translate-x-full'"
        class="fixed md:static inset-y-0 right-0 z-50 w-[85%] sm:w-96 md:w-80 lg:w-96 h-full flex flex-col bg-surface-card border-l border-surface-border shrink-0 transition-transform duration-300 md:translate-x-0">

        {{-- Cart Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-surface-border">
            <div class="flex items-center gap-2">
                <button @click="cartOpen = false" class="md:hidden text-gray-500 hover:text-main -ml-2 mr-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <svg class="w-5 h-5 text-brand-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="font-bold text-main">Pesanan</span>
                @if (!empty($cart))
                    <span
                        class="bg-brand-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                        {{ collect($cart)->sum('qty') }}
                    </span>
                @endif
            </div>
            @if (!empty($cart))
                <button wire:click="clearCart"
                    class="text-xs text-red-400 hover:text-red-300 transition">Kosongkan</button>
            @endif
        </div>



        {{-- Tipe Pesanan & Meja --}}
        <div class="px-5 py-3 border-b border-surface-border shrink-0">
            <select wire:model="selectedMeja"
                class="w-full bg-surface border border-surface-border rounded-xl px-3 py-2 text-sm text-main focus:outline-none focus:border-brand-500">
                <option value="">-- Pilih Meja --</option>
                @foreach ($this->mejas as $meja)
                    <option value="{{ $meja->id }}">Meja {{ $meja->nomor_meja }}
                        @if ($meja->status !== 'kosong')
                            ({{ $meja->status }})
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Cart Items --}}
        <div class="flex-1 overflow-y-auto px-5 py-3 space-y-3">
            @forelse($cart as $menuId => $item)
                <div class="flex items-center gap-2 sm:gap-3 fade-up">
                    {{-- Gambar kecil --}}
                    @if ($item['gambar'])
                        <img src="{{ $item['gambar'] }}" class="w-10 h-10 rounded-lg object-cover shrink-0"
                            onerror="this.style.display='none'">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-surface shrink-0 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-300 opacity-50" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-main truncate">{{ $item['nama'] }}</p>
                        <p class="text-xs text-brand-400">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                        <p class="min-[400px]:hidden text-xs font-bold text-main mt-0.5">Rp
                            {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</p>
                    </div>

                    {{-- Qty controls --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="decreaseQty({{ $menuId }})"
                            class="btn-qty w-9 h-9 bg-surface border border-surface-border rounded-full flex items-center justify-center text-main hover:border-red-400 hover:text-red-400 transition text-lg leading-none">−</button>
                        <span class="text-sm font-bold w-5 text-center">{{ $item['qty'] }}</span>
                        <button wire:click="increaseQty({{ $menuId }})"
                            class="btn-qty w-9 h-9 bg-surface border border-surface-border rounded-full flex items-center justify-center text-main hover:border-brand-400 hover:text-brand-400 transition text-lg leading-none">+</button>
                    </div>

                    <div class="hidden min-[400px]:block text-sm font-semibold text-main w-20 text-right shrink-0">
                        Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <div
                    class="flex flex-col items-center justify-center h-full text-gray-500 dark:text-gray-300 gap-3 py-16">
                    <svg class="w-16 h-16 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-sm text-center">Belum ada pesanan.<br><span class="text-xs opacity-70">Klik menu
                            untuk menambahkan</span></p>
                </div>
            @endforelse
        </div>



        {{-- Summary & Checkout --}}
        <div class="px-5 py-3 border-t border-surface-border bg-surface-card space-y-2 shrink-0">
            <div class="flex justify-between text-sm text-gray-500 dark:text-gray-300">
                <span>Subtotal</span>
                <span class="text-main">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
            </div>
            @if (($this->pengaturan?->pajak_aktif ?? false) && ($this->pengaturan?->pajak_default ?? 0) > 0)
                <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-300">
                    <span>Pajak ({{ $this->pengaturan?->pajak_default }}%)</span>
                    <span class="text-amber-400">+Rp {{ number_format($this->pajak, 0, ',', '.') }}</span>
                </div>
            @endif
            @if ($this->diskon > 0)
                <div class="flex justify-between text-sm text-gray-500 dark:text-gray-300">
                    <span>Diskon</span>
                    <span class="text-green-400">-Rp {{ number_format($this->diskon, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="flex justify-between text-base font-bold text-main pt-2 border-t border-surface-border">
                <span>Total</span>
                <span class="text-brand-400 text-lg">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
            </div>

            <button wire:click="openCheckout" @if (empty($cart)) disabled @endif
                class="w-full py-4 rounded-2xl font-bold text-base transition-all duration-200 mt-2
                {{ !empty($cart)
                    ? 'bg-brand-600 hover:bg-brand-500 text-white shadow-lg shadow-brand-900/50 active:scale-95'
                    : 'bg-surface border border-surface-border text-gray-500 dark:text-gray-300 cursor-not-allowed' }}">
                {{ empty($cart) ? 'Tambah Item Dulu' : '💳 Proses Pembayaran' }}
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- CHECKOUT MODAL                                         --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @if ($showCheckout)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-end sm:items-center justify-center sm:p-4"
            wire:click.self="$set('showCheckout', false)">
            <div
                class="bg-surface-card border border-surface-border rounded-t-3xl rounded-b-none sm:rounded-3xl w-full max-w-md max-h-[95dvh] sm:max-h-[90dvh] flex flex-col fade-up shadow-2xl overflow-hidden pb-4 sm:pb-0">
                
                {{-- Header --}}
                <div class="flex items-center justify-between p-5 border-b border-surface-border shrink-0">
                    <h2 class="text-lg font-bold text-main">Konfirmasi Pembayaran</h2>
                    <button wire:click="$set('showCheckout', false)"
                        class="text-gray-500 dark:text-gray-300 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body (Scrollable) --}}
                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    {{-- Total --}}
                    <div class="bg-surface rounded-2xl p-4 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-300 mb-1">Total Pembayaran</p>
                        <p class="text-3xl font-black text-brand-400">Rp {{ number_format($this->total, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Metode --}}
                    <div class="space-y-2">
                        <p class="text-xs text-gray-500 dark:text-gray-300 font-semibold uppercase tracking-wider">Metode
                            Pembayaran</p>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach (['tunai' => '💵 Tunai', 'debit' => '💳 Debit', 'qris' => '📱 QRIS'] as $val => $label)
                                <button wire:click="$set('metodePembayaran', '{{ $val }}')"
                                    class="py-3 rounded-xl text-sm font-semibold border transition
                                    {{ $metodePembayaran === $val ? 'bg-brand-600 border-brand-500 text-white' : 'bg-surface border-surface-border text-gray-500 dark:text-gray-300 hover:border-brand-500' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Nominal (tunai only) --}}
                    @if ($metodePembayaran === 'tunai')
                        <div class="space-y-3" x-data="{
                            display: '{{ (int) $nominalBayar > 0 ? number_format($nominalBayar, 0, ',', '.') : '' }}',
                            init() {
                                this.$watch('display', val => {
                                    if (val === '') {
                                        $wire.set('nominalBayar', 0);
                                        return;
                                    }
                                    const raw = parseInt(String(val).replace(/\./g, '')) || 0;
                                    $wire.set('nominalBayar', raw);
                                });
                            },
                            format(n) {
                                return n ? parseInt(n).toLocaleString('id-ID') : '';
                            },
                            onInput(e) {
                                const raw = e.target.value.replace(/\./g, '').replace(/[^0-9]/g, '');
                                if (!raw) {
                                    this.display = '';
                                    $wire.set('nominalBayar', 0);
                                    return;
                                }
                                const num = parseInt(raw) || 0;
                                this.display = this.format(num);
                                $wire.set('nominalBayar', num);
                            },
                            setVal(n) {
                                this.display = this.format(n);
                                $wire.set('nominalBayar', n);
                            }
                        }">
                            <p class="text-xs text-gray-500 dark:text-gray-300 font-semibold uppercase tracking-wider">
                                Nominal Bayar</p>

                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300 font-bold text-xl">Rp</span>
                                <input type="text" inputmode="numeric" x-model="display" @input="onInput($event)"
                                    @focus="$event.target.select()" placeholder="0"
                                    class="w-full bg-surface border border-surface-border rounded-xl pl-12 pr-4 py-3 text-2xl font-black text-main focus:outline-none focus:border-brand-500 text-right tabular-nums placeholder-gray-300 dark:placeholder-gray-600">
                            </div>

                            {{-- Quick amounts dari total --}}
                            @php
                                $tot = (int) $this->total;
                                $quickAmounts = array_unique([$tot, 20000, 50000, 100000, 200000]);
                                sort($quickAmounts);
                            @endphp
                            <div class="flex flex-wrap gap-2">
                                @foreach ($quickAmounts as $amount)
                                    <button @click="setVal({{ $amount }})"
                                        class="px-4 py-2 bg-surface border border-surface-border rounded-xl text-sm font-bold text-main hover:border-brand-500 hover:text-brand-400 transition">
                                        {{ number_format($amount, 0, ',', '.') }}
                                    </button>
                                @endforeach
                            </div>

                            <div
                                class="flex justify-between items-center bg-green-500/10 border border-green-500/20 rounded-xl px-5 py-4 mt-2">
                                <div>
                                    <p class="text-xs text-green-400 font-semibold uppercase tracking-wider">Kembalian</p>
                                    <p class="text-2xl font-black text-green-400">Rp
                                        {{ number_format($this->kembalian, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Footer Sticky --}}
                <div class="p-5 border-t border-surface-border bg-surface-card shrink-0">
                    <div class="flex gap-3">
                        <button wire:click="$set('showCheckout', false)"
                            class="w-1/3 py-3 rounded-2xl bg-gray-500 hover:bg-gray-600 text-white font-bold text-base transition active:scale-95 shadow-lg shadow-gray-900/50">
                            Batal
                        </button>
                        <button wire:click="prosesTransaksi" wire:loading.attr="disabled" wire:target="prosesTransaksi"
                            class="w-2/3 py-3 rounded-2xl bg-green-600 hover:bg-green-500 text-white font-bold text-base transition active:scale-95 shadow-lg shadow-green-900/50">
                            <span wire:loading.remove wire:target="prosesTransaksi">✅ Selesaikan</span>
                            <span wire:loading wire:target="prosesTransaksi">...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- SUCCESS MODAL                                          --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @if ($showSuccess)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div
                class="bg-surface-card border border-green-500/30 rounded-3xl w-full max-w-sm max-h-[85vh] overflow-y-auto p-6 sm:p-8 text-center space-y-4 fade-up shadow-2xl shadow-green-900/30">
                <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-main">Transaksi Berhasil!</h2>
                    <p class="text-sm text-main opacity-70 mt-1 font-medium tracking-wide">{{ $nomorNotaSuccess }}</p>
                </div>
                @if ($kembalianSuccess > 0)
                    <div class="bg-green-500/10 border border-green-500/20 rounded-2xl px-6 py-4">
                        <p class="text-sm text-green-300">Kembalian</p>
                        <p class="text-2xl font-black text-green-400">Rp
                            {{ number_format($kembalianSuccess, 0, ',', '.') }}</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 gap-3 mt-2">
                    <button onclick="printStruk(58, '{{ $nomorNotaSuccess }}')"
                        class="w-full py-3 rounded-2xl bg-surface border border-brand-500 text-brand-400 font-bold hover:bg-brand-500/10 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        58mm
                    </button>
                    <button onclick="printStruk(80, '{{ $nomorNotaSuccess }}')"
                        class="w-full py-3 rounded-2xl bg-surface border border-brand-500 text-brand-400 font-bold hover:bg-brand-500/10 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        80mm
                    </button>
                </div>
                <button wire:click="closeSuccess"
                    class="w-full py-3 rounded-2xl bg-brand-600 hover:bg-brand-500 text-white font-bold transition mt-2">
                    Selesai (Pesanan Baru)
                </button>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- PRINT AREA (HIDDEN FROM SCREEN)                        --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @if (!empty($notaData))
        <div id="print-area" class="hidden text-black bg-white">
            <div class="print-header text-center mb-4">
                <h1 class="font-bold text-xl">{{ $notaData['toko'] }}</h1>
                <p class="text-xs">{{ $notaData['alamat'] }}</p>
                <p class="text-xs">{{ $notaData['telepon'] }}</p>
            </div>

            <div class="text-xs mb-3 flex justify-between border-b border-black pb-2 border-dashed">
                <div>
                    <p>No: {{ $notaData['nomor'] }}</p>
                    <p>Tgl: {{ $notaData['tanggal'] }}</p>
                </div>
                <div class="text-right">
                    <p>Ksr: {{ $notaData['kasir'] }}</p>
                    @if ($notaData['nama_pembeli'])
                        <p>Plg: {{ $notaData['nama_pembeli'] }}</p>
                    @endif
                </div>
            </div>

            <table class="w-full text-xs mb-3">
                @foreach ($notaData['items'] as $item)
                    <tr>
                        <td colspan="3" class="pb-1">{{ $item['nama'] }}</td>
                    </tr>
                    <tr class="border-b border-black border-dashed">
                        <td class="pb-2">{{ $item['qty'] }}x</td>
                        <td class="pb-2">{{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td class="text-right pb-2">{{ number_format($item['qty'] * $item['harga'], 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="text-xs space-y-1 mb-3 border-b border-black pb-3 border-dashed">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>{{ number_format($notaData['subtotal'], 0, ',', '.') }}</span>
                </div>
                @if ($notaData['diskon'] > 0)
                    <div class="flex justify-between">
                        <span>Diskon</span>
                        <span>-{{ number_format($notaData['diskon'], 0, ',', '.') }}</span>
                    </div>
                @endif
                @if ($notaData['pajak'] > 0)
                    <div class="flex justify-between">
                        <span>Pajak ({{ $notaData['pajak_pct'] }}%)</span>
                        <span>{{ number_format($notaData['pajak'], 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold text-sm pt-1">
                    <span>TOTAL</span>
                    <span>{{ number_format($notaData['total'], 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="text-xs space-y-1 mb-4">
                <div class="flex justify-between">
                    <span>Bayar ({{ ucfirst(str_replace('_', ' ', $notaData['metode'])) }})</span>
                    <span>{{ number_format($notaData['nominal_bayar'], 0, ',', '.') }}</span>
                </div>
                @if ($notaData['metode'] === 'qris' || $notaData['metode'] === 'transfer')
                    <div class="flex justify-between">
                        <span>Bank/E-Wallet</span>
                        <span class="uppercase">{{ $notaData['bank_pengirim'] ?: '-' }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span>Kembali</span>
                    <span>{{ number_format($notaData['kembalian'], 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="text-center text-xs mt-4 mb-8">
                @php
                    $qrUrl = route('verifikasi.struk', $notaData['nomor']);
                    $qrCode = (new \chillerlan\QRCode\QRCode())->render($qrUrl);
                @endphp
                <img src="{{ $qrCode }}" alt="QR Code" style="width:100px; height:100px; margin: 0 auto; display:block;" />
                <div style="font-size:10px; margin-top:4px; margin-bottom:8px;">Scan untuk cek keaslian struk</div>
                
                @if (!empty($notaData['footer_struk']))
                    {!! nl2br(e($notaData['footer_struk'])) !!}
                @else
                    <p>Terima Kasih</p>
                    <p>Selamat Datang Kembali</p>
                @endif
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- MODAL LAPORAN --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @if ($showLaporan)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            style="margin:0 !important">
            <div
                class="bg-white dark:bg-gray-900 w-full max-w-sm rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div
                    class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-gray-900">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Cetak Laporan Transaksi</h3>
                    <button wire:click="$set('showLaporan', false)"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-5 space-y-4 bg-white dark:bg-gray-900">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Dari
                            Tanggal</label>
                        <input type="date" wire:model.defer="laporanStart"
                            class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none transition"
                            style="color-scheme: dark light;">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">Sampai
                            Tanggal</label>
                        <input type="date" wire:model.defer="laporanEnd"
                            class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none transition"
                            style="color-scheme: dark light;">
                    </div>
                </div>
                <div
                    class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 flex justify-end gap-3">
                    <button wire:click="$set('showLaporan', false)"
                        class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">Batal</button>
                    <a href="{{ route('laporan.transaksi') }}?start={{ $laporanStart }}&end={{ $laporanEnd }}"
                        target="_blank" @click="$wire.set('showLaporan', false)"
                        class="px-5 py-2 text-sm font-medium bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl shadow-lg shadow-emerald-500/30 transition">
                        Cetak PDF
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- MODAL RIWAYAT TRANSAKSI HARI INI --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @if ($showRiwayat)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            style="margin:0 !important">
            <div
                class="bg-white dark:bg-gray-900 w-full max-w-4xl max-h-[85vh] rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 flex flex-col">
                <div
                    class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-gray-900 rounded-t-2xl shrink-0">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Riwayat Transaksi</h3>
                    <button wire:click="$set('showRiwayat', false)"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                {{-- Filter Riwayat --}}
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shrink-0 flex flex-col sm:flex-row items-center gap-3">
                    <select wire:model.live="riwayatPeriode" class="w-full sm:w-auto bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-500">
                        <option value="hari_ini">Hari Ini</option>
                        <option value="kemarin">Kemarin</option>
                        <option value="minggu_ini">Minggu Ini</option>
                        <option value="bulan_ini">Bulan Ini</option>
                        <option value="custom">Pertanggal (Custom)</option>
                    </select>
                    
                    @if($riwayatPeriode === 'custom')
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <input type="date" wire:model.live="riwayatTanggalMulai" class="w-full sm:w-auto bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-500">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">s/d</span>
                            <input type="date" wire:model.live="riwayatTanggalSelesai" class="w-full sm:w-auto bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-brand-500">
                        </div>
                    @endif
                </div>
                <div class="p-0 overflow-auto flex-1 bg-white dark:bg-gray-900">
                    <table class="w-full text-left border-collapse text-sm text-gray-900 dark:text-white">
                        <thead
                            class="bg-gray-50 dark:bg-gray-900 sticky top-0 z-10 border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-600 dark:text-gray-400">Waktu</th>
                                <th class="px-4 py-3 font-medium text-gray-600 dark:text-gray-400">No. Nota</th>
                                <th
                                    class="hidden md:table-cell px-4 py-3 font-medium text-gray-600 dark:text-gray-400">
                                    Kasir</th>
                                <th class="px-4 py-3 font-medium text-gray-600 dark:text-gray-400 text-right">Total
                                </th>
                                <th class="px-4 py-3 font-medium text-gray-600 dark:text-gray-400 text-center">Status
                                </th>
                                <th class="px-4 py-3 font-medium text-gray-600 dark:text-gray-400 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($this->riwayatTransaksi as $rt)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition cursor-pointer"
                                    wire:click="viewPesananDetail({{ $rt->id }})">
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($rt->tanggal)->format('H:i') }}
                                    </td>
                                    <td
                                        class="px-4 py-3 font-mono text-emerald-600 dark:text-emerald-400 font-semibold underline decoration-emerald-600/30 underline-offset-2">
                                        {{ $rt->nomor_nota }}</td>
                                    <td class="hidden md:table-cell px-4 py-3">{{ $rt->kasir?->name }}</td>
                                    <td class="px-4 py-3 text-right font-semibold">Rp
                                        {{ number_format($rt->total_akhir, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($rt->status === 'selesai')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">Selesai</span>
                                        @elseif($rt->status === 'batal')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-rose-100 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20">Batal</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">Baru</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button wire:click.stop="cetakStrukRiwayat({{ $rt->id }})"
                                            class="p-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg text-gray-600 dark:text-gray-300 transition"
                                            title="Cetak Struk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada transaksi hari ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div
                    class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 rounded-b-2xl shrink-0">
                    {{ $this->riwayatTransaksi->links('livewire::tailwind') }}
                </div>
            </div>
        </div>
    @endif

    @if ($showDetailPesanan && $this->selectedPesananDetail)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            style="margin:0 !important">
            <div
                class="bg-white dark:bg-gray-900 w-full max-w-2xl max-h-[85vh] rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 flex flex-col">
                <div
                    class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-gray-900 rounded-t-2xl shrink-0">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Detail Transaksi:
                        {{ $this->selectedPesananDetail->nomor_nota }}</h3>
                    <button wire:click="closeDetailPesanan"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto flex-1 space-y-6">
                    <!-- Info Header -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Tanggal</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($this->selectedPesananDetail->tanggal)->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Kasir</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $this->selectedPesananDetail->kasir?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Status</p>
                            <p class="font-medium text-gray-900 dark:text-white uppercase">
                                {{ $this->selectedPesananDetail->status }}</p>
                        </div>
                    </div>

                    <!-- Items -->
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Daftar Menu</h4>
                        <div
                            class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4 border border-gray-100 dark:border-gray-800">
                            <table class="w-full text-sm text-left">
                                <thead>
                                    <tr
                                        class="text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                        <th class="pb-2 font-medium">Item</th>
                                        <th class="pb-2 font-medium text-center">Qty</th>
                                        <th class="pb-2 font-medium text-right">Harga</th>
                                        <th class="pb-2 font-medium text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($this->selectedPesananDetail->detailPesanans as $detail)
                                        <tr>
                                            <td class="py-2 text-gray-900 dark:text-white">
                                                {{ $detail->menu->nama ?? 'Menu Terhapus' }}</td>
                                            <td class="py-2 text-center text-gray-900 dark:text-white">
                                                {{ $detail->jumlah }}</td>
                                            <td class="py-2 text-right text-gray-900 dark:text-white">Rp
                                                {{ number_format($detail->harga_satuan_snapshot, 0, ',', '.') }}</td>
                                            <td class="py-2 text-right text-gray-900 dark:text-white font-medium">Rp
                                                {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="space-y-2 text-sm flex-1 w-full lg:w-1/2 ml-auto">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($this->selectedPesananDetail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if ($this->selectedPesananDetail->diskon > 0)
                            <div class="flex justify-between text-rose-500">
                                <span>Diskon</span>
                                <span>- Rp
                                    {{ number_format($this->selectedPesananDetail->diskon, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if ($this->selectedPesananDetail->pajak > 0)
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Pajak</span>
                                <span>Rp {{ number_format($this->selectedPesananDetail->pajak, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div
                            class="flex justify-between text-base font-bold text-gray-900 dark:text-white pt-2 border-t border-gray-200 dark:border-gray-700">
                            <span>Total Akhir</span>
                            <span>Rp {{ number_format($this->selectedPesananDetail->total_akhir, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Pembayaran -->
                    @if ($this->selectedPesananDetail->pembayarans->count() > 0)
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Pembayaran</h4>
                            @foreach ($this->selectedPesananDetail->pembayarans as $bayar)
                                <div
                                    class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-800 dark:text-emerald-400 p-3 rounded-lg text-sm border border-emerald-100 dark:border-emerald-800/30 flex justify-between">
                                    <div>
                                        <p class="font-medium uppercase">
                                            {{ str_replace('_', ' ', $bayar->metode_pembayaran) }}</p>
                                        <p class="text-xs opacity-80">
                                            {{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-base">Rp
                                            {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                                        @if ($bayar->kembalian > 0)
                                            <p class="text-xs opacity-80">Kembali: Rp
                                                {{ number_format($bayar->kembalian, 0, ',', '.') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div
                    class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 rounded-b-2xl flex flex-col-reverse sm:flex-row gap-2.5 sm:justify-between shrink-0">
                    <button
                        onclick="printStruk('{{ $ukuranKertas }}', '{{ $this->selectedPesananDetail->nomor_nota }}')"
                        class="w-full sm:w-auto px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-medium flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak Ulang Struk
                    </button>
                    <button wire:click="closeDetailPesanan"
                        class="w-full sm:w-auto px-4 py-2.5 bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700 transition font-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL PENDING ORDER --}}
    @if ($showPending)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            style="margin:0 !important">
            <div
                class="bg-white dark:bg-gray-900 w-full max-w-4xl max-h-[85vh] rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 flex flex-col">
                <div
                    class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-gray-900 rounded-t-2xl shrink-0">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Pesanan Pending</h3>
                    <button wire:click="$set('showPending', false)"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-0 overflow-auto flex-1 bg-white dark:bg-gray-900">
                    <table class="w-full text-left border-collapse text-sm text-gray-900 dark:text-white">
                        <thead
                            class="bg-gray-50 dark:bg-gray-900 sticky top-0 z-10 border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-600 dark:text-gray-400">Waktu</th>
                                <th
                                    class="hidden md:table-cell px-4 py-3 font-medium text-gray-600 dark:text-gray-400">
                                    Kasir</th>
                                <th class="px-4 py-3 font-medium text-gray-600 dark:text-gray-400 text-right">Total
                                </th>
                                <th class="px-4 py-3 font-medium text-gray-600 dark:text-gray-400 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($this->pendingTransaksi as $pt)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($pt->tanggal)->format('d/m/Y H:i') }}</td>
                                    <td class="hidden md:table-cell px-4 py-3">{{ $pt->kasir?->name }}</td>
                                    <td class="px-4 py-3 text-right font-semibold">Rp
                                        {{ number_format($pt->total_akhir, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <button wire:click="loadPending({{ $pt->id }})"
                                            class="px-3 py-1.5 bg-amber-100 dark:bg-amber-500/10 hover:bg-amber-200 dark:hover:bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-lg font-medium transition text-xs border border-amber-200 dark:border-amber-500/20">
                                            Lanjutkan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada pesanan pending</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('trigger-print-riwayat', function(event) {
            // Beri jeda sejenak agar DOM Livewire (print-area) selesai dirender
            setTimeout(() => {
                let args = event.detail;
                // Livewire 3 mengirimkan data dalam array jika multiple args
                let ukuran = args[0] ? args[0].ukuran : args.ukuran;
                let nota = args[0] ? args[0].nota : args.nota;
                printStruk(ukuran, nota);
            }, 300);
        });

        function printStruk(size, nota = 'Struk') {
            const pa = document.getElementById('print-area');
            if (pa) {
                // Hapus iframe lama jika ada
                let oldFrame = document.getElementById('print-iframe');
                if (oldFrame) {
                    oldFrame.remove();
                }

                // Buat iframe tersembunyi baru
                const iframe = document.createElement('iframe');
                iframe.id = 'print-iframe';
                iframe.style.position = 'fixed';
                iframe.style.right = '0';
                iframe.style.bottom = '0';
                iframe.style.width = '0';
                iframe.style.height = '0';
                iframe.style.border = '0';
                document.body.appendChild(iframe);

                let printHtml = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>${nota}</title>
                        <style>
                            @page { margin: 0; }
                            body { 
                                font-family: monospace; 
                                color: black; 
                                background: white; 
                                margin: 0; 
                                padding: 0; 
                            }
                            .print-container { 
                                width: ${size === '58' ? '58mm' : '80mm'}; 
                                padding: 4mm; 
                                margin: 0 auto; 
                            }
                            table { width: 100%; border-collapse: collapse; }
                            .text-center { text-align: center; }
                            .text-right { text-align: right; }
                            .text-left { text-align: left; }
                            .font-bold { font-weight: bold; }
                            .text-xl { font-size: 1.25rem; margin-bottom: 0.25rem; }
                            .text-sm { font-size: 0.875rem; }
                            .text-xs { font-size: 0.75rem; }
                            .mb-3 { margin-bottom: 0.75rem; }
                            .mb-4 { margin-bottom: 1rem; }
                            .mb-8 { margin-bottom: 2rem; }
                            .mt-4 { margin-top: 1rem; }
                            .pt-1 { padding-top: 0.25rem; }
                            .pb-1 { padding-bottom: 0.25rem; }
                            .pb-2 { padding-bottom: 0.5rem; }
                            .pb-3 { padding-bottom: 0.75rem; }
                            .border-b { border-bottom: 1px solid black; }
                            .border-dashed { border-bottom-style: dashed; }
                            .flex { display: flex; }
                            .justify-between { justify-content: space-between; }
                            .uppercase { text-transform: uppercase; }
                        </style>
                    </head>
                    <body>
                        <div class="print-container">
                            ${pa.innerHTML}
                        </div>
                    </body>
                    </html>
                `;

                const doc = iframe.contentWindow.document;
                doc.open();
                doc.write(printHtml);
                doc.close();

                // Tambahkan delay sedikit agar CSS selesai di-render oleh browser
                setTimeout(function() {
                    iframe.contentWindow.focus();

                    // Simpan title asli window utama (karena browser mengambil nama file PDF dari parent window)
                    const originalTitle = document.title;
                    document.title = nota;

                    iframe.contentWindow.print();

                    // Kembalikan title asli
                    document.title = originalTitle;
                }, 250);

            } else {
                alert('Data struk tidak ditemukan!');
            }
        }
    </script>
</div>
