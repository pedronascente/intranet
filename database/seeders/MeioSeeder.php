<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meios')->insert(['nome' => "Captação"]);
        DB::table('meios')->insert(['nome' => "Prospecção"]);
    }
}
