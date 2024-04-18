<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReguaAutomaticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regua_automaticas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('condominio_id')->constrained('regua_automatica_condominios')->onDelete('cascade');
            $table->string('ip');
            $table->string('usuario');
            $table->string('senha');
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
        Schema::dropIfExists('regua_automaticas');
    }
}
