@extends('app.layouts.basic')

<link rel="stylesheet" href="{{asset('css/adicionar-fornecedor.css')}}">

@section('titulo', 'Fornecedor')


@section('conteudo')
    <div class="conteudo-pagina">

        <div class="titulo-fornecedor">
            <h2>Gerenciamento de Fornecedores</h2>
        </div>

        <div class="informacao-pagina-fornecedor">
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form class="form-add-fornecedor" method="post" action="{{ route('app.fornecedor.adicionar') }}">
                @csrf
                <div class="form-group">
                    <input class="input-nome-fornecedor" type="text" id="nome" name="nome"
                           placeholder="Nome" required>
                </div>

                <div class="form-group">
                    <input type="text" name="site" placeholder="Site" class="input-site-fornecedor" required>
                </div>

                <div class="form-group">
                    <input type="text" name="uf" placeholder="UF" class="input-uf-fornecedor" required>
                </div>

                <div class="form-group">
                    <input type="text" name="email" placeholder="E-mail" class="input-email-fornecedor" required>
                </div>

                <button type="submit" class="button-add">Cadastrar</button>
                <button type="button" onclick="window.location.href='{{ route('app.fornecedor') }}'"
                        class="button-back">Voltar
                </button>
            </form>
        </div>
    </div>

    @include('app.layouts._partials.footer')
@endsection
