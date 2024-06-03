@extends('app.layouts.basic')

@section('title', 'Criar Pedido')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/adicionar-pedido.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endpush

@section('conteudo')
    <div class="conteudo-pagina">

        <div class="titulo-pedido">
            <h2 class="title-h2">Gerenciamento de Pedidos</h2>
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

            <form class="form-add-pedido" method="post" action="{{route('app.pedido.salvar')}}">
                @csrf

                <div class="form-group">
                    <button type="button" id="openModal" class="button-open-modal">Selecionar Produtos</button>
                </div>

                <!-- Div para exibir os produtos selecionados -->
                <div id="produtosSelecionados" class="produtos-selecionados" style="display: none;">
                    <table id="tabelaProdutos" class="tabela-produtos">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Quantidade</th>
                            <th>Preço Total</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Os produtos serão adicionados aqui -->
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <select name="cliente_id" class="select_cliente" required>
                        <option value="">Selecione o Cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" name="observacoes" placeholder="Observações" class="observacoes" required>
                </div>

                <div class="form-group">
                    <input type="text" step="any" name="valor_total" placeholder="R$ 0,00"
                           required class="valor_total" id="valor_total">
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
    <div id="myModal" class="modal-produtos">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div id="mensagemSemProdutos" style="display: none;">
                <p class="sem-produto">Não há produtos cadastrados.</p>
            </div>
            <select class="select-servico" id="produtos-list"></select>
            <input class="label-script" type="number" id="quantidade" placeholder="Quantidade" min="1">
            <button id="adicionarProduto" class="button-add-modal">Adicionar</button>
            <button class="button-cancelar" id="cancelar">Cancelar</button>
        </div>
    </div>

    <script>
        // Função para fechar o modal
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }
    </script>

@endsection
