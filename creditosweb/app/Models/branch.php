<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    protected $table='branches';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'id_ciudad',
        'name',
        'address',
        'telephone',
        'owner_name',
        'comments',
        'update_at',
        'created_at',
        'state'
    ];

    protected $guarded =[

    ];
}
