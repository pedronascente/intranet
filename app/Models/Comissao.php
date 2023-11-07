<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    use HasFactory;

    protected $table = 'comissoes';

    protected $fillable = [
        'data',
        'cliente',
        'conta_pedido',
        'meio',
        'servico',
        'qtd_veiculos',
        'placa',
        'numero_os',
        'total_rastreadores',
        'equip_servico',
        'observacao',
        'ins_vendas',
        'mensal',
        'comissao',
        'desconto_comissao',
        'taxa_instalacao ',
    ];

   
    public function ServicoAlarme()
    {
        return $this->belongsTo(ServicoAlarme::class);
    }
}
