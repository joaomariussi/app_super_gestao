<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PedidoModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cliente_id',
        'valor_total',
        'observacoes'
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(ClienteModel::class, 'cliente_id');
    }

    public function produtos(): HasMany
    {
        return $this->hasMany(PedidoProdutosModel::class, 'pedido_id');
    }
}
