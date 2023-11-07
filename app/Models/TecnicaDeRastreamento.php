<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TecnicaDeRastreamento extends Model
{
    use HasFactory;
    protected $table = "comissao_tecnica_de_rastreamentos";
    protected $fillable   = [
        'cliente',
        'data',
        'conta_pedido',
        'placa',
        'comissao',
        'desconto_comissao',
        'observacao',
    ];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }
}
