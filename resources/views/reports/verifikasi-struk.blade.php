<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Struk {{ $pesanan->nomor_nota }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-4 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-green-600 text-white p-6 text-center">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold">Struk Valid</h1>
            <p class="text-green-100 mt-1">Nota: {{ $pesanan->nomor_nota }}</p>
        </div>
        
        <div class="p-6 space-y-4">
            <div>
                <p class="text-sm text-gray-500">Tanggal Transaksi</p>
                <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d F Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Toko / Usaha</p>
                <p class="font-semibold text-gray-800">{{ $pesanan->usaha->nama_usaha ?? 'Sistem Kasir' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kasir</p>
                <p class="font-semibold text-gray-800">{{ $pesanan->kasir->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $pesanan->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($pesanan->status) }}
                </span>
            </div>
            
            <hr class="my-4 border-gray-200">
            
            <div>
                <p class="text-sm text-gray-500 mb-2">Rincian Pembayaran</p>
                <div class="flex justify-between font-bold text-lg text-gray-900">
                    <span>Total Transaksi</span>
                    <span>Rp {{ number_format($pesanan->total_akhir, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 p-4 text-center text-sm text-gray-500 border-t border-gray-100">
            Diverifikasi oleh Sistem Kasir Digital
        </div>
    </div>
</body>
</html>
