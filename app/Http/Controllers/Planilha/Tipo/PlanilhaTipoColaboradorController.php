<?php

namespace App\Http\Controllers\Planilha\Tipo;

use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\Meio;
use App\Models\Planilha\Tipo\ServicoAlarme;

class PlanilhaTipoColaboradorController extends Controller
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

    return $this->getViewWithComissaoData($tipo_planilha, $planilha, $this->getComissaoModel($tipo_planilha));
  }

  /**
   * Obtém uma instância do modelo de comissão com base no tipo de planilha.
   *
   * @param string $tipo_planilha
   * @return \Illuminate\Database\Eloquent\Model
   */
  private function getComissaoModel($tipo_planilha)
  {
    // Converter a primeira letra para maiúscula
    $tipo_planilha = ucfirst($tipo_planilha);

    // Formar o nome completo da classe
    $comissaoModel = 'App\Models\Planilha\Tipo\\' . $tipo_planilha;

    return new $comissaoModel;
  }

  /**
   * Retorna a vista com os dados de comissão para o tipo de planilha especificado.
   *
   * @param string $tipo_planilha
   * @param \App\Models\Planilha\Planilha $planilha
   * @param \Illuminate\Database\Eloquent\Model $comissaoModel
   * @return \Illuminate\View\View
   */
  private function getViewWithComissaoData($tipo_planilha, $planilha, $comissaoModel)
  {
    return view('planilha.tipo.' . $tipo_planilha . '.colaborador.index', [
      'planilha'           => $planilha,
      'meios'              => $this->getMeio(),
      'servico_alarme'     => $this->getServicoAlarme(),
      'listaComissao'      => $comissaoModel::where('planilha_id', $planilha->id)->orderBy('id', 'desc')->paginate(10),
      'valorTotalComissao' => $comissaoModel::where('planilha_id', $planilha->id)->sum('comissao'),
    ]);
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


























/*
switch ($tipo_planilha) {
      case 'comercialAlarmeCercaEletricaCFTV':


        return view('planilha.tipo.comercialAlarmeCercaEletricaCFTV.colaborador.index', [
          'servico_alarme' => $this->getServicoAlarme(),
          'meios'          => $this->getMeio(),
          'planilha'       => $planilha,
          'listaComissao'  => ComercialAlarmeCercaEletricaCFTV::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10),

        ]);
      case 'comercialRastreamentoVeicular':
        return view('planilha.tipo.comercialRastreamentoVeicular.colaborador.index', [
          'planilha'      => $planilha,
          'listaComissao' => ComercialRastreamentoVeicular::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      case 'EntregaDeAlarmes':
        return view('planilha.tipo.EntregaDeAlarmes.colaborador.index', [
          'planilha'      => $planilha,
          'listaComissao' => EntregaDeAlarmes::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      case 'portariaVirtual':
        return view('planilha.tipo.portariaVirtual.colaborador.index', [
          'meios'         => $this->getMeio(),
          'planilha'      => $planilha,
          'listaComissao' => PortariaVirtual::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      case 'reclamacaoDeCliente':
        return view('planilha.tipo.reclamacaoDeCliente.colaborador.index', [
          'planilha'      => $planilha,
          'listaComissao' => ReclamacaoDeCliente::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      case 'supervisaoComercialAlarmesCercaEletricaCFTV':

        return view('planilha.tipo.supervisaoComercialAlarmesCercaEletricaCFTV.colaborador.index', [
          'planilha'       => $planilha,
          'servico_alarme' =>  $this->getServicoAlarme(),
          'listaComissao'  =>  SupervisaoComercialAlarmesCercaEletricaCFTV::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      case 'supervisaoComercialRastreamento':
        return view('planilha.tipo.supervisaoComercialRastreamento.colaborador.index', [
          'planilha'      => $planilha,
          'listaComissao' => SupervisaoComercialRastreamento::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      case 'supervisaoTecnicaESACAlarmesCercaEletricaCFTV':
        return view('planilha.tipo.supervisaoTecnicaESacAlarmesCercaEletricaCFTV.colaborador.index', [
          'planilha'      => $planilha,
          'listaComissao' => SupervisaoTecnicaESacAlarmesCercaEletricaCFTV::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      case 'tecnicaAlarmesCercaEletricaCFTV':
        $servico_alarme = $this->getServicoAlarme();
        return view('planilha.tipo.tecnicaAlarmesCercaEletricaCFTV.colaborador.index', [
          'planilha'       => $planilha,
          'servico_alarme' => $servico_alarme,
          'listaComissao'  => TecnicaAlarmesCercaEletricaCFTV::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      case 'tecnicaDeRastreamento':
        return view('planilha.tipo.tecnicaDeRastreamento.colaborador.index', [
          'planilha'       => $planilha,
          'servico_alarme' => $this->getServicoAlarme(),
          'listaComissao'  =>  TecnicaDeRastreamento::where('planilha_id', $id)->orderBy('id', 'desc')->paginate(10)
        ]);
      default:
        // Lidar com outros casos ou lançar uma exceção, se necessário
        return null;
    }
*/