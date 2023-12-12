<?php

namespace App\Http\Controllers\Planilha;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Models\Planilha\PlanilhaPeriodo;
use App\Models\Planilha\Tipo\PlanilhaTipo;
use App\Models\planilha\PlanilhaStatus;

class PlanlhaAdministrativoController extends Controller
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

    public function index()
    {
        return view('planilha.administrativo.index', [
            'titulo'      => $this->titulo,
            'collections' => $this->planilha->whereIn('planilha_status_id', [2])
                ->orderBy('id', 'desc')
                ->paginate($this->paginate)
        ]);
    }

    public function  edit($id)
    {
        $titulo        = "Editar " . $this->titulo;
        $planilha      = $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id);
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
}


/*

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
            ->route('planilha-administrativo.index')
            ->with('status', 'Registrado com sucesso.');
    }
    public function detalhePlanilha($id)
    {
        $comissao = $this->indexAdmnistrativo($id);
        return view('planilha.administrativo.detalhes', $comissao);
    }

    public function wdw($id)
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

    public function filtro()
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
    public function indexAdmnistrativo($id)
    {
        $planilha = Planilha::with('colaborador', 'periodo', 'tipo')->findOrFail($id);
        $comissoes = $this->getComissoes($planilha->tipo->formulario, $id);
        $data = [
            'planilha' => $planilha,
            'listaComissao' => $comissoes,
        ];
        return $data;
    }
*/