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
}
