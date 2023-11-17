<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComercialRastreamentoVeicularesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial_rastreamento_veiculares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cliente');
            $table->date('data');
            $table->string('placa');
            $table->decimal('taxa_instalacao', 9, 2);
            $table->decimal('mensal', 9, 2);
            $table->decimal('comissao', 9, 2);
            $table->decimal('desconto_comissao', 9, 2)->nullable(); // Tornar a coluna 'desconto_comissao' nula
            $table->string('id_contrato')->nullable(); // Tornar a coluna 'desconto_comissao' nula
            $table->timestamps();

            $table->unsignedInteger("planilha_id");
            $table->foreign('planilha_id', 'fk_crv_planilha')->references('id')->on('planilhas')->onDelete('cascade');
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
        Schema::dropIfExists('comercial_rastreamento_veiculares');
    }
}
