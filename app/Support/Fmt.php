<?php

namespace App\Support;

class Fmt
{
    public static function rp(int|float|null $n): string
    {
        return 'Rp ' . number_format((float) $n, 0, ',', '.');
    }
}
