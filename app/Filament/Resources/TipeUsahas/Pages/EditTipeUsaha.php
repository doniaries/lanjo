<?php

namespace App\Filament\Resources\TipeUsahas\Pages;

use App\Filament\Resources\TipeUsahas\TipeUsahaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTipeUsaha extends EditRecord
{
    protected static string $resource = TipeUsahaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
