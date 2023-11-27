<?php

namespace App\Models\comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComercialAlarmeCercaEletricaCFTV extends Model
{
    use HasFactory;

    protected $table = "comercial_alarme_cerca_eletrica_cftvs";

    protected $fillable   = [
        'data',
        'cliente',
        'conta_pedido',
        'ins_vendas',
        'mensal',
        'comissao',
        'desconto_comissao',
        'planilha_id',
        'servico_id',
        'meio_id'
    ];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }

    public function meio()
    {
        return $this->belongsTo(Meio::class);
    }

    public function servico()
    {
        return $this->belongsTo(ServicoAlarme::class);
    }
}
