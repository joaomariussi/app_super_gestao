<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoModel extends Model
{
    protected $table = 'pedidos';

    protected $primaryKey = 'id';
    protected $fillable = [
        'cliente_id',
        'valor_total',
        'observacoes'
    ];
}
