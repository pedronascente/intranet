<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTable extends Migration
{
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('email')->unique();
            $table->char('rg', 20)->nullable();
            $table->char('cpf', 20)->nullable()->unique();
            $table->char('cnpj', 20)->nullable()->unique();
            $table->text('foto')->nullable();
            $table->timestamps();
            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->integer('cargo_id')->unsigned();
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('colaboradores');
    }
}
