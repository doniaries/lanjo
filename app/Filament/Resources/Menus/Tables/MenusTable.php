<?php

namespace App\Filament\Resources\Menus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use App\Models\KategoriMenu;

class MenusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query
                ->with(['kategoriMenu'])
                ->select(['menus.id', 'menus.kategori_menu_id', 'menus.nama', 'menus.harga_jual', 'menus.gambar', 'menus.stok', 'menus.status_aktif', 'menus.created_at', 'menus.updated_at'])
            )
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Foto')
                    ->disk('public')
                    ->defaultImageUrl(fn ($record) => $record->gambar && str_starts_with($record->gambar, 'http') ? $record->gambar : null)
                    ->size(48)
                    ->circular(),
                TextColumn::make('nama')
                    ->label('Nama Menu')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('kategoriMenu.nama')
                    ->label('Kategori')
                    ->sortable()
                    ->badge(),
                TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state <= 5 ? 'danger' : ($state <= 20 ? 'warning' : 'success')),
                IconColumn::make('status_aktif')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori_menu_id')
                    ->label('Kategori')
                    ->options(KategoriMenu::query()->orderBy('urutan')->pluck('nama', 'id')),
                TernaryFilter::make('status_aktif')
                    ->label('Status Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nama');
    }
}
