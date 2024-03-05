<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosTable extends Migration
{
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->unique();
            $table->string('rota');
            $table->string('slug');
            $table->string('descricao');
            $table->string('ativo')->nullable();
            $table->timestamps();
            $table->unsignedInteger('modulo_posicao_id')->nullable();
            $table->foreign('modulo_posicao_id')->references('id')->on('modulo_posicoes');
            $table->unsignedInteger('modulo_categoria_id')->nullable();
            $table->foreign('modulo_categoria_id')->references('id')->on('modulo_categorias');
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
        Schema::dropIfExists('modulos');
    }
}
