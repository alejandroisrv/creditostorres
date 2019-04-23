<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class claims extends Model
{
     protected $table='claims';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'invoice',
        'user',
        'comments',
        'created_at',
        'state',
        'authorizedby',
        'commisionvalue'
    ];

    protected $guarded =[

    ];
}
