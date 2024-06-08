@push('styles')
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
@endpush
<div class="topo">
    <div class="logo">
        <a href="{{ route('site.principal')  }}"><img src={{ asset('img/flavicon.png') }} alt="Logo"></a>
    </div>
    <div class="menu">
        <nav>
            <a class="home" href="{{ route('site.principal') }}">Home</a>
            <a class="contato" href="{{ route('site.contato') }}">Contato</a>
            <a class="clientes" href="{{ route('app.cliente') }}">Clientes</a>
            <a class="fornecedores" href="{{ route('app.fornecedor') }}">Fornecedores</a>
            <a class="produtos" href="{{ route('app.produto') }}">Produtos</a>
            <a class="pedidos" href="{{ route('app.pedido') }}">Pedidos</a>
            <a class="sobre-nos" href="{{ route('site.sobrenos') }}">Sobre Nós</a>
            <a class="sair" href="{{ route('logout') }}">Sair</a>
        </nav>
    </div>
</div>

@include('flash::message')
