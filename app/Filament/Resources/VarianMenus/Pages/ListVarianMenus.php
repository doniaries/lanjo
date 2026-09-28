<?php

namespace App\Filament\Resources\VarianMenus\Pages;

use App\Filament\Resources\VarianMenus\VarianMenuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVarianMenus extends ListRecords
{
    protected static string $resource = VarianMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
