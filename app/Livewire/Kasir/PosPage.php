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
    public ?int    $selectedKategori = null;
    public string  $searchMenu       = '';
    public array   $cart             = [];
    public ?int    $selectedMeja     = null;
    public string  $tipePesanan      = 'dine_in';
    public string  $catatan          = '';
    public float   $diskon           = 0;

    // Checkout modal
    public bool   $showCheckout       = false;
    public float  $nominalBayar       = 0;
    public string $metodePembayaran   = 'tunai';
    public string $namaPembeli        = '';
    public string $bankPengirim       = '';
    public string $ukuranKertas       = '80'; // '58' atau '80'

    // Print modal
    public bool   $showPrint          = false;

    // Success / nota terakhir
    public bool   $showSuccess        = false;
    public string $nomorNotaSuccess   = '';

    // Modals
    public bool   $showPending        = false;
    public bool   $showRiwayat        = false;
    public bool   $showLaporan        = false;
    public bool   $showDetailPesanan  = false;
    public ?int   $selectedPesananId  = null;
    public string $laporanStart       = '';
    public string $laporanEnd         = '';
    public float  $kembalianSuccess   = 0;
    public array  $notaData           = [];   // untuk print

    public function mount(): void
    {
        $this->laporanStart = now()->format('Y-m-d');
        $this->laporanEnd = now()->format('Y-m-d');
        $this->selectedKategori = null;
    }

    public function viewPesananDetail($id): void
    {
        $this->selectedPesananId = $id;
        $this->showRiwayat = false;
        $this->showDetailPesanan = true;
        
        $this->setNotaData($id);
    }

    public function cetakStrukRiwayat($id): void
    {
        $this->setNotaData($id);
        $this->dispatch('trigger-print-riwayat', ukuran: $this->ukuranKertas, nota: $this->notaData['nomor']);
    }

    private function setNotaData($id): void
    {
        $pesanan = Pesanan::with(['detailPesanans.menu', 'kasir', 'meja', 'pembayarans'])->find($id);
        if ($pesanan) {
            $items = [];
            foreach ($pesanan->detailPesanans as $detail) {
                $items[] = [
                    'nama' => $detail->menu->nama ?? $detail->nama_menu_snapshot,
                    'qty' => $detail->jumlah,
                    'harga' => $detail->harga_satuan_snapshot,
                ];
            }
            $pembayaran = $pesanan->pembayarans->first();

            $this->notaData = [
                'nomor'          => $pesanan->nomor_nota,
                'tanggal'        => \Carbon\Carbon::parse($pesanan->tanggal)->format('d/m/Y H:i'),
                'kasir'          => $pesanan->kasir?->name ?? '-',
                'toko'           => $this->pengaturan?->nama_toko ?? config('app.name'),
                'alamat'         => $this->pengaturan?->alamat ?? '',
                'telepon'        => $this->pengaturan?->telepon ?? '',
                'items'          => $items,
                'subtotal'       => $pesanan->subtotal,
                'pajak'          => $pesanan->pajak_nilai ?? 0,
                'pajak_pct'      => $this->pengaturan?->pajak_default ?? 0,
                'diskon'         => $pesanan->diskon_nilai ?? 0,
                'total'          => $pesanan->total_akhir,
                'metode'         => $pembayaran?->metode ?? 'tunai',
                'nominal_bayar'  => $pembayaran?->jumlah_bayar ?? $pesanan->total_akhir,
                'kembalian'      => $pembayaran?->kembalian ?? 0,
                'nama_pembeli'   => '', // could be added to DB later if needed
                'bank_pengirim'  => '',
                'tipe_pesanan'   => $pesanan->tipe_pesanan,
                'catatan'        => $pesanan->catatan ?? '',
            ];
        }
    }

    public function closeDetailPesanan(): void
    {
        $this->showDetailPesanan = false;
        $this->selectedPesananId = null;
        $this->showRiwayat = true;
    }

    #[Computed]
    public function selectedPesananDetail()
    {
        return $this->selectedPesananId 
            ? Pesanan::with(['detailPesanans.menu', 'kasir', 'meja', 'pembayarans'])->find($this->selectedPesananId) 
            : null;
    }

    #[Computed]
    public function riwayatTransaksi()
    {
        return \App\Models\Pesanan::with('kasir')
            ->whereDate('tanggal', today())
            ->latest('tanggal')
            ->limit(50)
            ->get();
    }

    // ──────────────────────────────────────────────────────────
    // Computed
    // ──────────────────────────────────────────────────────────
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

    // ──────────────────────────────────────────────────────────
    // Cart actions
    // ──────────────────────────────────────────────────────────
    public function selectKategori(int $id): void
    {
        $this->selectedKategori = $id;
        unset($this->menus);
    }

    public function addToCart(int $menuId, string $nama, float $harga, string $gambar = ''): void
    {
        if (isset($this->cart[$menuId])) {
            $this->cart[$menuId]['qty']++;
        } else {
            $this->cart[$menuId] = [
                'nama'   => $nama,
                'harga'  => $harga,
                'gambar' => $gambar,
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
        $this->cart          = [];
        $this->catatan       = '';
        $this->diskon        = 0;
        $this->selectedMeja  = null;
        $this->namaPembeli   = '';
        $this->bankPengirim  = '';
    }

    // ──────────────────────────────────────────────────────────
    // Kalkulasi
    // ──────────────────────────────────────────────────────────
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

    public function getKembalianProperty(): float
    {
        return max(0, $this->nominalBayar - $this->total);
    }

    // ──────────────────────────────────────────────────────────
    // Checkout
    // ──────────────────────────────────────────────────────────
    public function openCheckout(): void
    {
        if (empty($this->cart)) return;
        $this->nominalBayar  = $this->total;
        $this->namaPembeli   = '';
        $this->bankPengirim  = '';
        $this->showCheckout  = true;
    }

    public function setMetode(string $metode): void
    {
        $this->metodePembayaran = $metode;
        if ($metode === 'tunai') {
            $this->nominalBayar = $this->total;
        } else {
            $this->nominalBayar = $this->total;
        }
        $this->namaPembeli  = '';
        $this->bankPengirim = '';
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
                    'pesanan_id'            => $pesanan->id,
                    'menu_id'               => $menuId,
                    'nama_menu_snapshot'    => $item['nama'],
                    'harga_satuan_snapshot' => $item['harga'],
                    'jumlah'                => $item['qty'],
                    'subtotal'              => $item['harga'] * $item['qty'],
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

            // Siapkan data untuk print nota
            $this->notaData = [
                'nomor'          => $nomor,
                'tanggal'        => now()->format('d/m/Y H:i'),
                'kasir'          => $user->name,
                'toko'           => $this->pengaturan?->nama_toko ?? config('app.name'),
                'alamat'         => $this->pengaturan?->alamat ?? '',
                'telepon'        => $this->pengaturan?->telepon ?? '',
                'items'          => $this->cart,
                'subtotal'       => $this->subtotal,
                'pajak'          => $this->pajak,
                'pajak_pct'      => $this->pengaturan?->pajak_default ?? 0,
                'diskon'         => $this->diskon,
                'total'          => $this->total,
                'metode'         => $this->metodePembayaran,
                'nominal_bayar'  => $this->nominalBayar,
                'kembalian'      => $this->kembalian,
                'nama_pembeli'   => $this->namaPembeli,
                'bank_pengirim'  => $this->bankPengirim,
                'tipe_pesanan'   => $this->tipePesanan,
                'catatan'        => $this->catatan,
            ];

            $this->nomorNotaSuccess = $nomor;
            $this->kembalianSuccess = $this->kembalian;
        });

        $this->showCheckout = false;
        $this->showSuccess  = true;
        $this->clearCart();
    }

    public function closeSuccess(): void
    {
        $this->showSuccess = false;
    }

    public function openPrint(): void
    {
        $this->showPrint = true;
    }

    public function closePrint(): void
    {
        $this->showPrint = false;
    }

    public function render()
    {
        return view('livewire.kasir.pos-page')
            ->layout('layouts.kasir');
    }
}
