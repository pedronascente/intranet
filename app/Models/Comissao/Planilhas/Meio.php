<?php

namespace App\Models\Comissao\Planilhas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meio extends Model
{
    use HasFactory;

    public function comercialAlarmeCercaEletricaCFTV()
    {
        return $this->hasOne(ComercialAlarmeCercaEletricaCFTV::class);
    }
}
