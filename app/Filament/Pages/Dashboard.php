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
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->label('Dari Tanggal')
                            ->visible(fn(Get $get) => $get('periode') === 'custom')
                            ->required(fn(Get $get) => $get('periode') === 'custom')
                            ->columnSpan(1),
                        DatePicker::make('tanggal_selesai')
                            ->label('Sampai Tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->visible(fn(Get $get) => $get('periode') === 'custom')
                            ->required(fn(Get $get) => $get('periode') === 'custom')
                            ->columnSpan(1),
                        \Filament\Schemas\Components\Actions::make([
                            Action::make('cetak_laporan')
                                ->label('Cetak Laporan')
                                ->icon('heroicon-o-printer')
                                ->color('primary')
                                ->url(function () {
                                    $filters = $this->filters ?? [];
                                    $periode = $filters['periode'] ?? 'hari_ini';
                                    $start = $filters['tanggal_mulai'] ?? '';
                                    $end = $filters['tanggal_selesai'] ?? '';
                                    return route('laporan.cetak', [
                                        'periode' => $periode,
                                        'start' => $start,
                                        'end' => $end,
                                        'tenant_id' => \Filament\Facades\Filament::getTenant()?->id,
                                    ]);
                                })
                                ->extraAttributes([
                                    'onclick' => "event.preventDefault(); let w = 800; let h = 600; let left = (screen.width/2)-(w/2); let top = (screen.height/2)-(h/2); window.open(this.href, 'CetakLaporan', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);"
                                ])
                        ])->columnSpan(1)
                    ])
                    ->columns(4), // Ubah kolom dari 3 ke 4
            ]);
    }
}
