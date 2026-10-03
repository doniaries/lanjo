<?php

namespace App\Filament\Resources\Pesanans\Pages;

use App\Filament\Resources\Pesanans\PesananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPesanans extends ListRecords
{
    protected static string $resource = PesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('cetak_laporan')
                ->label('Cetak Laporan')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->modalHeading('Preview Laporan')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Tutup')
                ->form([
                    \Filament\Forms\Components\Select::make('periode')
                        ->label('Periode')
                        ->options([
                            'hari_ini' => 'Hari Ini',
                            'kemarin' => 'Kemarin',
                            'minggu_ini' => 'Minggu Ini',
                            'bulan_ini' => 'Bulan Ini',
                            'tahun_ini' => 'Tahun Ini',
                            'semua' => 'Semua',
                        ])
                        ->default('hari_ini')
                        ->live()
                        ->required(),
                    \Filament\Forms\Components\Placeholder::make('preview')
                        ->label('')
                        ->content(fn ($get) => view('components.iframe-modal', [
                            'url' => route('laporan.transaksi', ['periode' => $get('periode')])
                        ]))
                        ->hidden(fn ($get) => empty($get('periode'))),
                ])
                ->action(fn() => null),
            CreateAction::make(),
        ];
    }
}
