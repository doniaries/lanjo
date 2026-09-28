<?php

namespace App\Filament\Resources\VarianMenus\Pages;

use App\Filament\Resources\VarianMenus\VarianMenuResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVarianMenu extends CreateRecord
{
    protected static string $resource = VarianMenuResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
