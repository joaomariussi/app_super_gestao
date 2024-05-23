@extends('app.layouts.basic')

<title>Gerenciamento de Pedidos</title>

<link rel="stylesheet" href="{{ asset('css/index-pedido.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pedido">
            <h2>Gerenciamento de Pedidos</h2>
        </div>

        <div class="menu-pedido">
            <div class="button-wrapper">
                <a href="{{route('app.pedido.adicionar')}}" class="button-add">Novo Pedido</a>

                <div class="button-wrapper">
                    <a href="{{ route('site.principal') }}" class="button-back">Voltar</a>
                </div>
            </div>

            <table id="pedidos" class="display">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome do Cliente</th>
                    <th>Cód Produto</th>
                    <th>Nome do Produto</th>
                    <th>Quantidade</th>
                    <th>Valor R$</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($pedido_produtos as $pedido_produto)
                    <tr>
                        <td>{{ $pedido_produto->pedido_id }}</td>
                        <td>{{ $pedido_produto->cliente->nome }}</td>
                        <td>{{ $pedido_produto->produto_id }}</td>
                        <td>{{ $pedido_produto->nome }}</td>
                        <td>{{ $pedido_produto->quantidade }} un</td>
                        <td>R$ {{ number_format($pedido_produto->valor, 2, ',', '.') }}</td>
                        <td>
                            <form class="form-group" method="post">
                                @csrf
                                <button type="button" class="button-visualizar">Visualizar</button>
                                @method('DELETE')
                                <button type="button" class="button-delete"
                                        onclick="excluirPedido('{{ $pedido_produto->pedido_id }}')">Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function excluirPedido(id) {
            if (confirm('Deseja realmente excluir este pedido?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/pedido/excluir/' + id,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response.message);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }
    </script>

    <script src="{{ asset('js/table-pedidos.js') }}"></script>
@endsection
