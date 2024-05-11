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

            <table id="pedidos" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Cliente</th>
                    <th>Código do Produto</th>
                    <th>Nome do Produto</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->id_cliente }}</td>
                        <td>{{ $pedido->id_produto }}</td>
                        <td>{{ $pedido->nome_produto }}</td>
                        <td>{{ $pedido->quantidade }}</td>
                        <td>{{ $pedido->valor_produto }}</td>
                        <td>{{ $pedido->valor_total }}</td>
                        <td>
                            <form class="form-group" id="form-editar-cliente-{{ $pedido->id }}"
                                  action="{{ route('app.cliente.editar', ['id' => $pedido->id]) }}"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="cliente_id" value="{{ $pedido->id }}">
                                <button type="button" class="button-delete"
                                        onclick="excluirCliente('{{ $pedido->id }}')">Excluir
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

{{--    <script>--}}

{{--        function reloadDataTable() {--}}
{{--            if ($.fn.DataTable.isDataTable('#clientes')) {--}}
{{--                let table = $('#clientes').DataTable();--}}
{{--                table.clear().draw(); // Limpa a tabela sem destruí-la--}}
{{--                if (table.data().count() > 0) {--}}
{{--                    table.destroy(); // Destroi apenas se houver dados--}}
{{--                }--}}
{{--            }--}}
{{--            // Recarrega a página após 1 segundo--}}
{{--            setTimeout(function () {--}}
{{--                location.reload();--}}
{{--            }, 1000);--}}
{{--        }--}}

{{--        function excluirCliente(id) {--}}
{{--            if (confirm('Deseja realmente excluir este cliente?')) {--}}
{{--                $.ajax({--}}
{{--                    type: 'POST',--}}
{{--                    url: '/cliente/excluir/' + id,--}}
{{--                    data: {--}}
{{--                        id: id,--}}
{{--                        _token: '{{ csrf_token() }}'--}}
{{--                    },--}}
{{--                    dataType: 'json', // Define o tipo de retorno--}}
{{--                    success: function (response) {--}}
{{--                        console.log(response.message);--}}
{{--                        // Destroi a instância atual do DataTables--}}
{{--                        reloadDataTable();--}}
{{--                    },--}}
{{--                    error: function (xhr, status, error) {--}}
{{--                        console.error(error);--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}

    <script src="{{ asset('js/table-pedidos.js') }}"></script>
@endsection
