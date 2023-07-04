<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoSeeder extends Seeder
{

    public function run()
    {
        DB::table('grupos')->insert(['nome' => 'GRUPO RH ', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('grupos')->insert(['nome' => 'GRUPO PORTARIA', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('grupos')->insert(['nome' => 'GRUPO RASTREAMENTO', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('grupos')->insert(['nome' => 'GRUPO ALARME', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('grupos')->insert(['nome' => 'GRUPO COMERCIAL', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('grupos')->insert(['nome' => 'GRUPO SAC', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('grupos')->insert(['nome' => 'GRUPO ADMINISTRAÇÃO', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('grupos')->insert(['nome' => 'GRUPO MARKETING', 'descricao' => 'Responsável por' . Str::random(80)]);
    }
}
