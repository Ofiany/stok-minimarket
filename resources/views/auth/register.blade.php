@extends('layouts.guest')
@section('title', 'Registrasi')
@section('content')
<h1>Registrasi</h1>
<form method="POST" action="{{ url('/registrasi') }}">
    @csrf
    <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan Username" autofocus required>
        @error('username')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" required>
        @error('password')<div class="err">{{ $message }}</div>@enderror
    </div>
    <button class="btn" style="width:100%">Daftar</button>
</form>
<div class="alt">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></div>
@endsection
