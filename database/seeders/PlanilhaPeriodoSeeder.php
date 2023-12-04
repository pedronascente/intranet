<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanilhaPeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planilha_periodos')->insert(['nome' => 'JAN / FEV']);
        DB::table('planilha_periodos')->insert(['nome' => 'FEV / MAR']);
        DB::table('planilha_periodos')->insert(['nome' => 'MAR / ABR']);
        DB::table('planilha_periodos')->insert(['nome' => 'ABR / MAI']);
        DB::table('planilha_periodos')->insert(['nome' => 'MAI / JUN']);
        DB::table('planilha_periodos')->insert(['nome' => 'JUN / JUL']);
        DB::table('planilha_periodos')->insert(['nome' => 'JUL / AGO']);
        DB::table('planilha_periodos')->insert(['nome' => 'AGO / SET']);
        DB::table('planilha_periodos')->insert(['nome' => 'SET / OUT']);
        DB::table('planilha_periodos')->insert(['nome' => 'OUT / NOV']);
        DB::table('planilha_periodos')->insert(['nome' => 'NOV / DEZ']);
        DB::table('planilha_periodos')->insert(['nome' => 'DEZ / JAN']);
    }
}
