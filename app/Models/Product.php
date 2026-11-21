<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const KATEGORI = ['Makanan', 'Minuman', 'Snack', 'Kebutuhan Rumah Tangga', 'Perawatan Diri', 'Lainnya'];

    protected $fillable = ['kode', 'nama', 'kategori', 'harga_beli', 'harga_jual', 'stok', 'stok_minimum'];

    public function scopeCari(Builder $q, ?string $kata, ?string $kategori): Builder
    {
        return $q
            ->when($kata, fn ($q) => $q->where(fn ($w) => $w
                ->where('nama', 'like', "%{$kata}%")
                ->orWhere('kode', 'like', "%{$kata}%")))
            ->when($kategori && $kategori !== 'Semua', fn ($q) => $q->where('kategori', $kategori));
    }

    public function isMenipis(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }
}
