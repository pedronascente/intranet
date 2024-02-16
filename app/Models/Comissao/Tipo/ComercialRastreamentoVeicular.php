<?php

namespace App\Models\Comissao\Tipo;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Help\CaniveteHelp;
use App\contracts\ValidacaoComissaoDuplicadaInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComercialRastreamentoVeicular extends Model implements ValidacaoComissaoDuplicadaInterface
{
    use HasFactory;

    protected $table = "comercial_rastreamento_veiculares";

    protected $fillable   = [
        "cliente",
        "data",
        "placa",
        "taxa_instalacao",
        "mensal",
        "comissao",
        "desconto_comissao",
        "id_contrato",
        "planilha_id"
    ];

    public function planilha()
    {
        return $this->belongsTo(\App\Models\Comissao\Planilha::class);
    }

    public function rules()
    {
        return
            [
                'cliente' => 'required|min:2|max:200',
                'data' => 'required|date_format:d/m/Y', // Validar o formato da data
                'placa' => 'required|max:10',
                'id_contrato' => 'max:10',
                'comissao' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if (
                            $value < 0 || $value > 9999999.99
                        ) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
                'taxa_instalacao' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if (
                            $value < 0 || $value > 9999999.99
                        ) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
                'mensal' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if (
                            $value < 0 || $value > 9999999.99
                        ) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
                'desconto_comissao' => [
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if (
                            $value < 0 || $value > 9999999.99
                        ) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],

            ];
    }

    public function feedback()
    {
        return
            [
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido dia/mes/ano'
            ];
    }

    public function validarComissaoDuplicada($request)
    {
        $data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $planilha_id       = $request->planilha_id;
        $cliente           = $request->cliente;
        $id_contrato       = $request->id_contrato;
        $placa             = $request->placa;
        $taxa_instalacao   = $request->taxa_instalacao;
        $mensal            = $request->mensal;
        $comissao          = $request->comissao;
        $desconto_comissao = $request->desconto_comissao;

        $query = $this->where('data', '=', $data);

        if ($planilha_id) {
            $query->where('planilha_id', '=', $planilha_id);
        }

        $query->where('cliente',         '=', $cliente)
            ->where('id_contrato',       '=', $id_contrato)
            ->where('placa',             '=', $placa)
            ->where('taxa_instalacao',   '=', $taxa_instalacao)
            ->where('mensal',            '=', $mensal)
            ->where('comissao',          '=', $comissao)
            ->where('desconto_comissao', '=', $desconto_comissao);
        return $query->count();
    }
}