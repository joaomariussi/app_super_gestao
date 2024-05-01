<?php

namespace App\Http\Controllers;

use App\Models\MotivoContatoModel;
use App\Models\SiteContatoModel;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function contato()
    {
        // Traz todos os motivos de contato
        $motivos_contatos = MotivoContatoModel::all();

        return view('site.contato', ['motivos_contatos' => $motivos_contatos], ['titulo' => 'Contato']);
    }

    public function salvar(Request $request): RedirectResponse
    {
        $regras = [
            'nome' => 'required',
            'telefone' => 'required',
            'email' => 'email',
            'motivo_contato_id' => 'required',
            'mensagem' => 'required'
        ];

        $request->validate($regras);

        try {
            $dadosContato = [
                'nome' => $request->input('nome'),
                'telefone' => $request->input('telefone'),
                'email' => $request->input('email'),
                'motivo_contato_id' => $request->input('motivo_contato_id'),
                'mensagem' => $request->input('mensagem')
            ];
            SiteContatoModel::create($dadosContato);

        } catch (Exception $e) {
            return redirect()->route('site.contato');
        }

        return redirect()->route('site.contato');
    }
}
