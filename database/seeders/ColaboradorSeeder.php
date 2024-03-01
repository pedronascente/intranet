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
            'base_id'          => 1,
            'empresa_id'       => 5,
            'cargo_id'         => 49,
            'nome'             => 'Pedro',
            'email'            => 'desenvolvimento@grupovolpato.com',
            'rg'               => '99999999999999',
            'cpf'              => '99999999999',
            'foto'             => 'dummy-round.png',
            'ramal'            => '999',
            'numero_matricula' => '9999',
        ]);
        for($i=2; $i<=10; $i++){
            DB::table('colaboradores')->insert([
                'base_id'          => 1,
                'empresa_id'       => 1,
                'cargo_id'         => 1,
                'nome'             => Str::random(10),
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