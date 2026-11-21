@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h1 class="title">Dashboard</h1>
<div class="stats">
    <div class="stat"><b>{{ $jumlahProduk }}</b>Jenis produk</div>
    <div class="stat"><b>{{ $jumlahSupplier }}</b>Supplier</div>
    <div class="stat"><b>{{ $poDipesan }}</b>PO menunggu barang</div>
    <div class="stat"><b>{{ $stokMenipis }}</b>Produk stok menipis</div>
</div>
<div class="welcome">
    <h2>SELAMAT DATANG</h2>
    <p>Pilih menu pada sidebar untuk memulai!</p>
</div>
@endsection
