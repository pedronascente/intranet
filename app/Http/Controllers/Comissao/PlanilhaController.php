<?php

namespace App\Http\Controllers\Comissao;

use App\Models\User;
use App\Models\Colaborador;
use App\Models\Comissao\Periodo;
use App\Models\Comissao\Planilha;
use App\Models\Comissao\TipoPlanilha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanilhaController extends Controller
{
    private $actionIndex;
    private $paginate;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Planilha";
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\Comissao\PlanilhaController@index';
    }

    public function index()
    {
        $collections = Planilha::where('status', '<>', 'homologar')
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);

        return view('comissao.planilha.index', [
            'titulo' => $this->titulo,
            'collections' => $collections
        ]);
    }

    public function create(Request $request)
    {
        $titulo         = "Cadastrar  " . $this->titulo;
        $periodos       = Periodo::all();
        $tipoPlanilhas  = TipoPlanilha::all();
        $colaborador    = User::with('colaborador')->find($request->user()->id);

        return view(
            'comissao.planilha.create',
            [
                'titulo' => $titulo,
                'periodos' => $periodos,
                'tipoPlanilhas' => $tipoPlanilhas,
                'colaborador' => $colaborador->colaborador,
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->validarDuplicidade($request) >= 1) {
            return redirect()
                ->action($this->actionIndex)
                ->with('warning', "Está planilha já foi criada!");
        }
        $planilha = new Planilha();
        $colaborador    = Colaborador::findOrFail($request->colaborador_id);
        $periodo        = Periodo::findOrFail($request->periodo_id);
        $tipoPlanilha   = TipoPlanilha::findOrFail($request->tipo_planilha_id);

        $planilha->colaborador()->associate($colaborador);
        $planilha->periodo()->associate($periodo);
        $planilha->tipoPlanilha()->associate($tipoPlanilha);
        $planilha->ctps      = $request->ctps;
        $planilha->matricula = $request->matricula;
        $planilha->ano       = $request->ano;
        $planilha->save();

        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $titulo        = "Editar " . $this->titulo;
        $planilha      = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);
        $periodos      = Periodo::orderBy('nome', 'asc')->get();
        $tipoPlanilhas = TipoPlanilha::orderBy('id', 'desc')->get();

        return view(
            'comissao.planilha.edit',
            [
                'titulo' => $titulo,
                'periodos' => $periodos,
                'tipoPlanilhas' => $tipoPlanilhas,
                'planilha' => $planilha,
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $planilha = Planilha::findOrFail($id);
        $planilha->periodo()->associate($request->periodo_id);
        $planilha->colaborador()->associate($request->colaborador_id);
        $planilha->tipoPlanilha()->associate($request->tipo_planilha_id);
        $planilha->ctps      = $request->ctps;
        $planilha->matricula = $request->matricula;
        $planilha->ano       = $request->ano;

        $planilha->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $planilha = Planilha::findOrFail($request->id);
        $planilha->delete();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Excluido!");
    }

    public function homologar($id)
    {
        $planilha         = Planilha::findOrFail($id);
        $planilha->status = 'homologar';
        $planilha->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Planilha encaminhada para homlogação.");
    }

    private function validarDuplicidade($request)
    {
        $planilha = Planilha::where('colaborador_id', $request->colaborador_id)
            ->where('ano', $request->ano)
            ->where('periodo_id', $request->periodo_id)
            ->where('tipo_planilha_id', $request->tipo_planilha_id)
            ->count();
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
