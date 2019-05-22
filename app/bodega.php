<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bodega extends Model
{   protected $table="bodega_tabla";
    protected $fillable = ['administrador', 'direccion','municipio','telefono'];
}
