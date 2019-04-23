<?php

namespace App\Models;


use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table='roles';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'name',
        'display_name',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $guarded =[

    ];

}