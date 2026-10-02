<?php

namespace App\Filament\Widgets;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $filters = $this->pageFilters ?? [];
        $periode = $filters['periode'] ?? 'hari_ini';
        
        $startDate = Carbon::today();
        $endDate = Carbon::today()->endOfDay();

        if ($periode === 'kemarin') {
            $startDate = Carbon::yesterday();
            $endDate = Carbon::yesterday()->endOfDay();
        } elseif ($periode === 'minggu_ini') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } elseif ($periode === 'bulan_ini') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($periode === 'custom') {
            $startDate = Carbon::parse($filters['tanggal_mulai'] ?? Carbon::today());
            $endDate = Carbon::parse($filters['tanggal_selesai'] ?? Carbon::today())->endOfDay();
        }

        if ($startDate->isSameDay($endDate)) {
            $labelSuffix = $startDate->translatedFormat('d F Y');
        } else {
            $labelSuffix = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
        }

        $tenantId = \Filament\Facades\Filament::getTenant()?->id;

        // Pemasukan
        $queryPemasukan = Pesanan::query()
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', 'selesai');
        
        if ($tenantId) {
            $queryPemasukan->where('usaha_id', $tenantId);
        }
        $pemasukan = $queryPemasukan->sum('total_akhir');

        // Produk Terjual
        $queryProduk = DetailPesanan::query()->whereHas('pesanan', function($q) use ($startDate, $endDate, $tenantId) {
            $q->whereBetween('tanggal', [$startDate, $endDate])->where('status', 'selesai');
            if ($tenantId) {
                $q->where('usaha_id', $tenantId);
            }
        });
        $produkTerjual = $queryProduk->sum('jumlah');

        // Pesanan (semua pesanan)
        $queryPesanan = Pesanan::query()
            ->whereBetween('tanggal', [$startDate, $endDate]);
        
        if ($tenantId) {
            $queryPesanan->where('usaha_id', $tenantId);
        }
        $pesananCount = $queryPesanan->count();

        // Trend calculation for Pemasukan
        $prevStartDate = clone $startDate;
        $prevEndDate = clone $endDate;
        $diffInDays = $startDate->diffInDays($endDate) + 1;
        
        if ($periode === 'hari_ini' || $periode === 'kemarin') {
            $prevStartDate->subDay();
            $prevEndDate->subDay();
        } elseif ($periode === 'minggu_ini') {
            $prevStartDate->subWeek();
            $prevEndDate->subWeek();
        } elseif ($periode === 'bulan_ini') {
            $prevStartDate->subMonth();
            $prevEndDate->subMonth();
        } else {
            $prevStartDate->subDays($diffInDays);
            $prevEndDate->subDays($diffInDays);
        }

        $prevQuery = Pesanan::query()
            ->where('status', 'selesai')
            ->whereBetween('tanggal', [$prevStartDate, $prevEndDate]);
            
        if ($tenantId) {
            $prevQuery->where('usaha_id', $tenantId);
        }
        
        $prevPendapatan = $prevQuery->sum('total_akhir');
        $trendIcon = $pemasukan >= $prevPendapatan ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $trendColor = $pemasukan >= $prevPendapatan ? 'success' : 'danger';
        $trendDescription = $pemasukan >= $prevPendapatan ? 'Meningkat dari periode sebelumnya' : 'Menurun dari periode sebelumnya';

        return [
            Stat::make('Pemasukan ' . $labelSuffix, format_rupiah($pemasukan))
                ->description($trendDescription)
                ->descriptionIcon($trendIcon)
                ->color($trendColor),

            Stat::make('Produk Terjual ' . $labelSuffix, $produkTerjual . ' Item')
                ->description('Jumlah menu terjual (' . strtolower($labelSuffix) . ')')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Pesanan ' . $labelSuffix, $pesananCount . ' Pesanan')
                ->description('Total pesanan masuk (' . strtolower($labelSuffix) . ')')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),
        ];
    }
}
