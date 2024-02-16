<?php

namespace App\Http\Controllers\Comissao;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Models\Comissao\Tipo\Meio;
use App\Http\Controllers\Controller;
use App\Models\Comissao\PlanilhaStatus;
use App\Models\Comissao\PlanilhaPeriodo;
use App\Models\Comissao\Tipo\PlanilhaTipo;
use App\Models\Comissao\Tipo\ServicoAlarme;
use App\Models\Comissao\Tipo\PortariaVirtual;
use App\Models\Comissao\Tipo\EntregaDeAlarmes;
use App\Models\Comissao\Tipo\ReclamacaoDeCliente;
use App\Models\Comissao\Tipo\TecnicaDeRastreamento;
use App\Models\Comissao\Tipo\ComercialRastreamentoVeicular;
use App\Models\Comissao\Tipo\SupervisaoComercialRastreamento;
use App\Models\Comissao\Tipo\TecnicaAlarmesCercaEletricaCFTV;
use App\Models\Comissao\Tipo\ComercialAlarmeCercaEletricaCFTV;
use App\Models\Comissao\Tipo\SupervisaoComercialAlarmesCercaEletricaCFTV;
use App\Models\Comissao\Tipo\SupervisaoTecnicaESacAlarmesCercaEletricaCFTV;

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
                ->orderBy('id', 'desc') 
                ->paginate(10); 
        }
        return view('planilha.administrativo.conferir', [
            'titulo'      => "Conferir " . $this->titulo, 
            'collections' => $collections, 
        ]);
    }

    public function edit($id)
    {
        $planilha = $this->planilha->with('colaborador', 'periodo', 'tipo')
                         ->findOrFail($id);
       
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
        $routeName = $request->formulario == 'administrativo' ? 'comissao.administrativo.index' : 'planilha.index';
        return redirect()->route($routeName)->with('status', 'Registro atualizado com sucesso.');
    }

    public function editReprovar($id)
    {
        return view('planilha.administrativo.edit-reprovar', [
            'titulo'   =>  "Reprovar  " . $this->titulo , 
            'planilha' => $this->planilha->findOrFail($id), 
        ]);
    }

    public function updateReprovar(Request $request, $id)
    {
        $request->validate($this->planilha->rules_reprovar(), $this->planilha->rules_reprovar());
        $planilha = $this->planilha->findOrFail($id);
        $planilha->update($request->all());
        return redirect()
                    ->route('comissao.administrativo.index')
                    ->with('status', 'Registro Reprovado com sucesso.');
    }

    public function getValorTotalComissao(Planilha $planilha)
    {
        $tipoPlanilha = optional($planilha->tipo)->formulario;
        if ($tipoPlanilha) {
            $comissaoModel = $this->getComissaoModel($tipoPlanilha);
            $valor         = $comissaoModel::where('planilha_id', $planilha->id)->sum('comissao');
            return number_format($valor, 2, ',', '.');
        }
        return 0;
    }

    private function getComissaoModel($tipo_planilha)
    {
        $tipo_planilha = ucfirst($tipo_planilha);
        $comissaoModel = 'App\Models\Comissao\Tipo\\' . $tipo_planilha;
        return new $comissaoModel;
    }

    public function show()
    {
        return redirect()
            ->route('comissao.administrativo.index');
    }

    /*
     * Usuário administrativo:
    */
    public function editarComissaoAdministrativo($planilha,$comissao)
    {
        $id             = $comissao;
        $meio           = Meio::all();
        $planilha       = $this->planilha->with('tipo')->findOrFail($planilha);
        $servico_alarme = ServicoAlarme::all();
        
        if($planilha->tipo->formulario == 'comercialAlarmeCercaEletricaCFTV'){
            $titulo   = $planilha->tipo->nome;
            $comissao = ComercialAlarmeCercaEletricaCFTV::findOrFail($id);
            $pageView = 'planilha.tipo.comercialAlarmeCercaEletricaCFTV.administrativo.edit';
        }else if($planilha->tipo->formulario == 'comercialRastreamentoVeicular'){
            $titulo   = $planilha->tipo->nome;
            $comissao = ComercialRastreamentoVeicular::findOrFail($id);
            $pageView = 'planilha.tipo.comercialRastreamentoVeicular.administrativo.edit';
        }else if($planilha->tipo->formulario == 'entregaDeAlarmes'){
            $titulo   = $planilha->tipo->nome;
            $comissao = EntregaDeAlarmes::findOrFail($id);
            $pageView = 'planilha.tipo.entregaDeAlarmes.administrativo.edit';
        }else if($planilha->tipo->formulario == 'portariaVirtual'){
            $titulo   = $planilha->tipo->nome;
            $comissao = PortariaVirtual::findOrFail($id);
            $pageView = 'planilha.tipo.portariaVirtual.administrativo.edit';
        }else if($planilha->tipo->formulario == 'reclamacaoDeCliente'){
            $titulo   = $planilha->tipo->nome;
            $comissao = ReclamacaoDeCliente::findOrFail($id);
            $pageView = 'planilha.tipo.reclamacaoDeCliente.administrativo.edit';
        }else if($planilha->tipo->formulario == 'supervisaoComercialAlarmesCercaEletricaCFTV'){
            $titulo   = $planilha->tipo->nome;
            $comissao = SupervisaoComercialAlarmesCercaEletricaCFTV::findOrFail($id);
            $pageView = 'planilha.tipo.supervisaoComercialAlarmesCercaEletricaCFTV.administrativo.edit';
        }else if($planilha->tipo->formulario == 'supervisaoComercialRastreamento'){
            $titulo   = $planilha->tipo->nome;
            $comissao = SupervisaoComercialRastreamento::findOrFail($id);
            $pageView = 'planilha.tipo.supervisaoComercialRastreamento.administrativo.edit';
        }else if($planilha->tipo->formulario == 'supervisaoTecnicaESACAlarmesCercaEletricaCFTV'){
            $titulo   = $planilha->tipo->nome;
            $comissao = SupervisaoTecnicaESacAlarmesCercaEletricaCFTV::findOrFail($id);
            $pageView = 'planilha.tipo.supervisaoTecnicaESACAlarmesCercaEletricaCFTV.administrativo.edit';
        }else if($planilha->tipo->formulario == 'tecnicaAlarmesCercaEletricaCFTV'){
            $titulo   = $planilha->tipo->nome;
            $comissao = TecnicaAlarmesCercaEletricaCFTV::findOrFail($id);
            $pageView = 'planilha.tipo.tecnicaAlarmesCercaEletricaCFTV.administrativo.edit';
        }else if($planilha->tipo->formulario == 'tecnicaDeRastreamento'){
            $titulo   = $planilha->tipo->nome;
            $comissao = TecnicaDeRastreamento::findOrFail($id);
            $pageView = 'planilha.tipo.tecnicaDeRastreamento.administrativo.edit';
        }
       
        return view($pageView, [
            'titulo'         => $titulo,
            'comissao'       => $comissao,
            'servico_alarme' => $servico_alarme,
            'meio'           => $meio,
        ]);
    }
}
