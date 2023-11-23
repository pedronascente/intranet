<?php

namespace App\Models\comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortariaVirtual extends Model
{
    use HasFactory;

    protected $table = "portaria_virtuais";

    protected $fillable = [
        "cliente",
        "data",
        "ins_vendas",
        "mensal",
        "conta_pedido",
        "comissao",
        "desconto_comissao",
        "planilha_id",
        "meio_id",
    ];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }

    public function meio()
    {
        return $this->belongsTo(Meio::class);
    }
}
