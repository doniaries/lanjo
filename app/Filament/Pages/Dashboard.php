<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function getHeaderWidgets(): array
    {
        return [
            \Filament\Widgets\AccountWidget::class,
            \Filament\Widgets\FilamentInfoWidget::class,
        ];
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Filter Laporan')
                    ->columnSpan('full')
                    ->schema([
                        Select::make('periode')
                            ->options([
                                'hari_ini'   => 'Hari Ini',
                                'kemarin'    => 'Kemarin',
                                'minggu_ini' => 'Minggu Ini',
                                'bulan_ini'  => 'Bulan Ini',
                                'custom'     => 'Pertanggal (Custom)',
                            ])
                            ->default('hari_ini')
                            ->live()
                            ->columnSpan(1),
                        DatePicker::make('tanggal_mulai')
                            ->label('Dari Tanggal')
                            ->visible(fn (Get $get) => $get('periode') === 'custom')
                            ->required(fn (Get $get) => $get('periode') === 'custom')
                            ->columnSpan(1),
                        DatePicker::make('tanggal_selesai')
                            ->label('Sampai Tanggal')
                            ->visible(fn (Get $get) => $get('periode') === 'custom')
                            ->required(fn (Get $get) => $get('periode') === 'custom')
                            ->columnSpan(1),
                    ])
                    ->columns(3),
            ]);
    }
}
