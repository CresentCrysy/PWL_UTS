<?php

namespace App\Filament\Resources\Penjualans\Pages;

use App\Filament\Resources\Penjualans\PenjualanResource;
use App\Models\Barang;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = $data['user_id'] ?? Filament::auth()->user()->user_id;
        return $data;
    }

    protected function afterCreate(): void
    {
        // Kurangi stok barang setelah penjualan dibuat
        foreach ($this->record->details as $detail) {
            Barang::where('barang_id', $detail->barang_id)
                  ->decrement('stok', $detail->jumlah);
        }
    }
}
