<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

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
