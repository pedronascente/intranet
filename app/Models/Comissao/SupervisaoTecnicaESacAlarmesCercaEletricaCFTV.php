<?php

namespace App\Models\Comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisaoTecnicaESacAlarmesCercaEletricaCFTV extends Model
{
    use HasFactory;

    protected $table = 'supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs';

    protected $fillable = [
        'cliente',
        'data',
        'conta_pedido',
        'equipe_servico',
        'ins_vendas',
        'mensal',
        'comissao',
        'desconto_comissao',
        'planilha_id'
    ];

    public function planilha()
    {
        return $this->belongsTo(\App\Models\Planilha\Planilha::class);
    }
}
