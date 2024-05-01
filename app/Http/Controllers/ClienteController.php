<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        try {
            $clientes = ClienteModel::all();
            return view('app.cliente.index', compact('clientes'));
        } catch (Exception $e) {
            return view('app.cliente.index', ['message' => $e->getMessage()]);
        }
    }

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
                ClienteModel::create($data);

                return redirect()->route('app.cliente.adicionar')->with('success', 'Cliente cadastrado com sucesso!');
            }

            return view('app.cliente.adicionar');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editar(Request $request, $id): JsonResponse
    {
        try {
            // Busca o cliente pelo ID
            $cliente = ClienteModel::find($id);

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

    public function excluir($id): JsonResponse
    {
        try {
            $cliente = ClienteModel::find($id);
            if ($cliente) {
                $cliente->delete();
                return response()->json(['message' => 'Cliente excluído com sucesso!']);
            } else {
                return response()->json(['error' => 'Cliente não encontrado!'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
