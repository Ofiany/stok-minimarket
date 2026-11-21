@extends('layouts.app')
@section('title', 'Data PO')
@section('content')
<a class="back" href="{{ route('po.index') }}">&larr; Kembali</a>
<h1 class="title">Data PO</h1>
<div class="card" style="max-width:900px">
    <div class="grid2">
        <div><label>ID PO</label><input readonly value="{{ $po->kode }}"></div>
        <div><label>Status</label><div><span class="badge {{ $po->status }}">{{ ucfirst($po->status) }}</span></div></div>
        <div><label>Supplier</label><input readonly value="{{ $po->supplier->kode }} - {{ $po->supplier->nama }}"></div>
        <div><label>Tanggal PO</label><input readonly value="{{ $po->tanggal->format('d/m/Y') }}"></div>
        @if ($po->tanggal_terima)
            <div><label>Tanggal Diterima</label><input readonly value="{{ $po->tanggal_terima->format('d/m/Y H:i') }}"></div>
        @endif
    </div>
</div>

@php $bisaProses = $po->status === 'dipesan'; @endphp

<form method="POST" action="{{ route('po.receive', $po) }}" id="receive-form">
    @csrf
    <div class="table-wrap" style="max-width:900px;margin:0 auto 18px">
    <table>
        <thead><tr>
            <th>Kode Produk</th><th>Nama Produk</th><th class="num">Harga Beli</th><th class="num">Jumlah</th><th class="num">Subtotal</th>
            @if ($bisaProses) <th>Diterima</th><th>Kondisi</th> @elseif ($po->status === 'diterima') <th class="num">Diterima</th><th>Kondisi</th> @endif
        </tr></thead>
        <tbody>
        @foreach ($po->items as $it)
            <tr>
                <td>{{ $it->product->kode }}</td><td>{{ $it->product->nama }}</td>
                <td class="num">{{ \App\Support\Fmt::rp($it->harga_beli) }}</td>
                <td class="num">{{ $it->jumlah }}</td>
                <td class="num">{{ \App\Support\Fmt::rp($it->subtotal) }}</td>
                @if ($bisaProses)
                    <td><input type="number" min="0" max="{{ $it->jumlah }}" name="items[{{ $it->id }}][jumlah_diterima]" value="{{ old("items.{$it->id}.jumlah_diterima", $it->jumlah) }}" style="min-width:80px" required></td>
                    <td><select name="items[{{ $it->id }}][kondisi]" style="min-width:100px">
                        <option value="baik" @selected(old("items.{$it->id}.kondisi") === 'baik')>Baik</option>
                        <option value="rusak" @selected(old("items.{$it->id}.kondisi") === 'rusak')>Rusak</option>
                    </select></td>
                @elseif ($po->status === 'diterima')
                    <td class="num">{{ $it->jumlah_diterima }}</td><td>{{ ucfirst($it->kondisi) }}</td>
                @endif
            </tr>
        @endforeach
        <tr><td colspan="4" class="num"><b>Total</b></td><td class="num"><b>{{ \App\Support\Fmt::rp($po->total) }}</b></td>
            @if ($bisaProses || $po->status === 'diterima')<td colspan="2"></td>@endif</tr>
        </tbody>
    </table>
    </div>
    @if ($bisaProses)
        <p style="max-width:900px;margin:0 auto 18px;font-size:14px;color:#555">Hanya barang berkondisi <b>Baik</b> yang menambah stok. Barang rusak tetap dicatat pada PO.</p>
    @endif
</form>

@if ($bisaProses)
<div class="actions" style="max-width:900px">
    <form method="POST" action="{{ route('po.cancel', $po) }}" onsubmit="return confirm('Batalkan PO {{ $po->kode }}?')">
        @csrf
        <button class="btn wide light">Batalkan PO</button>
    </form>
    <button class="btn wide" form="receive-form" onclick="return confirm('Konfirmasi penerimaan barang? Stok akan bertambah.')">Terima</button>
</div>
@endif
@endsection
