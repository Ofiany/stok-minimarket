@extends('layouts.app')
@section('title', 'Data Supplier')
@section('content')
<a class="back" href="{{ route('suppliers.index') }}">&larr; Kembali</a>
<h1 class="title">Data Supplier</h1>
<div class="card narrow">
    <dl class="detail" style="margin:0">
        <dt>ID Supplier</dt><dd>{{ $supplier->kode }}</dd>
        <dt>Nama Supplier</dt><dd>{{ $supplier->nama }}</dd>
        <dt>Alamat</dt><dd>{{ $supplier->alamat }}</dd>
        <dt>No. Telepon</dt><dd>{{ $supplier->telepon }}</dd>
    </dl>
</div>
<div class="actions narrow">
    <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" onsubmit="return confirm('Hapus supplier {{ addslashes($supplier->nama) }}? Tindakan ini tidak dapat dibatalkan.')">
        @csrf @method('DELETE')
        <button class="btn wide light">Hapus Data</button>
    </form>
    <a class="btn wide" href="{{ route('suppliers.edit', $supplier) }}">Ubah Data</a>
</div>
@endsection
