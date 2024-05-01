<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadeModel extends Model
{
    protected $table = 'unidades';

    protected $fillable = ['unidade', 'descricao'];
}
