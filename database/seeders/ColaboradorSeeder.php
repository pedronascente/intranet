<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColaboradorSeeder extends Seeder
{
    public function run()
    {
        for($i=1; $i<=100; $i++){
            DB::table('colaboradores')->insert([
                'base_id'          => 1,
                'empresa_id'       => 1,
                'cargo_id'         => 1,
                'nome'             => Str::random(10),
                'sobrenome'        => ' de' . Str::random(3),
                'email'            =>  Str::random(6).'d@gmail.com',
                'rg'               => '777777777777'.$i,
                'cpf'              => $i.'.211.190/13',
                'cnpj'             => '15.' . $i . '.983/0001-43',
                'foto'             => 'dummy-round.png',
                'ramal'            => '5'.$i,
                'numero_matricula' => '10000'.$i,
            ]);
        }
    }
}