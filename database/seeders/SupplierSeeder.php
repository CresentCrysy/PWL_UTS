<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

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
