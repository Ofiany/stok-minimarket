<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    public const DIPESAN = 'dipesan';
    public const DITERIMA = 'diterima';
    public const DIBATALKAN = 'dibatalkan';

    protected $fillable = ['kode', 'supplier_id', 'tanggal', 'status', 'total', 'tanggal_terima'];

    protected function casts(): array
    {
        return ['tanggal' => 'date', 'tanggal_terima' => 'datetime'];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
