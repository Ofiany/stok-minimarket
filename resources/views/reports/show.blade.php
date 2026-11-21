@extends('layouts.app')
@section('title', 'Detail Laporan')
@section('content')
<a class="back" href="{{ route('reports.index') }}">&larr; Kembali</a>
<h1 class="title">Laporan {{ $report->tipeLabel() }}</h1>
<div class="toolbar">
    <div>
        <b>{{ $report->kode }}</b><br>
        Periode: {{ $report->periodeLabel() }} &middot; Dibuat: {{ $report->created_at->format('d/m/Y H:i') }}
    </div>
    <a class="btn" href="{{ route('reports.pdf', $report) }}">Ekspor PDF</a>
</div>
<div class="table-wrap">@include('reports._table')</div>
@endsection
