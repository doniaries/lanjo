<?php

namespace App\Filament\Resources\Pesanans\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetailPesanansRelationManager extends RelationManager
{
    protected static string $relationship = 'detailPesanans';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_menu_snapshot')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_menu_snapshot')
            ->columns([
                TextColumn::make('nama_menu_snapshot')
                    ->label('Nama Menu')
                    ->searchable(),
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),
                TextColumn::make('harga_satuan_snapshot')
                    ->label('Harga Satuan')
                    ->formatStateUsing(fn($state) => format_rupiah($state)),
                TextColumn::make('subtotal_snapshot')
                    ->label('Subtotal')
                    ->formatStateUsing(fn($state) => format_rupiah($state)),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
