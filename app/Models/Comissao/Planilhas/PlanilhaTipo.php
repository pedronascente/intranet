<?php

namespace App\Models\Comissao\Planilhas;

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
        return $this->hasOne(App\Models\Comissao\Planilha::class);
    }
}
