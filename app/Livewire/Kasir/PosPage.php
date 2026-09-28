<?php

namespace App\Livewire\Kasir;

use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pembayaran;
use App\Models\Pengaturan;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Computed;

class PosPage extends Component
{
    // State
    public ?int $selectedKategori = null;
    public string $searchMenu = '';
    public array $cart = [];          // ['menu_id' => ['nama', 'harga', 'qty', 'gambar']]
    public ?int $selectedMeja = null;
    public string $tipePesanan = 'dine_in';
    public string $catatan = '';
    public float $diskon = 0;

    // Checkout modal
    public bool $showCheckout = false;
    public float $nominalBayar = 0;
    public string $metodePembayaran = 'tunai';

    // Success modal
    public bool $showSuccess = false;
    public string $nomorNotaSuccess = '';
    public float $kembalianSuccess = 0;

    public function mount(): void
    {
        $this->selectedKategori = KategoriMenu::orderBy('urutan')->value('id');
    }

    #[Computed]
    public function pengaturan()
    {
        return Pengaturan::first();
    }

    #[Computed]
    public function kategoris()
    {
        return KategoriMenu::where('aktif', true)->orderBy('urutan')->get();
    }

    #[Computed]
    public function menus()
    {
        return Menu::with('kategoriMenu')
            ->when($this->selectedKategori, fn ($q) => $q->where('kategori_menu_id', $this->selectedKategori))
            ->when($this->searchMenu, fn ($q) => $q->where('nama', 'like', "%{$this->searchMenu}%"))
            ->where('status_aktif', true)
            ->orderBy('nama')
            ->get();
    }

    #[Computed]
    public function mejas()
    {
        return Meja::orderBy('nomor_meja')->get();
    }

    public function selectKategori(int $id): void
    {
        $this->selectedKategori = $id;
        unset($this->menus);
    }

    public function addToCart(int $menuId): void
    {
        $menu = Menu::find($menuId);
        if (! $menu) return;

        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['qty']++;
        } else {
            $this->cart[$menuId] = [
                'nama'   => $menu->nama,
                'harga'  => (float) $menu->harga_jual,
                'gambar' => $menu->gambar,
                'qty'    => 1,
            ];
        }
    }

    public function removeFromCart(int $menuId): void
    {
        unset($this->cart[$menuId]);
    }

    public function decreaseQty(int $menuId): void
    {
        if (isset($this->cart[$menuId])) {
            if ($this->cart[$menuId]['qty'] <= 1) {
                unset($this->cart[$menuId]);
            } else {
                $this->cart[$menuId]['qty']--;
            }
        }
    }

    public function increaseQty(int $menuId): void
    {
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['qty']++;
        }
    }

    public function clearCart(): void
    {
        $this->cart = [];
        $this->catatan = '';
        $this->diskon = 0;
        $this->selectedMeja = null;
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->cart)->sum(fn ($item) => $item['harga'] * $item['qty']);
    }

    public function getPajakProperty(): float
    {
        $pajak = $this->pengaturan?->pajak_default ?? 0;
        return $this->subtotal * ($pajak / 100);
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal + $this->pajak - $this->diskon;
    }

    public function openCheckout(): void
    {
        if (empty($this->cart)) return;
        $this->nominalBayar = $this->total;
        $this->showCheckout = true;
    }

    public function getKembalianProperty(): float
    {
        return max(0, $this->nominalBayar - $this->total);
    }

    public function prosesTransaksi(): void
    {
        if (empty($this->cart)) return;

        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        DB::transaction(function () use ($user) {
            $nomor = 'NOTA-' . now()->format('Ymd-His') . '-' . rand(100, 999);

            $pesanan = Pesanan::create([
                'nomor_nota'   => $nomor,
                'tanggal'      => now(),
                'meja_id'      => $this->selectedMeja ?: null,
                'tipe_pesanan' => $this->tipePesanan,
                'kasir_id'     => $user->id,
                'status'       => 'selesai',
                'subtotal'     => $this->subtotal,
                'diskon_nilai' => $this->diskon,
                'pajak_nilai'  => $this->pajak,
                'total_akhir'  => $this->total,
                'catatan'      => $this->catatan,
            ]);

            foreach ($this->cart as $menuId => $item) {
                DetailPesanan::create([
                    'pesanan_id'           => $pesanan->id,
                    'menu_id'              => $menuId,
                    'nama_menu_snapshot'   => $item['nama'],
                    'harga_satuan_snapshot'=> $item['harga'],
                    'jumlah'               => $item['qty'],
                    'subtotal'             => $item['harga'] * $item['qty'],
                ]);
            }

            Pembayaran::create([
                'pesanan_id'   => $pesanan->id,
                'metode'       => $this->metodePembayaran,
                'jumlah_bayar' => $this->nominalBayar,
                'kembalian'    => $this->kembalian,
                'waktu_bayar'  => now(),
                'kasir_id'     => $user->id,
            ]);

            $this->nomorNotaSuccess = $nomor;
            $this->kembalianSuccess = $this->kembalian;
        });

        $this->showCheckout = false;
        $this->showSuccess = true;
        $this->clearCart();
    }

    public function closeSuccess(): void
    {
        $this->showSuccess = false;
    }

    public function render()
    {
        return view('livewire.kasir.pos-page')
            ->layout('layouts.kasir');
    }
}
