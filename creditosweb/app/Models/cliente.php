<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $table='clients';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'name',
        'lastname',
        'telephone',
        'address',
        'state',
        'email',
        'created_at',
        'update_at',
        'comments',
        'discount',
        'good_customer',
        'cedula'
    ];

    protected $guarded =[

    ];

}
