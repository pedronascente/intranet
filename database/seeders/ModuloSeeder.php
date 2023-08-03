<?php

namespace Database\Seeders;

use \Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    public function run()
    {
        DB::table('modulos')->insert(['nome' => 'RH', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'Rastreamento', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'Portaria', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'Alarme', 'descricao' => Str::random(80)]);
    }
}
