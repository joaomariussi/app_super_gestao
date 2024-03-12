<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoContatoModel extends Model
{
    protected $table = 'motivos_contatos';

    protected $fillable = ['id', 'motivo'];

}
