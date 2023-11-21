<?php

namespace App\Models\comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaDeAlarme extends Model
{
    use HasFactory;

    protected $table = "entrega_alarmes";

    protected $fillable   = [
        'planilha_id',
        'cliente',
        'data',
        'conta_pedido',
        'comissao',
        'desconto_comissao'
    ];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }
}
