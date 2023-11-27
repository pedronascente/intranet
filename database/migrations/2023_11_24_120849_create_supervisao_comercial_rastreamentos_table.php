<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupervisaoComercialRastreamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisao_comercial_rastreamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('cliente');
            $table->string('conta_pedido');
            $table->integer('total_rastreadores');
            $table->decimal('comissao', 9, 2);
            $table->decimal('desconto_comissao', 9, 2);
            $table->timestamps();
            $table->unsignedInteger("planilha_id");
            $table->foreign('planilha_id', 'fk_scr_cftv_planilha')->references('id')->on('planilhas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supervisao_comercial_rastreamentos');
    }
}
