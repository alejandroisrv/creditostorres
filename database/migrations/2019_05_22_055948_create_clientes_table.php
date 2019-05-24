<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id')->unique()->unsigned();
            $table->integer('sucursal_id')->unique()->unsigned();
            $table->string('nombre')->unique();
            $table->string('apellido');
            $table->string('direccion');
            $table->string('telefono');
            $table->integer('municipio');
            $table->timestamps();
            $table->index(['id']);
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
