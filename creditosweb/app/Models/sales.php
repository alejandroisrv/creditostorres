<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    protected $table='sales';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'invoice',
        'commision',
        'created_at',
        'comments'
    ];

    protected $guarded =[

    ];
}
