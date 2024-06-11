<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nome', 'cpf', 'email', 'telefone', 'endereco', 'cep', 'estado', 'cidade'];

    public function pedido(): HasMany
    {
        return $this->hasMany(PedidoModel::class, 'cliente_id', 'id');
    }

}
