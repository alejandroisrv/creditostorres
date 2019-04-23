<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class salescommision extends Model
{
    protected $table='sale_commision';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'seller',
        'invoice',
        'total',
        'state',
        'created_at',
        'updated_at',
        'comments'
    ];

    protected $guarded =[

    ];
}
