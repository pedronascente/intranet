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
            'qtdToken'       => 1,
            'password'       => Hash::make('Admin@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'lilian.pereira',
            'status'         => 'on',
            'colaborador_id' => 2,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Lilian.pereira@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'tiago.rodrigues',
            'status'         => 'on',
            'colaborador_id' => 3,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Tiago.rodrigues@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'grazielle.silveira',
            'status'         => 'on',
            'colaborador_id' => 4,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Grazielle.silveira@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'deise.nunes',
            'status'         => 'on',
            'colaborador_id' => 5,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Deise.nunes@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'anamara.hoppe',
            'status'         => 'on',
            'colaborador_id' => 6,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Anamara.hoppe@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'tais.correa',
            'status'         => 'on',
            'colaborador_id' => 7,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Tais.correa@188'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name'           => 'maria.dutra',
            'status'         => 'on',
            'colaborador_id' => 8,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Maria.dutra@188'),
            'remember_token' => Str::random(10)
        ]);
       
        DB::table('users')->insert([
            'name'           => 'helenir.souza',
            'status'         => 'on',
            'colaborador_id' => 9,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Helenir.souza@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'katia.beatriz',
            'status'         => 'on',
            'colaborador_id' => 10,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Katia.beatriz@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'pedro.henrique',
            'status'         => 'on',
            'colaborador_id' => 11,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Pedro.henrique@188'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'name'           => 'francisco.maia',
            'status'         => 'on',
            'colaborador_id' => 12,
            'perfil_id'      => 2,
            'qtdToken'       => 1,
            'password'       => Hash::make('Francisco.maia@188'),
            'remember_token' => Str::random(10)
        ]);
    }
}