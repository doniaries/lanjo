<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['pesanan', 'kasir']))
            ->columns([
                TextColumn::make('pesanan.nomor_nota')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('metode')
                    ->badge(),
                TextColumn::make('jumlah_bayar')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kembalian')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('waktu_bayar')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('kasir.name')
                    ->numeric()
                    ->sortable(),
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
