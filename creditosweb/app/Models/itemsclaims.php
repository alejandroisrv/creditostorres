<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemsclaims extends Model
{
     protected $table='items_claims';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'claims',
        'item',
        'comments',
        'created_at'
    ];

    protected $guarded =[

    ];
}
