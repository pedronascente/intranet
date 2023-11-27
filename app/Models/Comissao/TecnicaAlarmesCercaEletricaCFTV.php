<?php

namespace App\Models\comissao;

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

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }

    public function servico()
    {
        return $this->belongsTo(ServicoAlarme::class);
    }
}
