<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    protected $table='payments';

    protected $primaryKey = 'id';

    public $timestamps=false;

    protected $fillable =[
        'payment_agreement',
        'collector',
        'paymentvalue',
        'totalrecieve',
        'iscompletedpayment',
        'finalpayment',
        'created_at',
        'comments'
    ];

    protected $guarded =[

    ];
}
