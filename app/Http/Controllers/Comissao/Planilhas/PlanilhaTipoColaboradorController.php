<?php

namespace App\Http\Controllers\Comissao\Planilhas;

use App\Http\Controllers\Controller;
use App\Models\Comissao\Planilha;
use App\Models\Comissao\Planilhas\Meio;
use App\Models\Comissao\Planilhas\ServicoAlarme;

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
    $comissaoModel = 'App\Models\Comissao\Planilhas\\' . $tipo_planilha;

    return new $comissaoModel;
  }

  /**
   * Retorna a vista com os dados de comissão para o tipo de planilha especificado.
   *
   * @param string $tipo_planilha
   * @param \App\Models\Comissao\Planilha $planilha
   * @param \Illuminate\Database\Eloquent\Model $comissaoModel
   * @return \Illuminate\View\View
   */
  private function getViewWithComissaoData($tipo_planilha, $planilha, $comissaoModel)
  {
    $valorTotalComissao = $comissaoModel::where('planilha_id', $planilha->id)->sum('comissao');
    $valorTotalComissao = number_format($valorTotalComissao, 2, ',', '.');

    return view('comissao.planilhas.' . $tipo_planilha . '.colaborador.index', [
      'planilha'           => $planilha,
      'meios'              => $this->getMeio(),
      'servico_alarme'     => $this->getServicoAlarme(),
      'listaComissao'      => $comissaoModel::where('planilha_id', $planilha->id)->orderBy('id', 'desc')->paginate(10),
      'valorTotalComissao' =>  $valorTotalComissao,
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
