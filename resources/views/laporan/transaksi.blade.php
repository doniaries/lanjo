<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    @php
        $pengaturan = \App\Models\Pengaturan::first();
        $namaToko = $pengaturan->nama_toko ?? 'Nama Toko';
        $alamatToko = $pengaturan->alamat ?? 'Alamat Toko';
        $telpToko = $pengaturan->telepon ?? '-';
        $shiftAktif = \App\Models\Shift::where('pengguna_id', auth()->id())->where('status', 'buka')->first();
    @endphp

    <div class="text-center" style="margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 10px;">
        <h1 style="margin: 0; font-size: 24px;">{{ $namaToko }}</h1>
        <p style="margin: 5px 0;">{{ $alamatToko }} | Telp: {{ $telpToko }}</p>
    </div>

    <h2 class="text-center" style="margin-top: 20px;">Laporan Transaksi</h2>
    <p class="text-center">Periode: {{ \Carbon\Carbon::parse($start)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. Nota</th>
                <th>Kasir</th>
                <th>Status</th>
                <th class="text-right">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($pesanans as $index => $pesanan)
                @php $grandTotal += $pesanan->total_akhir; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d/m/Y H:i') }}</td>
                    <td>{{ $pesanan->nomor_nota ?? '-' }}</td>
                    <td>{{ $pesanan->kasir->name ?? '-' }}</td>
                    <td>{{ ucfirst($pesanan->status) }}</td>
                    <td class="text-right">{{ format_rupiah($pesanan->total_akhir) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Grand Total</th>
                <th class="text-right">{{ format_rupiah($grandTotal) }}</th>
            </tr>
        </tfoot>
    </table>

    <table style="width: 100%; border: none; margin-top: 50px;">
        <tr style="border: none;">
            <td style="border: none; text-align: right; width: 100%;">
                <p style="margin: 0;">Kasir Bertugas,</p>
                <br><br><br><br>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">{{ auth()->user()->name ?? 'Administrator' }}</p>
                <p style="margin: 5px 0 0 0;">Shift: {{ $shiftAktif ? 'Aktif (' . \Carbon\Carbon::parse($shiftAktif->waktu_mulai)->format('H:i') . ' - Sekarang)' : 'Tidak ada' }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
