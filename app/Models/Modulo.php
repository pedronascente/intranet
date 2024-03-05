<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modulo extends Model
{
    use HasFactory;
    protected $table = "modulos";
    
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

    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class,'modulo_permissao');
    }

    public function rules()
    {
        return [
            'modulo_posicao_id' => 'required|integer',
            'modulo_categoria_id' => 'required|integer',
            'nome' => 'required|max:190|min:2',
            'rota' => 'required|max:190|min:2',
            'descricao' => 'required|max:190|min:5',
        ];
    }

    public function feedback()
    {   
        return  [
            'required' => 'Campo obrigatório.',
        ];
    }
    
    public static function ativarDesativarModulo($slug)
    {
        
        DB::table('modulos')->where('slug', '<>', $slug)->update(['ativo' => '']);// Desativa todos os módulos exceto aquele com o slug fornecido
        DB::table('modulos')->where('slug', $slug)->update(['ativo' => 'active']);  // Ativa o módulo com o slug fornecido

        $modulo = DB::table('modulos')->where('slug', $slug)->first();

        DB::table('modulo_categorias')->where('id', '<>',$modulo->modulo_categoria_id)->update(['ativo' => '']);
        DB::table('modulo_categorias')->where('id', $modulo->modulo_categoria_id)->update(['ativo' => 'active']);

    }
}