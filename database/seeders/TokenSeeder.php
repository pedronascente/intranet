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
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 1]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 2]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 3]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 4]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 5]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 6]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 7]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 8]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 9]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 10]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 11]);   
        DB::table('tokens')->insert(['token' => 'A7B4E0BA', 'posicao' => 1, 'user_id' => 12]);   
    }
}
