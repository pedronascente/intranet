<?php

namespace App\Http\Controllers\Planilha;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\User;
use App\Models\Colaborador;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\PlanilhaTipo;
use App\Models\planilha\PlanilhaStatus;
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
        $this->planilha =  $planilha;
    }

    /*
        * planilha_status :
        - 1 aberto
        - 2 arquivo
        - 3 Homologação
        - 4 reprovado
        *
    */
    public function index()
    {
        $collection =  $this->planilha->whereIn('planilha_status_id', [1, 4])
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);

        return view('planilha.colaborador.index', [
            'titulo'      => $this->titulo,
            'collections' => $collection
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
                ->route('planilha-colaborador.index')
                ->with('warning', "Está planilha já foi criada!");
        }

        $colaborador = Colaborador::findOrFail($request->colaborador_id);
        $periodo     = PlanilhaPeriodo::findOrFail($request->planilha_periodo_id);
        $tipo        = PlanilhaTipo::findOrFail($request->planilha_tipo_id);
        $statu       = PlanilhaStatus::findOrFail(1);

        $this->planilha->colaborador()->associate($colaborador);
        $this->planilha->periodo()->associate($periodo);
        $this->planilha->tipo()->associate($tipo);
        $this->planilha->status()->associate($statu);

        $this->planilha->ctps      = $request->ctps;
        $this->planilha->matricula = $request->matricula;
        $this->planilha->ano       = $request->ano;
        $this->planilha->save();
        return redirect()
            ->route('planilha-colaborador.index')
            ->with('status', 'Registrado com sucesso.');
    }

    public function edit($id)
    {
        return view(
            'planilha.colaborador.edit',
            [
                'titulo'    => "Editar " . $this->titulo,
                'periodos'  => PlanilhaPeriodo::orderBy('nome', 'asc')->get(),
                'tipos'     => PlanilhaTipo::orderBy('id', 'desc')->get(),
                'planilha'  => $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id),
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->planilha->rules(), $this->planilha->feedback());
        $planilha = $this->planilha->findOrFail($id);
        $planilha->update($request->all());
        if (isset($request->formulario) && $request->formulario == 'administrativo') {
            return redirect()
                ->route('planilha-administrativo.index')
                ->with('status', 'Registro atualizado com sucesso.');
        }
        return redirect()
            ->route('planilha-colaborador.index')
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $planilha = $this->planilha->findOrFail($id);
        $planilha->delete();
        return redirect()
            ->route('planilha-colaborador.index')
            ->with('status', "Registro Excluido!");
    }

    public function homologar($id)
    {
        $planilha = $this->planilha->findOrFail($id);
        $planilha->planilha_status_id = 3;
        $planilha->update();
        return redirect()
            ->route('planilha-colaborador.index')
            ->with('status', "Planilha encaminhada para Homlogação.");
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
