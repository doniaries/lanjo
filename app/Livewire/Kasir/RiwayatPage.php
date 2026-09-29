<?php

namespace App\Livewire\Kasir;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Pesanan;
use App\Models\Pengaturan;

class RiwayatPage extends Component
{
    use WithPagination;

    #[Computed]
    public function riwayatTransaksi()
    {
        return Pesanan::with('kasir')
            ->latest('tanggal')
            ->paginate(15);
    }

    public function cetakStrukRiwayat(int $id)
    {
        $pesanan = Pesanan::with(['detailPesanans.menu', 'kasir', 'meja', 'pembayarans'])->find($id);
        if (! $pesanan) return;

        $pengaturan = Pengaturan::first();

        // Create the cart-like items structure needed by the view
        $items = [];
        foreach ($pesanan->detailPesanans as $detail) {
            $items[$detail->menu_id] = [
                'nama' => $detail->nama_menu_snapshot,
                'harga' => $detail->harga_satuan_snapshot,
                'qty' => $detail->jumlah,
            ];
        }

        $pembayaran = $pesanan->pembayarans->first();

        $notaData = [
            'nomor'          => $pesanan->nomor_nota,
            'tanggal'        => \Carbon\Carbon::parse($pesanan->tanggal)->format('d/m/Y H:i'),
            'kasir'          => $pesanan->kasir?->name ?? '-',
            'toko'           => $pengaturan?->nama_toko ?? config('app.name'),
            'alamat'         => $pengaturan?->alamat ?? '',
            'telepon'        => $pengaturan?->telepon ?? '',
            'items'          => $items,
            'subtotal'       => (float) $pesanan->subtotal,
            'pajak'          => (float) $pesanan->pajak_nilai,
            'pajak_pct'      => $pengaturan?->pajak_default ?? 0,
            'diskon'         => (float) $pesanan->diskon_nilai,
            'total'          => (float) $pesanan->total_akhir,
            'metode'         => $pembayaran ? $pembayaran->metode : 'tunai',
            'nominal_bayar'  => $pembayaran ? (float) $pembayaran->jumlah_bayar : (float) $pesanan->total_akhir,
            'kembalian'      => $pembayaran ? (float) $pembayaran->kembalian : 0,
            'nama_pembeli'   => $pesanan->nama_pembeli ?? '',
            'bank_pengirim'  => $pesanan->bank_pengirim ?? '',
            'tipe_pesanan'   => $pesanan->tipe_pesanan,
            'catatan'        => $pesanan->catatan ?? '',
            'footer_struk'   => $pengaturan?->footer_struk ?? '',
        ];

        // Trigger the print event in the browser. 
        // We'll dispatch to the component itself to show a print modal, or simply redirect to a print page.
        // Actually, let's store it in session and redirect to a standalone print endpoint, or dispatch browser event.
        session()->flash('print_nota', $notaData);
        return redirect()->route('kasir.pos'); 
    }

    public function render()
    {
        return view('livewire.kasir.riwayat-page')->layout('layouts.kasir');
    }
}
