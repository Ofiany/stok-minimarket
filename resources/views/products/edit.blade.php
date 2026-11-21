@extends('layouts.app')
@section('title', 'Ubah Produk')
@section('content')
<a class="back" href="{{ route('products.show', $product) }}">&larr; Kembali</a>
<h1 class="title">Ubah Produk</h1>
<form method="POST" action="{{ route('products.update', $product) }}">
    @csrf @method('PUT')
    @include('products._form')
    <div class="actions">
        <button class="btn wide">UBAH</button>
        <a class="btn wide light" href="{{ route('products.show', $product) }}">BATAL</a>
    </div>
</form>
@endsection
