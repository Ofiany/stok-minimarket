<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::cari($request->q, $request->kategori)
            ->orderBy('nama')->paginate(10)->withQueryString();

        return view('products.index', ['products' => $products, 'kategori' => Product::KATEGORI]);
    }

    public function create()
    {
        return view('products.create', ['kategori' => Product::KATEGORI]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), [], $this->labels());
        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product, 'kategori' => Product::KATEGORI]);
    }

    public function update(Request $request, Product $product)
    {
        // Stok tidak diubah di sini: stok hanya berubah lewat penerimaan barang PO (NFR-03).
        $data = $request->validate($this->rules($product), [], $this->labels());
        unset($data['stok']);
        $product->update($data);

        return redirect()->route('products.show', $product)->with('success', 'Data produk berhasil diubah.');
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (QueryException) {
            return back()->with('error', 'Produk tidak dapat dihapus karena sudah tercatat di Purchase Order.');
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function rules(?Product $product = null): array
    {
        return [
            'kode' => ['required', 'string', 'max:50', Rule::unique('products', 'kode')->ignore($product)],
            'nama' => ['required', 'string', 'max:150'],
            'kategori' => ['required', Rule::in(Product::KATEGORI)],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'harga_jual' => ['required', 'integer', 'min:0', 'gte:harga_beli'],
            'stok' => [$product ? 'nullable' : 'required', 'integer', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],
        ];
    }

    private function labels(): array
    {
        return [
            'kode' => 'Kode produk', 'nama' => 'Nama produk', 'kategori' => 'Kategori',
            'harga_beli' => 'Harga beli', 'harga_jual' => 'Harga jual',
            'stok' => 'Jumlah stok', 'stok_minimum' => 'Stok minimum',
        ];
    }
}
