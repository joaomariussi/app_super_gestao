<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';

    protected $fillable = ['id_fornecedor', 'nome', 'descricao', 'peso', 'preco_venda', 'estoque_minimo', 'estoque_maximo',
        'largura', 'comprimento', 'altura', 'unidade_id'];
}
