<?php

namespace App\Filament\Resources\TipeUsahas\Pages;

use App\Filament\Resources\TipeUsahas\TipeUsahaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTipeUsahas extends ListRecords
{
    protected static string $resource = TipeUsahaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
