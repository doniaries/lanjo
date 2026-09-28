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
                ->form([
                    \Filament\Forms\Components\DatePicker::make('start_date')
                        ->label('Dari Tanggal')
                        ->required()
                        ->default(now()),
                    \Filament\Forms\Components\DatePicker::make('end_date')
                        ->label('Sampai Tanggal')
                        ->required()
                        ->default(now()),
                ])
                ->action(function (array $data, \Livewire\Component $livewire) {
                    $url = route('laporan.transaksi', [
                        'start' => $data['start_date'],
                        'end' => $data['end_date'],
                    ]);
                    $livewire->js("window.open('{$url}', '_blank');");
                }),
            CreateAction::make(),
        ];
    }
}
