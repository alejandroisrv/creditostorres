<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ciudad extends Model
{
    protected $table='cities';

    protected $primaryKey = 'id_ciudad';

    public $timestamps=false;

    protected $fillable =[
        'name',
        'state'
    ];

    protected $guarded =[

    ];
}
