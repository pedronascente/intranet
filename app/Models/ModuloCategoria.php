<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloCategoria extends Model
{
    use HasFactory;
    protected $table= 'modulo_categorias';

    public function modulos()
    {
        return $this->hasMany(Modulo::class, 'modulo_categoria_id','id');
    }
}
