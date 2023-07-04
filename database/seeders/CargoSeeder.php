<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    public function run()
    {
        DB::table('cargos')->insert(['nome' => 'Analista de Sistemas Jr']);
        DB::table('cargos')->insert(['nome' => 'Analista de Sistemas Pleno']);
        DB::table('cargos')->insert(['nome' => 'Analista de Ssistemas Senior']);
        DB::table('cargos')->insert(['nome' => 'Programador PHP jr']);
        DB::table('cargos')->insert(['nome' => 'Programador PHP Pleno']);
        DB::table('cargos')->insert(['nome' => 'Programador PHP Senior']);
        DB::table('cargos')->insert(['nome' => 'Gerente de Projetos Senior']);
    }
}
