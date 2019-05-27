<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{   
    protected $fillable = ['telefono','direccion','municipio'];

    public function sucursal(){
        
        return $this->belongsTo('App\Sucursal');

    }

    public function productos(){
        return $this->hasMany('App\Productos');
    }

    
}
