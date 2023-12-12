<?php

namespace App\Models\Planilha\Tipo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanilhaTipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function planilha()
    {
        return $this->hasOne(App\Models\Planilha\Planilha::class);
    }

    public function formatarData($dataEntrada)
    {
        // Verificar se a barra está presente na string
        if (strpos($dataEntrada, '/') === false) {
            // Se não houver barra, retornar false
            return false;
        }
        // Quebrar a data em dia, mês e ano
        list($dia, $mes, $ano) = explode("/", $dataEntrada);
        // Formatar a data no formato desejado: "2023/04/06"
        $dataFormatada = $ano . "-" . $mes . "-" . $dia;
        // Saída da data formatada
        return $dataFormatada;
    }
}
