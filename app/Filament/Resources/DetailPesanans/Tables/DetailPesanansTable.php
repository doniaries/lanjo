<?php

namespace App\Filament\Resources\DetailPesanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetailPesanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['pesanan', 'varianMenu']))
            ->columns([
                TextColumn::make('pesanan.nomor_nota')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('menu_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('varianMenu.nama_varian')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nama_menu_snapshot')
                    ->searchable(),
                TextColumn::make('harga_satuan_snapshot')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('catatan_item')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
