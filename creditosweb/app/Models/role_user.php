<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
    protected $table='role_user';

    protected $primaryKey = 'user_id';

    public $timestamps=false;

    protected $fillable =[
        'role_id'
    ];

    protected $guarded =[

    ];
}