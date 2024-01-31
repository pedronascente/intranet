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
        DB::table('tokens')->insert(['token' => '0B81E594', 'posicao' => 1, 'user_id' => 1]);
        DB::table('tokens')->insert(['token' => 'C0AEBB73', 'posicao' => 2, 'user_id' => 1]);

        DB::table('tokens')->insert(['token' => '940B81E5', 'posicao' => 1, 'user_id' => 2]);
        DB::table('tokens')->insert(['token' => 'B73C0AEB', 'posicao' => 2, 'user_id' => 2]);

        DB::table('tokens')->insert(['token' => '0B8194E5', 'posicao' => 1, 'user_id' => 3]);
        DB::table('tokens')->insert(['token' => 'B73CB0AE', 'posicao' => 2, 'user_id' => 3]);
        DB::table('tokens')->insert(['token' => 'E5940B81', 'posicao' => 3, 'user_id' => 3]);
        DB::table('tokens')->insert(['token' => '3C0AEBB7', 'posicao' => 4, 'user_id' => 3]);
        DB::table('tokens')->insert(['token' => '9E540B81', 'posicao' => 5, 'user_id' => 3]);
        DB::table('tokens')->insert(['token' => 'B7EB3C0A', 'posicao' => 6, 'user_id' => 3]);
        DB::table('tokens')->insert(['token' => '3CB70AEB', 'posicao' => 7, 'user_id' => 3]);

        DB::table('tokens')->insert(['token' => '3CB7AEB0', 'posicao' => 1, 'user_id' => 4]);
    }
}
