<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    public function run()
    {
        DB::table('modulos')->insert([
            'nome'                => 'Cargo',               
            'rota'                => '/cargo',         
            'slug'                => 'cargo',                 
            'descricao'           => "Responsável por Gerenciar Cargo.",
            'modulo_categoria_id' => 2,
            'modulo_posicao_id'   => 2,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Colaborador',         
            'rota'                => '/colaborador',   
            'slug'                => 'colaborador',           
            'descricao'           => "Responsável por Gerenciar Colaborador.",
            'modulo_categoria_id' => 2,
            'modulo_posicao_id'   => 2,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Empresa',             
            'rota'                => '/empresa',       
            'slug'                => 'empresa',               
            'descricao'           => "Responsável por Gerenciar Empresa.",
            'modulo_categoria_id' => 2,
            'modulo_posicao_id'   => 2,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Modulos',             
            'rota'                => '/modulo',        
            'slug'                => 'modulo',                
            'descricao'           => "Responsável por Gerenciar Modulo.",
            'modulo_categoria_id' => 4,
            'modulo_posicao_id'   => 2,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Permissão',           
            'rota'                => '/permissao',     
            'slug'                => 'permissao',             
            'descricao'           => "Responsável por Gerenciar Permissão.",
            'modulo_categoria_id' => 4,
            'modulo_posicao_id'   => 2,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Perfil',              
            'rota'                => '/perfil',        
            'slug'                => 'perfil',                
            'descricao'           => "Responsável por Gerenciar Perfil de usuário.",
            'modulo_categoria_id' => 4,
            'modulo_posicao_id'   => 2,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Usuário',             
            'rota'                => '/usuario',       
            'slug'                => 'usuario',                  
            'descricao'           => "Responsável por Gerenciar Usuario.",
            'modulo_categoria_id' => 3,
            'modulo_posicao_id'   => 2,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Base',                
            'rota'                => '/base',          
            'slug'                => 'base',                  
            'descricao'           => "Responsável por Criar as Bases.",
            'modulo_categoria_id' => 2,
            'modulo_posicao_id'   => 2,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Lançar Comissão',     
            'rota'                => '/comissao',                    
            'slug'                => 'lancar-comissao',
            'descricao'           => "Responsável por lanças as comissões dos colaboradores.",
            'modulo_categoria_id' => 1,
            'modulo_posicao_id'   => 1,  
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Administrar Comissão',
            'rota'                => '/comissao-administrativo',     
            'slug'                => 'administrar-comissao',
            'descricao'           => "Responsável por Administrar as comissões dos colaboradores.",
            'modulo_categoria_id' => 1,
            'modulo_posicao_id'   => 1,   
        ]);
        DB::table('modulos')->insert([
            'nome'                => 'Configurações',
            'rota'                => '/configuracoes',     
            'slug'                => 'configuracoes',
            'descricao'           => "Responsável por mostrar os links de navegações, do módulos de configurações do sistema",
            'modulo_categoria_id' => 3,
            'modulo_posicao_id'   => 2,   
        ]);
    }
} 