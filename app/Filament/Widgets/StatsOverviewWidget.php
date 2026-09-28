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
            Stat::make('Total Pengguna', User::count('*'))
                ->description('Jumlah pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([2, 3, 4, 3, 5, 4, 6, 5]),

            Stat::make('Pengguna Aktif', User::query()->where('is_active', true)->count('*'))
                ->description('Pengguna dengan status aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Role', Role::count('*'))
                ->description('Jumlah role yang tersedia')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),
        ];
    }
}
