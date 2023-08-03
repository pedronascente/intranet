<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeder extends Seeder
{

    public function run()
    {
        DB::table('perfis')->insert(['nome' => 'Setor de RH ', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'RASTREAMENTO', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'PORTARIA', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'ALARME', 'descricao' => 'Responsável por' . Str::random(80)]);
    }
}
