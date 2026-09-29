<div>
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- HEADER LOGO + JUDUL                                                --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    <style>
        /* ─── Reset lokal ──────────────────────────────────────────────── */
        .wiz-wrap { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ─── Brand ────────────────────────────────────────────────────── */
        .wiz-brand {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 28px;
        }
        .wiz-brand-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .wiz-brand-name { font-size: 20px; font-weight: 800; color: #e6edf3; }

        /* ─── Step indicator ───────────────────────────────────────────── */
        .wiz-steps {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 32px;
        }
        .wiz-step-dot {
            flex: 1; height: 4px; border-radius: 99px;
            background: #30363d; transition: background .3s;
        }
        .wiz-step-dot.active  { background: #f97316; }
        .wiz-step-dot.done    { background: #3fb950; }

        .wiz-step-labels {
            display: flex; justify-content: space-between;
            margin-bottom: 24px;
        }
        .wiz-step-label {
            font-size: 12px; font-weight: 600; color: #8b949e;
            transition: color .3s;
        }
        .wiz-step-label.active { color: #f97316; }
        .wiz-step-label.done   { color: #3fb950; }

        /* ─── Heading ──────────────────────────────────────────────────── */
        .wiz-title {
            font-size: 22px; font-weight: 800; color: #e6edf3;
            margin-bottom: 6px;
        }
        .wiz-subtitle {
            font-size: 14px; color: #8b949e; margin-bottom: 28px;
        }

        /* ─── Form ─────────────────────────────────────────────────────── */
        .wiz-field { margin-bottom: 18px; }
        .wiz-label {
            display: block; font-size: 13px; font-weight: 600;
            color: #8b949e; margin-bottom: 6px;
        }
        .wiz-input, .wiz-select, .wiz-textarea {
            width: 100%; padding: 11px 14px;
            background: #21262d; border: 1px solid #30363d;
            border-radius: 10px; color: #e6edf3; font-size: 14px;
            font-family: inherit; transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .wiz-input:focus, .wiz-select:focus, .wiz-textarea:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249,115,22,.15);
        }
        .wiz-input.error, .wiz-select.error { border-color: #f85149; }
        .wiz-select option { background: #21262d; }
        .wiz-textarea { resize: none; min-height: 80px; }

        /* Error message */
        .wiz-error { font-size: 12px; color: #f85149; margin-top: 5px; }

        /* ─── Radio-card untuk tipe ────────────────────────────────────── */
        .wiz-radio-group {
            display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
        }
        .wiz-radio-card input { display: none; }
        .wiz-radio-label {
            display: flex; flex-direction: column; align-items: center;
            gap: 6px; padding: 14px 10px;
            background: #21262d; border: 2px solid #30363d;
            border-radius: 10px; cursor: pointer;
            transition: border-color .2s, background .2s;
            font-size: 13px; font-weight: 600; color: #8b949e;
            text-align: center;
        }
        .wiz-radio-label .icon { font-size: 24px; }
        .wiz-radio-card input:checked + .wiz-radio-label {
            border-color: #f97316;
            background: rgba(249,115,22,.08);
            color: #e6edf3;
        }
        .wiz-radio-label:hover { border-color: #8b949e; }

        /* ─── Buttons ──────────────────────────────────────────────────── */
        .wiz-actions {
            display: flex; gap: 12px; margin-top: 28px;
        }
        .btn-back {
            flex: 1; padding: 12px; border: 1px solid #30363d;
            border-radius: 10px; background: transparent; color: #8b949e;
            font-size: 14px; font-weight: 600; cursor: pointer;
            font-family: inherit; transition: border-color .2s, color .2s;
        }
        .btn-back:hover { border-color: #8b949e; color: #e6edf3; }
        .btn-next {
            flex: 2; padding: 12px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border: none; border-radius: 10px; color: #fff;
            font-size: 14px; font-weight: 700; cursor: pointer;
            font-family: inherit; transition: opacity .2s, transform .1s;
        }
        .btn-next:hover { opacity: .92; }
        .btn-next:active { transform: scale(.98); }
        .btn-next:disabled { opacity: .5; cursor: not-allowed; }

        /* ─── Success flash ────────────────────────────────────────────── */
        .wiz-flash {
            padding: 12px 16px; background: rgba(63,185,80,.12);
            border: 1px solid #3fb950; border-radius: 10px;
            color: #3fb950; font-size: 14px; margin-bottom: 20px;
        }

        /* ─── Footer link ──────────────────────────────────────────────── */
        .wiz-footer {
            text-align: center; margin-top: 20px;
            font-size: 13px; color: #8b949e;
        }
        .wiz-footer a { color: #f97316; text-decoration: none; font-weight: 600; }
        .wiz-footer a:hover { text-decoration: underline; }

        /* ─── Animasi slide ─────────────────────────────────────────────── */
        .wiz-slide { animation: slideIn .3s ease; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(16px); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>

    <div class="wiz-wrap">

        {{-- Flash --}}
        @if (session('success'))
            <div class="wiz-flash">✅ {{ session('success') }}</div>
        @endif

        {{-- Brand --}}
        <div class="wiz-brand">
            <div class="wiz-brand-icon">🧾</div>
            <span class="wiz-brand-name">e-Trans</span>
        </div>

        {{-- Step bar --}}
        <div class="wiz-steps">
            <div class="wiz-step-dot {{ $step >= 1 ? ($step > 1 ? 'done' : 'active') : '' }}"></div>
            <div class="wiz-step-dot {{ $step >= 2 ? 'active' : '' }}"></div>
        </div>
        <div class="wiz-step-labels">
            <span class="wiz-step-label {{ $step === 1 ? 'active' : ($step > 1 ? 'done' : '') }}">
                {{ $step > 1 ? '✓ ' : '' }}Data Usaha
            </span>
            <span class="wiz-step-label {{ $step === 2 ? 'active' : '' }}">Akun Pengguna</span>
        </div>

        {{-- ══════════════ STEP 1: DATA USAHA ══════════════ --}}
        @if ($step === 1)
            <div class="wiz-slide">
                <h1 class="wiz-title">Nama Usaha Anda</h1>
                <p class="wiz-subtitle">Daftarkan usaha Anda untuk mulai menggunakan e-Trans.</p>

                {{-- Nama usaha --}}
                <div class="wiz-field">
                    <label class="wiz-label" for="nama_usaha">Nama Usaha <span style="color:#f97316">*</span></label>
                    <input
                        id="nama_usaha"
                        wire:model="nama_usaha"
                        type="text"
                        class="wiz-input @error('nama_usaha') error @enderror"
                        placeholder="Contoh: Warung Makan Pak Budi"
                        autocomplete="off"
                    />
                    @error('nama_usaha')
                        <p class="wiz-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipe usaha --}}
                <div class="wiz-field">
                    <label class="wiz-label">Tipe Usaha <span style="color:#f97316">*</span></label>
                    <div style="display:grid; grid-template-columns: repeat(3,1fr); gap:10px;">
                        @foreach (['restoran' => ['🍽️','Restoran'], 'katering' => ['🍱','Katering'], 'cafe' => ['☕','Cafe']] as $val => [$ico, $lbl])
                            <label class="wiz-radio-card">
                                <input type="radio" wire:model="tipe_usaha" value="{{ $val }}" />
                                <span class="wiz-radio-label">
                                    <span class="icon">{{ $ico }}</span>
                                    {{ $lbl }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('tipe_usaha')
                        <p class="wiz-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div class="wiz-field">
                    <label class="wiz-label" for="telepon_usaha">No. Telepon Usaha</label>
                    <input
                        id="telepon_usaha"
                        wire:model="telepon_usaha"
                        type="tel"
                        class="wiz-input"
                        placeholder="08xx-xxxx-xxxx"
                    />
                </div>

                {{-- Alamat --}}
                <div class="wiz-field">
                    <label class="wiz-label" for="alamat">Alamat Usaha</label>
                    <textarea
                        id="alamat"
                        wire:model="alamat"
                        class="wiz-textarea"
                        placeholder="Jl. Contoh No. 1, Kota..."
                        rows="2"
                    ></textarea>
                </div>

                <div class="wiz-actions">
                    <button type="button" wire:click="nextStep" class="btn-next" style="flex:1">
                        Lanjut →
                    </button>
                </div>
            </div>
        @endif

        {{-- ══════════════ STEP 2: AKUN PENGGUNA ══════════════ --}}
        @if ($step === 2)
            <div class="wiz-slide">
                <h1 class="wiz-title">Buat Akun Pengguna</h1>
                <p class="wiz-subtitle">Ini adalah akun yang akan digunakan untuk masuk ke sistem.</p>

                {{-- Nama --}}
                <div class="wiz-field">
                    <label class="wiz-label" for="name">Nama Lengkap <span style="color:#f97316">*</span></label>
                    <input
                        id="name"
                        wire:model="name"
                        type="text"
                        class="wiz-input @error('name') error @enderror"
                        placeholder="Nama lengkap pengguna"
                        autocomplete="name"
                    />
                    @error('name')
                        <p class="wiz-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="wiz-field">
                    <label class="wiz-label" for="email">Email <span style="color:#f97316">*</span></label>
                    <input
                        id="email"
                        wire:model="email"
                        type="email"
                        class="wiz-input @error('email') error @enderror"
                        placeholder="email@contoh.com"
                        autocomplete="email"
                    />
                    @error('email')
                        <p class="wiz-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="wiz-field">
                        <label class="wiz-label" for="password">Password <span style="color:#f97316">*</span></label>
                        <input
                            id="password"
                            wire:model="password"
                            type="password"
                            class="wiz-input @error('password') error @enderror"
                            placeholder="Min. 8 karakter"
                            autocomplete="new-password"
                        />
                        @error('password')
                            <p class="wiz-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="wiz-field">
                        <label class="wiz-label" for="password_confirmation">Konfirmasi</label>
                        <input
                            id="password_confirmation"
                            wire:model="password_confirmation"
                            type="password"
                            class="wiz-input"
                            placeholder="Ulangi password"
                            autocomplete="new-password"
                        />
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="wiz-field">
                    <label class="wiz-label" for="kontak">No. HP / WA</label>
                    <input
                        id="kontak"
                        wire:model="kontak"
                        type="tel"
                        class="wiz-input"
                        placeholder="08xx-xxxx-xxxx"
                    />
                </div>

                {{-- Status / tipe --}}
                <div class="wiz-field">
                    <label class="wiz-label">Status Pengguna <span style="color:#f97316">*</span></label>
                    <div class="wiz-radio-group">
                        <label class="wiz-radio-card">
                            <input type="radio" wire:model="tipe" value="pemilik" />
                            <span class="wiz-radio-label">
                                <span class="icon">👑</span>
                                Pemilik
                            </span>
                        </label>
                        <label class="wiz-radio-card">
                            <input type="radio" wire:model="tipe" value="karyawan" />
                            <span class="wiz-radio-label">
                                <span class="icon">👤</span>
                                Karyawan
                            </span>
                        </label>
                    </div>
                    @error('tipe')
                        <p class="wiz-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="wiz-actions">
                    <button type="button" wire:click="prevStep" class="btn-back">← Kembali</button>
                    <button
                        type="button"
                        wire:click="submit"
                        wire:loading.attr="disabled"
                        class="btn-next"
                    >
                        <span wire:loading.remove>🚀 Daftarkan Usaha</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        @endif

        {{-- Footer --}}
        <div class="wiz-footer">
            Sudah punya akun?
            <a href="{{ route('filament.admin.auth.login') }}">Masuk di sini</a>
        </div>

    </div>
</div>
