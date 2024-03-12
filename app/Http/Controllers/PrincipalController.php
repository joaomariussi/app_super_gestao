<?php

namespace App\Http\Controllers;

use App\Models\MotivoContatoModel;

class PrincipalController extends Controller
{
    public function index()
    {
        // Traz todos os motivos de contato
        $motivos_contatos = MotivoContatoModel::all();

        return view('site.principal', ['motivos_contatos' => $motivos_contatos], ['titulo' => 'Principal']);
    }
}
