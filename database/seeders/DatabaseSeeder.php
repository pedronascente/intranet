<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cargo;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            EmpresaSeeder::class,
            CargoSeeder::class,
            ModuloSeeder::class,
            PermissaoSeeder::class,
            PerfilSeeder::class,
            UserSeeder::class,
            ColaboradorSeeder::class,
            CartaoSeeder::class,
            TokenSeeder::class,
        ]);
    }
}
