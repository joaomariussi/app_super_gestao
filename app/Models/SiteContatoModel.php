<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class SiteContatoModel extends Model
{
    protected $table = 'site_contatos';
    protected $fillable = ['nome', 'telefone', 'email', 'motivo_contato_id', 'mensagem'];

    // Para que o Laravel saiba que o campo motivo_contato_id é um inteiro
    protected $casts = [
        'motivo_contato_id' => 'integer'
    ];


}
