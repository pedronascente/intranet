<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicoAlarmeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servico_alarme')->insert(['nome' => 'Alarme monitorado']);
        DB::table('servico_alarme')->insert(['nome' => 'Ampliação']);
        DB::table('servico_alarme')->insert(['nome' => 'Auditoria']);
        DB::table('servico_alarme')->insert(['nome' => 'Cerca Eletrica']);
        DB::table('servico_alarme')->insert(['nome' => 'CFTV']);
        DB::table('servico_alarme')->insert(['nome' => 'Instalação']);
        DB::table('servico_alarme')->insert(['nome' => 'Levantamento']);
        DB::table('servico_alarme')->insert(['nome' => 'Manutenção']);
        DB::table('servico_alarme')->insert(['nome' => 'Plantão']);
        DB::table('servico_alarme')->insert(['nome' => 'Retirada']);
        DB::table('servico_alarme')->insert(['nome' => 'Venda']);
        DB::table('servico_alarme')->insert(['nome' => 'Renovação']);
        DB::table('servico_alarme')->insert(['nome' => 'Troca de Retirada']);
    }
}
