@extends('app.layouts.basic')

<link rel="stylesheet" href="{{asset('css/adicionar-pedido.css')}}">

@section('titulo', 'Criar Pedido')


@section('conteudo')
    <div class="conteudo-pagina">

        <div class="titulo-pedido">
            <h2>Gerenciamento de Pedidos</h2>
        </div>

        <div class="informacao-pagina-pedido">
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

            <form class="form-add-pedido" method="post" action="#">
                @csrf

                <div class="form-group">
                    <button type="button" id="openModal" class="button-open-modal">Selecionar Produtos</button>
                </div>

                <!-- Div para exibir os produtos selecionados -->
                <div id="produtosSelecionados" class="produtos-selecionados">
                    <!-- Os produtos selecionados serão adicionados aqui -->
                </div>

                <div class="form-group">
                    <select name="id_cliente" class="select_cliente" required>
                        <option value="">Selecione o Cliente</option>
                        {{--                        @foreach ($clientes as $cliente)--}}
                        {{--                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>--}}
                        {{--                        @endforeach--}}
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" name="observacoes" placeholder="Observações"
                           class="observacoes" required>
                </div>

                <div class="button-container">
                    <button type="submit" class="button-add">Criar Pedido</button>
                </div>
                <div class="button-container">
                    <a href="{{ route('app.pedido') }}" class="button-back">Voltar</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Modal para selecionar produtos -->
    <div id="myModal" class="modal-servico">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <select class="select-servico" id="produtos-list"></select>
            <input class="label-script" type="number" id="quantidade" placeholder="Quantidade" min="1">
            <button id="adicionarProduto" class="button-add-modal">Adicionar</button>
            <button class="button-cancelar" id="cancelar">Cancelar</button>
        </div>
    </div>
@endsection
