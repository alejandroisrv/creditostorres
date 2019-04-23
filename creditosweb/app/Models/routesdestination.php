<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class routesdestination extends Model
{
    protected $table='routes_destination';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'client',
        'coordinate',
        'address',
        'route',
        'checkin',
        'checkin_time',
        'checkin_coordinates',
        'comments',
        'state'
    ];

    protected $guarded =[

    ];
}
