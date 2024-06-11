<?php

namespace App\Http\Controllers;

use App\Models\FornecedorModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{

    /**
     * Lista todos os fornecedores
     * @throws Exception
     */
    public function index(): Factory|View|Application
    {
        try {
            $fornecedores = FornecedorModel::all();
            return view('app.fornecedor.index',compact('fornecedores'));
        } catch (Exception $e) {
            return view('app.fornecedor.index', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Adiciona um novo fornecedor
     * @throws Exception
     */
    public function adicionar(Request $request): Factory|View|Application|RedirectResponse
    {
        try {
            if ($request->input('_token') != '') {
                $fornecedor = new FornecedorModel();
                $fornecedor->create($request->all());
                return redirect()->route('app.fornecedor.adicionar')->with('success', 'Fornecedor adicionado com sucesso!');
            }

            return view('app.fornecedor.adicionar');
        } catch (Exception $e) {
            flash()->error('Erro ao adicionar fornecedor!');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Edita um fornecedor
     * @throws Exception
     */
    public function editar(Request $request, $id): JsonResponse
    {
        try {
            // Busca o fornecedor pelo ID
            $fornecedor = (new FornecedorModel)->find($id);

            // Verifica se o fornecedor existe
            if ($fornecedor) {
                // Atualiza o fornecedor
                $fornecedor->update($request->only(['nome', 'site', 'uf', 'email']));
                flash()->success('Fornecedor atualizado com sucesso!');
                return response()->json(['message' => 'Fornecedor atualizado com sucesso!']);
            } else {
                flash()->error('Fornecedor não encontrado!');
                return response()->json(['error' => 'Fornecedor não encontrado!'], 404);
            }
        } catch (Exception $e) {
            flash()->error('Erro ao atualizar fornecedor!');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Exclui um fornecedor
     * @throws Exception
     */
    public function excluir($id): JsonResponse
    {
        try {
            // Busca o fornecedor pelo ID
            $fornecedor = (new FornecedorModel)->find($id);

            // Verifica se o fornecedor existe
            if (!$fornecedor) {
                flash()->error('Fornecedor não encontrado!');
                return response()->json(['error' => 'Fornecedor não encontrado!'], 404);
            }

            if ($fornecedor->produto()->exists()) {
                flash()->error('Fornecedor não pode ser excluído, pois possui produtos vinculados!');
                return response()->json(['error' => 'Fornecedor não pode ser excluído, pois possui produtos vinculados!'], 405);
            }

            // Exclui o fornecedor do banco de dados
            $fornecedor->delete();
            flash()->success('Fornecedor excluído com sucesso!');
            return response()->json(['message' => 'Fornecedor excluído com sucesso!']);

        } catch (Exception $e) {
            flash()->error('Erro ao excluir fornecedor!');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
