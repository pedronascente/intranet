<?php

namespace App\Models\Comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoAlarme extends Model
{
    use HasFactory;

    protected $table = 'servico_alarmes';

    public function comercialAlarmeCercaEletricaCFTV()
    {
        return $this->hasOne(ComercialAlarmeCercaEletricaCFTV::class);
    }
    public function supervisaoComercialAlarmesCercaEletricaCFTV()
    {
        return $this->hasOne(SupervisaoComercialAlarmesCercaEletricaCFTV::class);
    }
}
