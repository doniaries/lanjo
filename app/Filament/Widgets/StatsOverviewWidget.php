<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Spatie\Permission\Models\Role;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pemasukan Hari Ini', format_rupiah(\App\Models\Pesanan::whereDate('tanggal', today())->where('status', 'selesai')->sum('total_akhir')))
                ->description('Total pendapatan pesanan selesai')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Produk Terjual Hari Ini', \App\Models\DetailPesanan::whereHas('pesanan', function($q) {
                    $q->whereDate('tanggal', today())->where('status', 'selesai');
                })->sum('jumlah') . ' Item')
                ->description('Jumlah menu terjual')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Pesanan Hari Ini', \App\Models\Pesanan::whereDate('tanggal', today())->count() . ' Pesanan')
                ->description('Total pesanan masuk hari ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),
        ];
    }
}
