@extends('app.layouts.basic')

@section('title', 'Novo Produto')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/adicionar-produto.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>
@endpush

@push('head-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endpush

@push('scripts')
    <script src="{{ asset('js/scripts-mascaras.js') }}"></script>
@endpush

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h2 class="title-h2">Gerenciamento de Produtos</h2>
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
                    <input type="text" name="descricao" placeholder="Descrição"
                           class="input-descricao-produto" required>
                </div>

                <div class="form-group">
                    <input type="number" step="any" name="codigo" placeholder="Código do Produto"
                           class="input-codigo-produto" required>
                </div>

                <div class="form-group">
                    <input type="text" step="any" name="preco_venda" placeholder="R$ 0,00" id="preco_venda"
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

                <div class="button-wrapper">
                    <button type="submit" class="button-add">Cadastrar</button>
                    <a href="{{ route('app.produto') }}" class="button-back">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
