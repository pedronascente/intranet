<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortariaVirtuaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portaria_virtuais', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('cliente');
            $table->string('conta_pedido');
            $table->decimal('ins_vendas', 9, 2);
            $table->decimal('mensal', 9, 2);
            $table->decimal('comissao', 9, 2);
            $table->decimal('desconto_comissao', 9, 2)->nullable(); // Tornar a coluna 'desconto_comissao' nula
            $table->timestamps();

            $table->unsignedInteger("meio_id");
            $table->foreign('meio_id')->references('id')->on('meios')->onDelete('cascade');

            $table->unsignedInteger("planilha_id");
            $table->foreign('planilha_id')->references('id')->on('planilhas')->onDelete('cascade');

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
        Schema::dropIfExists('portaria_virtuais');
    }
}
