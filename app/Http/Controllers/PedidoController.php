<?php

namespace App\Http\Controllers;

use App\Models\PedidoModel;
use Exception;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        try {
            $pedidos = PedidoModel::all();
            return view('app.pedido.index', compact('pedidos'));
        } catch (Exception $e) {
            return view('app.pedido.index', ['message' => $e->getMessage()]);
        }
    }

    public function adicionar()
    {
        return view('app.pedido.adicionar');
    }


}
