<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table="sucursales";
    protected $fillable = ['direccion','municipio','telefono'];

    public function bodegas(){
        return $this->hasMany('App\Bodega');
    }
    public function productos(){
        return $this->hasMany('App\Productos');
    }
    public function clientes(){
        return $this->hasMany('App\Cliente');
    }
}
