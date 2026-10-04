<!DOCTYPE html>
<html>
<head>
    <title>Struk {{ $pesanan->nomor_nota }}</title>
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
            width: 80mm;
            padding: 4mm;
            margin: 0 auto;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mt-2 { margin-top: 8px; }
        .w-full { width: 100%; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 2px 0; vertical-align: top; }
        .border-t { border-top: 1px dashed black; }
        .border-b { border-bottom: 1px dashed black; }
        @media print {
            body { width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 10px; padding: 10px; background: #f3f4f6;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #059669; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">🖨️ Cetak Struk</button>
    </div>
    <div class="print-container">
        @php
            $isFree = $pesanan->usaha && $pesanan->usaha->isFree();
            $pengaturan = \App\Models\Pengaturan::where('usaha_id', $pesanan->usaha_id)->first();
        @endphp
        
        <div class="text-center mb-2">
            @if($isFree)
                <h2 class="font-bold mb-1" style="font-size: 16px; margin-top:0;">Struk Belanja</h2>
            @else
                <h2 class="font-bold mb-1" style="font-size: 16px; margin-top:0;">{{ $pengaturan->nama_toko ?? $pesanan->usaha->nama_usaha ?? 'NAMA TOKO' }}</h2>
                @if($pengaturan && $pengaturan->alamat)
                    <div style="font-size: 12px;">{{ $pengaturan->alamat }}</div>
                @endif
            @endif
            @if($pengaturan && $pengaturan->telepon)
                <div style="font-size: 12px;">Telp: {{ $pengaturan->telepon }}</div>
            @endif
        </div>
        
        <div class="border-t border-b mt-2 mb-2" style="font-size: 12px; padding:4px 0;">
            <table class="w-full">
                <tr>
                    <td class="text-left">Nota: {{ $pesanan->nomor_nota }}</td>
                    <td class="text-right">{{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="text-left">Kasir: {{ $pesanan->kasir->name ?? '-' }}</td>
                    <td class="text-right">Tipe: {{ $pesanan->tipe_pesanan === 'take_away' ? 'Take Away' : ($pesanan->meja ? 'Meja ' . $pesanan->meja->nomor_meja : 'Dine In') }}</td>
                </tr>
            </table>
        </div>
        
        <table class="w-full" style="font-size: 12px;">
            @foreach($pesanan->detailPesanans as $detail)
                <tr>
                    <td colspan="4" class="text-left">{{ $detail->nama_menu_snapshot ?? $detail->menu->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 10%;">{{ $detail->jumlah }}x</td>
                    <td class="text-right" style="width: 40%;">{{ number_format($detail->harga_satuan_snapshot, 0, ',', '.') }}</td>
                    <td class="text-right" style="width: 50%;">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        
        <div class="border-t mt-2" style="font-size: 12px; padding-top:4px;">
            <table class="w-full">
                <tr>
                    <td class="text-right" style="width:50%;">Subtotal:</td>
                    <td class="text-right font-bold">{{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($pesanan->pajak_nilai > 0)
                <tr>
                    <td class="text-right">Pajak:</td>
                    <td class="text-right">{{ number_format($pesanan->pajak_nilai, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($pesanan->diskon_nilai > 0)
                <tr>
                    <td class="text-right">Diskon:</td>
                    <td class="text-right">-{{ number_format($pesanan->diskon_nilai, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr>
                    <td class="text-right font-bold" style="font-size:14px;">Total:</td>
                    <td class="text-right font-bold" style="font-size:14px;">{{ number_format($pesanan->total_akhir, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        
        @if($pesanan->pembayarans->count() > 0)
        <div class="border-t mt-2" style="font-size: 12px; padding-top:4px;">
            <table class="w-full">
                @foreach($pesanan->pembayarans as $bayar)
                <tr>
                    <td class="text-right" style="width:50%;">Bayar ({{ ucfirst($bayar->metode) }}):</td>
                    <td class="text-right">{{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-right">Kembali:</td>
                    <td class="text-right">{{ number_format($bayar->kembalian, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif
        
        <div class="text-center mt-2 border-t" style="padding-top:8px;">
            @php
                $qrUrl = route('verifikasi.struk', $pesanan->nomor_nota);
                $qrCode = (new \chillerlan\QRCode\QRCode())->render($qrUrl);
            @endphp
            <img src="{{ $qrCode }}" alt="QR Code" style="width:100px; height:100px; margin: 0 auto; display:block;" />
            <div style="font-size:10px; margin-top:4px;">Scan untuk cek keaslian struk</div>
        </div>
        
        <div class="text-center mt-2" style="font-size: 11px;">
            @if($isFree)
                <p style="margin:0;">* VERSI FREE *</p>
                <p style="margin:0;">Software Kasir by: Lanjo</p>
                <p style="margin:0;">Upgrade / Hubungi: WA 0812-XXXX-XXXX</p>
            @else
                {{ $pengaturan->teks_footer ?? 'Terima kasih atas kunjungan Anda' }}
            @endif
        </div>
    </div>
</body>
</html>
