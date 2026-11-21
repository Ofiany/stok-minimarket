<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = PurchaseOrder::with('supplier')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest('id')->paginate(10)->withQueryString();

        return view('purchase-orders.index', compact('orders'));
    }

    public function create()
    {
        return view('purchase-orders.create', [
            'suppliers' => Supplier::orderBy('nama')->get(['id', 'kode', 'nama', 'alamat', 'telepon']),
            'products' => Product::orderBy('nama')->get(['id', 'kode', 'nama', 'harga_beli']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'distinct', 'exists:products,id'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'items.required' => 'Tambahkan minimal satu barang.',
            'items.*.product_id.distinct' => 'Produk yang sama tidak boleh dipilih dua kali.',
        ]);

        $po = DB::transaction(function () use ($data) {
            $urut = PurchaseOrder::whereDate('created_at', today())->count() + 1;

            $po = PurchaseOrder::create([
                'kode' => 'PO-' . now()->format('Ymd') . '-' . str_pad($urut, 3, '0', STR_PAD_LEFT),
                'supplier_id' => $data['supplier_id'],
                'tanggal' => today(),
                'status' => PurchaseOrder::DIPESAN,
                'total' => 0,
            ]);

            $total = 0;
            foreach ($data['items'] as $row) {
                $produk = Product::findOrFail($row['product_id']);
                $subtotal = $produk->harga_beli * (int) $row['jumlah'];
                $po->items()->create([
                    'product_id' => $produk->id,
                    'jumlah' => $row['jumlah'],
                    'harga_beli' => $produk->harga_beli,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
            $po->update(['total' => $total]);

            return $po;
        });

        return redirect()->route('po.show', $po)->with('success', 'Purchase Order berhasil dibuat.');
    }

    public function show(PurchaseOrder $po)
    {
        $po->load('supplier', 'items.product');

        return view('purchase-orders.show', compact('po'));
    }

    public function receive(Request $request, PurchaseOrder $po)
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.jumlah_diterima' => ['required', 'integer', 'min:0'],
            'items.*.kondisi' => ['required', 'in:baik,rusak'],
        ]);

        DB::transaction(function () use ($request, $po) {
            $po = PurchaseOrder::whereKey($po->id)->lockForUpdate()->firstOrFail();

            if ($po->status !== PurchaseOrder::DIPESAN) {
                throw ValidationException::withMessages(['status' => 'PO ini sudah diproses.']);
            }

            foreach ($po->items as $item) {
                $in = $request->input("items.{$item->id}");
                if (! $in) {
                    throw ValidationException::withMessages(['items' => 'Data penerimaan tidak lengkap.']);
                }
                $diterima = (int) $in['jumlah_diterima'];
                if ($diterima > $item->jumlah) {
                    throw ValidationException::withMessages([
                        'items' => 'Jumlah diterima tidak boleh melebihi jumlah pesanan.',
                    ]);
                }

                $item->update(['jumlah_diterima' => $diterima, 'kondisi' => $in['kondisi']]);

                // Hanya barang kondisi baik yang menambah stok (NFR-03, NFR-11).
                if ($in['kondisi'] === 'baik' && $diterima > 0) {
                    Product::whereKey($item->product_id)->increment('stok', $diterima);
                }
            }

            $po->update(['status' => PurchaseOrder::DITERIMA, 'tanggal_terima' => now()]);
        });

        return redirect()->route('po.show', $po)->with('success', 'Barang diterima dan stok diperbarui.');
    }

    public function cancel(PurchaseOrder $po)
    {
        // PO tidak dihapus, hanya statusnya diubah (NFR-10).
        $updated = PurchaseOrder::whereKey($po->id)
            ->where('status', PurchaseOrder::DIPESAN)
            ->update(['status' => PurchaseOrder::DIBATALKAN]);

        return redirect()->route('po.show', $po)->with(
            $updated ? 'success' : 'error',
            $updated ? 'PO dibatalkan.' : 'Hanya PO berstatus dipesan yang dapat dibatalkan.'
        );
    }
}
