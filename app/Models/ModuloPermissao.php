<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloPermissao extends Model
{
    use HasFactory;

    protected $table = 'modulo_permissao';
    protected $fillable = [
        'perfil_id', 
        'modulo_id', 
        'permissao_id'
    ];

  
}
