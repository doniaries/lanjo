<div class="flex h-screen overflow-hidden select-none"
    @keydown.window.enter.prevent="if(!['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName) && Object.keys($wire.cart).length > 0 && !$wire.showCheckout && !$wire.showSuccess) $wire.set('showCheckout', true)">

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- LEFT PANEL — Menu Browser                              --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div class="flex flex-col flex-1 overflow-hidden">

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
        }" class="flex items-center justify-between px-4 py-2.5 bg-surface-card border-b border-surface-border shrink-0">

            {{-- Logo & Nama Toko --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-white leading-tight">{{ $this->pengaturan?->nama_toko ?? config('app.name') }}</p>
                </div>
            </div>

            {{-- Quick Action Buttons --}}
            <div class="flex items-center gap-1.5">
                {{-- Riwayat --}}
                <a href="{{ route('filament.admin.resources.pesanans.index') }}" target="_blank"
                    title="Riwayat Transaksi"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-surface border border-surface-border hover:border-brand-500 hover:text-brand-400 text-surface-muted transition group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-[10px] font-medium">Riwayat</span>
                </a>

                {{-- Pending --}}
                <button wire:click="$set('showPending', true)" title="Pesanan Pending"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-surface border border-surface-border hover:border-amber-400 hover:text-amber-400 text-surface-muted transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-[10px] font-medium">Pending</span>
                </button>

                {{-- Reset / Bersihkan Cart --}}
                <button wire:click="clearCart" wire:confirm="Kosongkan semua pesanan?" title="Reset Pesanan"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-surface border border-surface-border hover:border-red-400 hover:text-red-400 text-surface-muted transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span class="text-[10px] font-medium">Reset</span>
                </button>

                {{-- Laporan --}}
                <a href="{{ route('filament.admin.resources.pembayarans.index') }}" target="_blank" title="Laporan Pembayaran"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-surface border border-surface-border hover:border-green-400 hover:text-green-400 text-surface-muted transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-[10px] font-medium">Laporan</span>
                </a>

                {{-- Theme Toggle --}}
                <button onclick="document.documentElement.classList.toggle('light-mode')" title="Ubah Tema"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-surface border border-surface-border hover:border-brand-400 hover:text-brand-400 text-surface-muted transition">
                    <svg class="w-4 h-4 hidden .light-mode:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="w-4 h-4 block .light-mode:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <span class="text-[10px] font-medium">Tema</span>
                </button>

                {{-- Fullscreen --}}
                <button @click="toggleFullscreen()" title="Full Screen"
                    class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl bg-surface border border-surface-border hover:border-brand-400 hover:text-brand-400 text-surface-muted transition">
                    <svg x-show="!isFullscreen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    <svg x-show="isFullscreen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25"/></svg>
                    <span class="text-[10px] font-medium" x-text="isFullscreen ? 'Keluar' : 'Fullscr'"></span>
                </button>

                {{-- Divider --}}
                <div class="w-px h-8 bg-surface-border mx-1"></div>

                {{-- Kasir info --}}
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-brand-700 rounded-full flex items-center justify-center text-xs font-bold text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-xs text-white font-medium">{{ auth()->user()->name }}</span>
                    <a href="{{ route('filament.admin.auth.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="text-xs text-surface-muted hover:text-red-400 transition">Keluar</a>
                    <form id="logout-form" action="{{ route('filament.admin.auth.logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            </div>

            {{-- Live Clock --}}
            <div x-data="{
                now: new Date(),
                init() { setInterval(() => this.now = new Date(), 1000) },
                get jam() { return this.now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }); },
                get tanggal() { return this.now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); }
            }" class="flex flex-col items-end">
                <span x-text="jam" class="text-xl font-black text-white tracking-wider tabular-nums"></span>
                <span x-text="tanggal" class="text-[11px] text-white opacity-80 font-medium"></span>
            </div>
        </div>

        {{-- KATEGORI TABS + SEARCH --}}
        <div class="flex items-center gap-2 px-5 py-3 border-b border-surface-border bg-surface-card shrink-0 overflow-x-auto">
            {{-- Tombol Semua --}}
            <button wire:click="$set('selectedKategori', null)"
                class="shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                {{ $selectedKategori === null
                    ? 'bg-brand-600 text-white shadow-lg shadow-brand-900'
                    : 'bg-surface border border-surface-border text-surface-muted hover:border-brand-500 hover:text-white' }}">
                Semua
            </button>

            @foreach($this->kategoris as $kat)
                <button wire:click="selectKategori({{ $kat->id }})"
                    class="shrink-0 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
                    {{ $selectedKategori === $kat->id
                        ? 'bg-brand-600 text-white shadow-lg shadow-brand-900'
                        : 'bg-surface border border-surface-border text-surface-muted hover:border-brand-500 hover:text-white' }}">
                    {{ $kat->nama }}
                </button>
            @endforeach

            {{-- Spacer --}}
            <div class="flex-1"></div>

            {{-- Search dipindah ke sini --}}
            <div class="relative shrink-0 w-56">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input wire:model.live.debounce.300ms="searchMenu" type="text" placeholder="Cari menu..."
                    class="w-full bg-surface border border-surface-border rounded-xl pl-10 pr-4 py-2 text-sm text-white placeholder-surface-muted focus:outline-none focus:border-brand-500 transition">
            </div>
        </div>


        {{-- MENU GRID --}}
        <div class="flex-1 overflow-y-auto p-5">
            @if($this->menus->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-surface-muted gap-3">
                    <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm">Menu tidak ditemukan</p>
                </div>
            @else
            {{-- MENU GRID: lebih banyak kolom, gambar lebih kecil --}}
            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-3">
                @foreach($this->menus as $menu)
                    <button wire:click="addToCart({{ $menu->id }}, '{{ addslashes($menu->nama) }}', {{ $menu->harga_jual }}, '{{ $menu->gambar ?? '' }}')"
                        class="menu-card group relative bg-surface-card border border-surface-border rounded-xl overflow-hidden text-left
                        hover:border-brand-500 hover:shadow-lg hover:shadow-brand-900/30 active:scale-95 transition-all duration-200 cursor-pointer">

                        {{-- Gambar lebih kecil: h-28 (bukan aspect-square) --}}
                        <div class="relative w-full h-28 overflow-hidden bg-surface">
                            @if($menu->gambar)
                                <img src="{{ $menu->gambar }}" alt="{{ $menu->nama }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg class=\'w-8 h-8 text-surface-muted opacity-40\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-surface-muted opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif

                                {{-- Qty badge jika sudah di cart --}}
                                @if(isset($cart[$menu->id]))
                                    <div class="absolute top-2 right-2 w-6 h-6 bg-brand-500 rounded-full flex items-center justify-center text-xs font-bold shadow-lg">
                                        {{ $cart[$menu->id]['qty'] }}
                                    </div>
                                @endif

                                {{-- Add overlay --}}
                                <div class="absolute inset-0 bg-brand-600/0 group-hover:bg-brand-600/10 transition flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition bg-brand-600 rounded-full p-2 shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="p-3">
                                <p class="text-sm font-semibold text-white leading-tight truncate">{{ $menu->nama }}</p>
                                <p class="text-xs text-brand-400 font-bold mt-1">Rp {{ number_format($menu->harga_jual, 0, ',', '.') }}</p>
                                @if($menu->stok <= 10)
                                    <p class="text-xs text-amber-400 mt-1">Stok: {{ $menu->stok }}</p>
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- RIGHT PANEL — Cart                                     --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div class="w-96 flex flex-col bg-surface-card border-l border-surface-border shrink-0 slide-in">

        {{-- Cart Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-surface-border">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="font-bold text-white">Pesanan</span>
                @if(!empty($cart))
                    <span class="bg-brand-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                        {{ collect($cart)->sum('qty') }}
                    </span>
                @endif
            </div>
            @if(!empty($cart))
                <button wire:click="clearCart" class="text-xs text-red-400 hover:text-red-300 transition">Kosongkan</button>
            @endif
        </div>

        {{-- Tipe & Meja --}}
        <div class="px-5 py-4 border-b border-surface-border space-y-3 shrink-0">
            <div class="flex gap-2">
                <button wire:click="$set('tipePesanan', 'dine_in')"
                    class="flex-1 py-2 rounded-xl text-xs font-semibold transition
                    {{ $tipePesanan === 'dine_in' ? 'bg-brand-600 text-white' : 'bg-surface border border-surface-border text-surface-muted' }}">
                    🍽 Dine In
                </button>
                <button wire:click="$set('tipePesanan', 'take_away')"
                    class="flex-1 py-2 rounded-xl text-xs font-semibold transition
                    {{ $tipePesanan === 'take_away' ? 'bg-brand-600 text-white' : 'bg-surface border border-surface-border text-surface-muted' }}">
                    🛍 Take Away
                </button>
            </div>

            @if($tipePesanan === 'dine_in')
                <select wire:model="selectedMeja"
                    class="w-full bg-surface border border-surface-border rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-brand-500">
                    <option value="">-- Pilih Meja --</option>
                    @foreach($this->mejas as $meja)
                        <option value="{{ $meja->id }}">Meja {{ $meja->nomor_meja }}
                            @if($meja->status !== 'kosong') ({{ $meja->status }}) @endif
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        {{-- Cart Items --}}
        <div class="flex-1 overflow-y-auto px-5 py-3 space-y-3">
            @forelse($cart as $menuId => $item)
                <div class="flex items-center gap-3 fade-up">
                    {{-- Gambar kecil --}}
                    @if($item['gambar'])
                        <img src="{{ $item['gambar'] }}" class="w-10 h-10 rounded-lg object-cover shrink-0"
                            onerror="this.style.display='none'">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-surface shrink-0 flex items-center justify-center">
                            <svg class="w-4 h-4 text-surface-muted opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ $item['nama'] }}</p>
                        <p class="text-xs text-brand-400">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                    </div>

                    {{-- Qty controls --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="decreaseQty({{ $menuId }})"
                            class="btn-qty w-7 h-7 bg-surface border border-surface-border rounded-full flex items-center justify-center text-white hover:border-red-400 hover:text-red-400 transition text-base leading-none">−</button>
                        <span class="text-sm font-bold w-5 text-center">{{ $item['qty'] }}</span>
                        <button wire:click="increaseQty({{ $menuId }})"
                            class="btn-qty w-7 h-7 bg-surface border border-surface-border rounded-full flex items-center justify-center text-white hover:border-brand-400 hover:text-brand-400 transition text-base leading-none">+</button>
                    </div>

                    <div class="text-sm font-semibold text-white w-20 text-right shrink-0">
                        Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center h-full text-surface-muted gap-3 py-16">
                    <svg class="w-16 h-16 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="text-sm text-center">Belum ada pesanan.<br><span class="text-xs opacity-70">Klik menu untuk menambahkan</span></p>
                </div>
            @endforelse
        </div>

        {{-- Catatan --}}
        @if(!empty($cart))
            <div class="px-5 py-3 border-t border-surface-border">
                <textarea wire:model.lazy="catatan" placeholder="Catatan pesanan..."
                    rows="2"
                    class="w-full bg-surface border border-surface-border rounded-xl px-3 py-2 text-sm text-white placeholder-surface-muted focus:outline-none focus:border-brand-500 resize-none"></textarea>
            </div>
        @endif

        {{-- Summary & Checkout --}}
        <div class="px-5 py-4 border-t border-surface-border bg-surface-card space-y-2 shrink-0">
            <div class="flex justify-between text-sm text-surface-muted">
                <span>Subtotal</span>
                <span class="text-white">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($this->pajak > 0)
                <div class="flex justify-between text-sm text-surface-muted">
                    <span>Pajak ({{ $this->pengaturan?->pajak_default ?? 0 }}%)</span>
                    <span class="text-amber-400">+Rp {{ number_format($this->pajak, 0, ',', '.') }}</span>
                </div>
            @endif
            @if($this->diskon > 0)
                <div class="flex justify-between text-sm text-surface-muted">
                    <span>Diskon</span>
                    <span class="text-green-400">-Rp {{ number_format($this->diskon, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="flex justify-between text-base font-bold text-white pt-2 border-t border-surface-border">
                <span>Total</span>
                <span class="text-brand-400 text-lg">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
            </div>

            <button wire:click="openCheckout"
                @if(empty($cart)) disabled @endif
                class="w-full py-4 rounded-2xl font-bold text-base transition-all duration-200 mt-2
                {{ !empty($cart)
                    ? 'bg-brand-600 hover:bg-brand-500 text-white shadow-lg shadow-brand-900/50 active:scale-95'
                    : 'bg-surface border border-surface-border text-surface-muted cursor-not-allowed' }}">
                {{ empty($cart) ? 'Tambah Item Dulu' : '💳 Proses Pembayaran' }}
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- CHECKOUT MODAL                                         --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @if($showCheckout)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            wire:click.self="$set('showCheckout', false)">
            <div class="bg-surface-card border border-surface-border rounded-3xl w-full max-w-md p-6 space-y-5 fade-up shadow-2xl">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white">Konfirmasi Pembayaran</h2>
                    <button wire:click="$set('showCheckout', false)" class="text-surface-muted hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Total --}}
                <div class="bg-surface rounded-2xl p-4 text-center">
                    <p class="text-sm text-surface-muted mb-1">Total Pembayaran</p>
                    <p class="text-3xl font-black text-brand-400">Rp {{ number_format($this->total, 0, ',', '.') }}</p>
                </div>

                {{-- Metode --}}
                <div class="space-y-2">
                    <p class="text-xs text-surface-muted font-semibold uppercase tracking-wider">Metode Pembayaran</p>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['tunai' => '💵 Tunai', 'debit' => '💳 Debit', 'qris' => '📱 QRIS'] as $val => $label)
                            <button wire:click="$set('metodePembayaran', '{{ $val }}')"
                                class="py-3 rounded-xl text-sm font-semibold border transition
                                {{ $metodePembayaran === $val ? 'bg-brand-600 border-brand-500 text-white' : 'bg-surface border-surface-border text-surface-muted hover:border-brand-500' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Nominal (tunai only) --}}
                @if($metodePembayaran === 'tunai')
                    <div class="space-y-3"
                        x-data="{
                            display: '{{ number_format($nominalBayar, 0, ',', '.') }}',
                            init() {
                                this.display = this.format({{ (int) $nominalBayar }});
                                this.$watch('display', val => {
                                    const raw = parseInt(String(val).replace(/\./g,'')) || 0;
                                    @this.set('nominalBayar', raw);
                                });
                            },
                            format(n) {
                                return parseInt(n).toLocaleString('id-ID');
                            },
                            onInput(e) {
                                const raw = e.target.value.replace(/\./g,'').replace(/[^0-9]/g,'');
                                const num = parseInt(raw) || 0;
                                this.display = this.format(num);
                                @this.set('nominalBayar', num);
                            },
                            setVal(n) {
                                this.display = this.format(n);
                                @this.set('nominalBayar', n);
                            }
                        }">
                        <p class="text-xs text-surface-muted font-semibold uppercase tracking-wider">Nominal Bayar</p>
                        
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-surface-muted font-bold text-xl">Rp</span>
                            <input type="text" inputmode="numeric"
                                x-model="display"
                                @input="onInput($event)"
                                @focus="$event.target.select()"
                                class="w-full bg-surface border border-surface-border rounded-xl pl-12 pr-4 py-3 text-2xl font-black text-white focus:outline-none focus:border-brand-500 text-right tabular-nums">
                        </div>

                        {{-- Quick amounts dari total --}}
                        @php
                            $tot = (int) $this->total;
                            $base = (int)(ceil($tot / 5000) * 5000);
                            $quickAmounts = array_unique([
                                $base,
                                (int)(ceil($tot / 10000) * 10000),
                                (int)(ceil($tot / 50000) * 50000),
                                (int)(ceil($tot / 100000) * 100000),
                                20000,
                                50000,
                                100000,
                                200000,
                            ]);
                            sort($quickAmounts);
                            // Filter only those >= total to avoid negative change, except we always show them
                        @endphp
                        <div class="flex flex-wrap gap-2">
                            @foreach($quickAmounts as $amount)
                                <button @click="setVal({{ $amount }})"
                                    class="px-4 py-2 bg-surface border border-surface-border rounded-xl text-sm font-bold text-white hover:border-brand-500 hover:text-brand-400 transition">
                                    {{ number_format($amount, 0, ',', '.') }}
                                </button>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center bg-green-500/10 border border-green-500/20 rounded-xl px-5 py-4">
                            <div>
                                <p class="text-xs text-green-400 font-semibold uppercase tracking-wider">Kembalian</p>
                                <p class="text-2xl font-black text-green-400">Rp {{ number_format($this->kembalian, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <button wire:click="prosesTransaksi"
                    wire:loading.attr="disabled"
                    wire:target="prosesTransaksi"
                    class="w-full py-4 rounded-2xl bg-green-600 hover:bg-green-500 text-white font-bold text-base transition active:scale-95 shadow-lg shadow-green-900/50">
                    <span wire:loading.remove wire:target="prosesTransaksi">✅ Selesaikan Transaksi</span>
                    <span wire:loading wire:target="prosesTransaksi">Memproses...</span>
                </button>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- SUCCESS MODAL                                          --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @if($showSuccess)
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-surface-card border border-green-500/30 rounded-3xl w-full max-w-sm p-8 text-center space-y-4 fade-up shadow-2xl shadow-green-900/30">
                <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-white">Transaksi Berhasil!</h2>
                    <p class="text-sm text-white opacity-70 mt-1 font-medium tracking-wide">{{ $nomorNotaSuccess }}</p>
                </div>
                @if($kembalianSuccess > 0)
                    <div class="bg-green-500/10 border border-green-500/20 rounded-2xl px-6 py-4">
                        <p class="text-sm text-green-300">Kembalian</p>
                        <p class="text-2xl font-black text-green-400">Rp {{ number_format($kembalianSuccess, 0, ',', '.') }}</p>
                    </div>
                @endif
                <button wire:click="closeSuccess"
                    class="w-full py-3 rounded-2xl bg-brand-600 hover:bg-brand-500 text-white font-bold transition">
                    Pesanan Baru
                </button>
            </div>
        </div>
    @endif

</div>
