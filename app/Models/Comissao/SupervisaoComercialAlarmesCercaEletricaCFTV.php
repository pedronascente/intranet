<?php

namespace App\Models\comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisaoComercialAlarmesCercaEletricaCFTV extends Model
{
    use HasFactory;

    protected $table = "supervisao_comercial_alarmes_cerca_eletrica_cftvs";
    protected $fillable = [
        'cliente',
        'data',
        'conta_pedido',
        'consultor',
        'mensal',
        'ins_vendas',
        'comissao',
        'desconto_comissao',
        'servico_id',
        'planilha_id',
    ];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }

    public function servico()
    {
        return $this->belongsTo(ServicoAlarme::class);
    }
}
