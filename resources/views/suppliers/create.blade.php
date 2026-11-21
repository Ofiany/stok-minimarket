@extends('layouts.app')
@section('title', 'Tambah Supplier')
@section('content')
<a class="back" href="{{ route('suppliers.index') }}">&larr; Kembali</a>
<h1 class="title">Tambah Supplier</h1>
<form method="POST" action="{{ route('suppliers.store') }}">
    @csrf
    @include('suppliers._form')
    <div class="actions">
        <button class="btn wide">TAMBAH</button>
        <a class="btn wide light" href="{{ route('suppliers.index') }}">BATAL</a>
    </div>
</form>
@endsection
