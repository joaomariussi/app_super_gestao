<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $id)
 */
class PedidoProdutosModel extends Model
{
    protected $table = 'pedido_produtos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pedido_id',
        'produto_id',
        'cliente_id',
        'nome',
        'codigo',
        'quantidade',
        'valor'
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(PedidoModel::class, 'pedido_id', 'id');
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(ProdutoModel::class, 'produto_id', 'id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(ClienteModel::class, 'cliente_id', 'id');
    }
}
