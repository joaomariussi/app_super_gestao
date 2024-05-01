@extends('app.layouts.basic')

@section('titulo', $titulo)

<link rel="stylesheet" href="{{ asset('css/sobre-nos.css') }}">

@section('conteudo')

    <div class="conteudo-sobre-nos">
        <div class="titulo-pagina">
            <h1>Olá, eu sou o Super Gestão</h1>
        </div>

        <div class="informacao-pagina">
            <p>O Super Gestão é o sistema online de controle administrativo que pode transformar e potencializar os
                negócios
                da sua empresa.</p>
            <p>Desenvolvido com a mais alta tecnologia para você cuidar do que é mais importante, seus negócios!</p>
        </div>
    </div>

    @include('app.layouts._partials.footer')

@endsection
