<div>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Riwayat Transaksi</h2>
            <a href="{{ route('kasir.pos') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm font-medium">
                &larr; Kembali ke POS
            </a>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 flex flex-col overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse text-sm text-gray-900 dark:text-white">
                    <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0 z-10 border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="px-4 py-4 font-medium text-gray-600 dark:text-gray-400">Waktu</th>
                            <th class="px-4 py-4 font-medium text-gray-600 dark:text-gray-400">No. Nota</th>
                            <th class="px-4 py-4 font-medium text-gray-600 dark:text-gray-400">Tipe</th>
                            <th class="px-4 py-4 font-medium text-gray-600 dark:text-gray-400">Kasir</th>
                            <th class="px-4 py-4 font-medium text-gray-600 dark:text-gray-400 text-right">Total</th>
                            <th class="px-4 py-4 font-medium text-gray-600 dark:text-gray-400 text-center">Status</th>
                            <th class="px-4 py-4 font-medium text-gray-600 dark:text-gray-400 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($this->riwayatTransaksi as $rt)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($rt->tanggal)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 font-mono text-emerald-600 dark:text-emerald-400 font-semibold underline decoration-emerald-600/30 underline-offset-2">{{ $rt->nomor_nota }}</td>
                            <td class="px-4 py-3">{{ $rt->tipe_pesanan === 'dine_in' ? 'Dine In' : 'Take Away' }}</td>
                            <td class="px-4 py-3">{{ $rt->kasir?->name }}</td>
                            <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($rt->total_akhir, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($rt->status === 'selesai')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">Selesai</span>
                                @elseif($rt->status === 'batal')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-rose-100 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20">Batal</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">Baru</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2 flex justify-end">
                                <a href="/admin/pesanans/{{ $rt->id }}" class="p-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg text-gray-600 dark:text-gray-300 transition" title="View Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <button wire:click="cetakStrukRiwayat({{ $rt->id }})" class="p-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg text-gray-600 dark:text-gray-300 transition" title="Cetak Struk">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 rounded-b-2xl shrink-0">
                {{ $this->riwayatTransaksi->links('livewire::tailwind') }}
            </div>
        </div>
    </div>
</div>
