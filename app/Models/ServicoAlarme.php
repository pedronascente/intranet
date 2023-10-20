<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoAlarme extends Model
{
    use HasFactory;

    protected $table = 'servico_alarme';

    public function comissao()
    {
        return $this->hasOne(Comissao::class);
    }
}
