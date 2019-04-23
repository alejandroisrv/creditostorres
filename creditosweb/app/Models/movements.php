<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movements extends Model
{
    protected $table='movements';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'id_item',
        'id_invoice',
        'id_user',
        'id_branch',
        'id_warehouse',
        'quantity',
        'created_at'
    ];

    protected $guarded =[

    ];
}
