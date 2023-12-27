<?php

namespace App\Http\Controllers\Planilha\Tipo;

use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;

use PDF;

/**
 * Classe controladora para a gestão administrativa de diferentes tipos de planilhas.
 */
class PlanilhaTipoAdministrativoController extends Controller
{
  /**
   * Instância do modelo de planilha.
   *
   * @var \App\Models\Planilha\Planilha
   */
  private $planilha;

  /**
   * Cria uma nova instância do controlador.
   *
   * @param \App\Models\Planilha\Planilha $planilha
   */
  public function __construct(Planilha $planilha)
  {
    $this->planilha = $planilha;
  }

  /**
   * Exibe a página administrativa para um determinado tipo de planilha.
   *
   * @param int $id Identificador da planilha
   * @return \Illuminate\View\View
   */
  public function index($id)
  {
    $planilha = $this->getPlanilhaWithRelationships($id);
    $tipo_planilha = $planilha->tipo->formulario;

    return $this->getViewWithComissaoData($tipo_planilha, $planilha, $this->getComissaoModel($tipo_planilha));
  }

  /**
   * Gera e exibe um PDF para a planilha administrativa de um determinado tipo.
   *
   * @param int $id Identificador da planilha
   * @return \Illuminate\Http\Response
   */
  public function imprimirPDF($id)
  {
    $planilha           = $this->getPlanilhaWithRelationships($id);
    $tipo_planilha      = $planilha->tipo->formulario;
    $valorTotalComissao = $this->getComissaoModel($tipo_planilha)::where('planilha_id', $planilha->id)->sum('comissao');

    $img_logo = 'img/empresa/' . $planilha->colaborador->empresa->imglogo;

    // Converte a imagem em base64
    $volpatoImage = base64_encode(file_get_contents(public_path($img_logo)));

    $view =  view(
      'planilha.tipo.' . $tipo_planilha . '.administrativo.imprimir',
      [
        'planilha' => $planilha,
        'valorTotalComissao' => $valorTotalComissao,
        'volpatoImage' => $volpatoImage,
      ]
    );
    $pdf = PDF::loadHtml($view)->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

    // Usar o método stream para abrir no navegador
    return $pdf->stream($tipo_planilha . '.pdf');
  }

  /**
   * Obtém uma instância da planilha com suas relações.
   *
   * @param int $id Identificador da planilha
   * @return \App\Models\Planilha\Planilha
   */
  private function getPlanilhaWithRelationships($id)
  {
    return $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id);
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
    return view('planilha.tipo.' . $tipo_planilha . '.administrativo.index', [
      'planilha' => $planilha,
      'listaComissao' => $comissaoModel::where('planilha_id', $planilha->id)->orderBy('id', 'desc')->paginate(10),
      'valorTotalComissao' => $comissaoModel::where('planilha_id', $planilha->id)->sum('comissao'),
    ]);
  }
}
