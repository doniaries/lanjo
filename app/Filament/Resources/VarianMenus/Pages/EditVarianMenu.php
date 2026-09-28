<?php

namespace App\Filament\Resources\VarianMenus\Pages;

use App\Filament\Resources\VarianMenus\VarianMenuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVarianMenu extends EditRecord
{
    protected static string $resource = VarianMenuResource::class;

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
