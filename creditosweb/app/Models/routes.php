<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class routes extends Model
{
    protected $table='routes';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'collector',
        'assignedby',
        'state',
        'comments',
        'created_at',
        'updated_at'
    ];

    protected $guarded =[

    ];
}
