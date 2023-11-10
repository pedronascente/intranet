<?php

namespace App\Models\Comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoAlarme extends Model
{
    use HasFactory;

    protected $table = 'servico_alarmes';

    public function comissao()
    {
        return $this->hasOne(Comissao::class);
    }
}
