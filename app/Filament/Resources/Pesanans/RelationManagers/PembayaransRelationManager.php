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

class PembayaransRelationManager extends RelationManager
{
    protected static string $relationship = 'pembayarans';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('metode')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('metode')
            ->columns([
                TextColumn::make('metode')
                    ->label('Metode Pembayaran')
                    ->searchable(),
                TextColumn::make('nominal')
                    ->label('Nominal Bayar')
                    ->formatStateUsing(fn ($state) => format_rupiah($state)),
                TextColumn::make('kembalian')
                    ->label('Kembalian')
                    ->formatStateUsing(fn ($state) => format_rupiah($state)),
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
