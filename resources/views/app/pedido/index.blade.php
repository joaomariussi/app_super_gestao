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
                <a href="{{ route('app.pedido.adicionar') }}" class="button-add">Novo Pedido</a>
                <a href="{{ route('site.principal') }}" class="button-back">Voltar</a>
            </div>

            <table id="pedidos" class="display">
                <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Nome do Cliente</th>
                    <th>Qtd Total</th>
                    <th>Valor Total R$</th>
                    <th>Data do Pedido</th>
                    <th>Última Atualização</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->cliente->nome }}</td>
                        <td>{{ $pedido->quantidade_total }} un</td>
                        <td>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($pedido->updated_at)) }}</td>
                        <td>
                            <form class="form-group" method="post" action="{{ route('app.pedido.excluir', $pedido->id) }}">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('app.pedido.visualizar', $pedido->id) }}" class="button-view">Visualizar</a>
                                <button type="button" class="button-delete" onclick="excluirPedido('{{ $pedido->id }}')">Excluir</button>
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
