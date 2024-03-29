<?php

namespace App\Http\Controllers\Comissao\Administrativo;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Models\Comissao\Planilhas\Meio;
use App\Http\Controllers\Controller;
use App\Models\Comissao\PlanilhaStatus;
use App\Models\Comissao\PlanilhaPeriodo;
use App\Models\Comissao\Planilhas\PlanilhaTipo;
use App\Models\Comissao\Planilhas\ServicoAlarme;
use App\Models\Comissao\Planilhas\PortariaVirtual;
use App\Models\Comissao\Planilhas\EntregaDeAlarmes;
use App\Models\Comissao\Planilhas\ReclamacaoDeCliente;
use App\Models\Comissao\Planilhas\TecnicaDeRastreamento;
use App\Models\Comissao\Planilhas\ComercialRastreamentoVeicular;
use App\Models\Comissao\Planilhas\SupervisaoComercialRastreamento;
use App\Models\Comissao\Planilhas\TecnicaAlarmesCercaEletricaCFTV;
use App\Models\Comissao\Planilhas\ComercialAlarmeCercaEletricaCFTV;
use App\Models\Comissao\Planilhas\SupervisaoComercialAlarmesCercaEletricaCFTV;
use App\Models\Comissao\Planilhas\SupervisaoTecnicaESacAlarmesCercaEletricaCFTV;

class AdministrarComissaoController extends Controller
{
    private $planilha;

    public function __construct(Planilha $planilha)
    {
        $this->planilha = $planilha;      
    }

    public function index(Request $request )
    {
        $arrayPlanilhaStatusId = [3, 5];
        if($request->query('ano') || $request->query('filtro')){
            $arrayListPlanilhas = $this->planilha->getPlanilha($request, $arrayPlanilhaStatusId);
        }else{
            $arrayListPlanilhas = $this->planilha
                ->whereIn('planilha_status_id', $arrayPlanilhaStatusId)
                ->orderBy('id', 'desc') 
                ->paginate(10); 
        }
        return view('comissao.administrativo.conferir', [
            'titulo' => "Administrar Comissão",
            'arrayListPlanilhas' => $arrayListPlanilhas, 
        ]);
    }

    public function edit($id)
    {
        return view('comissao.administrativo.edit', [
            'titulo'   => "Editar Planilha", 
            'planilha' => $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id), 
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
        $routeName = $request->formulario == 'administrativo' ? 'comissao.administrativo.index' : 'planilha.index';
        return redirect()->route($routeName)->with('status', 'Registro atualizado com sucesso.');
    }

    public function editReprovar($id)
    {
        return view('comissao.administrativo.edit-reprovar', [
            'titulo'=>  "Reprovar Planilha", 
            'planilha' => $this->planilha->findOrFail($id), 
        ]);
    }

    public function updateReprovar(Request $request, $id)
    {
        $request->validate($this->planilha->rules_reprovar(), $this->planilha->rules_reprovar());
        $planilha = $this->planilha->findOrFail($id);
        $planilha->update($request->all());
        return redirect()->route('comissao.administrativo.index')->with('status', 'Registro Reprovado com sucesso.');
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

    private function getComissaoModel($tipo_planilha)
    {
        $tipo_planilha = ucfirst($tipo_planilha);
        $comissaoModel = 'App\Models\Comissao\Planilhas\\' . $tipo_planilha;
        return new $comissaoModel;
    }

    public function show()
    {
        return redirect()->route('comissao.administrativo.index');
    }

    /*
     * Usuário administrativo:
    */
    public function editarComissaoAdministrativo($planilha,$comissao)
    {
        $id = $comissao;
        $meio = Meio::all();
        $planilha = $this->planilha->with('tipo')->findOrFail($planilha);
        $servico_alarme = ServicoAlarme::all();
        
        if($planilha->tipo->formulario == 'comercialAlarmeCercaEletricaCFTV'){
            $titulo   = $planilha->tipo->nome;
            $comissao = ComercialAlarmeCercaEletricaCFTV::findOrFail($id);
            $pageView = 'comissao.planilhas.comercialAlarmeCercaEletricaCFTV.administrativo.edit';
        }else if($planilha->tipo->formulario == 'comercialRastreamentoVeicular'){
            $titulo   = $planilha->tipo->nome;
            $comissao = ComercialRastreamentoVeicular::findOrFail($id);
            $pageView = 'comissao.planilhas.comercialRastreamentoVeicular.administrativo.edit';
        }else if($planilha->tipo->formulario == 'entregaDeAlarmes'){
            $titulo   = $planilha->tipo->nome;
            $comissao = EntregaDeAlarmes::findOrFail($id);
            $pageView = 'comissao.planilhas.entregaDeAlarmes.administrativo.edit';
        }else if($planilha->tipo->formulario == 'portariaVirtual'){
            $titulo   = $planilha->tipo->nome;
            $comissao = PortariaVirtual::findOrFail($id);
            $pageView = 'comissao.planilhas.portariaVirtual.administrativo.edit';
        }else if($planilha->tipo->formulario == 'reclamacaoDeCliente'){
            $titulo   = $planilha->tipo->nome;
            $comissao = ReclamacaoDeCliente::findOrFail($id);
            $pageView = 'comissao.planilhas.reclamacaoDeCliente.administrativo.edit';
        }else if($planilha->tipo->formulario == 'supervisaoComercialAlarmesCercaEletricaCFTV'){
            $titulo   = $planilha->tipo->nome;
            $comissao = SupervisaoComercialAlarmesCercaEletricaCFTV::findOrFail($id);
            $pageView = 'comissao.planilhas.supervisaoComercialAlarmesCercaEletricaCFTV.administrativo.edit';
        }else if($planilha->tipo->formulario == 'supervisaoComercialRastreamento'){
            $titulo   = $planilha->tipo->nome;
            $comissao = SupervisaoComercialRastreamento::findOrFail($id);
            $pageView = 'comissao.planilhas.supervisaoComercialRastreamento.administrativo.edit';
        }else if($planilha->tipo->formulario == 'supervisaoTecnicaESACAlarmesCercaEletricaCFTV'){
            $titulo   = $planilha->tipo->nome;
            $comissao = SupervisaoTecnicaESacAlarmesCercaEletricaCFTV::findOrFail($id);
            $pageView = 'comissao.planilhas.supervisaoTecnicaESACAlarmesCercaEletricaCFTV.administrativo.edit';
        }else if($planilha->tipo->formulario == 'tecnicaAlarmesCercaEletricaCFTV'){
            $titulo   = $planilha->tipo->nome;
            $comissao = TecnicaAlarmesCercaEletricaCFTV::findOrFail($id);
            $pageView = 'comissao.planilhas.tecnicaAlarmesCercaEletricaCFTV.administrativo.edit';
        }else if($planilha->tipo->formulario == 'tecnicaDeRastreamento'){
            $titulo   = $planilha->tipo->nome;
            $comissao = TecnicaDeRastreamento::findOrFail($id);
            $pageView = 'comissao.planilhas.tecnicaDeRastreamento.administrativo.edit';
        }
       
        return view($pageView, [
            'titulo'         => $titulo,
            'comissao'       => $comissao,
            'servico_alarme' => $servico_alarme,
            'meio'           => $meio,
        ]);
    }
}
