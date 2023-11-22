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
        "ins_venda",
        "mensal",
        "conta",
        "comissao",
        "desconto_comissao",
        "planilha_id",
        "meio_id",
    ];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }
}
