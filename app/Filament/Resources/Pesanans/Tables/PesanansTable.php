<?php

namespace App\Filament\Resources\Pesanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PesanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn($query) => $query
                    ->with(['meja', 'kasir'])
                    ->latest('tanggal')
            )
            ->recordUrl(fn (\Illuminate\Database\Eloquent\Model $record): string => \App\Filament\Resources\Pesanans\Pages\ViewPesanan::getUrl(['record' => $record->id]))
            ->columns([
                TextColumn::make('nomor_nota')
                    ->label('No. Nota')
                    ->searchable()
                    ->copyable()
                    ->sortable()
                    ->weight('bold')
                    ->fontFamily('mono')
                    ->copyable(),

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('meja.nomor_meja')
                    ->label('Meja')
                    ->badge()
                    ->color('info')
                    ->placeholder('-'),

                TextColumn::make('kasir.name')
                    ->label('Kasir')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'selesai' => 'success',
                        'batal'   => 'danger',
                        default   => 'warning',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'selesai' => 'Selesai',
                        'batal'   => 'Batal',
                        default   => 'Baru',
                    }),

                TextColumn::make('total_akhir')
                    ->label('Total')
                    ->formatStateUsing(fn($state) => format_rupiah($state))
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'baru'    => 'Baru',
                        'selesai' => 'Selesai',
                        'batal'   => 'Batal',
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
