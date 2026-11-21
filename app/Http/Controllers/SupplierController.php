<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::cari($request->q)->orderBy('nama')->paginate(10)->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        Supplier::create($request->validate($this->rules(), [], $this->labels()));

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($request->validate($this->rules($supplier), [], $this->labels()));

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Data supplier berhasil diubah.');
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
        } catch (QueryException) {
            return back()->with('error', 'Supplier tidak dapat dihapus karena sudah memiliki Purchase Order.');
        }

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }

    private function rules(?Supplier $supplier = null): array
    {
        return [
            'kode' => ['required', 'string', 'max:50', Rule::unique('suppliers', 'kode')->ignore($supplier)],
            'nama' => ['required', 'string', 'max:150'],
            'alamat' => ['required', 'string', 'max:500'],
            'telepon' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
        ];
    }

    private function labels(): array
    {
        return ['kode' => 'ID supplier', 'nama' => 'Nama supplier', 'alamat' => 'Alamat', 'telepon' => 'No. telepon'];
    }
}
