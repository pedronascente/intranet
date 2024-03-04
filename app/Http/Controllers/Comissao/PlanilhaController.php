<?php

namespace App\Http\Controllers\Comissao;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Colaborador\Colaborador;
use App\Models\Comissao\Planilha;
use App\Models\Comissao\Planilhas\PlanilhaTipo;
use App\Models\Comissao\PlanilhaStatus;
use App\Models\Comissao\PlanilhaPeriodo;
class PlanilhaController extends Controller
{
    private $paginate;
    private $planilha;
    private $arrayListPermissoesDoModuloDaRota;

    public function __construct(Planilha $planilha)
    {
        $this->paginate = 10;
        $this->planilha = $planilha;
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $colaborador_id = $request->user()->colaborador_id; 
        $titulo = "Lançar Comisssão";
        $arrayListPlanilhasEmAndamentoEaguardandoHomologacao = $this->planilha->where('colaborador_id', $colaborador_id)->whereIn('planilha_status_id', [1, 4])->orderBy('id', 'desc')->paginate($this->paginate);
        return view('comissao.planilha.index', [
            'titulo' => $titulo,
            'arrayListPlanilha' => $arrayListPlanilhasEmAndamentoEaguardandoHomologacao,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create(Request $request)
    {
        if (!in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            return redirect()->route('planilha.index')->with('error', "Você não tem permissão de cadastro.");
        } 

        $titulo = "Cadastrar Planilha";
        $periodos = PlanilhaPeriodo::all();
        $tipos = PlanilhaTipo::all();
        $colaborador = $this->getNomeColaborador($request);

        return view('comissao.planilha.create',[
            'titulo' => $titulo,
            'periodos' => $periodos,
            'tipos' => $tipos,
            'colaborador' => $colaborador,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->planilha->rules(), $this->planilha->feedback());
        // Verifica se já existe uma planilha duplicada
        if ($this->validarDuplicidade($request) >= 1) {
            return redirect()->route('planilha.index')->with('warning', "Esta planilha já foi criada!");
        }
        $colaborador = Colaborador::findOrFail($request->colaborador_id);
        $periodo = PlanilhaPeriodo::findOrFail($request->planilha_periodo_id);
        $tipo = PlanilhaTipo::findOrFail($request->planilha_tipo_id);
        $status = PlanilhaStatus::findOrFail(1);
        // Associa os modelos e salva a nova planilha
        $this->planilha->colaborador()->associate($colaborador);
        $this->planilha->periodo()->associate($periodo);
        $this->planilha->tipo()->associate($tipo);
        $this->planilha->status()->associate($status);
        $this->planilha->ctps = $request->ctps;
        $this->planilha->matricula = $colaborador->numero_matricula;
        $this->planilha->ano = $request->ano;
        $this->planilha->save();
        return redirect()
            ->route('planilha.index')
            ->with('status', 'Registrado com sucesso.');
    }

    /**
     * Exibe o formulário de edição de planilha.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (!in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
            return redirect()->route('planilha.index')->with('error', "Você não tem permissão de edição.");
        } 
        return view('comissao.planilha.edit',[
            'titulo' => "Editar Planilha",
            'periodos' => PlanilhaPeriodo::orderBy('nome', 'asc')->get(),
            'tipos' => PlanilhaTipo::orderBy('id', 'desc')->get(),
            'planilha' => $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->planilha->rules(), $this->planilha->feedback());
        $planilha = $this->planilha->findOrFail($id);
        $planilha->update($request->all());
        // Redireciona para a rota apropriada com a mensagem de sucesso
        if (isset($request->formulario) && $request->formulario == 'administrativo') {
            return redirect()
                ->route('comissao.administrativo.index')
                ->with('status', 'Registro atualizado com sucesso.');
        }
        return redirect()
            ->route('planilha.index')
            ->with('status', 'Registro atualizado com sucesso.');
    }

    /**
     * Exclui uma planilha.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
            return redirect()->route('planilha.index')->with('error', "Você não tem permissão de exclusão.");
        } 
        $planilha = $this->planilha->findOrFail($id);
        $planilha->delete();
        return redirect()
            ->route('planilha.index')
            ->with('status', "Registro Excluído!");
    }

    /**
     * Altera o status de uma planilha para "Homologada".
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function homologar($id)
    {
        $planilha = $this->planilha->findOrFail($id);
        $planilha->planilha_status_id = 3; // ID do status "Homologada"
        $planilha->update();
        return redirect()
            ->route('planilha.index')
            ->with('status', "Planilha encaminhada para Homologação.");
    }

    /**
     * Valida a duplicidade de uma planilha com base nos parâmetros fornecidos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    private function validarDuplicidade($request)
    {
        return Planilha::where('colaborador_id', $request->colaborador_id)
            ->where('ano', $request->ano)
            ->where('planilha_periodo_id', $request->planilha_periodo_id)
            ->where('planilha_tipo_id', $request->planilha_tipo_id)
            ->count();
    }

    private function getNomeColaborador($request){
        if (!isset($request->user()->id)) {
            return redirect()->route('login.form');
        }
        $id = $request->input('id') ? $request->input('id'): $request->user()->colaborador_id;
        $colaborador = Colaborador::find($id);
        return $colaborador;
    }

    public function show($id)
    {
        return redirect()->route('planilha.index');
    }
}
