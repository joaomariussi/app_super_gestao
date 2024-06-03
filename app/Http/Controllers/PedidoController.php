<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\PedidoModel;
use App\Models\PedidoProdutosModel;
use App\Models\ProdutoModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class PedidoController extends Controller
{
    public function index(): Factory|View|RedirectResponse|Application
    {
        try {
            // Carregar todos os pedidos com os produtos relacionados
            $pedidos = PedidoModel::with(['cliente', 'produtos.produto'])->get();

            // Calcular quantidade total de produtos e valor total por pedido
            foreach ($pedidos as $pedido) {
                $pedido->quantidade_total = $pedido->produtos->sum('quantidade');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return view('app.pedido.index', compact('pedidos'));
    }

    public function adicionar(Request $request): Factory|View|Application|RedirectResponse
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
                $pedido->valor_total = str_replace('R$ ', '', $dados_pedido['valor_total'] ?? null);
                $pedido->observacoes = $dados_pedido['observacoes'] ?? null;

                // Inicializa um array para armazenar os produtos
                $pedido_produtos = [];

                foreach ($dados_pedido['produtos'] as $produto) {
                    $pedido_produto = new PedidoProdutosModel();
                    // Não definir o pedido_id aqui
                    $pedido_produto->produto_id = $produto['id_produto'];
                    $pedido_produto->cliente_id = $dados_pedido['cliente_id'];
                    $pedido_produto->nome = $produto['nome_produto'];
                    $pedido_produto->codigo = $produto['codigo_produto'];
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

    public function excluir($id): JsonResponse
    {
        try {
            $pedido = PedidoModel::find($id);

            if ($pedido) {
                // Excluir registros na tabela pedido_produtos associados ao pedido
                PedidoProdutosModel::where('pedido_id', $id)->delete();
                // Agora, excluir o pedido
                $pedido->delete();
                return response()->json(['message' => 'Pedido excluído com sucesso!', 'pedido' => $pedido]);
            } else {
                return response()->json(['error' => 'Pedido não encontrado!'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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

    public function visualizar($id): Factory|View|RedirectResponse|Application
    {
        try {
            $pedido = PedidoModel::with('cliente')->find($id);

            if ($pedido) {
                $pedido_produtos = PedidoProdutosModel::where('pedido_id', $id)->with('produto')->get();

                // Calcula a quantidade total de produtos no pedido
                $quantidade_total = $pedido_produtos->sum('quantidade');

                return view('app.pedido.visualizar',
                    compact('pedido', 'pedido_produtos', 'quantidade_total'));
            } else {
                return redirect()->back()->with('error', 'Pedido não encontrado!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function gerarPdf($id): Response|RedirectResponse
    {
        try {
            $pedido = PedidoModel::with('cliente')->find($id);

            if ($pedido) {
                $pedido_produtos = PedidoProdutosModel::where('pedido_id', $id)->with('produto')->get();
                $quantidade_total = $pedido_produtos->sum('quantidade');

                $pdf = PDF::loadView('app.pedido.pdf',
                    compact('pedido', 'pedido_produtos', 'quantidade_total'));

                return $pdf->download('pedido_' . $pedido->id . '.pdf');
            } else {
                return redirect()->back()->with('error', 'Pedido não encontrado!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
