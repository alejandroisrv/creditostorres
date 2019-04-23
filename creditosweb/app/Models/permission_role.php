<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permission_role extends Model
{
    protected $table='permission_role';

    protected $primaryKey = 'permission_id';

    public $timestamps=false;

    protected $fillable =[
        'role_id'
    ];

    protected $guarded =[

    ];
}

