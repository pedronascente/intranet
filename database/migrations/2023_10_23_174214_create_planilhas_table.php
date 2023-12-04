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
            $table->char("ano", 4);
            $table->string("ctps");

            $table->integer("colaborador_id")->unsigned();
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');

            $table->integer("planilha_status_id")->unsigned();
            $table->foreign('planilha_status_id')->references('id')->on('planilha_status');

            $table->integer("planilha_periodo_id")->unsigned();
            $table->foreign('planilha_periodo_id')->references('id')->on('planilha_periodos');

            $table->integer("planilha_tipo_id")->unsigned();
            $table->foreign('planilha_tipo_id')->references('id')->on('planilha_tipos');
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
