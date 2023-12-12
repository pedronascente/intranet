<?php

namespace App\Models\Planilha\Tipo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TecnicaAlarmesCercaEletricaCFTV extends Model
{
    use HasFactory;

    protected $table = 'tecnica_alarmes_cerca_eletrica_cftvs';
    protected $fillable = [
        'data',
        'cliente',
        'conta_pedido',
        'numero_os',
        'comissao',
        'desconto_comissao',
        'servico_id',
        'planilha_id'
    ];

    public function servico()
    {
        return $this->belongsTo(ServicoAlarme::class);
    }

    public function planilha()
    {
        return $this->belongsTo(\App\Models\Planilha\Planilha::class);
    }

    public function rules()
    {
        return [
            'cliente'      => 'required|min:2|max:200',
            'data'         => 'required|date_format:d/m/Y',
            'conta_pedido' => 'required|max:50',
            'numero_os'    => 'numeric',
            'servico_id'   => 'exists:servico_alarmes,id',
            'comissao'     => [
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
                'servico_id.exists' => 'O Serviço informado não existe.',
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido d/m/Y',
            ];
    }
}
