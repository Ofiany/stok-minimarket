@extends('layouts.app')
@section('title', 'Data Produk')
@section('content')
<a class="back" href="{{ route('products.index') }}">&larr; Kembali</a>
<h1 class="title">Data Produk</h1>
<div class="card narrow">
    <dl class="detail" style="margin:0">
        <dt>Kode Produk</dt><dd>{{ $product->kode }}</dd>
        <dt>Nama Produk</dt><dd>{{ $product->nama }}</dd>
        <dt>Kategori</dt><dd>{{ $product->kategori }}</dd>
        <dt>Harga Beli</dt><dd>{{ \App\Support\Fmt::rp($product->harga_beli) }}</dd>
        <dt>Harga Jual</dt><dd>{{ \App\Support\Fmt::rp($product->harga_jual) }}</dd>
        <dt>Jumlah Stok</dt><dd>{{ $product->stok }} @if($product->isMenipis())<span class="badge menipis">Menipis (min. {{ $product->stok_minimum }})</span>@endif</dd>
    </dl>
</div>
<div class="actions narrow">
    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Hapus produk {{ addslashes($product->nama) }}? Tindakan ini tidak dapat dibatalkan.')">
        @csrf @method('DELETE')
        <button class="btn wide light">Hapus Produk</button>
    </form>
    <a class="btn wide" href="{{ route('products.edit', $product) }}">Ubah Detail</a>
</div>
@endsection
