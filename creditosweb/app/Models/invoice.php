<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $table='invoice';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'user',
        'taxes',
        'subtotal',
        'total',
        'state',
        'created_at',
        'updated_at'
    ];

    protected $guarded =[

    ];
}
