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
    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class);
    }

    public static function getPermissoes($id)
    {
        $listArraypermissoes = DB::table('perfis')
            ->join('perfil_permissao', 'perfis.id', '=', 'perfil_permissao.perfil_id')
            ->join('permissoes', 'permissoes.id', '=', 'perfil_permissao.permissao_id')
            ->select('perfil_permissao.modulo_id', 'perfil_permissao.permissao_id', 'permissoes.nome')->where('perfil_id', $id)
            ->get()->groupBy('modulo_id');

        return $listArraypermissoes;
    }

    public function rules(){
        return [
                'nome' => 'required|max:190|unique:perfis,nome',
                'descricao' => 'required|max:190|min:3',
        ];
    }

    public function feedback(){
        return [
                'nome.required' => 'Campo obrigatório.',
                'nome.unique' => 'Este perfil já está sendo utilizado.',
                'descricao.required' => 'Campo obrigatório.',
        ];
     }

    public function validarDuplicidade($nome)
    {
        return $this->where('nome', $nome)
            ->get()
            ->count();
    }
}
