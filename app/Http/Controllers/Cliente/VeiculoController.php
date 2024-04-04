<?php
namespace App\Http\Controllers\Cliente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VeiculoController extends Controller
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
        return view('cliente.veiculo.index', [
            'titulo' => 'Listar Veículo',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

 
    public function create()
    {
        return view('cliente.veiculo.create', [
            'titulo' => 'Cadastrar Veículo',
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

 

    public function store(Request $request)
    {
        return redirect()->route('cliente.show', 1);
    }

    public function edit($id)
    {
        return view('cliente.veiculo.edit', [
            'titulo' => 'Editar Veículo',
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
