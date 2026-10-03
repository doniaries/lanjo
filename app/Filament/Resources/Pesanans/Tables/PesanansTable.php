<?php

namespace App\Filament\Resources\Pesanans\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
            ->recordUrl(fn(\Illuminate\Database\Eloquent\Model $record): string => \App\Filament\Resources\Pesanans\Pages\ViewPesanan::getUrl(['record' => $record->id]))
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
                Filter::make('periode')
                    ->form([
                        \Filament\Forms\Components\Select::make('periode')
                            ->label('Periode')
                            ->options([
                                'hari_ini' => 'Hari Ini',
                                'kemarin' => 'Kemarin',
                                'minggu_ini' => 'Minggu Ini',
                                'bulan_ini' => 'Bulan Ini',
                                'tahun_ini' => 'Tahun Ini',
                                'semua' => 'Semua',
                            ])
                            ->default('hari_ini'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $now = now();
                        return match ($data['periode'] ?? 'hari_ini') {
                            'hari_ini' => $query->whereDate('tanggal', $now->format('Y-m-d')),
                            'kemarin' => $query->whereDate('tanggal', $now->copy()->subDay()->format('Y-m-d')),
                            'minggu_ini' => $query->whereBetween('tanggal', [
                                $now->copy()->startOfWeek()->format('Y-m-d 00:00:00'),
                                $now->copy()->endOfWeek()->format('Y-m-d 23:59:59'),
                            ]),
                            'bulan_ini' => $query->whereMonth('tanggal', $now->month)
                                                 ->whereYear('tanggal', $now->year),
                            'tahun_ini' => $query->whereYear('tanggal', $now->year),
                            default => $query,
                        };
                    })
            ])
            ->recordActions([
                Action::make('cetak_struk')
                    ->label('Cetak Struk')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->modalHeading('Preview Struk')
                    ->modalContent(fn (\App\Models\Pesanan $record) => view('components.iframe-modal', ['url' => route('pesanan.cetak-struk', $record->id)]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
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
