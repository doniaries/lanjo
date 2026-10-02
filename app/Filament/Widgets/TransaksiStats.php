<?php

namespace App\Filament\Widgets;

use App\Models\Pesanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class TransaksiStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $periode = $this->filters['periode'] ?? 'hari_ini';
        
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
            $startDate = Carbon::parse($this->filters['tanggal_mulai'] ?? Carbon::today());
            $endDate = Carbon::parse($this->filters['tanggal_selesai'] ?? Carbon::today())->endOfDay();
        }

        $tenantId = \Filament\Facades\Filament::getTenant()?->id;

        $query = Pesanan::query()
            ->where('status', 'selesai')
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($tenantId) {
            $query->where('usaha_id', $tenantId);
        }

        $totalPendapatan = $query->sum('total_akhir');
        $totalTransaksi = $query->count();
        
        // Cek pendapatan sebelumnya untuk trend
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
        
        $trendIcon = $totalPendapatan >= $prevPendapatan ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $trendColor = $totalPendapatan >= $prevPendapatan ? 'success' : 'danger';
        $trendDescription = $totalPendapatan >= $prevPendapatan ? 'Meningkat dari periode sebelumnya' : 'Menurun dari periode sebelumnya';

        return [
            Stat::make('Total Pendapatan', format_rupiah($totalPendapatan))
                ->description($trendDescription)
                ->descriptionIcon($trendIcon)
                ->color($trendColor),
                
            Stat::make('Total Transaksi', $totalTransaksi . ' Transaksi')
                ->description('Transaksi Selesai')
                ->color('info'),
        ];
    }
}
