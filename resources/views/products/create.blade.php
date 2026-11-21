@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('content')
<a class="back" href="{{ route('products.index') }}">&larr; Kembali</a>
<h1 class="title">Tambah Produk</h1>
<form method="POST" action="{{ route('products.store') }}">
    @csrf
    @include('products._form')
    <div class="actions">
        <button class="btn wide">TAMBAH</button>
        <a class="btn wide light" href="{{ route('products.index') }}">BATAL</a>
    </div>
</form>
@endsection
