<?php

namespace App\Http\Controllers;

use App\Models\FornecedorModel;
use App\Models\ProdutoModel;
use App\Models\UnidadeModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
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

    public function adicionar(Request $request)
    {
        try {
            $unidades = UnidadeModel::all();

            $fornecedores = FornecedorModel::all();

            if ($request->input('_token') != '') {
                $produto = new ProdutoModel();
                $produto->create($request->all());
                return redirect()->route('app.produto.adicionar')->with('success', 'Produto cadastrado com sucesso!');
            }

            return view('app.produto.adicionar', compact('unidades', 'fornecedores'));
        } catch (Exception $e) {
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
                return response()->json(['message' => 'Produto atualizado com sucesso!',
                    compact('unidades', 'produtos')]);
            } else {
                return response()->json(['error' => 'Produto não encontrado!'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function excluir($id): JsonResponse
    {
        try {
            // Busca o fornecedor pelo ID
            $produtos = ProdutoModel::find($id);

            $unidades = UnidadeModel::all();

            // Verifique se o fornecedor existe
            if ($produtos) {
                // Excluí o fornecedor
                $produtos->delete();
                return response()->json(['message' => 'Produto excluído com sucesso!',
                    compact('produtos', 'unidades')]);
            } else {
                return response()->json(['error' => 'Fornecedor não encontrado!'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function visualizar()
    {
        try {
            $produtos = ProdutoModel::all();

            return view('app.produto.visualizar', compact('produtos'));
        } catch (Exception $e) {
            return view('app.produto.visualizar', ['message' => $e->getMessage()]);
        }

    }
}
