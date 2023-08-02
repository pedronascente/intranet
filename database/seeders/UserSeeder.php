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
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 4,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 7,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 8,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 7,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 6,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 5,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 4,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 3,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 1,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'status' => 'on',
            'perfil_id' => 2,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'status' => 'on',
            'perfil_id' => 2,
            'password' => Hash::make('Admin@188'),
            'remember_token' => Str::random(10)
        ]);
    }
}
