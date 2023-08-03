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
            'empresa_id' => 1,
            'cargo_id' => 1,
            'user_id' => null,
            'nome' => Str::random(10),
            'sobrenome' => ' de tal ' . Str::random(3),
            'email' => Str::random(10) . '@bol.com',
            'rg' => '42.488.999-7',
            'cpf' => '348.211.190-13',
            'cnpj' => '15626983000143',
            'foto' => 'dummy-round.png',
        ]);
    }
}
