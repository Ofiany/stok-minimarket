<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Manajemen Stok Minimarket</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="auth">
    <div class="card">
        @if (session('success'))<div class="flash success">{{ session('success') }}</div>@endif
        @yield('content')
    </div>
</div>
</body>
</html>
