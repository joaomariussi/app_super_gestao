<?php

namespace App\Http\Controllers;

use App\Models\FornecedorModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        try {
            $fornecedores = FornecedorModel::all();
            return view('app.fornecedor.index', ['fornecedores' => $fornecedores]);
        } catch (Exception $e) {
            return view('app.fornecedor.index', ['message' => $e->getMessage()]);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');

        // Lógica para buscar fornecedores com base na consulta do usuário
        $fornecedores = FornecedorModel::where('nome', 'like', '%' . $query . '%')->get();

        // Retorna os resultados da busca como um array JSON
        return response()->json($fornecedores);
    }

    /**
     * @throws Exception
     */
    public function adicionar(Request $request)
    {
        $message = '';

        // Extende a classe FornecedorModel
        $fornecedor = new FornecedorModel();

        if ($request->input('_token') != '') {
            $message = 'Fornecedor adicionado com sucesso!';
            $fornecedor->create($request->all());
        }

        return view('app.fornecedor.adicionar', ['message' => $message]);
    }

    public function editar(Request $request, $id): JsonResponse
    {
        // Busca o fornecedor pelo ID
        $fornecedor = FornecedorModel::find($id);

        // Atualiza os dados do fornecedor com os dados do formulário
        $fornecedor->nome = $request->input('nome');
        $fornecedor->site = $request->input('site');
        $fornecedor->uf = $request->input('uf');
        $fornecedor->email = $request->input('email');
        $fornecedor->save();

        return response()->json(['message' => 'Fornecedor editado com sucesso!']);
    }

    public function excluir($id): JsonResponse
    {
        // Encontre o fornecedor pelo ID
        $fornecedor = FornecedorModel::find($id);

        // Verifique se o fornecedor existe
        if ($fornecedor) {
            // Exclua o fornecedor
            $fornecedor->delete();
            return response()->json(['message' => 'Fornecedor excluído com sucesso!']);
        } else {
            return response()->json(['error' => 'Fornecedor não encontrado!'], 404);
        }
    }
}
