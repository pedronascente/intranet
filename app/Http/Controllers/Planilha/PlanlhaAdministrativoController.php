<?php

namespace App\Http\Controllers\Planilha;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Models\planilha\PlanilhaStatus;
use App\Models\Planilha\PlanilhaPeriodo;
use App\Models\Planilha\Tipo\PlanilhaTipo;

class PlanlhaAdministrativoController extends Controller
{
    private $titulo;
    private $planilha;

    public function __construct(Planilha $planilha)
    {
        $this->titulo = "Planilha";
        $this->planilha = $planilha;
    }

    public function index()
    {
        $collections = $this->planilha->whereIn('planilha_status_id', [3, 5])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('planilha.administrativo.conferir', [
            'titulo'      => $this->titulo . " | Conferir ",
            'collections' => $collections,
        ]);
    }

    public function edit($id)
    {
        $planilha = $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id);

        return view('planilha.administrativo.edit', [
            'titulo'   => "Editar " . $this->titulo,
            'planilha' => $planilha,
            'periodos' => PlanilhaPeriodo::orderBy('nome', 'asc')->get(),
            'tipos'    => PlanilhaTipo::orderBy('id', 'desc')->get(),
            'status'   => PlanilhaStatus::orderBy('id', 'asc')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->planilha->rules(), $this->planilha->feedback());
        $planilha = $this->planilha->findOrFail($id);
        $planilha->update($request->all());
        $routeName = $request->formulario == 'administrativo' ? 'planilha-administrativo.index' : 'planilha-colaborador.index';
        return redirect()->route($routeName)->with('status', 'Registro atualizado com sucesso.');
    }

    public function show(Request $request, $origem)
    {
        $ano           = $request->input('ano');
        $termoPesquisa = $request->input('filtro');
        $whereIn       = $origem == 'conferir' ? [3, 5] : [2];

        $query = $this->planilha->with('colaborador', 'tipo', 'status')
            ->whereIn('planilha_status_id', $whereIn);

        if ($ano) {
            $query->where('ano', '=', $ano);
        }

        if ($termoPesquisa) {
            $this->getTermoPesquisa($query, $termoPesquisa);
        }

        $collections = $query->paginate(10);

        return view('planilha.administrativo.' . $origem, [
            'titulo' => $this->titulo . " | " . ucfirst($origem),
            'collections' => $collections
        ]);
    }

    public function arquivo()
    {
        $collections = $this->planilha->whereIn('planilha_status_id', [2])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('planilha.administrativo.arquivado', [
            'titulo' => $this->titulo . " | Arquivado ",
            'collections' => $collections
        ]);
    }

    public function arquivar($id)
    {
        $this->updateStatus($id, 2, "Planilha Arquivada com sucesso.");
        return redirect()->route('planilha-administrativo.index')->with('status', "Planilha Arquivada com sucesso.");
    }

    public function recuperar($id)
    {
        $this->updateStatus($id, 5, "Planilha Recuperada para Homologação.");
        return redirect()->route('planilha-administrativo.index')->with('status', "Planilha Recuperada para Homologação.");
    }

    public function editReprovar($id)
    {
        return view('planilha.administrativo.edit-reprovar', [
            'titulo'   => "Reprovar " . $this->titulo,
            'planilha' => $this->planilha->findOrFail($id),
        ]);
    }

    public function updateReprovar(Request $request, $id)
    {
        $request->validate($this->planilha->rules_reprovar(), $this->planilha->rules_reprovar());
        $planilha = $this->planilha->findOrFail($id);
        $planilha->update($request->all());

        return redirect()->route('planilha-administrativo.index')->with('status', 'Registro Reprovado com sucesso.');
    }

    public function getValorTotalComissao(Planilha $planilha)
    {
        $tipoPlanilha = optional($planilha->tipo)->formulario;
        if ($tipoPlanilha) {
            $comissaoModel = $this->getComissaoModel($tipoPlanilha);
            $valor = $comissaoModel::where('planilha_id', $planilha->id)->sum('comissao');
            return number_format($valor, 2, ',', '.');
        }

        return 0;
    }

    private function getTermoPesquisa($query, $termoPesquisa)
    {
        $query->where(function ($q) use ($termoPesquisa) {
            $q->whereHas('colaborador', function ($q) use ($termoPesquisa) {
                $q->where('nome', 'like', '%' . $termoPesquisa . '%')
                    ->orWhere('sobrenome', 'like', '%' . $termoPesquisa . '%');
            })
                ->orWhereHas('tipo', function ($q) use ($termoPesquisa) {
                    $q->where('nome', 'like', '%' . $termoPesquisa . '%');
                })
                ->orWhereHas('periodo', function ($q) use ($termoPesquisa) {
                    $q->where('nome', 'like', '%' . $termoPesquisa . '%');
                });
        });
    }

    private function updateStatus($id, $statusId, $message)
    {
        $planilha = $this->planilha->findOrFail($id);
        $planilha->planilha_status_id = $statusId;
        $planilha->update();
    }

    private function getComissaoModel($tipo_planilha)
    {
        $tipo_planilha = ucfirst($tipo_planilha);
        $comissaoModel = 'App\Models\Planilha\Tipo\\' . $tipo_planilha;
        return new $comissaoModel;
    }
}
