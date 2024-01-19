<?php

namespace App\Http\Controllers\Planilha\Tipo;

use PDF;
use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;

/**
 * Classe controladora para a gestão administrativa de diferentes tipos de planilhas.
 */
class PlanilhaTipoAdministrativoController extends Controller
{
  private $planilha;

  public function __construct(Planilha $planilha)
  {
    $this->planilha = $planilha;
  }

  /**
   * Exibe a página de índice para uma planilha com a opção de aplicar um filtro.
   *
   * @param  \Illuminate\Http\Request  $request  Instância da requisição HTTP.
   * @param  int  $id  Identificador da planilha.
   * @return \Illuminate\Contracts\View\View
   */
  public function index(Request $request, $id)
  {
    // Obtém o termo de filtro da requisição
    $filtro = $request->input('filtro');

    // Obtém a planilha com relacionamentos
    $planilha = $this->getPlanilhaWithRelationships($id);

    // Obtém o tipo de planilha
    $tipo_planilha = $planilha->tipo->formulario;

    // Verifica se há um filtro aplicado
    if ($filtro) {
      // Se houver filtro, chama o método para gerar a visão com dados de comissão aplicando o filtro
      return $this->getViewWithComissaoDataFiltro($tipo_planilha, $planilha, $this->getComissaoModel($tipo_planilha), $filtro);
    }

    // Se não houver filtro, chama o método para gerar a visão com dados de comissão sem filtro
    return $this->getViewWithComissaoData($tipo_planilha, $planilha, $this->getComissaoModel($tipo_planilha));
  }


  /**
   * Gera um arquivo PDF para uma planilha específica.
   *
   * @param  int  $id  Identificador da planilha.
   * @return \Illuminate\Http\Response
   */
  public function imprimirPDF($id)
  {
    // Obtém a planilha com relacionamentos
    $planilha = $this->getPlanilhaWithRelationships($id);

    // Obtém o tipo de planilha
    $tipo_planilha = $planilha->tipo->formulario;

    // Obtém o valor total da comissão
    $valorTotalComissao = $this->getComissaoModel($tipo_planilha)::where('planilha_id', $planilha->id)->sum('comissao');

    // Obtém o caminho da imagem do logo da empresa
    $img_logo = ($planilha->colaborador->empresa->imglogo) ? 'img/empresa/' . $planilha->colaborador->empresa->imglogo : 'img/empresa/logo-default.jpg';

    // Converte a imagem em base64
    $volpatoImage = base64_encode(file_get_contents(public_path($img_logo)));

    // Gera a visão para o PDF
    $view = view(
      'planilha.tipo.' . $tipo_planilha . '.administrativo.imprimir',
      [
        'planilha'           => $planilha, // Dados da planilha
        'valorTotalComissao' => number_format($valorTotalComissao, 2, ',', '.'), // Valor total da comissão formatado
        'volpatoImage'       => $volpatoImage, // Imagem da empresa convertida em base64
      ]
    );

    // Carrega a visão HTML no PDF
    $pdf = PDF::loadHtml($view)->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

    // Usa o método stream para abrir no navegador
    return $pdf->stream($tipo_planilha . '.pdf');
  }

