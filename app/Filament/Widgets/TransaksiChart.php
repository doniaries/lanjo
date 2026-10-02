<?php

namespace App\Filament\Widgets;

use App\Models\Pesanan;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class TransaksiChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Grafik Transaksi';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
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

        $orders = $query
            ->selectRaw('DATE(tanggal) as date, SUM(total_akhir) as total, COUNT(id) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $dataTotal = [];
        $dataCount = [];

        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        $ordersMap = $orders->keyBy('date');

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $labels[] = $date->format('d M Y');
            $dataTotal[] = $ordersMap->has($dateString) ? $ordersMap[$dateString]->total : 0;
            $dataCount[] = $ordersMap->has($dateString) ? $ordersMap[$dateString]->count : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pendapatan (Rp)',
                    'data' => $dataTotal,
                    'borderColor' => '#10b981', 
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $dataCount,
                    'borderColor' => '#3b82f6', 
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
