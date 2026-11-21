<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'jumlahProduk' => Product::count(),
            'jumlahSupplier' => Supplier::count(),
            'poDipesan' => PurchaseOrder::where('status', PurchaseOrder::DIPESAN)->count(),
            'stokMenipis' => Product::whereColumn('stok', '<=', 'stok_minimum')->count(),
        ]);
    }
}
