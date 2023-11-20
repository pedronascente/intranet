<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaDeAlarme extends Model
{
    use HasFactory;

    protected $table = "entrega_alarmes";

    protected $fillable   = [];

    public function planilha()
    {
        return $this->belongsTo(Planilha::class);
    }
}
