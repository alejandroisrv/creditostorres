<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class itemsinvoice extends Model
{
    protected $table='items_invoice';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'item',
        'invoice',
        'quantity',
        'disccount',
        'subtotal',
        'total',
        'created_at',
        'state',
        'comments'
    ];

    protected $guarded =[

    ];
}
