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

    public static function AtivarDesativarModuloECategoria($slug)
    {
        // Ativa o módulo com o slug fornecido e desativa todos os outros módulos
        DB::table('modulos')->update(['ativo' => DB::raw("CASE WHEN slug = '{$slug}' THEN 'active' ELSE '' END")]);

        // Ativa a categoria do módulo com o slug fornecido e desativa todas as outras categorias
        DB::table('modulo_categorias')->where('id', DB::table('modulos')->where('slug', $slug)->value('modulo_categoria_id'))
        ->update(['ativo' => 'active']);

        DB::table('modulo_categorias')->where('id', '<>', DB::table('modulos')->where('slug', $slug)->value('modulo_categoria_id'))
        ->update(['ativo' => '']);
    }

    public function getModulo($filtro = null)
    {
        $query = $this->orderBy('id', 'desc');
        if ($filtro) {
            $query->where('nome', 'like', '%' . $filtro . '%');
        }
        return $query->paginate(10);
    }
}