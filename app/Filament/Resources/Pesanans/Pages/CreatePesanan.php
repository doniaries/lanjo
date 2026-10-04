<?php

namespace App\Filament\Resources\Pesanans\Pages;

use App\Filament\Resources\Pesanans\PesananResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePesanan extends CreateRecord
{
    protected static string $resource = PesananResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $usaha = $user?->usaha;

        if ($usaha && $usaha->isFree()) {
            $jumlahPesananBulanIni = \App\Models\Pesanan::where('usaha_id', $usaha->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            if ($jumlahPesananBulanIni >= 100) {
                \Filament\Notifications\Notification::make()
                    ->warning()
                    ->title('Batas Kuota Tercapai')
                    ->body('Paket Free hanya bisa membuat maksimal 100 transaksi bulan ini. Silakan upgrade ke versi Premium.')
                    ->send();
                
                $this->halt();
            }
        }

        return $data;
    }
}
