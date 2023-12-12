<?php

namespace App\Http\Controllers\Planilha\Tipo;

use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\Meio;
use App\Models\Planilha\Tipo\ServicoAlarme;
use App\Models\Planilha\Tipo\EntregaDeAlarme;
use App\Models\Planilha\Tipo\PortariaVirtual;
use App\Models\Planilha\Tipo\ReclamacaoDeCliente;
use App\Models\Planilha\Tipo\TecnicaDeRastreamento;
use App\Models\Planilha\Tipo\ComercialRastreamentoVeicular;
use App\Models\Planilha\Tipo\SupervisaoComercialRastreamento;
use App\Models\Planilha\Tipo\TecnicaAlarmesCercaEletricaCFTV;
use App\Models\Planilha\Tipo\ComercialAlarmeCercaEletricaCFTV;
use App\Models\Planilha\Tipo\SupervisaoComercialAlarmesCercaEletricaCFTV;
use App\Models\Planilha\Tipo\SupervisaoTecnicaESacAlarmesCercaEletricaCFTV;

class PlanilhaTipoAdministrativoController extends Controller
{
  private $planilha;

  public function __construct(Planilha $planilha)
  {
    $this->planilha = $planilha;
  }

  public function index($id)
  {
    $planilha      = $this->planilha->with('tipo')->findOrFail($id);
    $tipo_planilha = $planilha->tipo->formulario;

    switch ($tipo_planilha) {
      case 'comercialAlarmeCercaEletricaCFTV':
        return view('planilha.tipo.comercialAlarmeCercaEletricaCFTV.administrativo.index', [
          'servico_alarme'     => $this->getServicoAlarme(),
          'meios'              => $this->getMeio(),
          'planilha'           => $planilha,
          'listaComissao'      => ComercialAlarmeCercaEletricaCFTV::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => ComercialAlarmeCercaEletricaCFTV::sum('comissao')->where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'comercialRastreamentoVeicular':
        return view('planilha.tipo.comercialRastreamentoVeicular.administrativo.index', [
          'planilha'            => $planilha,
          'listaComissao'       => ComercialRastreamentoVeicular::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao'  => ComercialRastreamentoVeicular::where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'entregaDeAlarmes':
        return view('planilha.tipo.entregaDeAlarmes.administrativo.index', [
          'planilha'           => $planilha,
          'listaComissao'      => EntregaDeAlarme::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => EntregaDeAlarme::where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'portariaVirtual':
        return view('planilha.tipo.portariaVirtual.administrativo.index', [
          'meios'              => $this->getMeio(),
          'planilha'           => $planilha,
          'listaComissao'      => PortariaVirtual::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => PortariaVirtual::where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'reclamacaoDeCliente':
        return view('planilha.tipo.reclamacaoDeCliente.administrativo.index', [
          'planilha'           => $planilha,
          'listaComissao'      => ReclamacaoDeCliente::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => ReclamacaoDeCliente::where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'supervisaoComercialAlarmesCercaEletricaCFTV':
        return view('planilha.tipo.supervisaoComercialAlarmesCercaEletricaCFTV.administrativo.index', [
          'planilha'           => $planilha,
          'servico_alarme'     => $this->getServicoAlarme(),
          'listaComissao'      => SupervisaoComercialAlarmesCercaEletricaCFTV::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => SupervisaoComercialAlarmesCercaEletricaCFTV::where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'supervisaoComercialRastreamento':
        return view('planilha.tipo.supervisaoComercialRastreamento.administrativo.index', [
          'planilha'           => $planilha,
          'listaComissao'      => SupervisaoComercialRastreamento::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => SupervisaoComercialRastreamento::where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'supervisaoTecnicaESACAlarmesCercaEletricaCFTV':
        return view('planilha.tipo.supervisaoTecnicaESacAlarmesCercaEletricaCFTV.administrativo.index', [
          'planilha'           => $planilha,
          'listaComissao'      => SupervisaoTecnicaESacAlarmesCercaEletricaCFTV::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => SupervisaoTecnicaESacAlarmesCercaEletricaCFTV::where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'tecnicaAlarmesCercaEletricaCFTV':
        $servico_alarme = $this->getServicoAlarme();
        return view('planilha.tipo.tecnicaAlarmesCercaEletricaCFTV.administrativo.index', [
          'planilha'           => $planilha,
          'servico_alarme'     => $servico_alarme,
          'listaComissao'      => TecnicaAlarmesCercaEletricaCFTV::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => TecnicaAlarmesCercaEletricaCFTV::where('planilha_id', $id)->sum('comissao'),
        ]);
      case 'tecnicaDeRastreamento':
        return view('planilha.tipo.tecnicaDeRastreamento.administrativo.index', [
          'planilha'           => $planilha,
          'servico_alarme'     => $this->getServicoAlarme(),
          'listaComissao'      => TecnicaDeRastreamento::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),
          'valorTotalComissao' => TecnicaDeRastreamento::where('planilha_id', $id)->sum('comissao'),
        ]);
      default:
        // Lidar com outros casos ou lançar uma exceção, se necessário
        return null;
    }
  }

  private function getServicoAlarme()
  {
    return ServicoAlarme::all();
  }

  private function getMeio()
  {
    return Meio::all();
  }
}
