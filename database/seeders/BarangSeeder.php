<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barangs = [
            ['kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Indomie Goreng', 'harga_beli' => 2500, 'harga_jual' => 3500, 'stok' => 100],
            ['kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Roti Tawar', 'harga_beli' => 10000, 'harga_jual' => 14000, 'stok' => 50],
            ['kategori_id' => 2, 'barang_kode' => 'BRG003', 'barang_nama' => 'Aqua 600ml', 'harga_beli' => 2000, 'harga_jual' => 3000, 'stok' => 200],
            ['kategori_id' => 2, 'barang_kode' => 'BRG004', 'barang_nama' => 'Teh Botol Sosro', 'harga_beli' => 3500, 'harga_jual' => 5000, 'stok' => 150],
            ['kategori_id' => 3, 'barang_kode' => 'BRG005', 'barang_nama' => 'Beras 5kg', 'harga_beli' => 55000, 'harga_jual' => 70000, 'stok' => 30],
            ['kategori_id' => 3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Minyak Goreng 1L', 'harga_beli' => 14000, 'harga_jual' => 18000, 'stok' => 80],
            ['kategori_id' => 4, 'barang_kode' => 'BRG007', 'barang_nama' => 'Sabun Mandi Lifebuoy', 'harga_beli' => 3500, 'harga_jual' => 5000, 'stok' => 60],
            ['kategori_id' => 4, 'barang_kode' => 'BRG008', 'barang_nama' => 'Pasta Gigi Pepsodent', 'harga_beli' => 8000, 'harga_jual' => 12000, 'stok' => 45],
        ];

        foreach ($barangs as $b) {
            Barang::create($b);
        }
    }
}
