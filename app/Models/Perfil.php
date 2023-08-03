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

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function modulos()
    {
        return $this->belongsToMany(Modulo::class);
    }

    public static function getPermissoes($id)
    {
        $listArraypermissoes = DB::table('perfis')
            ->join('modulo_permissao', 'perfis.id', '=', 'modulo_permissao.perfil_id')
            ->join('permissoes', 'permissoes.id', '=', 'modulo_permissao.permissao_id')
            ->select('modulo_id', 'modulo_permissao.permissao_id')->where('perfil_id', $id)
            ->get()->groupBy('modulo_id');

        return $listArraypermissoes;
    }
}
