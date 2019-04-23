<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class routeshedule extends Model
{
    protected $table='routes_shedule';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'route',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ];

    protected $guarded =[

    ];
}
