<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class delinquentclient extends Model
{
    protected $table='delinquent_client';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'client',
        'payment_agreement',
        'state',
        'comments',
        'created_at'
    ];

    protected $guarded =[

    ];
}
