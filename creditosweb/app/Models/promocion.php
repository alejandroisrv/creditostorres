<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promocion extends Model
{
    protected $table='promotion';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        
        'id_item',
        'id_user',
        'porcentage',
        'promotionvalue',
        'state',
        'dateexpiration',
        'created_at',
        'update_at'
    ];

    protected $guarded =[

    ];
}
