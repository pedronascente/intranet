<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periodos')->insert(['nome' => 'JAN / FEV']);
        DB::table('periodos')->insert(['nome' => 'FEV / MAR']);
        DB::table('periodos')->insert(['nome' => 'MAR / ABR']);
        DB::table('periodos')->insert(['nome' => 'ABR / MAI']);
        DB::table('periodos')->insert(['nome' => 'MAI / JUN']);
        DB::table('periodos')->insert(['nome' => 'JUN / JUL']);
        DB::table('periodos')->insert(['nome' => 'JUL / AGO']);
        DB::table('periodos')->insert(['nome' => 'AGO / SET']);
        DB::table('periodos')->insert(['nome' => 'SET / OUT']);
        DB::table('periodos')->insert(['nome' => 'OUT / NOV']);
        DB::table('periodos')->insert(['nome' => 'NOV / DEZ']);
        DB::table('periodos')->insert(['nome' => 'DEZ / JAN']);
    }
}
