<?php

namespace App\Models\Comissao;

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
}
