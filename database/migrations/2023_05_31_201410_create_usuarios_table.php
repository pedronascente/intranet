<?php

use Illuminate\DATABASE\Migrations\Migration;
use Illuminate\DATABASE\SCHEMA\Blueprint;
use Illuminate\Support\Facades\SCHEMA;

class CreateUsuariosTable extends Migration
{

    public function up()
    {
        SCHEMA::CREATE('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('usuario');
            $table->string('email')->UNIQUE();
            $table->TIMESTAMP('email_verified_at')->nullable();
            $table->string('password');
            $table->char('rg', 15)->nullable();
            $table->char('cpf', 11)->nullable();
            $table->char('cnpj', 14)->nullable();
            $table->text('foto')->nullable();
            $table->char('ativo', 4);
            $table->rememberToken();

            $table->integer('tipo_id')->unsigned();
            $table->foreign('tipo_id')->references('id')->on('tipos');

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->integer('grupo_id')->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos');

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
        SCHEMA::dropIfExists('usuarios');
    }
}
