@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
<h1 class="title">Laporan</h1>
<div class="toolbar">
    <form method="GET" action="{{ route('reports.index') }}">
        <select name="periode" onchange="this.form.submit()">
            @foreach (\App\Models\Report::PERIODE as $v => $l)<option value="{{ $v }}" @selected($periode === $v)>{{ $l }}</option>@endforeach
        </select>
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari laporan">
        <button class="btn search" title="Cari">&#x1F50D;</button>
    </form>
    <a class="btn" href="{{ route('reports.create') }}">+ Buat Laporan</a>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>ID Laporan</th><th>Periode</th><th>Tipe Laporan</th><th>Tanggal Buat</th></tr></thead>
    <tbody>
    @forelse ($reports as $r)
        <tr class="click" onclick="location='{{ route('reports.show', $r) }}'">
            <td>{{ $r->kode }}</td><td>{{ $r->periodeLabel() }}</td><td>{{ $r->tipeLabel() }}</td><td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    @empty
        <tr><td class="empty" colspan="4">Data laporan tidak ada.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
@include('partials.pager', ['paginator' => $reports])
@endsection
