<?php

namespace App\Models\Comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TecnicaDeRastreamento extends Model
{
    use HasFactory;

    protected $table = "tecnica_de_rastreamentos";

    protected $fillable   = [
        'cliente',
        'data',
        'conta_pedido',
        'placa',
        'comissao',
        'desconto_comissao',
        'observacao',
        'planilha_id'
    ];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }
}
