<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use App\Models\Planilha\PlanilhaPeriodo;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\PlanilhaTipo;
use App\Http\Controllers\Comissao\ComissaoController;
use App\Models\planilha\PlanilhaStatus;

class PlanilhaController extends Controller
{
    private $actionIndex;
    private $paginate;
    private $titulo;
    private $comissao;
    private $planilha;

    public function __construct(Planilha $planilha)
    {
        $this->titulo = "Planilha de comissão";
        $this->paginate = 10;
        $this->planilha =  $planilha;
        $this->actionIndex = 'App\Http\Controllers\PlanilhaController@index';
        $this->comissao = new ComissaoController();
    }

    /*
    * COLABORADOR
    */

    public function index()
    {
        $collections = $this->planilha::whereIn('planilha_status_id', [1, 3,4])
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);
        return view('planilha.colaborador.index', [
            'titulo' => $this->titulo,
            'collections' => $collections
        ]);
    }


    public function create(Request $request)
    {
        if (isset($request->user()->id)) {
            $titulo         = "Cadastrar  " . $this->titulo;
            $periodos       = PlanilhaPeriodo::all();
            $tipos          = PlanilhaTipo::all();
            $colaborador    = User::with('colaborador')->find($request->user()->id);
            return view(
                'planilha.colaborador.create',
                [
                    'titulo'      => $titulo,
                    'periodos'    => $periodos,
                    'tipos'       => $tipos,
                    'colaborador' => $colaborador->colaborador,
                ]
            );
        } else {
            return redirect()
                ->route('login.form');
        }
    }

    public function store(Request $request)
    {
        $request->validate($this->planilha->rules(), $this->planilha->feedback());
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
        $planilha      = $this->planilha::with('colaborador', 'periodo', 'tipo')->findOrFail($id);
        $periodos      = PlanilhaPeriodo::orderBy('nome', 'asc')->get();
        $tipos         = PlanilhaTipo::orderBy('id', 'desc')->get();
        return view(
            'planilha.colaborador.edit',
            [
                'titulo'    => $titulo,
                'periodos'  => $periodos,
                'tipos'     => $tipos,
                'planilha'  => $planilha,
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->planilha->rules(), $this->planilha->feedback());
        $planilha = Planilha::findOrFail($id);
        $planilha->update($request->all());
        if (isset($request->formulario) && $request->formulario == 'administrativo') {
            return redirect()
                ->route('planilha.administrativo.index')
                ->with('status', 'Registro atualizado com sucesso.');
        }
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Atualizado com sucesso.");
    }

    public function destroy($id)
    {
        $planilha = Planilha::findOrFail($id);
        $planilha->delete();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Excluido!");
    }

    public function homologar($id)
    {
        $planilha = $this->planilha::findOrFail($id);
        $planilha->planilha_status_id = 2;
        $planilha->update();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Planilha encaminhada para Homlogação.");
    }

    /*
    * ADMNISTRATIVO----------------------------------------------------------------------
    */

    public function indexAdministrativo()
    {
        $collections = $this->planilha::whereIn('planilha_status_id', [1, 2])
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);
        return view('planilha.administrativo.index', [
            'titulo' => "Conferir " . $this->titulo,
            'collections' => $collections
        ]);
    }

    public function  editAdministrativo($id)
    {
        $titulo        = "Editar " . $this->titulo;
        $planilha      = $this->planilha::with('colaborador', 'periodo', 'tipo')->findOrFail($id);
        $periodos      = PlanilhaPeriodo::orderBy('nome', 'asc')->get();
        $tipos         = PlanilhaTipo::orderBy('id', 'desc')->get();
        $status         = PlanilhaStatus::orderBy('id', 'desc')->get();
        return view(
            'planilha.administrativo.edit',
            [
                'titulo' => $titulo,
                'planilha' => $planilha,
                'periodos' => $periodos,
                'tipos' => $tipos,
                'status' => $status,
            ]
        );
    }

    public function storeAdministrativo(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->validarDuplicidade($request) >= 1) {
            return redirect()
                ->route('planilha.administrativo.index')
                ->with('warning', "Está planilha já foi criada!");
        }
        $this->salvar($request);
        return redirect()
            ->route('planilha.administrativo.index')
            ->with('status', 'Registrado com sucesso.');
    }
    public function detalhePlanilha($id)
    {
        $comissao = $this->comissao->indexAdmnistrativo($id);
        return view('planilha.administrativo.detalhes', $comissao);
    }

    public function createNovoColaborador($id)
    {
        $titulo         = "Cadastrar  " . $this->titulo;
        $periodos       = PlanilhaPeriodo::all();
        $tipos  = PlanilhaTipo::all();
        $colaborador    = User::with('colaborador')->find($id);

        return view(
            'planilha.colaborador.create',
            [
                'titulo' => $titulo,
                'periodos' => $periodos,
                'tipos' => $tipos,
                'colaborador' => $colaborador->colaborador,
            ]
        );
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
        $colaborador = Colaborador::findOrFail($request->colaborador_id);
        $periodo     = PlanilhaPeriodo::findOrFail($request->planilha_periodo_id);
        $tipo        = PlanilhaTipo::findOrFail($request->planilha_tipo_id);
        $statu       = PlanilhaStatus::findOrFail(4);

        $this->planilha->colaborador()->associate($colaborador);
        $this->planilha->periodo()->associate($periodo);
        $this->planilha->tipo()->associate($tipo);
        $this->planilha->status()->associate($statu);

        $this->planilha->ctps      = $request->ctps;
        $this->planilha->matricula = $request->matricula;
        $this->planilha->ano       = $request->ano;
        $this->planilha->save();
    }

    private function validarDuplicidade($request)
    {
        $planilha = Planilha::where('colaborador_id', $request->colaborador_id)
            ->where('ano', $request->ano)
            ->where('planilha_periodo_id', $request->planilha_periodo_id)
            ->where('planilha_tipo_id', $request->planilha_tipo_id)
            ->count();
        return $planilha;
    }
}









    /*
    public function createAdministrativo(Request $request)
    {
        $titulo         = "Cadastrar " . $this->titulo;
        $periodos       = Periodo::all();
        $tipos  = PlanilhaTipo::all();
        $colaborador    = User::with('colaborador')->find($request->user()->id);

        return view(
            'planilha.administrativo.create',
            [
                'titulo' => $titulo,
                'periodos' => $periodos,
                'tipos' => $tipos,
                'colaborador' => $colaborador->colaborador,
            ]
        );
    }



    */

/*


private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'ctps' => 'required|max:20',
                'matricula' => 'required|max:20',
                'ano' => 'required|max:4',
                'planilha_periodo_id' => 'exists:planilha_periodos,id',
                'planilha_tipo_id' => 'exists:planilha_tipos,id',
            ],
            [
                'ctps.required' => 'Campo obrigatório.',
                'matricula.unique' => 'Campo obrigatório.',
                'ano.required' => 'Campo obrigatório.',
                'planilha_periodo_id.exists' => 'O Periodo informado não existe.',
                'planilha_tipo_id.exists' => 'O Tipo de planilha informado não existe.',
            ],
        );
    }

*/