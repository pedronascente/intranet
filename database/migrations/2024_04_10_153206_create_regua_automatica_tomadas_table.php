<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReguaAutomaticaTomadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regua_automatica_tomadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regua_id')->constrained('regua_automaticas')->onDelete('cascade');
            $table->string('tomada');
            $table->string('api');
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
        Schema::dropIfExists('regua_automatica_tomadas');
    }
}