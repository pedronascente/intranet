<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tokens')->insert(['token' => '40500AD5', 'posicao' => 1, 'cartao_id' => 1]);
        DB::table('tokens')->insert(['token' => 'E7B161F2', 'posicao' => 2, 'cartao_id' => 1]);
    }
}
