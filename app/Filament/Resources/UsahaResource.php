<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsahaResource\Pages;
use App\Models\Usaha;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class UsahaResource extends Resource
{
    protected static ?string $model = Usaha::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';
    
    public static function getNavigationGroup(): ?string
    {
        return 'Sistem Admin';
    }

    // Membatasi HANYA SUPERADMIN yang bisa melihat menu ini
    public static function canAccess(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        
        return $user?->tipe === 'superadmin';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_usaha')
                    ->required()
                    ->maxLength(255),
                Select::make('paket')
                    ->options([
                        'free' => 'Free',
                        'premium' => 'Premium',
                    ])
                    ->default('free')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_usaha')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('paket')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'free' => 'gray',
                        'premium' => 'success',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn (string $state) => strtoupper($state)),
                ToggleColumn::make('is_active')
                    ->label('Aktif?'),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
