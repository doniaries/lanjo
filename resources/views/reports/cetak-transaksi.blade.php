<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body @if(!$isPreview) onload="window.print()" @endif>
    @if(!$isPreview)
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #000; color: #fff; border: none; cursor: pointer; border-radius: 5px;">Print Laporan</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #ccc; color: #000; border: none; cursor: pointer; border-radius: 5px; margin-left: 10px;">Tutup</button>
    </div>
    @endif

    <div class="header">
        <h2>Laporan Transaksi Penjualan</h2>
        <p>Periode: {{ $labelSuffix }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nomor Nota</th>
                <th>Kasir</th>
                <th>Subtotal</th>
                <th class="text-right">Total Akhir</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSemua = 0; @endphp
            @forelse($pesanans as $index => $pesanan)
                @php $totalSemua += $pesanan->total_akhir; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d/m/Y H:i') }}</td>
                    <td>{{ $pesanan->nomor_nota }}</td>
                    <td>{{ $pesanan->kasir->name ?? '-' }}</td>
                    <td>Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($pesanan->total_akhir, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan:</th>
                <th class="text-right">Rp {{ number_format($totalSemua, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
