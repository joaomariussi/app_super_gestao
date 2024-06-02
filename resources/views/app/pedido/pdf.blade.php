<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido #{{ $pedido->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .conteudo-pagina {
            width: 100%;
            padding: 20px;
        }

        .informacoes, .detalhes-pedido, .produtos-pedido {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .detalhes-pedido, .produtos-pedido {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .detalhes-pedido .coluna, .produtos-pedido table {
            width: 100%;
            margin: 0 auto;
        }

        .detalhes-pedido {
            display: flex;
            justify-content: space-between;
            margin: 20px auto;
            padding: 20px;
            max-width: 1200px;
        }

        .coluna {
            width: 45%;
        }

        .coluna-dados-cliente {
            margin-right: 10px;
        }

        h3 {
            margin-bottom: 15px;
            color: #2a9ee2;
            font-size: 20px;
            text-transform: uppercase;
        }

        p {
            margin: 5px 0;
            color: #555;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        table th {
            background-color: #2a9ee2;
            color: white;
            font-weight: normal;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .produtos-pedido {
            margin: 20px auto;
            padding: 20px;
            max-width: 1200px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: left;
        }

        .title-produtos-pedidos {
            margin-bottom: 20px;
            color: #2a9ee2;
            font-size: 20px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div class="conteudo-pagina">

    <div class="informacoes">
        <h3>Informações do Pedido</h3>
        <p><strong>ID do Pedido:</strong> {{ $pedido->id }}</p>
        <p><strong>Data do Pedido:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Última Atualização:</strong> {{ $pedido->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="detalhes-pedido">
        <div class="coluna coluna-dados-cliente">
            <h3>Dados do Cliente</h3>
            <p><strong>Nome:</strong> {{ $pedido->cliente->nome }}</p>
            <p><strong>CPF:</strong> {{ formatarCpf($pedido->cliente->cpf) }}</p>
            <p><strong>Email:</strong> {{ $pedido->cliente->email }}</p>
            <p><strong>Telefone:</strong> {{ formatarTelefone($pedido->cliente->telefone) }}</p>
        </div>

        <div class="coluna">
            <h3>Dados da Entrega</h3>
            <p><strong>CEP:</strong> {{ formatarCep($pedido->cliente->cep) }}</p>
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
</body>
</html>

@php
    function formatarCpf($cpf): string {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }

    function formatarCep($cep): string {
        return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    }

    function formatarTelefone($telefone): string {
        return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
    }
@endphp
