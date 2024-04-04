<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentacaoController extends Controller
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
        return view('cliente.documentacao.index', [
            'titulo' => 'Listar Documentos',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

   
    public function create()
    {
        return view('cliente.documentacao.create', [
            'titulo' => 'Anexar Documentos',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function store(Request $request)
    {
        return $this->index();
    }

   
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        'excluir doc';
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
