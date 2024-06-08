<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\FornecedorModel;
use App\Models\PedidoModel;
use App\Models\ProdutoModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PrincipalController extends Controller
{
    public function index(): Factory|View|Application
    {
        try {
            $total_pedidos = PedidoModel::count();
            $total_clientes = ClienteModel::count();
            $total_produtos = ProdutoModel::count();
            $total_fornecedores = FornecedorModel::count();

            return view('site.principal', [
                'total_pedidos' => $total_pedidos,
                'total_clientes' => $total_clientes,
                'total_produtos' => $total_produtos,
                'total_fornecedores' => $total_fornecedores
            ]);
        } catch (Exception) {
            return view('site.principal', [
                'total_pedidos' => 0,
                'total_clientes' => 0,
                'total_produtos' => 0,
                'total_fornecedores' => 0,
            ]);
        }
    }
}
