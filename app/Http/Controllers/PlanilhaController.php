<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Periodo;
use App\Models\Planilha;
use App\Models\Colaborador;
use App\Models\TipoPlanilha;
use Illuminate\Http\Request;

class PlanilhaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = Planilha::orderBy('id', 'desc')->paginate(8);
        return view('comissao.planilha.index', ['collections' => $collections]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $periodos = Periodo::all();
        $tipoPlanilhas = TipoPlanilha::all();
        $colaborador = User::with('colaborador')->find($request->user()->id);
        return view(
            'comissao.planilha.create',
            [
                'periodos' => $periodos,
                'tipoPlanilhas' =>  $tipoPlanilhas,
                'colaborador' =>  $colaborador->colaborador,
            ]
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->validarDuplicidade($request) >= 1) {
            return redirect()
                ->action('App\Http\Controllers\PlanilhaController@index')
                ->with('warning', "Está planilha já foi criada!");
        }

        $planilha = new Planilha();
        $colaborador = Colaborador::findOrFail($request->colaborador_id);
        $periodo = Periodo::findOrFail($request->periodo_id);
        $tipoPlanilha = TipoPlanilha::findOrFail($request->tipo_planilha_id);
        $planilha->ctps = $request->ctps;
        $planilha->matricula = $request->matricula;
        $planilha->ano = $request->ano;
        $planilha->colaborador()->associate($colaborador);
        $planilha->periodo()->associate($periodo);
        $planilha->tipoPlanilha()->associate($tipoPlanilha);
        $planilha->save();
        return redirect()
            ->action('App\Http\Controllers\PlanilhaController@index')
            ->with('status', "Registrado com sucesso!");
    }


    public function destroy(Request $request, $id)
    {
        dd($request->all(), $id);
    }

    private function validarDuplicidade($request)
    {
        $planilha = Planilha::where('colaborador_id', $request->colaborador_id)
            ->where('ano', $request->ano)
            ->where('periodo_id', $request->periodo_id)
            ->where('tipo_planilha_id', $request->tipo_planilha_id)->count();
        return $planilha;
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'ctps' => 'required|max:20',
                'matricula' => 'required|max:20',
                'ano' => 'required|max:4',
                'periodo_id' => 'required',
                'tipo_planilha_id' => 'required',

            ],
            [
                'ctps.required' => 'Campo obrigatório.',
                'matricula.unique' => 'Campo obrigatório.',
                'ano.required' => 'Campo obrigatório.',
                'periodo.required' => 'Campo obrigatório.',
                'tipo_planilha_id.required' => 'Campo obrigatório.',
            ],
        );
    }
}
