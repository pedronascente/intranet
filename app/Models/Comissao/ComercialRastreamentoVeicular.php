<?php

namespace App\Models\Comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComercialRastreamentoVeicular extends Model
{
    use HasFactory;

    protected $table = "comercial_rastreamento_veiculares";

    protected $fillable   = [
        "cliente",
        "data",
        "placa",
        "taxa_instalacao",
        "mensal",
        "comissao",
        "desconto_comissao",
        "id_contrato",
        "planilha_id"
    ];

    public function planilha()
    {
        return $this->belongsTo(\App\Models\Planilha\Planilha::class);
    }
}
