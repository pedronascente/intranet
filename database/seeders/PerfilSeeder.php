<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeder extends Seeder
{
    public function run()
    {
        DB::table('perfis')->insert(['nome' => 'Administrador',     'descricao' => 'Responsável por Gerenciar o sistema.']);
        DB::table('perfis')->insert(['nome' => 'Lançar comissão',   'descricao' => 'Responsável por CADASTRAR COMISSOES.']);
        DB::table('perfis')->insert(['nome' => 'Conferir comissão', 'descricao' => 'Responsável por validar as comissões dos usuarios.']);
    }
}