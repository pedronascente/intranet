<?php

namespace App\Http\Controllers\Configuracoes;

use App\Http\Controllers\Controller;
use App\Models\ModuloCategoria;

class ConfiguracaoController extends Controller
{
    public function index()
    {

        $ModuloCategoria = ModuloCategoria::getCategoriasEseusModulos(2);
        return view('configuracoes.index', ['ModuloCategoria' => $ModuloCategoria]);
    }   
}
