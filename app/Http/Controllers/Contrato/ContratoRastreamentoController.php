<?php

namespace App\Http\Controllers\Contrato;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContratoRastreamentoController extends Controller
{
    protected $arrayListPermissoesDoModuloDaRota; //VALIDA AS PERMISSÕES DOS MODULOS
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }
    public function index()
    {
        return view('contrato.vendedor.index', [
            'titulo' => 'Listar Contratos',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function show($id)
    {
        return view('contrato.vendedor.show', [
            'titulo' => 'Visualizar Contrato',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }
}
