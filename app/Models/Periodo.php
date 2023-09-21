<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
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
