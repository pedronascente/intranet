<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class);
    }

    public function posicao()
    {
        return $this->belongsTo(ModuloPosicao::class, 'modulo_posicao_id', 'id');
    }
    public function categoria()
    {
        return $this->belongsTo(ModuloCategoria::class,'modulo_categoria_id', 'id');
    }

    public function rules()
    {
        return [
            'modulo_posicao_id'   => 'required|integer',
            'modulo_categoria_id' => 'required|integer',
            'nome'                => 'required|max:190|min:2',
            'rota'                => 'required|max:190|min:2',
            'descricao'           => 'required|max:190|min:5',
        ];
    }

    public function feedback()
    {   
        return  [
            'required' => 'Campo obrigatório.',
        ];
    }
}