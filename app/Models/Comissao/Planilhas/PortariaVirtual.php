<?php

namespace App\Models\Comissao\Planilhas;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Help\CaniveteHelp;
use App\contracts\ValidacaoComissaoDuplicadaInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PortariaVirtual extends Model implements ValidacaoComissaoDuplicadaInterface
{
    use HasFactory;

    protected $table = "portaria_virtuais";

    protected $fillable = [
        "planilha_id",
        "cliente",
        "data",
        "ins_vendas",
        "mensal",
        "conta_pedido",
        "comissao",
        "desconto_comissao",
        "meio_id",
    ];

    public function planilha()
    {
        return $this->belongsTo(\App\Models\Comissao\Planilha::class);
    }

    public function meio()
    {
        return $this->belongsTo(Meio::class);
    }

    public function rules()
    {
        return  [
            'cliente'      => 'required|min:2|max:200',
            'data'         => 'required|date_format:d/m/Y', // Validar o formato da data
            'conta_pedido' => 'required|max:50',
            'meio_id'      => 'exists:meios,id',
            'comissao'     => [
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
            'ins_vendas' => [
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
        return [
            'meio_id.exists'                     => 'O meio informado não existe.',
            'required'                           => 'Campo obrigatório.',
            'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
            'date_format'                        => 'O campo data deve estar no formato válido dia/mes/ano'
        ];
    }
    
    public function validarComissaoDuplicada($request)
    {
        $data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $planilha_id       = $request->planilha_id;
        $cliente           = $request->cliente;
        $meio_id           = $request->meio_id;
        $ins_vendas        = $request->ins_vendas;
        $mensal            = $request->mensal;
        $conta_pedido      = $request->conta_pedido;
        $comissao          = $request->comissao;
        $desconto_comissao = $request->desconto_comissao;

        $query = $this->where('data', '=', $data);

        if ($planilha_id) {
            $query->where('planilha_id', '=', $planilha_id);
        }

        $query->where('cliente',         '=', $cliente)
            ->where('meio_id',           '=', $meio_id)
            ->where('ins_vendas',        '=', $ins_vendas)
            ->where('mensal',            '=', $mensal)
            ->where('conta_pedido',      '=', $conta_pedido)
            ->where('comissao',          '=', $comissao)
            ->where('desconto_comissao', '=', $desconto_comissao);
        return $query->count();
    }
}