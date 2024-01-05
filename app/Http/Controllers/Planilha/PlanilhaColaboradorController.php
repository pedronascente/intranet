<?php

namespace App\Http\Controllers\Planilha;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Colaborador;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\PlanilhaTipo;
use App\Models\Planilha\PlanilhaStatus;
use App\Models\Planilha\PlanilhaPeriodo;

class PlanilhaColaboradorController extends Controller
{
    private $titulo;
    private $paginate;
    private $planilha;

    public function __construct(Planilha $planilha)
    {
        $this->titulo   = "Planilha de comissão";
        $this->paginate = 10;
        $this->planilha = $planilha;
    }

    /**
     * Exibe a listagem das planilhas de colaboradores.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtém as planilhas com status 1 (Em andamento) e 4 (Aguardando homologação)
        $collection = $this->planilha->whereIn('planilha_status_id', [1, 4])
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);

        return view('planilha.colaborador.index', [
            'titulo'      => $this->titulo,
            'collections' => $collection
        ]);
    }

    /**
     * Exibe o formulário de criação de planilha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if (isset($request->user()->id)) {
            $titulo      = "Cadastrar " . $this->titulo;
            $periodos    = PlanilhaPeriodo::all();
            $tipos       = PlanilhaTipo::all();
            $id          = $request->input('id') ? $request->input('id') : $request->user()->colaborador_id;
            $colaborador = Colaborador::find($id);

            return view(
                'planilha.colaborador.create',
                [
                    'titulo'      => $titulo,
                    'periodos'    => $periodos,
                    'tipos'       => $tipos,
                    'colaborador' => $colaborador,
                ]
            );
        } else {
            return redirect()->route('login.form');
        }
    }

    /**
     * Armazena uma nova planilha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->planilha->rules(), $this->planilha->feedback());

        // Verifica se já existe uma planilha duplicada
        if ($this->validarDuplicidade($request) >= 1) {
            return redirect()
                ->route('planilha-colaborador.index')
                ->with('warning', "Esta planilha já foi criada!");
        }

        $colaborador = Colaborador::findOrFail($request->colaborador_id);
        $periodo     = PlanilhaPeriodo::findOrFail($request->planilha_periodo_id);
        $tipo        = PlanilhaTipo::findOrFail($request->planilha_tipo_id);
        $status      = PlanilhaStatus::findOrFail(1);

        // Associa os modelos e salva a nova planilha
        $this->planilha->colaborador()->associate($colaborador);
        $this->planilha->periodo()->associate($periodo);
        $this->planilha->tipo()->associate($tipo);
        $this->planilha->status()->associate($status);
        $this->planilha->ctps      = $request->ctps;
        $this->planilha->matricula = $request->matricula;
        $this->planilha->ano       = $request->ano;
        $this->planilha->save();

        return redirect()
            ->route('planilha-colaborador.index')
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
        return view(
            'planilha.colaborador.edit',
            [
                'titulo'   => "Editar " . $this->titulo,
                'periodos' => PlanilhaPeriodo::orderBy('nome', 'asc')->get(),
                'tipos'    => PlanilhaTipo::orderBy('id', 'desc')->get(),
                'planilha' => $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id),
            ]
        );
    }

    /**
     * Atualiza os dados de uma planilha existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->planilha->rules(), $this->planilha->feedback());
        $planilha = $this->planilha->findOrFail($id);
        $planilha->update($request->all());

        // Redireciona para a rota apropriada com a mensagem de sucesso
        if (isset($request->formulario) && $request->formulario == 'administrativo') {
            return redirect()
                ->route('planilha-administrativo.index')
                ->with('status', 'Registro atualizado com sucesso.');
        }

        return redirect()
            ->route('planilha-colaborador.index')
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
        $planilha = $this->planilha->findOrFail($id);
        $planilha->delete();

        return redirect()
            ->route('planilha-colaborador.index')
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
            ->route('planilha-colaborador.index')
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
}