  /**
   * Obtém uma instância da planilha com seus relacionamentos.
   *
   * @param  int  $id  Identificador da planilha.
   * @return \App\Models\Planilha\Planilha
   */
  private function getPlanilhaWithRelationships($id)
  {
    // Obtém a planilha com os relacionamentos de colaborador, período e tipo
    return $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id);
  }

  /**
   * Obtém uma instância da model de comissão com base no tipo de planilha.
   *
   * @param  string  $tipo_planilha  Tipo de planilha.
   * @return mixed
   */
  private function getComissaoModel($tipo_planilha)
  {
    // Formata o tipo de planilha para garantir consistência no namespace
    $tipo_planilha = ucfirst($tipo_planilha);

    // Monta o nome da classe da model de comissão com base no tipo de planilha
    $comissaoModel = 'App\Models\Planilha\Tipo\\' . $tipo_planilha;

    // Retorna uma nova instância da model de comissão
    return new $comissaoModel;
  }

  /**
   * Gera uma visão com dados de comissão para uma planilha específica.
   *
   * @param  string  $tipo_planilha  Tipo de planilha.
   * @param  \App\Models\Planilha\Planilha  $planilha  Instância da planilha.
   * @param  mixed  $comissaoModel  Instância da model de comissão.
   * @return \Illuminate\Contracts\View\View
   */
  private function getViewWithComissaoData($tipo_planilha, $planilha, $comissaoModel)
  {
    // Obtém o valor total da comissão
    $valorTotalComissao = $comissaoModel::where('planilha_id', $planilha->id)->sum('comissao');

    // Retorna a visão com dados de comissão e informações adicionais
    return view('planilha.tipo.' . $tipo_planilha . '.administrativo.index', [
      'planilha'           => $planilha, // Dados da planilha
      'listaComissao'      => $comissaoModel::where('planilha_id', $planilha->id)->orderBy('id', 'desc')->paginate(10), // Lista de comissões paginada
      'valorTotalComissao' => number_format($valorTotalComissao, 2, ',', '.'), // Valor total da comissão formatado
    ]);
  }

  /**
   * Obtém uma view com dados de comissão filtrados para uma planilha específica.
   *
   * @param string $tipo_planilha Tipo da planilha.
   * @param Planilha $planilha Instância da planilha.
   * @param Model $comissaoModel Modelo de comissão específico.
   * @param string $filtro Termo de pesquisa/filtro.
   * @return \Illuminate\Contracts\View\View View com os resultados da consulta.
   */
  private function getViewWithComissaoDataFiltro($tipo_planilha, $planilha, $comissaoModel, $filtro)
  {

    // Inicializa a consulta
    $query = $comissaoModel::where('planilha_id', $planilha->id);

    // Aplica condições específicas com base no tipo de planilha
    switch ($tipo_planilha) {
      case 'tecnicaAlarmesCercaEletricaCFTV':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',         'like', '%' . $filtro . '%')
            ->orWhere('numero_os',     'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',  'like', '%' . $filtro . '%')
            ->orWhereHas('servico', function ($q) use ($filtro) {
              $q->where('nome', 'like', '%' . $filtro . '%');
            });
        });
        break;

      case 'tecnicaDeRastreamento':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',             'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',      'like', '%' . $filtro . '%')
            ->orWhere('placa',             'like', '%' . $filtro . '%')
            ->orWhere('observacao',        'like', '%' . $filtro . '%')
            ->orWhere('comissao',          'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao', 'like', '%' . $filtro . '%');
        });
        break;

      case 'supervisaoTecnicaESACAlarmesCercaEletricaCFTV':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',             'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',      'like', '%' . $filtro . '%')
            ->orWhere('equipe_servico',    'like', '%' . $filtro . '%')
            ->orWhere('ins_vendas',        'like', '%' . $filtro . '%')
            ->orWhere('mensal',            'like', '%' . $filtro . '%')
            ->orWhere('comissao',          'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao', 'like', '%' . $filtro . '%');
        });
        break;

      case 'comercialRastreamentoVeicular':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',             'like', '%' . $filtro . '%')
            ->orWhere('placa',             'like', '%' . $filtro . '%')
            ->orWhere('taxa_instalacao',   'like', '%' . $filtro . '%')
            ->orWhere('mensal',            'like', '%' . $filtro . '%')
            ->orWhere('comissao',          'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao', 'like', '%' . $filtro . '%')
            ->orWhere('id_contrato',       'like', '%' . $filtro . '%');
        });
        break;

      case 'supervisaoComercialAlarmesCercaEletricaCFTV':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',             'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',      'like', '%' . $filtro . '%')
            ->orWhere('consultor',         'like', '%' . $filtro . '%')
            ->orWhere('mensal',            'like', '%' . $filtro . '%')
            ->orWhere('ins_vendas',        'like', '%' . $filtro . '%')
            ->orWhere('comissao',          'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao', 'like', '%' . $filtro . '%')
            ->orWhereHas('servico', function ($q) use ($filtro) {
              $q->where('nome', 'like', '%' . $filtro . '%');
            });
        });
        break;

      case 'portariaVirtual':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',             'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',      'like', '%' . $filtro . '%')
            ->orWhere('ins_vendas',        'like', '%' . $filtro . '%')
            ->orWhere('mensal',            'like', '%' . $filtro . '%')
            ->orWhere('comissao',          'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao', 'like', '%' . $filtro . '%')
            ->orWhereHas('meio', function ($q) use ($filtro) {
              $q->where('nome', 'like', '%' . $filtro . '%');
            });
        });
        break;

      case 'entregaDeAlarmes':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',             'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',      'like', '%' . $filtro . '%')
            ->orWhere('comissao',          'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao', 'like', '%' . $filtro . '%');
        });
        break;

      case 'supervisaoComercialRastreamento':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',              'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',       'like', '%' . $filtro . '%')
            ->orWhere('total_rastreadores', 'like', '%' . $filtro . '%')
            ->orWhere('comissao',           'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao',  'like', '%' . $filtro . '%');
        });
        break;

      case 'comercialAlarmeCercaEletricaCFTV':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',             'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',      'like', '%' . $filtro . '%')
            ->orWhere('ins_vendas',        'like', '%' . $filtro . '%')
            ->orWhere('comissao',          'like', '%' . $filtro . '%')
            ->orWhere('mensal',            'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao', 'like', '%' . $filtro . '%')
            ->orWhereHas('meio', function ($q) use ($filtro) {
              $q->where('nome', 'like', '%' . $filtro . '%');
            })
            ->orWhereHas('servico', function ($q) use ($filtro) {
              $q->where('nome', 'like', '%' . $filtro . '%');
            });
        });
        break;

      case 'reclamacaoDeCliente':
        $query->where(function ($q) use ($filtro) {
          $q->where('cliente',             'like', '%' . $filtro . '%')
            ->orWhere('conta_pedido',      'like', '%' . $filtro . '%')
            ->orWhere('comissao',          'like', '%' . $filtro . '%')
            ->orWhere('desconto_comissao', 'like', '%' . $filtro . '%');
        });
        break;
    }

    // Finaliza a consulta e obtém os resultados agrupados por planilha_id
    $listaComissao = $query->orderBy('id', 'desc')->paginate(10);

    return view('planilha.tipo.' . $tipo_planilha . '.administrativo.index', [
      'planilha'           => $planilha,
      'listaComissao'      => $listaComissao,
      'valorTotalComissao' => number_format($listaComissao->sum('comissao'), 2, ',', '.'),
    ]);
  }
} //fim da classe.
