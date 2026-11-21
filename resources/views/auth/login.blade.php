@extends('layouts.guest')
@section('title', 'Masuk')
@section('content')
<h1>Masuk</h1>
<form method="POST" action="{{ url('/masuk') }}">
    @csrf
    <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan Username" autofocus required>
        @error('username')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Masukkan Password" required>
        @error('password')<div class="err">{{ $message }}</div>@enderror
    </div>
    <button class="btn" style="width:100%">Masuk</button>
</form>
<div class="alt">Belum punya akun? <a href="{{ route('register') }}">Registrasi</a></div>
@endsection
