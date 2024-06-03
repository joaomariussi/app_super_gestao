@extends('app.layouts.basic')

<title>Visualizar Pedido</title>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/visualizar-pedido.css') }}">
@endpush

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pedido">
            <h2 class="titulo">Detalhes do Pedido #{{ $pedido->id }}</h2>
        </div>

        <a href="{{ route('app.pedido') }}" class="botao-voltar">Voltar</a>

        <div class="informacoes">
            <div class="info-pedido coluna-informacoes">
                <h3>Informações do Pedido</h3>
                <p><strong>ID do Pedido:</strong> {{ $pedido->id }}</p>
                <p><strong>Pedido criado em:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                <a class="button-imprimir" href="{{ route('app.pedido.pdf', ['id' => $pedido->id]) }}">
                    Imprimir Pedido
                </a>

            </div>

            <div class="resumo-pedido">
                <div class="card">
                    <h4>Total do Pedido</h4>
                    <p>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</p>
                </div>
                <div class="card">
                    <h4>Quantidade de Itens</h4>
                    <p>{{ $quantidade_total }}</p>
                </div>
            </div>
        </div>

        <div class="detalhes-pedido">
            <div class="coluna-esquerda">
                <h3>Dados do Cliente</h3>
                <p><strong>Nome:</strong> {{ $pedido->cliente->nome }}</p>
                <p><strong>CPF:</strong> <script>document.write(formatarCpf('{{ $pedido->cliente->cpf }}'))</script></p>
                <p><strong>Email:</strong> {{ $pedido->cliente->email }}</p>
                <p><strong>Telefone:</strong> <script>document.write(formatarTelefone('{{ $pedido->cliente->telefone }}'))</script></p>
            </div>

            <div class="coluna-direita">
                <h3>Dados da Entrega</h3>
                <p><strong>CEP:</strong> <script>document.write(formatarCep('{{ $pedido->cliente->cep }}'))</script></p>
                <p><strong>Cidade:</strong> {{ $pedido->cliente->cidade }}</p>
                <p><strong>Estado:</strong> {{ $pedido->cliente->estado }}</p>
                <p><strong>Endereço:</strong> {{ $pedido->cliente->endereco }}</p>
            </div>
        </div>

        <div class="produtos-pedido">
            <h3 class="title-produtos-pedidos">Produtos</h3>
            <table>
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Código Produto</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pedido_produtos as $produto)
                    <tr>
                        <td>{{ $produto->produto->nome }}</td>
                        <td>{{ $produto->produto->codigo }}</td>
                        <td>{{ $produto->quantidade }}</td>
                        <td>R$ {{ number_format($produto->valor, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script src="{{ asset('js/scripts.js') }}"></script>
