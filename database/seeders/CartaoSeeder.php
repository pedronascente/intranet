<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cartoes')->insert(['status' => 'on', 'nome' => '2fa', 'qtdToken' => 2, 'user_id' => 1]);
    }
}
