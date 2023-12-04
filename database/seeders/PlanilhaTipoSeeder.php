<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanilhaTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planilha_tipos')->insert(['nome' => 'Comercial Alarme / Cerca Elétrica / CFTV',                  'formulario' => 'comercialAlarmeCercaEletricaCFTV']);
        DB::table('planilha_tipos')->insert(['nome' => 'Comercial Rastreamento Veicular',                           'formulario' => 'comercialRastreamentoVeicular']);
        DB::table('planilha_tipos')->insert(['nome' => 'Entregas de Alarmes',                                       'formulario' => 'entregaDeAlarmes']);
        DB::table('planilha_tipos')->insert(['nome' => 'Portaria Virtual',                                          'formulario' => 'portariaVirtual']);
        DB::table('planilha_tipos')->insert(['nome' => 'Reclamação de Cliente',                                     'formulario' => 'reclamacaoDeCliente']);
        DB::table('planilha_tipos')->insert(['nome' => 'Supervisão Comercial Alarmes / Cerca Elétrica / CFTV',      'formulario' => 'supervisaoComercialAlarmesCercaEletricaCFTV']);
        DB::table('planilha_tipos')->insert(['nome' => 'Supervisão Comercial Rastreamento',                         'formulario' => 'supervisaoComercialRastreamento']);
        DB::table('planilha_tipos')->insert(['nome' => 'Supervisão Técnica e SAC Alarmes / Cerca Elétrica / CFTV',  'formulario' => 'supervisaoTecnicaESACAlarmesCercaEletricaCFTV']);
        DB::table('planilha_tipos')->insert(['nome' => 'Técnica Alarmes / Cerca Elétrica / CFTV',                   'formulario' => 'tecnicaAlarmesCercaEletricaCFTV']);
        DB::table('planilha_tipos')->insert(['nome' => 'Técnica de Rastreamento',                                   'formulario' => 'tecnicaDeRastreamento']);
    }
}
