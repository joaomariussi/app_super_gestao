<?php

namespace App\Http\Controllers;

use App\Models\FornecedorModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        try {
            $fornecedores = FornecedorModel::all();
            return view('app.fornecedor.index',compact('fornecedores'));
        } catch (Exception $e) {
            return view('app.fornecedor.index', ['message' => $e->getMessage()]);
        }
    }

//    public function search(Request $request): JsonResponse
//    {
//        try {
//            $fornecedores = FornecedorModel::where('nome', 'like', '%' . $request->input('nome') . '%')
//                ->orWhere('site', 'like', '%' . $request->input('site') . '%')
//                ->orWhere('uf', 'like', '%' . $request->input('uf') . '%')
//                ->get();
//
//            return response()->json($fornecedores);
//        } catch (Exception $e) {
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }

    /**
     * @throws Exception
     */
    public function adicionar(Request $request)
    {
        try {
            if ($request->input('_token') != '') {
                $fornecedor = new FornecedorModel();
                $fornecedor->create($request->all());
                return redirect()->route('app.fornecedor.adicionar')->with('success', 'Fornecedor adicionado com sucesso!');
            }

            return view('app.fornecedor.adicionar');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editar(Request $request, $id): JsonResponse
    {
        try {
            // Busca o fornecedor pelo ID
            $fornecedor = FornecedorModel::find($id);

            // Verifica se o fornecedor existe
            if ($fornecedor) {
                // Atualiza o fornecedor
                $fornecedor->update($request->all());
                return response()->json(['message' => 'Fornecedor atualizado com sucesso!']);
            } else {
                return response()->json(['error' => 'Fornecedor não encontrado!'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function excluir($id): JsonResponse
    {
        try {
            // Busca o fornecedor pelo ID
            $fornecedor = FornecedorModel::find($id);

            // Verifique se o fornecedor existe
            if ($fornecedor) {
                // Excluí o fornecedor
                $fornecedor->delete();
                return response()->json(['message' => 'Fornecedor excluído com sucesso!']);
            } else {
                return response()->json(['error' => 'Fornecedor não encontrado!'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
