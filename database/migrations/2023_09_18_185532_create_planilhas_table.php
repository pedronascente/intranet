<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanilhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilhas', function (Blueprint $table) {
            $table->increments('id');
            $table->string("matricula");
            $table->char("status", 10)->default('aberto');
            $table->char("ano", 4);
            $table->string("ctps");
            $table->integer("colaborador_id")->unsigned();
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');
            $table->integer("periodo_id")->unsigned();
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->integer("tipo_planilha_id")->unsigned();
            $table->foreign('tipo_planilha_id')->references('id')->on('tipo_planilhas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planilhas');
    }
}
