@extends('app.layouts.basic')

<script src="{{asset('js/libraries/jquery/jquery.js')}}"></script>
<script src="{{ asset('js/table-produto.js') }}"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css"/>
<link rel="stylesheet" href="{{ asset('css/visualizar-produto.css') }}">


@section('conteudo')
    <div class="conteudo-pagina">

        <div class="titulo-produto">
            <h2>Gerenciamento de Produtos</h2>
        </div>

        <div class="menu-produto">
            <div class="button-wrapper">
                <div class="button-wrapper">
                    <button type="submit" class="button-back"
                            onclick="window.location.href = '{{ route('site.principal') }}'">Voltar
                    </button>
                </div>
            </div>
            <table class="table table-striped" id="table-produtos">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome do Produto</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Preço de Venda</th>
                    <th scope="col">Estoque Mínimo</th>
                    <th scope="col">Estoque Máximo</th>
                    <th scope="col">Unidade de Medida</th>
                    <th scope="col">Largura</th>
                    <th scope="col">Comprimento</th>
                    <th scope="col">Altura</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($produtos as $produto)
                    <tr>
                        <th scope="row">{{ $produto->id }}</th>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->descricao }}</td>
                        <td>{{ $produto->peso }}</td>
                        <td>{{ $produto->preco_venda }}</td>
                        <td>{{ $produto->estoque_minimo }}</td>
                        <td>{{ $produto->estoque_maximo }}</td>
                        <td>{{ $produto->unidade_id }}</td>
                        <td>{{ $produto->largura }}</td>
                        <td>{{ $produto->comprimento }}</td>
                        <td>{{ $produto->altura }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nenhum produto encontrado</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection


