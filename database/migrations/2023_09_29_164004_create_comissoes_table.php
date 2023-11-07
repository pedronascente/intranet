<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissoes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('cliente');
            $table->string('conta_pedido');
            $table->string('meio')->nullable();
            $table->string('servico')->nullable();
            $table->integer('qtd_veiculos')->nullable();
            $table->string('placa');
            $table->integer('numero_os');
            $table->integer('total_rastreadores');
            $table->string('equip_servico');
            $table->string('observacao');
            $table->decimal('ins_vendas', $precision = 9, $scale = 2);
            $table->decimal('mensal', $precision = 9, $scale = 2);
            $table->decimal('comissao', $precision = 9, $scale = 2);
            $table->decimal('desconto_comissao', $precision = 9, $scale = 2);
            $table->decimal('taxa_instalacao', $precision = 9, $scale = 2);
            $table->timestamps();
            $table->integer("servico_alarme_id")->unsigned()->nullable();
            $table->foreign('servico_alarme_id')->references('id')->on('servico_alarme');
            $table->integer("planilha_id")->unsigned();
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
        Schema::dropIfExists('comissoes');
    }
}
