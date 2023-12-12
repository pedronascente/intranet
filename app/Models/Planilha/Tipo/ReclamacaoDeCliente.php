<?php

namespace App\Models\Planilha\Tipo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReclamacaoDeCliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente',
        'data',
        'conta_pedido',
        'comissao',
        'desconto_comissao',
        'planilha_id',
    ];

    public function planilha()
    {
        return $this->belongsTo(\App\Models\Planilha\Planilha::class);
    }

    public function rules()
    {
        return [
            'cliente' => 'required|min:2|max:200',
            'data' => 'required|date_format:d/m/Y', // Validar o formato da data
            'conta_pedido' => 'required|max:50',
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
        return  [
            'required' => 'Campo obrigatório.',
            'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
            'date_format' => 'O campo data deve estar no formato válido dia/mes/ano'
        ];
    }
}
