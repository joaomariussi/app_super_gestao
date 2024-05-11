<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Super Gestão - @yield('titulo')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
@include('app.layouts._partials.header')
@yield('conteudo')
</body>
</html>
