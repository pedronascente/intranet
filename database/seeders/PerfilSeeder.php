<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeder extends Seeder
{

    public function run()
    {
        DB::table('perfis')->insert(['nome' => 'RH ', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'PORTARIA', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'RASTREAMENTO', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'ALARME', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'COMERCIAL', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'SAC', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'ADMINISTRAÇÃO', 'descricao' => 'Responsável por' . Str::random(80)]);
        DB::table('perfis')->insert(['nome' => 'MARKETING', 'descricao' => 'Responsável por' . Str::random(80)]);
    }
}
