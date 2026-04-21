<?php

namespace App\Filament\Widgets;
 
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\PenjualanDetail;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
 
class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
 
    protected function getStats(): array
    {
        $totalHariIni = Penjualan::whereDate('penjualan_tanggal', today())
            ->with('details')
            ->get()
            ->sum(fn ($p) => $p->details->sum(fn ($d) => $d->harga * $d->jumlah));
 
        $totalBulanIni = Penjualan::whereMonth('penjualan_tanggal', now()->month)
            ->whereYear('penjualan_tanggal', now()->year)
            ->with('details')
            ->get()
            ->sum(fn ($p) => $p->details->sum(fn ($d) => $d->harga * $d->jumlah));
 
        $transaksiHariIni = Penjualan::whereDate('penjualan_tanggal', today())->count();
 
        $barangHabis = Barang::where('stok', '<=', 10)->count();
 
        return [
            Stat::make('Penjualan Hari Ini', 'Rp ' . number_format($totalHariIni, 0, ',', '.'))
                ->description($transaksiHariIni . ' transaksi')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),
 
            Stat::make('Penjualan Bulan Ini', 'Rp ' . number_format($totalBulanIni, 0, ',', '.'))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
 
            Stat::make('Barang Stok Menipis', $barangHabis . ' barang')
                ->description('Stok ≤ 10 unit')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($barangHabis > 0 ? 'danger' : 'success'),
 
            Stat::make('Total Barang', Barang::count() . ' item')
                ->description('Data master barang')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning'),
        ];
    }
}
