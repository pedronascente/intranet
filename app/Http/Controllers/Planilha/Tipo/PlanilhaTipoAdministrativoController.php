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

  public function index(Request $request, $id)
  {
    $filtro        = $request->input('filtro');
    $planilha      = $this->getPlanilhaWithRelationships($id);
    $tipo_planilha = $planilha->tipo->formulario;

    if ($filtro) {
      return $this->getViewWithComissaoDataFiltro($tipo_planilha, $planilha, $this->getComissaoModel($tipo_planilha), $filtro);
    }

    return $this->getViewWithComissaoData($tipo_planilha, $planilha, $this->getComissaoModel($tipo_planilha));
  }


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
        'planilha'           => $planilha,
        'valorTotalComissao' => $valorTotalComissao,
        'volpatoImage'       => $volpatoImage,
      ]
    );
    $pdf = PDF::loadHtml($view)->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

    // Usar o método stream para abrir no navegador
    return $pdf->stream($tipo_planilha . '.pdf');
  }

  private function getPlanilhaWithRelationships($id)
  {
    return $this->planilha->with('colaborador', 'periodo', 'tipo')->findOrFail($id);
  }

  private function getComissaoModel($tipo_planilha)
  {
    $tipo_planilha = ucfirst($tipo_planilha);
    $comissaoModel = 'App\Models\Planilha\Tipo\\' . $tipo_planilha;
    return new $comissaoModel;
  }

  private function getViewWithComissaoData($tipo_planilha, $planilha, $comissaoModel)
  {
    return view('planilha.tipo.' . $tipo_planilha . '.administrativo.index', [
      'planilha'           => $planilha,
      'listaComissao'      => $comissaoModel::where('planilha_id', $planilha->id)->orderBy('id', 'desc')->paginate(10),
      'valorTotalComissao' => $comissaoModel::where('planilha_id', $planilha->id)->sum('comissao'),
    ]);
  }

  private function getViewWithComissaoDataFiltro($tipo_planilha, $planilha, $comissaoModel, $filtro)
  {

    // Inicializa a consulta
    $query = $comissaoModel::where('planilha_id', $planilha->id);

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
      'valorTotalComissao' => $listaComissao->sum('comissao'),
    ]);
  }
}//fim da classe.
