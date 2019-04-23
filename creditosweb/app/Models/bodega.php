<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bodega extends Model
{
    protected $table='warehouse';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'branch',
        'name',
        'address',
        'state',
        'telephone',
        'update_at',
        'created_at',
        'incharge'
    ];

    protected $guarded =[

    ];
}
