<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kategori_id')
                    ->required()
                    ->numeric(),
                TextInput::make('barang_kode')
                    ->required(),
                TextInput::make('barang_nama')
                    ->required(),
                TextInput::make('harga_beli')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('harga_jual')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('stok')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
