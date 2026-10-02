<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cetak_laporan')
                ->label('Cetak Laporan')
                ->icon('heroicon-o-printer')
                ->color('primary')
                ->modalHeading('Preview Laporan Transaksi')
                ->modalWidth('4xl')
                ->modalContent(function () {
                    $filters = $this->filters ?? [];
                    $periode = $filters['periode'] ?? 'hari_ini';
                    $start = $filters['tanggal_mulai'] ?? '';
                    $end = $filters['tanggal_selesai'] ?? '';
                    $url = route('laporan.cetak', [
                        'periode' => $periode,
                        'start' => $start,
                        'end' => $end,
                        'preview' => 1
                    ]);
                    return view('reports.preview-transaksi', ['url' => $url]);
                })
                ->modalSubmitActionLabel('Cetak Sekarang')
                ->action(function () {
                    $filters = $this->filters ?? [];
                    $periode = $filters['periode'] ?? 'hari_ini';
                    $start = $filters['tanggal_mulai'] ?? '';
                    $end = $filters['tanggal_selesai'] ?? '';
                    $url = route('laporan.cetak', [
                        'periode' => $periode,
                        'start' => $start,
                        'end' => $end,
                    ]);
                    
                    $this->js("window.open('{$url}', '_blank');");
                })
        ];
    }

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
