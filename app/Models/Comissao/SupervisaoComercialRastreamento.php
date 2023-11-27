<?php

namespace App\Models\comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisaoComercialRastreamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'cliente',
        'conta_pedido',
        'total_rastreadores',
        'comissao',
        'desconto_comissao',
        'planilha_id'
    ];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }
}
