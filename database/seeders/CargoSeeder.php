<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    public function run()
    {
        DB::table('cargos')->insert(['nome' => 'Auxiliar Geral de Serviços']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar do Lider de Monitoramento']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar de Supervisão de Atendimento de Ocorrência']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar de Marketing']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar de Manutenção']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar de Limpeza']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar de Líder de Monitoramento']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar de Estoque I']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar de Estoque']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar de Diretoria']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Admnistrativo']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Administrativo/ Tecnica']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Administrativo/ Programação']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Administrativo II']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Administrativo I']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Administrativo / Cobrança I']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Administrativo']);
        DB::table('cargos')->insert(['nome' => 'Assistente Juridico']);
        DB::table('cargos')->insert(['nome' => 'Assistente Administrativo Operacional']);
        DB::table('cargos')->insert(['nome' => 'Assistente Administrativo']);
        DB::table('cargos')->insert(['nome' => 'Assistente Administrativo II']);
        DB::table('cargos')->insert(['nome' => 'Assistente Administrativo III']);
        DB::table('cargos')->insert(['nome' => 'Analista de RH']);
        DB::table('cargos')->insert(['nome' => 'Agente de Atendimento de Ocorrência I']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Geral de Serviços I']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Geral de Serviços II']);
        DB::table('cargos')->insert(['nome' => 'Auxiliar Suporte']);
        DB::table('cargos')->insert(['nome' => 'Coordenador de Instalação de Rastreador']);
        DB::table('cargos')->insert(['nome' => 'Coordenador de Portaria Virtual']);
        DB::table('cargos')->insert(['nome' => 'Coordenador Seguros']);
        DB::table('cargos')->insert(['nome' => 'Coordenadora Cobrança']);
        DB::table('cargos')->insert(['nome' => 'Diretor Operacional']);
        DB::table('cargos')->insert(['nome' => 'Encarregado de Serviços Gerais']);
        DB::table('cargos')->insert(['nome' => 'Estagiário']);
        DB::table('cargos')->insert(['nome' => 'Gerente Operacional']);
        DB::table('cargos')->insert(['nome' => 'Gerente de TI']);
        DB::table('cargos')->insert(['nome' => 'Gerente Comercial']);
        DB::table('cargos')->insert(['nome' => 'Instalador de Rastreador Veícular ']);
        DB::table('cargos')->insert(['nome' => 'Instalador I']);
        DB::table('cargos')->insert(['nome' => 'Instalador II']);
        DB::table('cargos')->insert(['nome' => 'Instalador MASTER']);
        DB::table('cargos')->insert(['nome' => 'Jovem Aprendiz']);
        DB::table('cargos')->insert(['nome' => 'Lider de Monitoramento']);
        DB::table('cargos')->insert(['nome' => 'Operador de Central I']);
        DB::table('cargos')->insert(['nome' => 'Operador de Portaria Virtual/Rastreamento']);
        DB::table('cargos')->insert(['nome' => 'Operador de Rastreamento']);
        DB::table('cargos')->insert(['nome' => 'Porteiro']);
        DB::table('cargos')->insert(['nome' => 'Programador']);
        DB::table('cargos')->insert(['nome' => 'Programador MASTER']);
        DB::table('cargos')->insert(['nome' => 'Promotor de Vendas']);
        DB::table('cargos')->insert(['nome' => 'Recepcionista']);
        DB::table('cargos')->insert(['nome' => 'Sub Gerente de Informatica']);
        DB::table('cargos')->insert(['nome' => 'Sub-Gerente Administrativa']);
        DB::table('cargos')->insert(['nome' => 'Supervisor Administrativo']);
        DB::table('cargos')->insert(['nome' => 'Supervisor Administrativo II']);
        DB::table('cargos')->insert(['nome' => 'Supervisor Comercial']);
        DB::table('cargos')->insert(['nome' => 'Supervisor Comercial de Rastreamento']);
        DB::table('cargos')->insert(['nome' => 'Supervisor de Atendimento de Ocorrência']);
        DB::table('cargos')->insert(['nome' => 'Supervisor de Compras']);
        DB::table('cargos')->insert(['nome' => 'Supervisor de Treinamento']);
        DB::table('cargos')->insert(['nome' => 'Supervisor Operacional']);
        DB::table('cargos')->insert(['nome' => 'Supervisor RH']);
        DB::table('cargos')->insert(['nome' => 'Supervisor Técnico']);
        DB::table('cargos')->insert(['nome' => 'Supervisora Administrativo I']);
        DB::table('cargos')->insert(['nome' => 'Suporte Informática']);
        DB::table('cargos')->insert(['nome' => 'Supervisor Administrativo I']);
        DB::table('cargos')->insert(['nome' => 'Supervisor da UVA']);
        DB::table('cargos')->insert(['nome' => 'Técnico Instalador']); 
        DB::table('cargos')->insert(['nome' => 'Vendedor Frotista']);
        DB::table('cargos')->insert(['nome' => 'Vendedor']);
        DB::table('cargos')->insert(['nome' => 'Vendedor I']);
        DB::table('cargos')->insert(['nome' => 'Vendedor Sênior']);       
    }
}