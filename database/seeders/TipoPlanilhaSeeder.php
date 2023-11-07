<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPlanilhaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_planilhas')->insert(['nome' => 'Comercial Alarme / Cerca Elétrica / CFTV',                  'formulario' => 'comercialAlarmeCercaEletricaCFTV']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Comercial Rastreamento Veicular',                           'formulario' => 'comercialRastreamentoVeicular']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Entregas de Alarmes',                                       'formulario' => 'entregasDeAlarmes']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Portaria Virtual',                                          'formulario' => 'portariaVirtual']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Reclamação de Cliente',                                     'formulario' => 'reclamacaoDeCliente']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Supervisão Comercial Alarmes / Cerca Elétrica / CFTV',      'formulario' => 'supervisaoComercialAlarmesCercaEletricaCFTV']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Supervisão Comercial Rastreamento',                         'formulario' => 'supervisaoComercialRastreamento']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Supervisão Técnica e SAC Alarmes / Cerca Elétrica / CFTV',  'formulario' => 'supervisaoTecnicaESACAlarmesCercaEletricaCFTV']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Técnica Alarmes / Cerca Elétrica / CFTV',                   'formulario' => 'tecnicaAlarmesCercaEletricaCFTV']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Técnica de Rastreamento',                                   'formulario' => 'tecnicaDeRastreamento']);
    }
}
