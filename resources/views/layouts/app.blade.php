<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Manajemen Stok') - Minimarket</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <h2>Manajemen Stok</h2>
        <a class="nav {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="nav {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a>
        <a class="nav {{ request()->routeIs('po.*', 'suppliers.*') ? 'active' : '' }}" href="{{ route('po.index') }}">Purchase Order</a>
        <a class="nav {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">Laporan</a>
        <div class="user">Masuk sebagai {{ auth()->user()->username }}</div>
        <form class="logout" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Keluar" aria-label="Keluar">&#x238B;</button>
        </form>
    </aside>
    <main class="main">
        @if (session('success'))<div class="flash success">{{ session('success') }}</div>@endif
        @if (session('error'))<div class="flash error">{{ session('error') }}</div>@endif
        @if ($errors->has('status') || $errors->has('items'))
            <div class="flash error">{{ $errors->first('status') ?: $errors->first('items') }}</div>
        @endif
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>
