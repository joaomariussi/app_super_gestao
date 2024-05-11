<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Exibe a lista de clientes
     *
     * @return View
     */
    public function index(): View
    {
        try {
            // Busca todos os clientes
            $clientes = ClienteModel::all();
            return view('app.cliente.index', compact('clientes'));
        } catch (Exception $e) {
            return view('app.cliente.index', ['message' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|RedirectResponse|\Illuminate\View\View
     * Adiciona um novo cliente
     */
    public function adicionar(Request $request)
    {
        try {
            // Remove as máscaras dos campos
            if ($request->isMethod('post')) {
                $data = $request->except('_token');
                $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']); // Remove tudo exceto números
                $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
                $data['cep'] = preg_replace('/[^0-9]/', '', $data['cep']);

                // Salva os dados no banco de dados
                (new ClienteModel)->create($data);

                return redirect()->route('app.cliente.adicionar')->with('success', 'Cliente cadastrado com sucesso!');
            }

            return view('app.cliente.adicionar');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * Edita um cliente
     */
    public function editar(Request $request, $id): JsonResponse
    {
        try {
            // Busca o cliente pelo ID
            $cliente = (new ClienteModel)->find($id);

            // Verifica se o cliente existe e se a requisição é do tipo POST
            if ($request->isMethod('post') || $cliente) {
                $data = $request->except('_token');

                // Remove as máscaras dos campos
                $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']); // Remove tudo exceto números
                $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
                $data['cep'] = preg_replace('/[^0-9]/', '', $data['cep']);

                // Atualiza os dados no banco de dados
                $cliente->update($data);

                return response()->json(['message' => 'Cliente atualizado com sucesso!']);
            } else {
                return response()->json(['error' => 'Cliente não encontrado!]'], 405);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     * Exclui um cliente
     */
    public function excluir($id): JsonResponse
    {
        try {
            // Busca o cliente pelo ID
            $cliente = (new ClienteModel)->find($id);

            // Verifica se o cliente existe
            if ($cliente) {

                // Exclui o cliente do banco de dados
                $cliente->delete();
                return response()->json(['message' => 'Cliente excluído com sucesso!']);
            } else {
                return response()->json(['error' => 'Cliente não encontrado!'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * Verifica se um CPF já está cadastrado
     */
    public function verificaCpf(Request $request): JsonResponse
    {
        try {
            $cpf = $request->cpf;
            $cliente = ClienteModel::where('cpf', $cpf)->exists();
            return response()->json(['existe' => $cliente]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * Verifica se um e-mail já está cadastrado
     */
    public function verificaEmail(Request $request): JsonResponse
    {
        try {
            $email = $request->email;
            $cliente = ClienteModel::where('email', $email)->exists();
            return response()->json(['existe' => $cliente]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
