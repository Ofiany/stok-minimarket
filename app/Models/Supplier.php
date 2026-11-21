<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['kode', 'nama', 'alamat', 'telepon'];

    public function scopeCari(Builder $q, ?string $kata): Builder
    {
        return $q->when($kata, fn ($q) => $q->where(fn ($w) => $w
            ->where('nama', 'like', "%{$kata}%")
            ->orWhere('kode', 'like', "%{$kata}%")
            ->orWhere('alamat', 'like', "%{$kata}%")));
    }
}
