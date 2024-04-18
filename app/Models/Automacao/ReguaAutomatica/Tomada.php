<?php

namespace App\Models\Automacao\ReguaAutomatica;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tomada extends Model
{
    use HasFactory;

    protected $table = "regua_automatica_tomadas";

    public function regua()
    {
        return $this->belongsTo(Regua::class);
    }

    public function criarTomadas($request, $regua_id)
    {
        try {

            DB::beginTransaction();

            foreach (array_combine($request->tomada, $request->api) as $t => $api) {
                $tomada = new Tomada;
                $tomada->regua_id = $regua_id;
                $tomada->tomada = $t;
                $tomada->api = $api;
                $tomada->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Lidar com exceções aqui, como registrar em log ou retornar uma mensagem de erro
            Log::error('Erro ao criar tomada: ' . $e->getMessage());

            // Retornar uma mensagem de erro para o usuário
            throw new \Exception('Erro ao criar tomada. Por favor, tente novamente mais tarde.', 500);
        }
    }
}