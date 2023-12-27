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
    }
}
