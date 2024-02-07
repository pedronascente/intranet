<?php

namespace App\Http\Controllers\Configuracoes;

use App\Http\Controllers\Controller;
use App\Models\ModuloCategoria;

class ConfiguracaoController extends Controller
{

    public function index()
    {
        $filtro = '2';//Configurações

        // Consulta para buscar todas as categorias com pelo menos um módulo onde modulo_posicao_id = 2
        $categoriasComModulos = ModuloCategoria::whereHas('modulos', function ($query) use ($filtro) {
            $query->where('modulo_posicao_id', $filtro);
        })->with(['modulos' => function ($query) use ($filtro) {
            $query->where('modulo_posicao_id', $filtro);
        }])->get();

        return view('configuracoes.index', ['ModuloCategoria' => $categoriasComModulos]);
    }
    
}
