<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{   
    protected $fillable = ['administrador', 'direccion','municipio','telefono'];


    public function sucursal(){
        
        return $this->belongsTo('App\Sucursal');

    }
}
