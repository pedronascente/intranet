<?php

namespace App\Models\Comissao\Planilhas;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Help\CaniveteHelp;
use App\contracts\ValidacaoComissaoDuplicadaInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupervisaoComercialAlarmesCercaEletricaCFTV extends Model implements ValidacaoComissaoDuplicadaInterface
{
    use HasFactory;

    protected $table    = "supervisao_comercial_alarmes_cerca_eletrica_cftvs";
    protected $fillable = [
        'data',
        'planilha_id',
        'cliente',
        'servico_id',
        'conta_pedido',
        'consultor',
        'mensal',
        'ins_vendas',
        'comissao',
        'desconto_comissao',
        
    ];

    public function servico()
    {
        return $this->belongsTo(ServicoAlarme::class);
    }

    public function planilha()
    {
        return $this->belongsTo(\App\Models\Comissao\Planilha::class);
    }

    public function rules()
    {
        return [
            'cliente'      => 'required|min:2|max:200',
            'data'         => 'required|date_format:d/m/Y',
            'conta_pedido' => 'required|max:50',
            'consultor'    => 'required|max:200',
            'servico_id'   => 'exists:servico_alarmes,id',
            'mensal' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
                function ($attribute, $value, $fail) {
                    if ($value < 0 || $value > 9999999.99) {
                        $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                    }
                },
            ],
            'ins_vendas' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
                function ($attribute, $value, $fail) {
                    if ($value < 0 || $value > 9999999.99) {
                        $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                    }
                },
            ],
            'comissao' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
                function ($attribute, $value, $fail) {
                    if ($value < 0 || $value > 9999999.99) {
                        $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                    }
                },
            ],
            'desconto_comissao' => [
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
                function ($attribute, $value, $fail) {
                    if ($value < 0 || $value > 9999999.99) {
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
                'servico_id.exists'                  => 'O Serviço informado não existe.',
                'required'                           => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format'                        => 'O campo data deve estar no formato válido d/m/Y',
            ];
    }
    
    public function validarComissaoDuplicada($request)
    {
        $data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $planilha_id       = $request->planilha_id;
        $cliente           = $request->cliente;
        $servico_id        = $request->servico_id;
        $conta_pedido      = $request->conta_pedido;
        $consultor         = $request->consultor;
        $mensal            = $request->mensal;
        $ins_vendas        = $request->ins_vendas;
        $comissao          = $request->comissao;
        $desconto_comissao = $request->desconto_comissao;

        $query = $this->where('data', '=', $data);

        if ($planilha_id) {
            $query->where('planilha_id','=', $planilha_id);
        }

        $query->where('cliente',        '=', $cliente)
            ->where('servico_id',       '=', $servico_id)
            ->where('conta_pedido',     '=', $conta_pedido)
            ->where('consultor',        '=', $consultor)
            ->where('mensal',           '=', $mensal)
            ->where('ins_vendas',       '=', $ins_vendas)
            ->where('comissao',         '=', $comissao)
            ->where('desconto_comissao','=', $desconto_comissao);
        return $query->count();
    }
}