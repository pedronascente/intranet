<?php

namespace App\Http\Controllers\Planilha;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Models\Planilha\PlanilhaPeriodo;
use App\Models\planilha\PlanilhaStatus;
use App\Models\Planilha\Tipo\PlanilhaTipo;

/**
 * Controlador para manipulação das operações administrativas relacionadas às planilhas de comissão.
 */
class PlanlhaAdministrativoController extends Controller
{
    private $titulo;
    private $planilha;

    /**
     * Construtor do controlador.
     *
     * @param Planilha $planilha
     */
    public function __construct(Planilha $planilha)
    {
        $this->titulo   = "Planilha de comissão";
        $this->planilha =  $planilha;
    }

    /**
     * Exibe a página inicial para conferência de planilhas de comissões.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('planilha.administrativo.index', [
            'titulo'      => "Conferir Planilha de comissões",
            'collections' => $this->planilha->whereIn('planilha_status_id', [3, 5])
                ->orderBy('id', 'desc')
                ->paginate(10)
        ]);
    }

    /**
     * Exibe a página de edição de uma planilha.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function  edit($id)
    {
        return view(
            'planilha.administrativo.edit',
            [
                'titulo'   => "Editar " . $this->titulo,
                'planilha' => $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id),
                'periodos' => PlanilhaPeriodo::orderBy('nome', 'asc')->get(),
                'tipos'    => PlanilhaTipo::orderBy('id', 'desc')->get(),
                'status'   => PlanilhaStatus::orderBy('id', 'asc')->get(),
            ]
        );
    }

    /**
     * Atualiza os dados de uma planilha.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Aplica filtros para pesquisa de planilhas.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filtro(Request $request)
    {
        $ano = $request->input('ano');
        $termoPesquisa = $request->input('filtro');
        if ($ano) {
            $query = $this->planilha->with('colaborador', 'tipo', 'status')
                ->whereIn('planilha_status_id', [3, 5])
                ->where('ano', '=', $ano);
        } else {
            $query = $this->planilha->with('colaborador', 'tipo', 'status')
                ->whereIn('planilha_status_id', [3, 5]);
        }

        if ($termoPesquisa) {
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
        // Adicionando paginação com um número fixo de itens por página (por exemplo, 10 itens por página)
        $colaboradores = $query->paginate(10);
        return view('planilha.administrativo.index', [
            'titulo' => $this->titulo,
            'collections' => $colaboradores
        ]);
    }

    /**
     * Exibe a página para gerenciamento de planilhas no status "Arquivo".
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function arquivo()
    {
        return view('planilha.administrativo.arquivo', [
            'titulo'      => "Arquivo",
            'collections' => $this->planilha->whereIn('planilha_status_id', [2])
                ->orderBy('id', 'desc')
                ->paginate(10)
        ]);
    }


    /**
     * Arquiva uma planilha .
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function arquivar($id)
    {
        $planilha = $this->planilha->findOrFail($id);
        $planilha->planilha_status_id = 2;
        $planilha->update();
        return redirect()
            ->route('planilha-administrativo.index')
            ->with('status', "Planilha Arquivado com sucesso.");
    }

    /**
     * Recupera uma planilha para homologação.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recuperar($id)
    {
        $planilha = $this->planilha->findOrFail($id);
        $planilha->planilha_status_id = 5;
        $planilha->update();
        return redirect()
            ->route('planilha-administrativo.index')
            ->with('status', "Planilha Recuperada para Homologação.");
    }

    /**
     * Exibe a página de edição para reprovar uma planilha.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function  editReprovar($id)
    {
        return view(
            'planilha.administrativo.edit-reprovar',
            [
                'titulo'   => "Reprovar " . $this->titulo,
                'planilha' => $this->planilha->findOrFail($id),
            ]
        );
    }

    /**
     * Atualiza os dados de uma planilha após reprovação.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateReprovar(Request $request, $id)
    {
        $request->validate($this->planilha->rules_reprovar(), $this->planilha->rules_reprovar());
        $planilha = $this->planilha->findOrFail($id);
        $planilha->update($request->all());
        return redirect()
            ->route('planilha-administrativo.index')
            ->with('status', 'Registro Reprovado com sucesso.');
    }
}
