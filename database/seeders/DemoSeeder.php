<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['kode' => 'SUP-001', 'nama' => 'PT Sumber Pangan', 'alamat' => 'Jl. Raya Rangkasbitung No. 10, Lebak', 'telepon' => '0252-111222'],
            ['kode' => 'SUP-002', 'nama' => 'CV Minuman Segar', 'alamat' => 'Jl. Sudirman No. 25, Serang', 'telepon' => '0254-333444'],
        ];
        foreach ($suppliers as $s) {
            Supplier::updateOrCreate(['kode' => $s['kode']], $s);
        }

        $products = [
            ['kode' => 'PRD-001', 'nama' => 'Beras 5 kg', 'kategori' => 'Makanan', 'harga_beli' => 62000, 'harga_jual' => 68000, 'stok' => 20, 'stok_minimum' => 5],
            ['kode' => 'PRD-002', 'nama' => 'Minyak Goreng 1 L', 'kategori' => 'Makanan', 'harga_beli' => 16000, 'harga_jual' => 18500, 'stok' => 30, 'stok_minimum' => 10],
            ['kode' => 'PRD-003', 'nama' => 'Air Mineral 600 ml', 'kategori' => 'Minuman', 'harga_beli' => 2500, 'harga_jual' => 3500, 'stok' => 100, 'stok_minimum' => 24],
            ['kode' => 'PRD-004', 'nama' => 'Teh Botol 450 ml', 'kategori' => 'Minuman', 'harga_beli' => 4000, 'harga_jual' => 5500, 'stok' => 6, 'stok_minimum' => 12],
            ['kode' => 'PRD-005', 'nama' => 'Sabun Mandi', 'kategori' => 'Perawatan Diri', 'harga_beli' => 3000, 'harga_jual' => 4500, 'stok' => 40, 'stok_minimum' => 10],
        ];
        foreach ($products as $p) {
            Product::updateOrCreate(['kode' => $p['kode']], $p);
        }
    }
}
