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
        DB::table('tipo_planilhas')->insert(['nome' => 'Comercial Alarme / Cerca Elétrica / CFTV',                  'formulario' => 'form1']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Comercial Rastreamento Veicular',                           'formulario' => 'form2']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Entregas de Alarmes',                                       'formulario' => 'form3']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Portaria Virtual',                                          'formulario' => 'form4']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Reclamação de Cliente',                                     'formulario' => 'form5']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Supervisão Comercial Alarmes / Cerca Elétrica / CFTV',      'formulario' => 'form6']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Supervisão Comercial Rastreamento',                         'formulario' => 'form7']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Supervisão Técnica e SAC Alarmes / Cerca Elétrica / CFTV',  'formulario' => 'form8']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Técnica Alarmes / Cerca Elétrica / CFTV',                   'formulario' => 'form9']);
        DB::table('tipo_planilhas')->insert(['nome' => 'Técnica de Rastreamento',                                   'formulario' => 'form10']);
    }
}
