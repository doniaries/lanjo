<?php

namespace App\Filament\Resources\TipeUsahas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TipeUsahaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Tipe Usaha')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
