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
     *  Adiciona um novo cliente
     * @param Request $request
     * @return Application|Factory|RedirectResponse|\Illuminate\View\View
     */
    public function adicionar(Request $request): Factory|\Illuminate\View\View|Application|RedirectResponse
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
            flash()->error('Erro ao cadastrar o cliente!');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     *  Edita um cliente
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function editar(Request $request, $id): JsonResponse
    {
        try {
            // Busca o cliente pelo ID
            $cliente = (new ClienteModel)->find($id);

            if ($cliente) {
                $data = $request->except('_token');

                // Remove as máscaras dos campos
                $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']); // Remove tudo exceto números
                $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
                $data['cep'] = preg_replace('/[^0-9]/', '', $data['cep']);

                // Atualiza os dados no banco de dados
                $cliente->update($data);

                flash()->success('Cliente atualizado com sucesso!');
                return response()->json(['message' => 'Cliente atualizado com sucesso!']);
            } else {
                flash()->error('Cliente não encontrado!');
                return response()->json(['error' => 'Cliente não encontrado!'], 405);
            }
        } catch (Exception $e) {
            flash()->error('Erro ao atualizar o cliente!');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     *  Exclui um cliente
     * @param $id
     * @return JsonResponse
     */
    public function excluir($id): JsonResponse
    {
        try {
            // Busca o cliente pelo ID
            $cliente = (new ClienteModel)->find($id);

            // Verifica se o cliente existe
            if (!$cliente) {
                flash()->error('Cliente não encontrado!');
                return response()->json(['error' => 'Cliente não encontrado!'], 404);
            }

            // Verifica se o cliente possui pedidos vinculados
            if ($cliente->pedido()->exists()) {
                flash()->error('Cliente não pode ser excluído, pois possui pedidos vinculados!');
                return response()->json(['error' => 'Cliente não pode ser excluído, pois possui pedidos vinculados!'], 405);
            }

            // Exclui o cliente do banco de dados
            $cliente->delete();
            flash()->success('Cliente excluído com sucesso!');
            return response()->json(['message' => 'Cliente excluído com sucesso!']);

        } catch (Exception $e) {
            flash()->error('Erro ao excluir o cliente!');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     *  Verifica se um CPF já está cadastrado
     * @param Request $request
     * @return JsonResponse
     */
    public function verificaCpf(Request $request): JsonResponse
    {
        try {
            $cpf = $request->cpf;
            $cliente = (new ClienteModel)->where('cpf', $cpf)->exists();
            return response()->json(['existe' => $cliente]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     *  Verifica se um e-mail já está cadastrado
     * @param Request $request
     * @return JsonResponse
     */
    public function verificaEmail(Request $request): JsonResponse
    {
        try {
            $email = $request->email;
            $cliente = (new ClienteModel)->where('email', $email)->exists();
            return response()->json(['existe' => $cliente]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
