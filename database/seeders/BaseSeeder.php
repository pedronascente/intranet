<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bases')->insert(['nome' => 'AMAZONAS']);
        DB::table('bases')->insert(['nome' => 'CAIRU']);
        DB::table('bases')->insert(['nome' => 'CANOAS']);
        DB::table('bases')->insert(['nome' => 'GRAVATAI']);
        DB::table('bases')->insert(['nome' => 'PEREIRA FRANCO']);
        DB::table('bases')->insert(['nome' => 'SÃO PAULO']);
        DB::table('bases')->insert(['nome' => 'ZONA SUL']);
    }
}
