<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegaTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegas', function (Blueprint $table) {
            $table->bigIncrements('id_bodega');
            $table->string('nombre',100);
            $table->string('telefono',100);
            $table->string('direccion',100);
            $table->interger('encargado');
            $table->interger('sucursal');
            $table->timestamps();
            $table->index(['id_bodega']);
        });
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id_producto');
            $table->string('nombre',100)->unique();
            $table->decimal('precio_costo',10,3);
            $table->decimal('precio_revendedor',10,3);
            $table->decimal('comision',10,3);
            $table->interger('cantidad');
            $table->interger('bodega');
            $table->interger('sucursal');
            $table->timestamps();
            $table->index(['id_producto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bodegas');
        Schema::dropIfExists('productos');
    }
}
