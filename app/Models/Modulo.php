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
  
    public static function AtivarDesativarModuloECategoria($slug)
    {

        $modulo = DB::table('modulos')->where('slug', $slug)->first();
        DB::table('modulos')->where('slug', '<>', $slug)->update(['ativo' => '']);// Desativa todos os módulos exceto aquele com o slug fornecido
        DB::table('modulos')->where('slug', $slug)->update(['ativo' => 'active']);  // Ativa o módulo com o slug fornecido
       
        if($modulo){
            DB::table('modulo_categorias')->where('id', '<>', $modulo->modulo_categoria_id)->update(['ativo' => '']);
            DB::table('modulo_categorias')->where('id', $modulo->modulo_categoria_id)->update(['ativo' => 'active']);
        }
       
    }

    public function getModulo($filtro = null)
    {
        $query = $this::with('categoria')->orderBy('id', 'desc');

        if ($filtro) {
            $query->where(function ($query) use ($filtro) {
                $query->where('nome', 'like', '%' . $filtro . '%')
                ->orWhere('slug', 'like', '%' . $filtro . '%')
                ->orWhereHas('categoria', function ($query) use ($filtro) {
                    $query->where('nome', 'like', '%' . $filtro . '%');
                });
            });
        }

        return $query->paginate(10);
    }

    public function validarFormulario($request)
    {
        if($request->nova_categoria == null && $request->modulo_categoria_id == null)
        {
            $rules = [
                'modulo_posicao_id' => 'required|integer',
                'modulo_categoria_id' => 'required|integer',
                'nome' => 'required|max:190|min:2',
                'rota' => 'required|max:190|min:2',
                'descricao' => 'required|max:190|min:5',
            ];
        }else{
            $rules = [
                'modulo_posicao_id' => 'required|integer',
                'nome' => 'required|max:190|min:2',
                'rota' => 'required|max:190|min:2',
                'descricao' => 'required|max:190|min:5',
            ];
        }

        $feedback = [
            'required' => 'Campo obrigatório.',
        ];
        $request->validate($rules, $feedback);
    }
}