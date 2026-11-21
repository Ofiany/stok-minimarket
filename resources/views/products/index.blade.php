@extends('layouts.app')
@section('title', 'Produk')
@section('content')
<h1 class="title">Produk</h1>
<div class="toolbar">
    <form method="GET" action="{{ route('products.index') }}">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau kode produk">
        <select name="kategori" onchange="this.form.submit()">
            <option value="Semua">Semua kategori</option>
            @foreach ($kategori as $k)<option value="{{ $k }}" @selected(request('kategori') === $k)>{{ $k }}</option>@endforeach
        </select>
        <button class="btn search" title="Cari">&#x1F50D;</button>
    </form>
    <a class="btn" href="{{ route('products.create') }}">+ Tambah Produk</a>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>Kode</th><th>Nama Produk</th><th>Kategori</th><th class="num">Harga Beli</th><th class="num">Harga Jual</th><th class="num">Stok</th></tr></thead>
    <tbody>
    @forelse ($products as $p)
        <tr class="click" onclick="location='{{ route('products.show', $p) }}'">
            <td>{{ $p->kode }}</td><td>{{ $p->nama }}</td><td>{{ $p->kategori }}</td>
            <td class="num">{{ \App\Support\Fmt::rp($p->harga_beli) }}</td>
            <td class="num">{{ \App\Support\Fmt::rp($p->harga_jual) }}</td>
            <td class="num">{{ $p->stok }} @if($p->isMenipis())<span class="badge menipis">Menipis</span>@endif</td>
        </tr>
    @empty
        <tr><td class="empty" colspan="6">Data produk tidak ada.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@include('partials.pager', ['paginator' => $products])
@endsection
