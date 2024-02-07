<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    protected $table = 'permissoes';

    
    public function rules()
    {
        return ['nome' => 'required|max:190',];
    }

    public function feedback()
    {
       return ['nome.required' => 'Campo obrigatório.', ];      
    }

    public function validarDuplicidade($nome)
    {
        return $this->where('nome', $nome)
                    ->get()
                    ->count();
    }

    public function modulos_associados()
    {
        return $this->belongsToMany(Modulo::class, 'modulo_permissao', 'permissao_id', 'modulo_id');
    }


}