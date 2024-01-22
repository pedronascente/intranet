<?php

namespace App\Http\Controllers\Planilha;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Models\planilha\PlanilhaStatus;
use App\Models\Planilha\PlanilhaPeriodo;
use App\Models\Planilha\Tipo\PlanilhaTipo;

class AdministrativoController extends Controller
{
    private $titulo;
    private $planilha;

    public function __construct(Planilha $planilha)
    {
        $this->titulo   = "Planilha";
        $this->planilha = $planilha;      
    }

    public function index(Request $request )
    {
        $arrayPlanilhaStatusId = [3, 5];
        if($request->query('ano') || $request->query('filtro')){
            $collections = $this->planilha->getPlanilha($request, $arrayPlanilhaStatusId);
        }else{
            $collections = $this->planilha
                ->whereIn('planilha_status_id', $arrayPlanilhaStatusId)
                ->orderBy('id', 'desc') // Ordena as planilhas pelo ID em ordem decrescente
                ->paginate(10); // Paginação para exibir 10 resultados por página
        }
        // Retorna a visão (view) 'planilha.administrativo.conferir' com os dados necessários
        return view('planilha.administrativo.conferir', [
            'titulo'      => "Conferir " . $this->titulo, // Título da página
            'collections' => $collections, // Planilhas a serem exibidas na view
        ]);
    }

    /**
     * Exibe a página de edição para uma planilha específica.
     *
     * @param  int  $id  Identificador da planilha a ser editada.
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        // Obtém a planilha com relacionamentos (colaborador, período, tipo) com base no ID fornecido
        $planilha = $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id);
        // Retorna a visão (view) 'planilha.administrativo.edit' com os dados necessários
        return view('planilha.administrativo.edit', [
            'titulo'   => "Editar " . $this->titulo, // Título da página
            'planilha' => $planilha, // Planilha a ser editada
            'periodos' => PlanilhaPeriodo::orderBy('nome', 'asc')->get(), // Lista de períodos para dropdown
            'tipos'    => PlanilhaTipo::orderBy('id', 'desc')->get(), // Lista de tipos de planilha para dropdown
            'status'   => PlanilhaStatus::orderBy('id', 'asc')->get(), // Lista de status de planilha para dropdown
        ]);
    }

    /**
     * Atualiza uma planilha existente com os dados fornecidos.
     *
     * @param  \Illuminate\Http\Request  $request  Instância da requisição HTTP.
     * @param  int  $id  Identificador da planilha a ser atualizada.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Valida os dados da requisição com base nas regras definidas na model da planilha
        $request->validate($this->planilha->rules(), $this->planilha->feedback());
        // Obtém a planilha existente com base no ID fornecido
        $planilha = $this->planilha->findOrFail($id);
        // Atualiza os dados da planilha com os dados da requisição
        $planilha->update($request->all());
        // Determina o nome da rota para redirecionamento com base no formulário
        $routeName = $request->formulario == 'administrativo' ? 'comissao.administrativo.index' : 'planilha.index';
        // Redireciona para a rota apropriada com uma mensagem de status
        return redirect()->route($routeName)->with('status', 'Registro atualizado com sucesso.');
    }

    public function editReprovar($id)
    {
        return view('planilha.administrativo.edit-reprovar', [
            'titulo'   =>  "Reprovar  " . $this->titulo , // Título da página
            'planilha' => $this->planilha->findOrFail($id), // Planilha a ser reprovada
        ]);
    }

    public function updateReprovar(Request $request, $id)
    {
        // Valida os dados da requisição com base nas regras definidas na model da planilha
        $request->validate($this->planilha->rules_reprovar(), $this->planilha->rules_reprovar());
        // Obtém a planilha existente com base no ID fornecido
        $planilha = $this->planilha->findOrFail($id);
        // Atualiza os dados da planilha com os dados da requisição
        $planilha->update($request->all());
        // Redireciona para a página de listagem de planilhas administrativas
        return redirect()->route('comissao.administrativo.index')->with('status', 'Registro Reprovado com sucesso.');
    }

    public function getValorTotalComissao(Planilha $planilha)
    {
        // Obtém o tipo de planilha associado à planilha (se existir)
        $tipoPlanilha = optional($planilha->tipo)->formulario;
        // Calcula o valor total da comissão com base no tipo de planilha
        if ($tipoPlanilha) {
            $comissaoModel = $this->getComissaoModel($tipoPlanilha);
            $valor = $comissaoModel::where('planilha_id', $planilha->id)->sum('comissao');
            return number_format($valor, 2, ',', '.');
        }
        return 0;
    }

    private function getComissaoModel($tipo_planilha)
    {
        // Formata o tipo de planilha para garantir consistência no namespace
        $tipo_planilha = ucfirst($tipo_planilha);
        // Monta o nome da classe da model de comissão com base no tipo de planilha
        $comissaoModel = 'App\Models\Planilha\Tipo\\' . $tipo_planilha;
        // Retorna uma nova instância da model de comissão
        return new $comissaoModel;
    }

    public function show()
    {
        return redirect()
            ->route('comissao.administrativo.index');
    }
}
