<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'rota',
        'descricao',
        'tipo_menu',
    ];

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class);
    }

    public function rules()
    {
        return [
            'tipo_menu' => 'required|max:190|min:2',
            'nome'      => 'required|max:190|min:2',
            'rota'      => 'required|max:190|min:2',
            'descricao' => 'required|max:190|min:5',
        ];
    }

    public function feedback()
    {   
        return  [
                'tipo_menu.required'  => 'Selecione um tipo de Menu',
                'nome.required'       => 'Campo obrigatório.',
                'rota.required'       => 'Campo obrigatório.',
                'descricao.required'  => 'Campo obrigatório.',
        ];
    }
}
