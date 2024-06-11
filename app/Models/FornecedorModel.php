<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FornecedorModel extends Model
{
    protected $table = 'fornecedores';
    protected $fillable = ['nome', 'site', 'uf', 'email'];

    public function produto(): HasMany
    {
        return $this->hasMany(ProdutoModel::class, 'id_fornecedor');
    }
}
