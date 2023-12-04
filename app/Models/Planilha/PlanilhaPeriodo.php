<?php

namespace App\Models\Planilha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanilhaPeriodo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function planilha()
    {
        return $this->hasOne(Planilha::class);
    }

    
}
