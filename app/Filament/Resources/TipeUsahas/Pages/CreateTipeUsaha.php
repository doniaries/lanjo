<?php

namespace App\Filament\Resources\TipeUsahas\Pages;

use App\Filament\Resources\TipeUsahas\TipeUsahaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTipeUsaha extends CreateRecord
{
    protected static string $resource = TipeUsahaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
