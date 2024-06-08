<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdutoModel extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'id_fornecedor',
        'nome',
        'codigo',
        'descricao',
        'peso',
        'preco_venda',
        'largura',
        'comprimento',
        'altura',
        'quantidade',
        'unidade_id'
    ];

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(UnidadeModel::class, 'unidade_id');
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(FornecedorModel::class, 'id_fornecedor');
    }

    public function pedido(): HasMany
    {
        return $this->hasMany(PedidoProdutosModel::class, 'produto_id', 'id');
    }
}
