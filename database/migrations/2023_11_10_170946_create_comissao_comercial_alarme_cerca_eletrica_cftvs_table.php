<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissaoComercialAlarmeCercaEletricaCFTVSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissao_comercial_alarme_cerca_eletrica_cftvs', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('cliente');
            $table->string('conta_pedido');
            $table->string('meio');
            $table->string('ins_vendas');
            $table->decimal('comissao', 9, 2);
            $table->decimal('mensal', 9, 2);
            $table->decimal('desconto_comissao', 9, 2)->nullable(); // Tornar a coluna 'desconto_comissao' nula
            $table->timestamps();
            $table->unsignedInteger("servico_id");
            $table->foreign('servico_id', 'fk_comissao_servico')->references('id')->on('servico_alarmes');
            $table->unsignedInteger("planilha_id");
            $table->foreign('planilha_id', 'fk_comissao_planilha')->references('id')->on('planilhas')->onDelete('cascade');
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comissao_comercial_alarme_cerca_eletrica_cftvs');
    }
}
