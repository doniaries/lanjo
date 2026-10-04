<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsahaResource\Pages;
use App\Filament\Resources\UsahaResource\RelationManagers;
use App\Models\Usaha;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsahaResource extends Resource
{
    protected static ?string $model = Usaha::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Sistem Admin';

    // Membatasi HANYA SUPERADMIN yang bisa melihat menu ini
    public static function canAccess(): bool
    {
        return auth()->user()->tipe === 'superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_usaha')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('paket')
                    ->options([
                        'free' => 'Free',
                        'premium' => 'Premium',
                    ])
                    ->default('free')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_usaha')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paket')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'free' => 'gray',
                        'premium' => 'success',
                    })
                    ->formatStateUsing(fn (string $state) => strtoupper($state)),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif?'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tombol aksi cepat untuk upgrade ke Premium
                Action::make('upgrade')
                    ->label('Jadikan Premium')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->hidden(fn (Usaha $record) => $record->isPremium())
                    ->action(fn (Usaha $record) => $record->update(['paket' => 'premium'])),

                // Tombol aksi cepat untuk turun ke Free
                Action::make('downgrade')
                    ->label('Turunkan ke Free')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->hidden(fn (Usaha $record) => $record->isFree())
                    ->action(fn (Usaha $record) => $record->update(['paket' => 'free'])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsahas::route('/'),
            'create' => Pages\CreateUsaha::route('/create'),
            'edit' => Pages\EditUsaha::route('/{record}/edit'),
        ];
    }
}
