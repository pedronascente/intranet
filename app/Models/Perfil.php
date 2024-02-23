<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Perfil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    protected $table = "perfis";

    public function user()
    {
        return $this->hasOne(User::class);
    }
 
    public function modulos()
    {
        return $this->belongsToMany(Modulo::class);
    }
    
    public function rules(){
        return [
            'nome'             => 'required|max:190|unique:perfis,nome',
            'descricao'        => 'required|max:190|min:3',
            'ArrayListModulos' => 'required',
        ];
    }

    public function feedback(){
        return [
            'nome.unique'               => 'Este perfil já está sendo utilizado.',    
            'required'                  => 'Campo obrigatório.',
            'ArrayListModulos.required' => 'Selecione um Modulo.',
        ];
     }

    public function validarPerfilDuplicado($nome)
    {
        return $this->where('nome', $nome)
            ->get()
            ->count();
    }

    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class, 'modulo_permissao', 'perfil_id', 'permissao_id');
    }

    public function getPermissao($moduloId, $perfilId)
    {
        return Permissao::select('permissoes.id', 'permissoes.nome')
        ->join('modulo_permissao', 'permissoes.id', '=', 'modulo_permissao.permissao_id')
        ->join('perfis', 'perfis.id', '=', 'modulo_permissao.perfil_id')
        ->join('modulos', 'modulos.id', '=', 'modulo_permissao.modulo_id')
        ->where('modulo_permissao.modulo_id', $moduloId)
            ->where('modulo_permissao.perfil_id', $perfilId)
            ->get();
    }
}
