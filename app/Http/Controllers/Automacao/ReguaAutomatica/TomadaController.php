<?php

namespace App\Http\Controllers\Automacao\ReguaAutomatica;

use App\Http\Controllers\Controller;
use App\Models\Automacao\ReguaAutomatica\Tomada;
use Illuminate\Http\Request;

class TomadaController extends Controller
{

    private $_arrayListPermissoesDoModuloDaRota;
    private $_Modeltomada;

    public function __construct(Tomada $tomada)
    {
        $this->_Modeltomada = $tomada;
        $this->middleware(function ($request, $next) {
            $this->_arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota') ? session()->get('permissoesDoModuloDaRota') : [];
            return $next($request);
        });
    }


    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->_Modeltomada->regua_id = $request->regua_id;
        $this->_Modeltomada->tomada = $request->tomada;
        $this->_Modeltomada->api = $request->api;
        $this->_Modeltomada->save();
        return redirect()
            ->back()
            ->with('status', "Registrado com sucesso.");
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $tomada =  $this->_Modeltomada::find($id);

        if ($tomada) {
            return response()->json([
                'tomada' => $tomada->tomada,
                'api' => $tomada->api,
                'rota' => route('tomada.update', $tomada->id),
            ]);
        } else {
            return response()->json(['error' => 'Tomada não encontrada'], 404);
        }
    }
   
    public function update(Request $request, $id)
    {
        $tomada = $this->_Modeltomada::find($id);
        $tomada->tomada = $request->input('tomada');
        $tomada->api = $request->input('api');
        $tomada->save();

        return redirect()
            ->back()
            ->with('status', "Registro atualizado com sucesso!");
    }

    public function destroy($id)
    {
        // Encontra a tomada pelo ID
        $tomada = $this->_Modeltomada::find($id);

        // Verifica se a tomada foi encontrada
        if (!$tomada) {
            return redirect()
                ->back()
                ->with('error', "Tomada não encontrada!");
        }

        // Exclui a tomada
        $tomada->delete();

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()
            ->back()
            ->with('status', "Registro excluído!");
    }

}
