<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nome', 'cpf', 'email', 'telefone', 'endereco', 'cep', 'estado', 'cidade'];
}
