<?php


namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContatoController extends Controller
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
        return view('cliente.contato.index', [
            'titulo' => 'Listar contato',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create()
    {
        return view('cliente.contato.create', [
            'titulo' => 'Cadastrar Contato',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

   
    public function store(Request $request)
    {
        return redirect()->route('cliente.show',1);
    }

   
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        return view('cliente.contato.edit', [
            'titulo' => 'Editar Contato',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

 
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
