<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class typeitem extends Model
{
    protected $table='item_type';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'name',
        'comments',
        'created_at',
        'update_at',
        'state'
    ];

    protected $guarded =[

    ];
}
