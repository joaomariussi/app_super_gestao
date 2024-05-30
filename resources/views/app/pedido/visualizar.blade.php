@extends('app.layouts.basic')

<title>Gerenciamento de Pedidos</title>

@section('conteudo')
<link rel="stylesheet" href="{{ asset('css/visualizar-pedido.css') }}">

<div class="conteudo-pagina">
    <div class="titulo-pedido">
        <h2>Detalhes do Pedido #{{ $pedido->id }}</h2>
    </div>

    <div class="detalhes-pedido">
        <div class="coluna-esquerda">
            <h3>Informações do Pedido</h3>
            <p><strong>ID do Pedido:</strong> {{ $pedido->id }}</p>
            <p><strong>Data do Pedido:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Última Atualização:</strong> {{ $pedido->updated_at->format('d/m/Y H:i') }}</p>
            <button class="button-print" onclick="window.print()">Imprimir Pedido</button>
        </div>

        <div class="coluna-direita">
            <h3>Dados do Cliente</h3>
            <p><strong>Nome:</strong> {{ $pedido->cliente->nome }}</p>
            <p><strong>CPF:</strong> <script>document.write(formatarCpf('{{ $pedido->cliente->cpf }}'))</script></p>
            <p><strong>Email:</strong> {{ $pedido->cliente->email }}</p>
            <p><strong>Telefone:</strong> <script>document.write(formatarTelefone('{{ $pedido->cliente->telefone }}'))</script></p>
            <h3>Dados da Entrega</h3>
            <p><strong>CEP:</strong> <script>document.write(formatarCep('{{ $pedido->cliente->cep }}'))</script></p>
            <p><strong>Cidade:</strong> {{ $pedido->cliente->cidade }}</p>
            <p><strong>Estado:</strong> {{ $pedido->cliente->estado }}</p>
            <p><strong>Endereço:</strong> {{ $pedido->cliente->endereco }}</p>
        </div>
    </div>

    <div class="produtos-pedido">
        <h3>Produtos no Pedido</h3>
        <table>
            <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pedido_produtos as $produto)
                <tr>
                    <td>{{ $produto->produto->nome }}</td>
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
