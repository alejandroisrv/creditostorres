<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table='items';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'created_by',
        'type',
        'name',
        'descripcion',
        'price',
        'commision',
        'reseller_price',
        'comments',
        'created_at',
        'update_at',
        'nombreimage',
        'adjunto'
    ];

    protected $guarded =[

    ];
}
