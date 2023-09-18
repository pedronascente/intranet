<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColaboradorSeeder extends Seeder
{
    public function run()
    {
        DB::table('colaboradores')->insert([
            'base_id' => 1,
            'empresa_id' => 1,
            'cargo_id' => 1,
            'user_id' => 1,
            'nome' => Str::random(10),
            'sobrenome' => ' de tal ' . Str::random(3),
            'email' => 'nascente3d@gmail.com',
            'rg' => '777777777777777',
            'cpf' => '348.211.190/13',
            'cnpj' => '15.626.983/0001-43',
            'foto' => 'dummy-round.png',
            'ramal' => '521',
        ]);
    }
}
