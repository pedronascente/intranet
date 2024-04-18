<?php

namespace App\Models\Automacao\ReguaAutomatica;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use App\Models\Automacao\ReguaAutomatica\Tomada;
use App\Models\Automacao\ReguaAutomatica\Condominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Regua extends Model
{
    use HasFactory;
    protected $table = "regua_automaticas";

    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }

    public function tomadas()
    {
        return  $this->hasMany(Tomada::class);
    }

    public function criarRegua($request,  $condominio_id)
    {
        try {
            
            DB::beginTransaction();

            $this->condominio_id = $condominio_id;
            $this->usuario = $request->input('usuario');
            $this->senha = $request->input('senha');
            $this->ip = $request->input('ip');
            $this->save();
            $regua_id = $this->id;
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Lidar com exceções aqui, como registrar em log ou retornar uma mensagem de erro
            Log::error('Erro ao criar regua: ' . $e->getMessage());

            // Retornar uma mensagem de erro para o usuário
            throw new \Exception('Erro ao criar regua. Por favor, tente novamente mais tarde.', 500);
        }

        $this->criarTomadas($request, $regua_id);
    }

    public function atualizarRegua($request, $condominio_id)
    {
        $regua = $this->where('condominio_id', $condominio_id)->first();
        $regua->usuario = $request->usuario;
        $regua->senha = $request->senha;
        $regua->ip = $request->ip;
        $regua->update();
    }

    private function criarTomadas($request, $regua_id)
    {
        $tomada = new Tomada();
        $tomada->criarTomadas($request, $regua_id);
    }
}