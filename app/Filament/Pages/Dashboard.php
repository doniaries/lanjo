<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filter Laporan')
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
