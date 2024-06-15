@extends('app.layouts.basic')

@section('title', 'Pedidos')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/index-pedido.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
@endpush

@push('head-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
@endpush

@push('scripts')
    <script src="{{ asset('js/table-pedidos.js') }}"></script>
@endpush

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h2 class="title-h2">Gerenciamento de Pedidos</h2>
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
                    <th>Quantidade Total</th>
                    <th>Valor Total R$</th>
                    <th>Data do Pedido</th>
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
                        window.location.href = '{{ route("app.pedido") }}';
                    },
                    error: function (xhr, status, error) {
                        window.location.href = '{{ route("app.pedido") }}';
                    }
                });
            }
        }

        $(document).ready(function(){
            // Espera a página carregar completamente
            setTimeout(function(){
                // Verifica se há uma mensagem flash
                if($('.alert').length > 0){
                    // Mostra a mensagem flash
                    $('.alert').slideDown();
                    // Define um tempo para esconder a mensagem flash após 5 segundos
                    setTimeout(function(){
                        $('.alert').slideUp();
                    }, 4000);
                }
            }, 1000); // Aguarda 1 segundo antes de verificar a existência da mensagem flash
        });
    </script>

    @include('app.layouts._partials.footer')

@endsection
