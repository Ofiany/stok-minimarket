@extends('layouts.app')
@section('title', 'Purchase Order')
@section('content')
<h1 class="title">Purchase Order</h1>
<div class="toolbar">
    <a class="btn" href="{{ route('po.create') }}">+ Buat PO</a>
    <form method="GET" action="{{ route('po.index') }}">
        <select name="status" onchange="this.form.submit()">
            <option value="">Semua status</option>
            @foreach (['dipesan' => 'Dipesan', 'diterima' => 'Diterima', 'dibatalkan' => 'Dibatalkan'] as $v => $l)
                <option value="{{ $v }}" @selected(request('status') === $v)>{{ $l }}</option>
            @endforeach
        </select>
        <a class="btn" href="{{ route('suppliers.index') }}">Supplier</a>
    </form>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>ID PO</th><th>ID Supplier</th><th>Tanggal</th><th>Status</th></tr></thead>
    <tbody>
    @forelse ($orders as $o)
        <tr class="click" onclick="location='{{ route('po.show', $o) }}'">
            <td>{{ $o->kode }}</td><td>{{ $o->supplier->kode }}</td>
            <td>{{ $o->tanggal->format('d/m/Y') }}</td>
            <td><span class="badge {{ $o->status }}">{{ ucfirst($o->status) }}</span></td>
        </tr>
    @empty
        <tr><td class="empty" colspan="4">Belum ada Purchase Order.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@include('partials.pager', ['paginator' => $orders])
@endsection
