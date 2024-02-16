<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('email')->unique();
            $table->string('token_reset_pass')->nullable();
            $table->char('rg', 20)->nullable();
            $table->char('cpf', 20)->nullable()->unique();
            $table->char('cnpj', 20)->nullable()->unique();
            $table->text('foto')->nullable();
            $table->char('ramal', 4);
            $table->bigInteger('numero_matricula')->unique();
            $table->timestamps();
            $table->integer('base_id')->unsigned();
            $table->foreign('base_id')->references('id')->on('bases');
            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->integer('cargo_id')->unsigned();
            $table->foreign('cargo_id')->references('id')->on('cargos');
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
        Schema::dropIfExists('colaboradores');
    }
}
