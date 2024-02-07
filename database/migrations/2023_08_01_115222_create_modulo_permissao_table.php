<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloPermissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulo_permissao', function (Blueprint $table) {
            $table->integer('perfil_id')->unsigned();
            $table->integer('modulo_id')->unsigned();
            $table->integer('permissao_id')->unsigned();
            $table->timestamps();
            $table->foreign('perfil_id')->references('id')->on('perfis')->onDelete('cascade');
            $table->foreign('modulo_id')->references('id')->on('modulos')->onDelete('cascade');
            $table->foreign('permissao_id')->references('id')->on('permissoes')->onDelete('cascade');
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
        Schema::dropIfExists('modulo_permissao');
    }
}