<?php

namespace App\Filament\Widgets;
 
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
 
class PenjualanChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan 7 Hari Terakhir';
    protected static ?int $sort = 2;
 
    protected function getData(): array
    {
        $data = [];
        $labels = [];
 
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d/m');
 
            $total = Penjualan::whereDate('penjualan_tanggal', $date)
                ->with('details')
                ->get()
                ->sum(fn ($p) => $p->details->sum(fn ($d) => $d->harga * $d->jumlah));
 
            $data[] = $total;
        }
 
        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan (Rp)',
                    'data'  => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }
 
    protected function getType(): string
    {
        return 'line';
    }
}
