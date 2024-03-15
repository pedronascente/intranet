<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 

class ClienteController extends Controller
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
       return view('cliente.cliente.index',[
        'titulo' =>'Listar Cliente',
            'arrayListPermissoesDoModuloDaRota' =>$this->arrayListPermissoesDoModuloDaRota,
       ]);
    }

    public function create(Request $request)
    {   
        if($request->pessoa){
              switch ($request->pessoa) {
                case 'j':
                    return view('cliente.cliente.juridica.create', [
                        'titulo' => 'Cadastrar Cliente',
                    ]);
                    break;
                
                default:
                    return view('cliente.cliente.fisica.create', [
                        'titulo' => 'Cadastrar Cliente',
                    ]);
                    break;
              }  
        }

        return view('cliente.cliente.tipoCliente',[
            'titulo' => 'Cadastrar Cliente',
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('cliente.cliente.show', [
            'titulo' => 'Visualizar Cliente',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function edit($id)
    {

        if ($id) {
            switch (1) {
                case 'j':
                    return view('cliente.cliente.juridica.create', [
                        'titulo' => 'Editar Cliente',
                    ]);
                    break;

                default:
                    return view('cliente.cliente.fisica.create', [
                        'titulo' => 'Editar Cliente',
                    ]);
                    break;
            }
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        echo 'Destruir Clientes';
    }
}
