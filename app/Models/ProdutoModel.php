<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';

    protected $fillable = ['id_fornecedor', 'nome', 'codigo', 'descricao', 'peso', 'preco_venda',
        'largura', 'comprimento', 'altura', 'quantidade', 'unidade_id'];
}
