@extends('layouts.app')
@section('title', 'Supplier')
@section('content')
<a class="back" href="{{ route('po.index') }}">&larr; Kembali</a>
<h1 class="title">Supplier</h1>
<div class="toolbar">
    <form method="GET" action="{{ route('suppliers.index') }}">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari Supplier">
        <button class="btn search" title="Cari">&#x1F50D;</button>
    </form>
    <a class="btn" href="{{ route('suppliers.create') }}">+ Tambah Supplier</a>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>ID</th><th>Nama Supplier</th><th>Alamat</th><th>No. Telepon</th></tr></thead>
    <tbody>
    @forelse ($suppliers as $s)
        <tr class="click" onclick="location='{{ route('suppliers.show', $s) }}'">
            <td>{{ $s->kode }}</td><td>{{ $s->nama }}</td><td>{{ $s->alamat }}</td><td>{{ $s->telepon }}</td>
        </tr>
    @empty
        <tr><td class="empty" colspan="4">Data supplier tidak ada.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@include('partials.pager', ['paginator' => $suppliers])
@endsection
