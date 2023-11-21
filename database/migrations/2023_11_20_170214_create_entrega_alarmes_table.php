<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregaAlarmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega_alarmes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('cliente');
            $table->string('conta_pedido');
            $table->decimal('comissao', 9, 2);
            $table->decimal('desconto_comissao', 9, 2)->nullable(); // Tornar a coluna 'desconto_comissao' nula
            $table->timestamps();
            $table->unsignedInteger("planilha_id");
            $table->foreign('planilha_id', 'fk_entrega_alarmes_planilha')->references('id')->on('planilhas')->onDelete('cascade');
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
        Schema::dropIfExists('entrega_alarmes');
    }
}
