<?php

namespace App\Models\Automacao\ReguaAutomatica;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condominio extends Model
{
    use HasFactory;
    protected $table = "regua_automatica_condominios";

    public function regua()
    {
       return $this->hasOne(Regua::class);
    }

    public function criarCondominio($request)
    {
        try {

            DB::beginTransaction();

            $this->condominio = $request->input('condominio');
            $this->save();
            $condominio_id = $this->id;
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Lidar com exceções aqui, como registrar em log ou retornar uma mensagem de erro
            Log::error('Erro ao criar condominio: ' . $e->getMessage());

            // Retornar uma mensagem de erro para o usuário
            throw new \Exception('Erro ao criar condominio. Por favor, tente novamente mais tarde.', 500);
        }
        $this->criarRegua($request, $condominio_id);
    }

    public function atualizar($request, $id)
    {
        $request->validate([
            'condominio' => 'required|string',
            'usuario' => 'required|string',
            'senha' => 'required|string',
            'ip' => 'required|string',
        ]);

        $condominio = $this->findOrFail($id); 
        $condominio->condominio = $request->condominio; 
        $condominio->save(); 

        $this->atualizarRegua($request,$id);

    }

    private function objetoRegua()
    {
        return new Regua;
    }
    
    private function criarRegua($request,  $condominio_id)
    {
        $this->objetoRegua()
             ->criarRegua($request,  $condominio_id);
    }

    private function atualizarRegua($request, $condominio_id)
    {
        $this->objetoRegua()
            ->atualizarRegua($request, $condominio_id);
    }
}