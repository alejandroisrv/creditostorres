<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $fillable = ['administrador', 'direccion','municipio','telefono'];


    public function bodegas(){

        return $this->hasMany('App\Bodega');
        
    }
}
