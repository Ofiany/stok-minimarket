@extends('layouts.app')
@section('title', 'Buat Laporan')
@section('content')
<a class="back" href="{{ route('reports.index') }}">&larr; Kembali</a>
<h1 class="title">Buat Laporan</h1>
<form method="POST" action="{{ route('reports.store') }}">
    @csrf
    <div class="card">
        <div class="grid2">
            <div>
                <label>Periode</label>
                <select name="periode" required>
                    <option value="">Pilih Periode</option>
                    @foreach (\App\Models\Report::PERIODE as $v => $l)<option value="{{ $v }}" @selected(old('periode') === $v)>{{ $l }}</option>@endforeach
                </select>
                @error('periode')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div>
                <label>Tipe</label>
                <select name="tipe" required>
                    <option value="">Pilih Tipe Laporan</option>
                    @foreach (\App\Models\Report::TIPE as $v => $l)<option value="{{ $v }}" @selected(old('tipe') === $v)>{{ $l }}</option>@endforeach
                </select>
                @error('tipe')<div class="err">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="actions">
        <button class="btn wide">BUAT</button>
        <a class="btn wide light" href="{{ route('reports.index') }}">BATAL</a>
    </div>
</form>
@endsection
