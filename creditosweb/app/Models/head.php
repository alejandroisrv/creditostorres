<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class head extends Model
{
    protected $table='head';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'invoice',
        'client',
        'seller',
        'created_at'
    ];

    protected $guarded =[

    ];
}
