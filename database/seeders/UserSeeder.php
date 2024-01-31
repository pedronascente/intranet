<?php

namespace Database\Seeders;

use Illuminate\Support\Str;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name'           => 'admin',
            'status'         => 'on',
            'colaborador_id' => 1,
            'perfil_id'      => 1,
            'qtdToken'       => 2,
            'password'       => Hash::make('Admin@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'luiz.teste',
            'status'         => 'on',
            'colaborador_id' => 2,
            'perfil_id'      => 2,
            'qtdToken'       => 2,
            'password'       => Hash::make('Admin@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'mario.teste',
            'status'         => 'on',
            'colaborador_id' => 3,
            'perfil_id'      => 2,
            'qtdToken'       => 7,
            'password'       => Hash::make('Admin@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'ricardo.teste',
            'status'         => 'on',
            'colaborador_id' => 4,
            'perfil_id'      => 3,
            'qtdToken'       => 1,
            'password'       => Hash::make('Admin@188'),
            'remember_token' => Str::random(10)
        ]);
    }
}
