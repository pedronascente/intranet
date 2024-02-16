<?php

namespace App\Http\Controllers\Comissao;

use PDF;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;

class ImprimirPlanilhaController extends Controller
{
    private $planilha;

    public function __construct(Planilha $planilha)
    {
        $this->planilha = $planilha;
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
} 