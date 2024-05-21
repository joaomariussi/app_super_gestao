<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\PedidoModel;
use App\Models\PedidoProdutosModel;
use App\Models\ProdutoModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PedidoController extends Controller
{
    public function index()
    {
        try {
            $pedido_produtos = PedidoProdutosModel::with('cliente')->get();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return view('app.pedido.index', compact('pedido_produtos'));
    }

    public function adicionar(Request $request)
    {
        try {

            $clientes = ClienteModel::all();

            $produtos = ProdutoModel::all();

            if ($request->input('_token') != '') {

                $request->session()->put('dados_pedido', $request->all());
                $dados_pedido = $request->session()->get('dados_pedido');

                // Criar o pedido sem salvar
                $pedido = new PedidoModel();
                $pedido->cliente_id = $dados_pedido['cliente_id'] ?? null;
                $pedido->valor_total = $dados_pedido['valor_total'] ?? null;
                $pedido->observacoes = $dados_pedido['observacoes'] ?? null;

                // Inicializa um array para armazenar os produtos
                $pedido_produtos = [];

                foreach ($dados_pedido['produtos'] as $produto) {
                    $pedido_produto = new PedidoProdutosModel();
                    // Não definir o pedido_id aqui
                    $pedido_produto->produto_id = $produto['id_produto'];
                    $pedido_produto->cliente_id = $dados_pedido['cliente_id'];
                    $pedido_produto->nome = $produto['nome_produto'];
                    $pedido_produto->quantidade = $produto['quantidade'];
                    $pedido_produto->valor = $produto['valor'];

                    // Adiciona o pedido_produto ao array
                    $pedido_produtos[] = $pedido_produto;
                }

                // Salva o pedido primeiro para obter o ID
                $pedido->save();

                // Salva os produtos do pedido
                foreach ($pedido_produtos as $pedido_produto) {
                    $pedido_produto->pedido_id = $pedido->id;
                    $pedido_produto->save();
                }
                return redirect()->route('app.pedido.adicionar')->with('success', 'Pedido cadastrado com sucesso!');
            }

            return view('app.pedido.adicionar', compact('clientes', 'produtos'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function buscaProdutos(Request $request): JsonResponse
    {

        try {
            $query = $request->input('query');

            // Lógica para buscar produtos com base na consulta do usuário
            $produtos = ProdutoModel::where('nome', 'like', '%' . $query . '%')->get();

            // Retorna os resultados da busca como um array JSON
            return response()->json($produtos);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Erro ao buscar produtos: ' . $e->getMessage()]);
        }
    }

}
