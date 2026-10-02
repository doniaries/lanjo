<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function cetak(Request $request)
    {
        $periode = $request->query('periode', 'hari_ini');
        $tenantId = \Filament\Facades\Filament::getTenant()?->id ?? $request->query('tenant_id');

        $startDate = Carbon::today();
        $endDate = Carbon::today()->endOfDay();
        $labelSuffix = 'Hari Ini';

        if ($periode === 'kemarin') {
            $startDate = Carbon::yesterday();
            $endDate = Carbon::yesterday()->endOfDay();
            $labelSuffix = 'Kemarin';
        } elseif ($periode === 'minggu_ini') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
            $labelSuffix = 'Minggu Ini';
        } elseif ($periode === 'bulan_ini') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $labelSuffix = 'Bulan Ini';
        } elseif ($periode === 'custom') {
            $startDate = Carbon::parse($request->query('start', Carbon::today()));
            $endDate = Carbon::parse($request->query('end', Carbon::today()))->endOfDay();
            $labelSuffix = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
        }

        $query = Pesanan::query()
            ->with(['kasir', 'meja'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', 'selesai');

        if ($tenantId) {
            $query->where('usaha_id', $tenantId);
        }

        $pesanans = $query->orderBy('tanggal', 'asc')->get();

        return view('reports.cetak-transaksi', [
            'pesanans' => $pesanans,
            'labelSuffix' => $labelSuffix,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'isPreview' => $request->query('preview', 0),
        ]);
    }
}
