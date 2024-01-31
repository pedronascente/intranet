<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    public function run()
    {
        DB::table('modulos')->insert(['nome' => 'Cargo',               'rota' => '/configuracoes/cargo',         'slug' => 'cargo',                'tipo_menu' => 'menu-configuracao', 'descricao' => "Responsável por Gerenciar Cargo."]);
        DB::table('modulos')->insert(['nome' => 'Colaborador',         'rota' => '/configuracoes/colaborador',   'slug' => 'colaborador',          'tipo_menu' => 'menu-configuracao', 'descricao' => "Responsável por Gerenciar Colaborador."]);
        DB::table('modulos')->insert(['nome' => 'Empresa',             'rota' => '/configuracoes/empresa',       'slug' => 'empresa',              'tipo_menu' => 'menu-configuracao', 'descricao' => "Responsável por Gerenciar Empresa."]);
        DB::table('modulos')->insert(['nome' => 'Modulos',             'rota' => '/configuracoes/modulo',        'slug' => 'modulo',               'tipo_menu' => 'menu-configuracao', 'descricao' => "Responsável por Gerenciar Modulo."]);
        DB::table('modulos')->insert(['nome' => 'Permissão',           'rota' => '/configuracoes/permissao',     'slug' => 'permissao',            'tipo_menu' => 'menu-configuracao', 'descricao' => "Responsável por Gerenciar Permissão."]);
        DB::table('modulos')->insert(['nome' => 'Perfil',              'rota' => '/configuracoes/perfil',        'slug' => 'perfil',               'tipo_menu' => 'menu-configuracao', 'descricao' => "Responsável por Gerenciar Perfil de usuário."]);
        DB::table('modulos')->insert(['nome' => 'Usuário',             'rota' => '/configuracoes/usuario',       'slug' => 'usuario',                 'tipo_menu' => 'menu-configuracao', 'descricao' => "Responsável por Gerenciar Usuario."]);
        DB::table('modulos')->insert(['nome' => 'Base',                'rota' => '/configuracoes/base',          'slug' => 'base',                 'tipo_menu' => 'menu-configuracao', 'descricao' => "Responsável por Criar as Bases."]);
        DB::table('modulos')->insert(['nome' => 'Lançar Comissão',     'rota' => '/comissao',                    'slug' => 'lancar-comissao',      'tipo_menu' => 'menu-lateral',      'descricao' => "Responsável por lanças as comissões dos colaboradores."]);
        DB::table('modulos')->insert(['nome' => 'Administrar Comissão','rota' => '/comissao-administrativo',     'slug' => 'administrar-comissao', 'tipo_menu' => 'menu-lateral',      'descricao' => "Responsável por Administrar as comissões dos colaboradores."]);
    }
} 
