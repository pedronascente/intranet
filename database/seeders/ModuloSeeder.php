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
        DB::table('modulos')->insert(['nome' => 'PORTARIA', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'RASTREAMENTO', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'ALARME', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'COMERCIAL', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'SAC', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'ADMINISTRAÇÃO', 'descricao' => Str::random(80)]);
        DB::table('modulos')->insert(['nome' => 'MARKETING', 'descricao' => Str::random(80)]);
    }
}
