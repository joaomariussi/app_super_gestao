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
        try {
            // Salva os dados no banco de dados
            SiteContatoModel::create($request->all());

            return redirect()->route('site.principal')->with('success', 'Contato cadastrado com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
