<?php

namespace App\Http\Controllers;

use App\Models\MotivoContatoModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PrincipalController extends Controller
{
    public function index(): Factory|View|Application
    {
        try {
            $motivos_contato = MotivoContatoModel::all();
            return view('site.principal', compact('motivos_contato'));
        } catch (Exception $e) {
            return view('app.principal.index')->with('error', $e->getMessage());
        }
    }
}
