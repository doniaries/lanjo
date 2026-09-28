<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query
                ->with(['pesanan', 'kasir'])
                ->latest('waktu_bayar')
            )
            ->columns([
                TextColumn::make('pesanan.nomor_nota')
                    ->label('No. Nota')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->fontFamily('mono'),

                TextColumn::make('metode')
                    ->label('Metode')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'tunai'    => 'success',
                        'transfer' => 'info',
                        'qris'     => 'warning',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'tunai'    => '💵 Tunai',
                        'transfer' => '🏦 Transfer',
                        'qris'     => '📱 QRIS',
                        default    => $state,
                    }),

                TextColumn::make('jumlah_bayar')
                    ->label('Jumlah Bayar')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('kembalian')
                    ->label('Kembalian')
                    ->money('IDR')
                    ->sortable()
                    ->color('success'),

                TextColumn::make('waktu_bayar')
                    ->label('Waktu Bayar')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('kasir.name')
                    ->label('Kasir')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('metode')
                    ->label('Metode Bayar')
                    ->options([
                        'tunai'    => 'Tunai',
                        'transfer' => 'Transfer',
                        'qris'     => 'QRIS',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
