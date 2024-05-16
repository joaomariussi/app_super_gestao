@extends('app.layouts.basic')

<link rel="stylesheet" href="{{asset('css/adicionar-produto.css')}}">

@section('titulo', 'Fornecedor')


@section('conteudo')
    <div class="conteudo-pagina">

        <div class="titulo-fornecedor">
            <h2>Gerenciamento de Produtos</h2>
        </div>

        <div class="informacao-pagina-produtos">
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

            <form class="form-add-produto" method="post" action="{{ route('app.produto.salvar') }}">
                @csrf
                <div class="form-group">
                    <input class="input-nome-produto" type="text" id="nome" name="nome"
                           placeholder="Nome do Produto" required>
                </div>

                <div class="form-group">
                    <select name="id_fornecedor" class="select_fornecedor" required>
                        <option value="">Selecione o Fornecedor</option>
                        @foreach ($fornecedores as $fornecedor)
                            <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" name="descricao" placeholder="Descrição" class="input-descricao-produto"
                           required>
                </div>

                <div class="form-group">
                    <input type="number" step="any" name="preco_venda" placeholder="Preço de Venda"
                           class="input-preco-venda-produto" required>
                </div>

                <div class="form-group">
                    <input type="number" step="any" name="quantidade" placeholder="Quantidade"
                           class="input-quantidade-produto" required>
                </div>

                <div class="form-group">
                    <input type="number" step="any" name="peso" placeholder="Peso" class="input-peso-produto" required>
                </div>

                <div class="form-group">
                    <input type="number" step="any" name="largura" placeholder="Largura"
                           class="input-largura" required>
                </div>

                <div class="form-group">
                    <input type="number" step="any" name="comprimento" placeholder="Comprimento"
                           class="input-comprimento" required>
                </div>

                <div class="form-group">
                    <input type="number" step="any" name="altura" placeholder="Altura"
                           class="input-altura" required>
                </div>

                <div class="form-group">
                    <select name="unidade_id" class="select_unidade" required>
                        <option value="">Selecione a Unidade</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="button-add">Cadastrar</button>
                <button type="button" onclick="window.location.href='{{ route('app.produto') }}'"
                        class="button-back">Voltar
                </button>
            </form>
        </div>
    </div>
@endsection
