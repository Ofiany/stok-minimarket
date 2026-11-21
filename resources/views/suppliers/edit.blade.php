@extends('layouts.app')
@section('title', 'Ubah Supplier')
@section('content')
<a class="back" href="{{ route('suppliers.show', $supplier) }}">&larr; Kembali</a>
<h1 class="title">Ubah Supplier</h1>
<form method="POST" action="{{ route('suppliers.update', $supplier) }}">
    @csrf @method('PUT')
    @include('suppliers._form')
    <div class="actions">
        <button class="btn wide">UBAH</button>
        <a class="btn wide light" href="{{ route('suppliers.show', $supplier) }}">BATAL</a>
    </div>
</form>
@endsection
