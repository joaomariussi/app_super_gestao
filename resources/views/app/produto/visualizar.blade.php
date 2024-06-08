@extends('app.layouts.basic')

@section('title', 'Visualizar Produto')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/visualizar-produto.css') }}">
@endpush

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-produto">
            <h2 class="title-h2">Detalhes do Produto</h2>
        </div>

        <a href="{{ route('app.produto') }}" class="botao-voltar">Voltar</a>

        <div class="informacoes">
            <div class="info-produto">
                <div class="coluna-esquerda">
                    <h3>Informações Gerais</h3>
                    <p><strong>ID do Produto:</strong> {{ $produto->id }}</p>
                    <p><strong>Nome:</strong> {{ $produto->nome }}</p>
                    <p><strong>Descrição:</strong> {{ $produto->descricao }}</p>
                    <p><strong>Código:</strong> {{ $produto->codigo }}</p>
                    <p><strong>Unidade de Medida:</strong> {{ $produto->unidade->unidade }}</p>
                    <p><strong>Fornecedor:</strong> {{ $produto->fornecedor->nome }}</p>
                </div>
                <div class="coluna-direita">
                    <h3>Detalhes do Produto</h3>
                    <p><strong>Preço de Venda:</strong> R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</p>
                    <p><strong>Estoque:</strong> {{ $produto->quantidade }}</p>
                    <p><strong>Peso:</strong> {{ $produto->peso }} kg</p>
                    <p><strong>Largura:</strong> {{ $produto->largura }} cm</p>
                    <p><strong>Comprimento:</strong> {{ $produto->comprimento }} cm</p>
                    <p><strong>Altura:</strong> {{ $produto->altura }} cm</p>
                    <p><strong>Cadastrado em:</strong> {{ $produto->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Última Atualização:</strong> {{ $produto->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
