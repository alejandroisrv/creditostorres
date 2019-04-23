<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table='permissions';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'name',
        'display_name',
        'description'
    ];

    protected $guarded =[

    ];
}