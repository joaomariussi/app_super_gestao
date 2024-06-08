<?php

namespace App\Http\Controllers;

use App\Models\FornecedorModel;
use App\Models\ProdutoModel;
use App\Models\UnidadeModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ProdutoController extends Controller
{
    public function index(): Factory|View|Application
    {
        try {
            $produtos = ProdutoModel::all();

            $unidades = UnidadeModel::all();

            $fornecedores = FornecedorModel::all();
            return view('app.produto.index', compact('produtos', 'unidades', 'fornecedores'));
        } catch (Exception $e) {
            return view('app.produto.index', ['message' => $e->getMessage()]);
        }
    }

    public function adicionar(Request $request): Factory|View|Application|\Illuminate\Http\RedirectResponse
    {
        try {
            $unidades = UnidadeModel::all();
            $fornecedores = FornecedorModel::all();

            if ($request->input('_token') != '') {
                // Obter todos os dados do request
                $produtoData = $request->all();

                // Verificar se o campo preco_venda está presente e formatá-lo
                if (isset($produtoData['preco_venda'])) {
                    // Remover o prefixo 'R$ ' e os pontos, e substituir a vírgula por ponto
                    $preco = str_replace(['R$ ', '.', ','], ['', '', '.'], $produtoData['preco_venda']);
                    // Atualizar o valor no array de dados do produto
                    $produtoData['preco_venda'] = (float) $preco;
                }

                // Criar o novo produto
                $produto = new ProdutoModel();
                $produto->create($produtoData);

                // Redirecionar com mensagem de sucesso
                return redirect()->route('app.produto.adicionar')->with('success', 'Produto cadastrado com sucesso!');
            }

            // Retornar a view com as unidades e fornecedores
            return view('app.produto.adicionar', compact('unidades', 'fornecedores'));
        } catch (Exception $e) {
            // Redirecionar de volta com mensagem de erro
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editar(Request $request, $id): JsonResponse
    {
        try {
            // Busca o produto pelo ID
            $produtos = ProdutoModel::find($id);

            $unidades = UnidadeModel::all();

            // Verifica se o produto existe
            if ($produtos) {
                // Atualiza o produto
                $produtos->update($request->all());
                flash('Produto atualizado com sucesso!')->success();
                return response()->json(
                    ['message' => 'Produto atualizado com sucesso!',
                        'produto' => $produtos, 'unidades' => $unidades
                    ]);
            } else {
                flash()->error('Produto não encontrado!');
                return response()->json(['error' => 'Produto não encontrado!'], 404);
            }
        } catch (Exception $e) {
            flash()->error('Ocorreu um erro ao atualizar o produto. Por favor, tente novamente.');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function excluir($id): JsonResponse
    {
        try {
            // Busca o produto pelo ID
            $produto = ProdutoModel::find($id);

            // Verifica se o produto existe
            if (!$produto) {
                flash()->error('Produto não encontrado!');
                return response()->json(['error' => 'Produto não encontrado!'], 404);
            }

            // Verifica se o produto está associado a um pedido
            if ($produto->pedido()->exists()) {
                flash()->error('Produto não pode ser excluído, pois está associado a um pedido.');
                return response()->json(['error' => 'Produto não pode ser excluído, pois está associado a um pedido.'], 400);
            }

            // Exclui o produto do banco de dados
            $produto->delete();
            flash()->success('Produto excluído com sucesso!');
            return response()->json(['message' => 'Produto excluído com sucesso!']);

        } catch (Exception $e) {
            flash()->error('Ocorreu um erro ao excluir o produto. Por favor, tente novamente.');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function visualizar($id): Factory|View|Application
    {
        try {
            $produto = ProdutoModel::with('unidade', 'fornecedor')->find($id);

            if ($produto) {
                return view('app.produto.visualizar', compact('produto'));
            } else {
                return view('app.produto.index', ['message' => 'Produto não encontrado!']);
            }
        } catch (Exception $e) {
            return view('app.produto.index', ['message' => $e->getMessage()]);
        }
    }
}
