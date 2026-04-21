<?php

namespace App\Filament\Widgets;
 
use App\Models\PenjualanDetail;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
 
class TopBarangWidget extends BaseWidget
{
    protected static ?string $heading = 'Barang Terlaris Bulan Ini';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';
 
    public function table(Table $table): Table
    {
        return $table
            ->query(
                PenjualanDetail::query()
                    ->selectRaw('barang_id, SUM(jumlah) as total_terjual, SUM(harga * jumlah) as total_pendapatan')
                    ->whereHas('penjualan', function (Builder $q) {
                        $q->whereMonth('penjualan_tanggal', now()->month)
                          ->whereYear('penjualan_tanggal', now()->year);
                    })
                    ->groupBy('barang_id')
                    ->orderByDesc('total_terjual')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('barang.barang_kode')->label('Kode'),
                Tables\Columns\TextColumn::make('barang.barang_nama')->label('Nama Barang'),
                Tables\Columns\TextColumn::make('barang.kategori.kategori_nama')->label('Kategori'),
                Tables\Columns\TextColumn::make('total_terjual')->label('Terjual')->badge()->color('success'),
                Tables\Columns\TextColumn::make('total_pendapatan')
                    ->label('Pendapatan')
                    ->getStateUsing(fn ($record) => 'Rp ' . number_format($record->total_pendapatan, 0, ',', '.')),
            ]);
    }
}
