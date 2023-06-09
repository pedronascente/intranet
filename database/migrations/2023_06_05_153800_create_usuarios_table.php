<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('colaborador_id')->unsigned();
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');

            $table->integer('grupo_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos');

            $table->string('usuario');
            $table->string('password');
            $table->string('email')->UNIQUE();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('ativo', 5);
            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
