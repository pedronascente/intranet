<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use App\Models\Planilha\Periodo;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\TipoPlanilha;
use App\Http\Controllers\Comissao\ComissaoController;

class PlanilhaController extends Controller
{
    private $actionIndex;
    private $paginate;
    private $titulo;
    private $comissao;

    public function __construct()
    {
        $this->titulo = "Planilha de comissão";
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\PlanilhaController@index';
        $this->comissao = new ComissaoController();
    }

    /*
    * COLABORADOR
    */

    public function index()
    {
        $collections = Planilha::where('status', '<>', 'homologar')
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);

        return view('planilha.colaborador.index', [
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
            'planilha.colaborador.create',
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

        $this->salvar($request);

        return redirect()
            ->route('planilha.index')
            ->with('status', 'Registrado com sucesso.');
    }

    public function edit($id)
    {
        $titulo        = "Editar " . $this->titulo;
        $planilha      = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);
        $periodos      = Periodo::orderBy('nome', 'asc')->get();
        $tipoPlanilhas = TipoPlanilha::orderBy('id', 'desc')->get();

        return view(
            'planilha.colaborador.edit',
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

    /*
    * ADMNISTRATIVO
    */

    public function indexAdministrativo()
    {
        $collections = Planilha::whereIn('status', ['homologar', 'reprovado'])
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);

        return view('planilha.administrativo.index', [
            'titulo' => "Conferir " . $this->titulo,
            'collections' => $collections
        ]);
    }

    public function createAdministrativo(Request $request)
    {
        $titulo         = "Cadastrar " . $this->titulo;
        $periodos       = Periodo::all();
        $tipoPlanilhas  = TipoPlanilha::all();
        $colaborador    = User::with('colaborador')->find($request->user()->id);

        return view(
            'planilha.administrativo.create',
            [
                'titulo' => $titulo,
                'periodos' => $periodos,
                'tipoPlanilhas' => $tipoPlanilhas,
                'colaborador' => $colaborador->colaborador,
            ]
        );
    }

    public function storeAdministrativo(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->validarDuplicidade($request) >= 1) {
            return redirect()
                ->route('planilha.administrativo.conferir')
                ->with('warning', "Está planilha já foi criada!");
        }
        $this->salvar($request);
        return redirect()
            ->route('planilha.administrativo.conferir')
            ->with('status', 'Registrado com sucesso.');
    }
    public function detalhePlanilha($id)
    {
        $comissao = $this->comissao->indexAdmnistrativo($id);

        //dd($comissao);

        return view('planilha.administrativo.detalhes', $comissao);
    }

    public function  editAdministrativo($id)
    {
        $titulo        = "Editar " . $this->titulo;
        $planilha      = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);
        $periodos      = Periodo::orderBy('nome', 'asc')->get();
        $tipoPlanilhas = TipoPlanilha::orderBy('id', 'desc')->get();

        return view(
            'planilha.administrativo.edit',
            [
                'titulo' => $titulo,
                'periodos' => $periodos,
                'tipoPlanilhas' => $tipoPlanilhas,
                'planilha' => $planilha,
            ]
        );
    }

    /*
    public function createNovoColaborador($id)
    {
        $titulo         = "Cadastrar  " . $this->titulo;
        $periodos       = Periodo::all();
        $tipoPlanilhas  = TipoPlanilha::all();
        $colaborador    = User::with('colaborador')->find($id);

        return view(
            'planilha.colaborador.create',
            [
                'titulo' => $titulo,
                'periodos' => $periodos,
                'tipoPlanilhas' => $tipoPlanilhas,
                'colaborador' => $colaborador->colaborador,
            ]
        );
    }

    

    */

    public function homologar($id)
    {
        $planilha         = Planilha::findOrFail($id);
        $planilha->status = 'homologar';
        $planilha->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Planilha encaminhada para homlogação.");
    }

    public function createPesquisarColaborador()
    {
        $titulo = "Pesquisar Colaborador";
        return view('planilha.supervisor.pesquisar', ['titulo' => $titulo,]);
    }

    public function resultadoPesquisaColaborador(Request $request)
    {
        $titulo = "Pesquisar Colaborador";
        $termoPesquisa = $request->input('filtro');

        if ($termoPesquisa) {
            // Realizar a consulta usando o filtro 'like'
            $colaboradores = Colaborador::where('nome', 'like', '%' . $termoPesquisa . '%')
                ->orWhere('sobrenome', 'like', '%' . $termoPesquisa . '%')
                ->get();
        } else {
            // Se nenhum termo de pesquisa foi fornecido, retornar todos os colaboradores
            $colaboradores = Colaborador::all();
        }

        // Retornar a view com os resultados da pesquisa
        return view('planilha.supervisor.resultado', [
            'colaboradores' => $colaboradores,
            'titulo' => $titulo,
        ]);
    }



    private function salvar($request)
    {

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
                'periodo_id' => 'exists:periodos,id',
                'tipo_planilha_id' => 'exists:tipo_planilhas,id',
            ],
            [
                'ctps.required' => 'Campo obrigatório.',
                'matricula.unique' => 'Campo obrigatório.',
                'ano.required' => 'Campo obrigatório.',
                'periodo_id.exists' => 'O Periodo informado não existe.',
                'tipo_planilha_id.exists' => 'O Tipo de planilha informado não existe.',
            ],
        );
    }
}
