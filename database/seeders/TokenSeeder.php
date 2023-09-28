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
        DB::table('tokens')->insert(['token' => '0B81E594', 'posicao' => 1, 'cartao_id' => 1]);
        DB::table('tokens')->insert(['token' => 'C0AEBB73', 'posicao' => 2, 'cartao_id' => 1]);
    }
}
