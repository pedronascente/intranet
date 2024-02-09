<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloCategoria extends Model
{
    use HasFactory;
    protected $table = 'modulo_categorias';

    public function modulos()
    {
        return $this->hasMany(Modulo::class);
    }

    public static function getCategoriasEseusModulos($id){
      
        $ModuloCategoria = ModuloCategoria::has('modulos')
        ->whereHas('modulos', function ($query) use ($id) {
            $query->where('modulo_posicao_id', $id);
        })
        ->with(['modulos' => function ($query) use ($id) {
            $query->where('modulo_posicao_id', $id);
        }])
        ->get();
        return $ModuloCategoria; 
    }
}


