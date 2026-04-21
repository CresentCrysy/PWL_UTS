<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Level;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Kategori;
use App\Models\Barang;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['level_kode' => 'ADM', 'level_nama' => 'Administrator'],
            ['level_kode' => 'MNG', 'level_nama' => 'Manager'],
            ['level_kode' => 'KSR', 'level_nama' => 'Kasir'],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'level_id'  => 1,
                'username'  => 'admin',
                'nama'      => 'Administrator',
                'email'     => 'admin@pos.com',
                'password'  => Hash::make('password'),
            ],
            [
                'level_id'  => 2,
                'username'  => 'manager',
                'nama'      => 'Manager Toko',
                'email'     => 'manager@pos.com',
                'password'  => Hash::make('password'),
            ],
            [
                'level_id'  => 3,
                'username'  => 'kasir01',
                'nama'      => 'Kasir Satu',
                'email'     => 'kasir@pos.com',
                'password'  => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['supplier_kode' => 'SUP001', 'supplier_nama' => 'PT Maju Jaya', 'supplier_alamat' => 'Jl. Raya No. 1, Jakarta'],
            ['supplier_kode' => 'SUP002', 'supplier_nama' => 'CV Berkah Abadi', 'supplier_alamat' => 'Jl. Pahlawan No. 5, Surabaya'],
            ['supplier_kode' => 'SUP003', 'supplier_nama' => 'UD Sejahtera', 'supplier_alamat' => 'Jl. Mawar No. 10, Malang'],
        ];

        foreach ($suppliers as $s) {
            Supplier::create($s);
        }
    }
}

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['kategori_kode' => 'MKN', 'kategori_nama' => 'Makanan'],
            ['kategori_kode' => 'MNM', 'kategori_nama' => 'Minuman'],
            ['kategori_kode' => 'SBK', 'kategori_nama' => 'Sembako'],
            ['kategori_kode' => 'KBR', 'kategori_nama' => 'Kebersihan'],
        ];

        foreach ($kategoris as $k) {
            Kategori::create($k);
        }
    }
}

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