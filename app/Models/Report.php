<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public const PERIODE = [
        'semua' => 'Semua',
        'hari_ini' => 'Hari Ini',
        'minggu_ini' => 'Minggu Ini',
        'bulan_ini' => 'Bulan Ini',
        'tahun_ini' => 'Tahun Ini',
    ];

    public const TIPE = [
        'barang_masuk' => 'Barang Masuk',
        'stok' => 'Stok',
    ];

    protected $fillable = ['kode', 'periode', 'tipe', 'user_id', 'data'];

    protected function casts(): array
    {
        return ['data' => 'array'];
    }

    public function periodeLabel(): string
    {
        return self::PERIODE[$this->periode] ?? $this->periode;
    }

    public function tipeLabel(): string
    {
        return self::TIPE[$this->tipe] ?? $this->tipe;
    }

    /** @return array{0: \Illuminate\Support\Carbon|null, 1: \Illuminate\Support\Carbon|null} */
    public static function rentang(string $periode): array
    {
        return match ($periode) {
            'hari_ini' => [now()->startOfDay(), now()->endOfDay()],
            'minggu_ini' => [now()->startOfWeek(), now()->endOfWeek()],
            'bulan_ini' => [now()->startOfMonth(), now()->endOfMonth()],
            'tahun_ini' => [now()->startOfYear(), now()->endOfYear()],
            default => [null, null],
        };
    }
}
