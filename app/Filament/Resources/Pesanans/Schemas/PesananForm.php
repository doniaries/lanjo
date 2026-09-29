<?php

namespace App\Filament\Resources\Pesanans\Schemas;

use App\Models\Meja;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PesananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Nomor nota: auto-generate, readonly saat create
                TextInput::make('nomor_nota')
                    ->label('Nomor Nota')
                    ->default(fn () => 'REC-' . now()->format('Y-m-d') . '-' . str_pad(
                        \App\Models\Pesanan::whereDate('created_at', today())->count() + 1,
                        4, '0', STR_PAD_LEFT
                    ))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->readOnly(),

                DateTimePicker::make('tanggal')
                    ->label('Tanggal')
                    ->default(now())
                    ->required(),

                Select::make('meja_id')
                    ->label('Meja')
                    ->relationship('meja', 'nomor_meja')
                    ->options(fn () => Meja::orderBy('nomor_meja')->pluck('nomor_meja', 'id'))
                    ->searchable()
                    ->nullable()
                    ->placeholder('-- Pilih Meja (opsional) --'),

                \Filament\Forms\Components\Hidden::make('tipe_pesanan')
                    ->default('dine_in'),

                Select::make('kasir_id')
                    ->label('Kasir')
                    ->relationship('kasir', 'name')
                    ->searchable()
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'baru'    => 'Baru',
                        'selesai' => 'Selesai',
                        'batal'   => 'Batal',
                    ])
                    ->default('baru')
                    ->required(),

                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->formatStateUsing(fn ($state) => $state ? format_rupiah($state) : format_rupiah(0))
                    ->readOnly()
                    ->default(0),

                TextInput::make('diskon_nilai')
                    ->label('Diskon')
                    ->formatStateUsing(fn ($state) => $state ? format_rupiah($state) : format_rupiah(0))
                    ->readOnly()
                    ->default(0),

                TextInput::make('pajak_nilai')
                    ->label('Pajak')
                    ->formatStateUsing(fn ($state) => $state ? format_rupiah($state) : format_rupiah(0))
                    ->readOnly()
                    ->default(0),

                TextInput::make('total_akhir')
                    ->label('Total Akhir')
                    ->formatStateUsing(fn ($state) => $state ? format_rupiah($state) : format_rupiah(0))
                    ->readOnly()
                    ->default(0),

                Textarea::make('catatan')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }
}
