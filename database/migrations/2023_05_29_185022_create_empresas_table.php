<?php

use Illuminate\DATABASE\Migrations\Migration;
use Illuminate\DATABASE\SCHEMA\Blueprint;
use Illuminate\Support\Facades\SCHEMA;

class CreateEmpresasTable extends Migration
{
    public function up()
    {
        SCHEMA::CREATE('empresas', function (Blueprint $TABLE) {
            $TABLE->increments('id');
            $TABLE->string('nome');
            $TABLE->timestamps();
        });
    }

    public function down()
    {
        SCHEMA::dropIfExists('empresas');
    }
}
